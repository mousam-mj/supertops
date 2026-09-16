<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderNotificationService
{
    public function sendOrderConfirmation(Order $order): void
    {
        $order->loadMissing('items.product');

        $this->sendConfirmationEmail($order);
        $this->sendOrderSms($order);
        $this->sendOrderWhatsApp($order);
    }

    private function sendConfirmationEmail(Order $order): void
    {
        $email = trim((string) ($order->customer_email ?? ''));
        if ($email === '' || str_ends_with($email, '@otp.supertops.local')) {
            Log::warning('Order confirmation email skipped: missing or placeholder email', [
                'order_number' => $order->order_number,
            ]);

            return;
        }

        try {
            $name = trim((string) ($order->customer_name ?? 'Customer'));

            Mail::send('emails.order-confirmation', ['order' => $order], function ($message) use ($email, $name, $order) {
                $message->to($email, $name !== '' ? $name : null)
                    ->subject("Order Confirmation - {$order->order_number}");
            });

            Log::info('Order confirmation email sent', [
                'order_number' => $order->order_number,
                'email' => $email,
            ]);
        } catch (\Throwable $e) {
            Log::error('Order confirmation email failed', [
                'order_number' => $order->order_number,
                'email' => $email,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function sendOrderSms(Order $order): void
    {
        $mobile = $this->normalizeMobile((string) ($order->customer_phone ?? ''));
        if ($mobile === null) {
            return;
        }

        $authKey = config('services.msg91.auth_key');
        if (empty($authKey)) {
            return;
        }

        $templateId = config('services.msg91.order_sms_template_id');
        if (! empty($templateId) && $templateId !== 'your_order_template_id_here') {
            $this->sendMsg91FlowMessage($mobile, $templateId, [
                'var1' => (string) $order->order_number,
                'var2' => number_format((float) $order->total_amount, 2),
                'order_number' => (string) $order->order_number,
                'total' => number_format((float) $order->total_amount, 2),
            ], 'order_sms');

            return;
        }

        $message = "Thank you for your order {$order->order_number} with Perch. Total: Rs "
            .number_format((float) $order->total_amount, 2)
            .'. We will notify you when it ships.';

        try {
            $response = Http::timeout(8)->asForm()->post('https://control.msg91.com/api/sendhttp.php', [
                'authkey' => $authKey,
                'mobiles' => config('services.msg91.country', 91).$mobile,
                'message' => $message,
                'sender' => config('services.msg91.sender_id', 'PADIAB'),
                'route' => config('services.msg91.route', 4),
                'country' => config('services.msg91.country', 91),
            ]);

            Log::info('Order confirmation SMS response', [
                'order_number' => $order->order_number,
                'mobile' => $mobile,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Order confirmation SMS failed', [
                'order_number' => $order->order_number,
                'mobile' => $mobile,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function sendOrderWhatsApp(Order $order): void
    {
        $mobile = $this->normalizeMobile((string) ($order->customer_phone ?? ''));
        $templateId = config('services.msg91.order_whatsapp_template_id');

        if ($mobile === null || empty($templateId) || $templateId === 'your_whatsapp_template_id_here') {
            return;
        }

        $this->sendMsg91FlowMessage($mobile, $templateId, [
            'var1' => (string) $order->order_number,
            'var2' => number_format((float) $order->total_amount, 2),
            'order_number' => (string) $order->order_number,
            'total' => number_format((float) $order->total_amount, 2),
        ], 'order_whatsapp');
    }

    private function sendMsg91FlowMessage(string $mobile, string $templateId, array $variables, string $channel): void
    {
        $authKey = config('services.msg91.auth_key');
        if (empty($authKey)) {
            return;
        }

        $recipient = array_merge(
            ['mobiles' => config('services.msg91.country', 91).$mobile],
            $variables
        );

        try {
            $response = Http::timeout(8)->withHeaders([
                'accept' => 'application/json',
                'authkey' => $authKey,
                'content-type' => 'application/json',
            ])->post('https://control.msg91.com/api/v5/flow', [
                'template_id' => $templateId,
                'short_url' => '0',
                'realTimeResponse' => '1',
                'recipients' => [$recipient],
            ]);

            Log::info("Order {$channel} response", [
                'mobile' => $mobile,
                'template_id' => $templateId,
                'status' => $response->status(),
                'response' => $response->json() ?? $response->body(),
            ]);
        } catch (\Throwable $e) {
            Log::error("Order {$channel} failed", [
                'mobile' => $mobile,
                'template_id' => $templateId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function normalizeMobile(string $phone): ?string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';
        if (str_starts_with($digits, '91') && strlen($digits) === 12) {
            $digits = substr($digits, 2);
        }

        return preg_match('/^[6-9]\d{9}$/', $digits) ? $digits : null;
    }
}
