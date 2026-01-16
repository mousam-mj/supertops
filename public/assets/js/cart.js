/**
 * Cart functionality for the e-commerce site
 */
(function() {
    'use strict';

    const CartAPI = {
        baseUrl: '/api/cart',
        
        getCsrfToken: function() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        },

        addToCart: function(productId, quantity = 1, size = null, color = null) {
            return fetch(`${this.baseUrl}/add`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity,
                    size: size,
                    color: color
                })
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    // Return error data with success flag
                    return {
                        success: false,
                        message: data.message || 'An error occurred',
                        status: response.status
                    };
                }
                return data;
            });
        },

        updateCart: function(cartId, quantity) {
            return fetch(`${this.baseUrl}/update/${cartId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    return {
                        success: false,
                        message: data.message || 'An error occurred',
                        status: response.status
                    };
                }
                return data;
            });
        },

        removeFromCart: function(cartId) {
            return fetch(`${this.baseUrl}/remove/${cartId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json());
        },

        getCartCount: function() {
            return fetch(`${this.baseUrl}/count`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    return data.data.count || 0;
                }
                return 0;
            });
        },

        updateCartCount: function() {
            this.getCartCount().then(count => {
                const cartCountElements = document.querySelectorAll('.cart-quantity, .cart-count');
                cartCountElements.forEach(el => {
                    el.textContent = count;
                    if (count > 0) {
                        el.style.display = 'flex';
                    } else {
                        el.style.display = 'none';
                    }
                });
            });
        }
    };

    // Initialize cart functionality when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Update cart count on page load
        CartAPI.updateCartCount();

        // Handle "Add to Cart" buttons
        document.querySelectorAll('.add-cart-btn, .add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const productId = this.getAttribute('data-product-id');
                if (!productId) {
                    console.error('Product ID not found');
                    return;
                }

                const quantity = parseInt(document.getElementById('product-quantity')?.value || 1);
                const size = document.querySelector('input[name="size"]:checked')?.value || null;
                const color = document.querySelector('input[name="color"]:checked')?.value || null;

                // Disable button during request
                const originalText = this.innerHTML;
                this.disabled = true;
                this.innerHTML = 'Adding...';

                CartAPI.addToCart(productId, quantity, size, color)
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            if (typeof showNotification === 'function') {
                                showNotification('Product added to cart successfully!', 'success');
                            } else {
                                alert('Product added to cart!');
                            }
                            
                            // Update cart count
                            CartAPI.updateCartCount();
                            
                            // Refresh cart modal if it's open
                            if (window.CartModal && window.CartModal.loadCartItems) {
                                window.CartModal.loadCartItems();
                            }
                        } else {
                            // Show error message
                            if (typeof showNotification === 'function') {
                                showNotification(data.message || 'Failed to add product to cart', 'error', 6000);
                            } else {
                                alert(data.message || 'Failed to add product to cart');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (typeof showNotification === 'function') {
                            showNotification('An error occurred. Please try again.', 'error', 6000);
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.innerHTML = originalText;
                    });
            });
        });

        // Handle quantity updates (if on cart page)
        document.querySelectorAll('.increase-qty, .decrease-qty').forEach(btn => {
            btn.addEventListener('click', function() {
                const cartId = this.getAttribute('data-cart-id');
                if (!cartId) return;

                const input = document.querySelector(`input[data-cart-id="${cartId}"]`);
                if (!input) return;

                let currentQty = parseInt(input.value) || 1;
                
                if (this.classList.contains('increase-qty')) {
                    currentQty += 1;
                } else if (this.classList.contains('decrease-qty') && currentQty > 1) {
                    currentQty -= 1;
                } else {
                    return;
                }

                CartAPI.updateCart(cartId, currentQty)
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            if (typeof showNotification === 'function') {
                                showNotification(data.message || 'Failed to update quantity', 'error', 6000);
                            } else {
                                alert(data.message || 'Failed to update quantity');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (typeof showNotification === 'function') {
                            showNotification('An error occurred. Please try again.', 'error', 6000);
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    });
            });
        });

        // Handle remove item buttons
        document.querySelectorAll('.remove-item-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const cartId = this.getAttribute('data-cart-id');
                if (!cartId) return;

                if (!confirm('Are you sure you want to remove this item from your cart?')) {
                    return;
                }

                CartAPI.removeFromCart(cartId)
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Failed to remove item');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            });
        });
    });

    // Make CartAPI available globally
    window.CartAPI = CartAPI;
})();

