/**
 * Cart Modal functionality - API-based
 */
(function() {
    'use strict';

    const CartModal = {
        baseUrl: '/api/cart',
        
        getCsrfToken: function() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        },

        getImageUrl: function(imagePath) {
            if (!imagePath) return '/assets/images/product/perch-bottal.webp';
            if (imagePath.startsWith('assets/') || imagePath.startsWith('/assets/')) {
                return '/' + imagePath.replace(/^\//, '');
            }
            return '/storage/' + imagePath;
        },

        /**
         * Load and display cart items in modal
         */
        loadCartItems: function() {
            const listItemCart = document.querySelector('.modal-cart-block .list-product');
            if (!listItemCart) return;

            fetch(this.baseUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.items) {
                    this.renderCartItems(data.data.items, data.data.total || 0);
                } else {
                    this.renderEmptyCart();
                }
            })
            .catch(error => {
                console.error('Error loading cart:', error);
                this.renderEmptyCart();
            });
        },

        /**
         * Render cart items
         */
        renderCartItems: function(items, total) {
            const listItemCart = document.querySelector('.modal-cart-block .list-product');
            if (!listItemCart) return;

            listItemCart.innerHTML = '';

            if (items.length === 0) {
                this.renderEmptyCart();
                return;
            }

            const moneyForFreeship = 150;
            let totalCart = total || 0;

            items.forEach((item) => {
                const product = item.product || {};
                const imageUrl = this.getImageUrl(product.image);
                const productName = product.name || 'Product';
                const variant = this.getVariantText(item);
                
                // Get unit price and subtotal from API response
                const unitPrice = item.unit_price || product.current_price || product.sale_price || product.price || 0;
                const quantity = item.quantity || 1;
                const subtotal = item.subtotal || (unitPrice * quantity);

                const prdItem = document.createElement('div');
                prdItem.setAttribute('data-cart-id', item.id);
                prdItem.classList.add('item', 'py-5', 'flex', 'items-center', 'justify-between', 'gap-3', 'border-b', 'border-line');
                
                prdItem.innerHTML = `
                    <div class="infor flex items-center gap-3 w-full">
                        <div class="bg-img w-[100px] aspect-square flex-shrink-0 rounded-lg overflow-hidden">
                            <img src="${imageUrl}" alt="${productName}" class="w-full h-full object-cover" />
                        </div>
                        <div class="w-full">
                            <div class="flex items-center justify-between w-full">
                                <div class="name text-button">${productName}</div>
                                <div class="remove-cart-btn remove-btn caption1 font-semibold text-red underline cursor-pointer" data-cart-id="${item.id}">
                                    Remove
                                </div>
                            </div>
                            <div class="flex items-center justify-between gap-2 mt-3 w-full">
                                <div class="flex items-center text-secondary2 capitalize">
                                    ${variant} ${quantity > 1 ? `× ${quantity}` : ''}
                                </div>
                                <div class="product-price text-title">$${parseFloat(subtotal).toFixed(2)}</div>
                            </div>
                        </div>
                    </div>
                `;

                listItemCart.appendChild(prdItem);
            });

            // Update free shipping progress
            this.updateFreeShippingProgress(totalCart, moneyForFreeship);
            
            // Update total
            const totalCartEl = document.querySelector('.modal-cart-block .total-cart');
            if (totalCartEl) {
                totalCartEl.innerHTML = '$' + parseFloat(totalCart).toFixed(2);
            }

            // Attach remove event listeners
            this.attachRemoveListeners();
        },

        /**
         * Get variant text (size/color)
         */
        getVariantText: function(item) {
            const parts = [];
            if (item.size) parts.push(item.size);
            if (item.color) parts.push(item.color);
            return parts.length > 0 ? parts.join('/') : 'Standard';
        },

        /**
         * Render empty cart
         */
        renderEmptyCart: function() {
            const listItemCart = document.querySelector('.modal-cart-block .list-product');
            if (!listItemCart) return;

            listItemCart.innerHTML = '<p class="mt-1 text-center py-8 text-secondary">No products in cart</p>';
            
            const totalCartEl = document.querySelector('.modal-cart-block .total-cart');
            if (totalCartEl) {
                totalCartEl.innerHTML = '$0.00';
            }

            this.updateFreeShippingProgress(0, 150);
        },

        /**
         * Update free shipping progress bar
         */
        updateFreeShippingProgress: function(total, target) {
            const morePriceEl = document.querySelector('.modal-cart-block .more-price');
            const progressLineEl = document.querySelector('.modal-cart-block .tow-bar-block .progress-line');
            
            if (morePriceEl && progressLineEl) {
                const remaining = Math.max(0, target - total);
                morePriceEl.innerHTML = remaining.toFixed(0);
                
                const percentage = Math.min(100, (total / target) * 100);
                progressLineEl.style.width = percentage + '%';
            }
        },

        /**
         * Attach remove button event listeners
         */
        attachRemoveListeners: function() {
            const removeButtons = document.querySelectorAll('.modal-cart-block .remove-cart-btn');
            removeButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const cartId = btn.getAttribute('data-cart-id');
                    if (!cartId) return;

                    this.removeItem(cartId);
                });
            });
        },

        /**
         * Remove item from cart
         */
        removeItem: function(cartId) {
            if (!confirm('Are you sure you want to remove this item from your cart?')) {
                return;
            }

            fetch(`${this.baseUrl}/remove/${cartId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.getCsrfToken(),
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const data = await response.json();
                if (data.success) {
                    if (typeof showNotification === 'function') {
                        showNotification('Item removed from cart', 'success');
                    }
                    this.loadCartItems();
                    if (window.CartAPI && window.CartAPI.updateCartCount) {
                        window.CartAPI.updateCartCount();
                    }
                } else {
                    if (typeof showNotification === 'function') {
                        showNotification(data.message || 'Failed to remove item', 'error');
                    } else {
                        alert(data.message || 'Failed to remove item');
                    }
                }
            })
            .catch(error => {
                console.error('Error removing item:', error);
                if (typeof showNotification === 'function') {
                    showNotification('An error occurred. Please try again.', 'error');
                } else {
                    alert('An error occurred. Please try again.');
                }
            });
        },

        /**
         * Load "You May Also Like" products
         */
        loadRelatedProducts: function() {
            const relatedContainer = document.querySelector('.modal-cart-block .left .list');
            if (!relatedContainer) return;

            // Fetch featured or new arrival products
            fetch('/api/products?featured=1&per_page=4', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data && data.data.data && data.data.data.length > 0) {
                    this.renderRelatedProducts(data.data.data, relatedContainer);
                } else if (data.success && Array.isArray(data.data) && data.data.length > 0) {
                    this.renderRelatedProducts(data.data, relatedContainer);
                }
            })
            .catch(error => {
                console.error('Error loading related products:', error);
            });
        },

        /**
         * Render related products
         */
        renderRelatedProducts: function(products, container) {
            container.innerHTML = '';
            
            products.forEach(product => {
                const imageUrl = this.getImageUrl(product.image);
                const productUrl = `/product/${product.slug}`;
                const price = product.sale_price || product.price || 0;
                const originalPrice = product.sale_price ? product.price : null;

                const productEl = document.createElement('div');
                productEl.classList.add('product-item', 'mb-4');
                productEl.innerHTML = `
                    <a href="${productUrl}" class="block">
                        <div class="bg-img w-full aspect-square rounded-lg overflow-hidden mb-2">
                            <img src="${imageUrl}" alt="${product.name}" class="w-full h-full object-cover" />
                        </div>
                        <div class="name text-button mb-1">${product.name}</div>
                        <div class="product-price-block flex items-center gap-2">
                            <div class="product-price text-title">$${parseFloat(price).toFixed(2)}</div>
                            ${originalPrice ? `<div class="product-origin-price caption1 text-secondary2"><del>$${parseFloat(originalPrice).toFixed(2)}</del></div>` : ''}
                        </div>
                    </a>
                `;
                container.appendChild(productEl);
            });
        }
    };

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        const modalCart = document.querySelector('.modal-cart-block');
        const modalCartMain = document.querySelector('.modal-cart-block .modal-cart-main');
        if (!modalCart || !modalCartMain) return;

        // Function to load cart when modal opens
        const loadCartWhenOpen = function() {
            if (modalCartMain.classList.contains('open')) {
                CartModal.loadCartItems();
                CartModal.loadRelatedProducts();
            }
        };

        // Load cart when modal opens via cart icon
        const cartIcons = document.querySelectorAll('.cart-icon, .cart-btn, [data-cart], .add-cart-btn, .add-to-cart-btn');
        cartIcons.forEach(cartIcon => {
            cartIcon.addEventListener('click', function() {
                setTimeout(loadCartWhenOpen, 200);
            });
        });

        // Watch for modal opening via class changes
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    const target = mutation.target;
                    if (target.classList.contains('open')) {
                        setTimeout(loadCartWhenOpen, 100);
                    }
                }
            });
        });

        // Observe modal cart main for class changes
        observer.observe(modalCartMain, {
            attributes: true,
            attributeFilter: ['class']
        });

        // Also observe the modal container
        observer.observe(modalCart, {
            attributes: true,
            attributeFilter: ['class', 'style']
        });

        // Initial load if modal is already open
        setTimeout(loadCartWhenOpen, 500);
    });

    // Make available globally
    window.CartModal = CartModal;
})();

