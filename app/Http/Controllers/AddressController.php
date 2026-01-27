<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    // Middleware is applied in routes, no need to duplicate here
    
    public function __construct()
    {
        // Log when controller is instantiated
        \Log::info('AddressController instantiated');
    }

    /**
     * Store a newly created address
     */
    public function store(Request $request)
    {
        // Log request for debugging - this will help us see if request reaches here
        Log::info('=== Address store request received ===', [
            'user_id' => Auth::id(),
            'authenticated' => Auth::check(),
            'has_csrf' => $request->has('_token'),
            'csrf_value' => $request->input('_token'),
            'session_id' => $request->session()->getId(),
            'ip' => $request->ip(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
        ]);
        
        // If we reach here, middleware passed, but double check
        if (!Auth::check()) {
            Log::error('=== Address store: User not authenticated AFTER middleware ===', [
                'session_id' => $request->session()->getId(),
                'ip' => $request->ip(),
            ]);
            return redirect()->route('login')
                ->with('error', 'Your session has expired. Please login again.');
        }

        // Validate the request
        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|min:5|max:6',
            'is_default' => 'nullable',
        ]);

        $isDefault = $request->has('is_default') && ($request->is_default == '1' || $request->is_default === true);

        // If this is set as default, unset other defaults
        if ($isDefault) {
            Address::where('user_id', Auth::id())
                ->update(['is_default' => false]);
        }

        try {
            $address = Address::create([
                'user_id' => Auth::id(),
                'label' => $validated['label'] ?? 'Home',
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
                'address_line_1' => $validated['address_line_1'],
                'address_line_2' => $validated['address_line_2'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'pincode' => $validated['pincode'],
                'is_default' => $isDefault,
            ]);

            Log::info('Address saved successfully', [
                'address_id' => $address->id,
                'user_id' => Auth::id()
            ]);

            return redirect()->route('my-account')
                ->with('success', 'Address added successfully!');
        } catch (\Exception $e) {
            Log::error('Address save error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('my-account')
                ->withErrors(['error' => 'Failed to save address. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Update an existing address
     */
    public function update(Request $request, $id)
    {
        $address = Address::where('user_id', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'full_name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:20',
            'address_line_1' => 'sometimes|required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'state' => 'sometimes|required|string|max:255',
            'pincode' => 'sometimes|required|string|min:5|max:6',
            'is_default' => 'nullable',
        ]);

        $isDefault = $request->has('is_default') && ($request->is_default == '1' || $request->is_default === true);

        // If this is set as default, unset other defaults
        if ($isDefault) {
            Address::where('user_id', Auth::id())
                ->where('id', '!=', $id)
                ->update(['is_default' => false]);
        }

        try {
            $updateData = array_merge($validated, [
                'is_default' => $isDefault
            ]);

            $address->update($updateData);

            return redirect()->route('my-account')
                ->with('success', 'Address updated successfully!');
        } catch (\Exception $e) {
            Log::error('Address update error: ' . $e->getMessage());

            return redirect()->route('my-account')
                ->withErrors(['error' => 'Failed to update address. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Delete an address
     */
    public function destroy($id)
    {
        $address = Address::where('user_id', Auth::id())
            ->findOrFail($id);

        $address->delete();

        return redirect()->route('my-account')
            ->with('success', 'Address deleted successfully!');
    }

    /**
     * Set an address as default
     */
    public function setDefault($id)
    {
        $address = Address::where('user_id', Auth::id())
            ->findOrFail($id);

        // Unset other defaults
        Address::where('user_id', Auth::id())
            ->where('id', '!=', $id)
            ->update(['is_default' => false]);

        $address->update(['is_default' => true]);

        return redirect()->route('my-account')
            ->with('success', 'Default address updated!');
    }
}
