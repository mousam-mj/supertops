/**
 * Checkout functionality
 */
(function() {
    'use strict';

    const CheckoutAPI = {
        baseUrl: '/api',
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
        isAuthenticated: {{ auth()->check() ? 'true' : 'false' }},
        appliedCoupon: null,
        couponDiscount: 0,
        subtotal: {{ $subtotal }},
        shipping: {{ $shipping }},
        total: {{ $total }},

        getCartItems: function() {
            if (this.isAuthenticated) {
                return fetch(`${this.baseUrl}/cart`, {
                    headers: { 'Accept': 'application/json' }
                }).then(r => r.json());
            } else {
                return fetch(`${this.baseUrl}/cart`, {
                    headers: { 'Accept': 'application/json' }
                }).then(r => r.json());
            }
        },

        validateCoupon: function(code) {
            return fetch(`${this.baseUrl}/coupons/validate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ code: code })
            }).then(r => r.json());
        },

        createRazorpayOrder: function(amount) {
            return fetch(`${this.baseUrl}/payments/create-order`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ amount: amount, currency: 'INR' })
            }).then(r => r.json());
        },

        createOrder: function(orderData) {
            const url = `${this.baseUrl}/orders`;
            const headers = {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken,
                'Accept': 'application/json'
            };

            if (this.isAuthenticated) {
                const token = localStorage.getItem('auth_token');
                if (token) {
                    headers['Authorization'] = `Bearer ${token}`;
                }
            }

            return fetch(url, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify(orderData)
            }).then(r => r.json());
        },

        updateSummary: function() {
            const discount = this.couponDiscount || 0;
            const newTotal = this.subtotal - discount + this.shipping;

            document.getElementById('summary-subtotal').textContent = `$${this.subtotal.toFixed(2)}`;
            
            if (discount > 0) {
                document.getElementById('coupon-discount-row').classList.remove('hidden');
                document.getElementById('summary-coupon-discount').textContent = `-$${discount.toFixed(2)}`;
            } else {
                document.getElementById('coupon-discount-row').classList.add('hidden');
            }

            document.getElementById('summary-shipping').textContent = 
                this.shipping > 0 ? `$${this.shipping.toFixed(2)}` : 'Free';
            
            document.getElementById('summary-total').textContent = `$${newTotal.toFixed(2)}`;
        }
    };

    // Apply Coupon
    document.getElementById('apply-coupon-btn')?.addEventListener('click', function() {
        const code = document.getElementById('coupon_code').value.trim();
        const messageEl = document.getElementById('coupon-message');

        if (!code) {
            messageEl.textContent = 'Please enter a coupon code';
            messageEl.className = 'mt-2 caption1 text-red-600';
            return;
        }

        this.disabled = true;
        this.textContent = 'Applying...';

        CheckoutAPI.validateCoupon(code)
            .then(data => {
                if (data.success) {
                    CheckoutAPI.appliedCoupon = code;
                    CheckoutAPI.couponDiscount = data.data.discount_amount || 0;
                    CheckoutAPI.updateSummary();
                    messageEl.textContent = `Coupon applied! You saved $${CheckoutAPI.couponDiscount.toFixed(2)}`;
                    messageEl.className = 'mt-2 caption1 text-green-600';
                } else {
                    messageEl.textContent = data.message || 'Invalid coupon code';
                    messageEl.className = 'mt-2 caption1 text-red-600';
                }
            })
            .catch(error => {
                messageEl.textContent = 'Failed to apply coupon. Please try again.';
                messageEl.className = 'mt-2 caption1 text-red-600';
            })
            .finally(() => {
                this.disabled = false;
                this.textContent = 'Apply';
            });
    });

    // Form Submission
    document.getElementById('checkout-form')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;

        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';

        // Get form data
        const formData = new FormData(form);
        const paymentMethod = formData.get('payment_method');
        const isGuest = !CheckoutAPI.isAuthenticated;

        // Prepare order data
        let orderData = {
            payment_method: paymentMethod,
            coupon_code: CheckoutAPI.appliedCoupon,
            notes: formData.get('notes') || ''
        };

        if (CheckoutAPI.isAuthenticated) {
            const addressId = formData.get('address_id');
            if (!addressId) {
                // Create address from form
                orderData.shipping_address = {
                    first_name: formData.get('first_name'),
                    last_name: formData.get('last_name'),
                    email: formData.get('email'),
                    phone: formData.get('phone'),
                    address: formData.get('address'),
                    city: formData.get('city'),
                    state: formData.get('state'),
                    pincode: formData.get('pincode')
                };
            } else {
                orderData.shipping_address_id = addressId;
            }
        } else {
            // Guest checkout
            orderData.guest_info = {
                first_name: formData.get('first_name'),
                last_name: formData.get('last_name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                address: formData.get('address'),
                city: formData.get('city'),
                state: formData.get('state'),
                pincode: formData.get('pincode')
            };
        }

        // Handle payment
        if (paymentMethod === 'razorpay') {
            const total = CheckoutAPI.subtotal - CheckoutAPI.couponDiscount + CheckoutAPI.shipping;
            
            CheckoutAPI.createRazorpayOrder(total)
                .then(razorpayData => {
                    if (!razorpayData.success) {
                        throw new Error(razorpayData.message || 'Failed to create payment order');
                    }

                    const options = {
                        key: razorpayData.data.key,
                        amount: razorpayData.data.amount * 100, // Convert to paise
                        currency: razorpayData.data.currency,
                        order_id: razorpayData.data.order_id,
                        name: 'Perch Bottle',
                        description: 'Order Payment',
                        handler: function(response) {
                            orderData.razorpay_order_id = response.razorpay_order_id;
                            orderData.razorpay_payment_id = response.razorpay_payment_id;
                            orderData.razorpay_signature = response.razorpay_signature;

                            // Create order
                            CheckoutAPI.createOrder(orderData)
                                .then(data => {
                                    if (data.success) {
                                        window.location.href = `/order-success/${data.data.id}`;
                                    } else {
                                        showNotification(data.message || 'Order creation failed', 'error');
                                        submitBtn.disabled = false;
                                        submitBtn.textContent = originalText;
                                    }
                                })
                                .catch(error => {
                                    showNotification('Failed to create order. Please contact support.', 'error');
                                    submitBtn.disabled = false;
                                    submitBtn.textContent = originalText;
                                });
                        },
                        prefill: {
                            name: formData.get('first_name') + ' ' + formData.get('last_name'),
                            email: formData.get('email'),
                            contact: formData.get('phone')
                        },
                        theme: {
                            color: '#6366f1'
                        }
                    };

                    const razorpay = new Razorpay(options);
                    razorpay.open();
                    razorpay.on('payment.failed', function(response) {
                        showNotification('Payment failed. Please try again.', 'error');
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    });
                })
                .catch(error => {
                    showNotification(error.message || 'Failed to initialize payment', 'error');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
        } else {
            // COD - Direct order creation
            CheckoutAPI.createOrder(orderData)
                .then(data => {
                    if (data.success) {
                        window.location.href = `/order-success/${data.data.id}`;
                    } else {
                        showNotification(data.message || 'Order creation failed', 'error');
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                })
                .catch(error => {
                    showNotification('Failed to create order. Please contact support.', 'error');
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                });
        }
    });

    // Make CheckoutAPI available globally
    window.CheckoutAPI = CheckoutAPI;
})();

