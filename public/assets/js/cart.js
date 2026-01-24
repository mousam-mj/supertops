// Cart functionality for dynamic products
(function() {
    'use strict';

    // Add to cart functionality
    function initAddToCart() {
        document.addEventListener('click', function(e) {
            const addCartBtn = e.target.closest('.add-cart-btn');
            if (!addCartBtn) return;

            e.preventDefault();
            e.stopPropagation();

            const productId = addCartBtn.getAttribute('data-product-id');
            if (!productId) {
                console.error('Product ID not found');
                return;
            }

            // Get size and color if available
            const sizeItem = addCartBtn.closest('.product-item')?.querySelector('.size-item.active');
            const colorItem = addCartBtn.closest('.product-item')?.querySelector('.color-item.active');
            
            const size = sizeItem?.getAttribute('data-size') || null;
            const color = colorItem?.getAttribute('data-color') || null;

            // Show loading state
            const originalText = addCartBtn.innerHTML;
            addCartBtn.innerHTML = '<i class="ph ph-spinner ph-spin text-xl"></i> Adding...';
            addCartBtn.disabled = true;

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            
            // Make API call
            fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    product_id: parseInt(productId),
                    quantity: 1,
                    size: size,
                    color: color
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count
                    updateCartCount();
                    
                    // Show success message
                    showNotification('Product added to cart!', 'success');
                    
                    // Open cart modal if exists
                    const cartModal = document.querySelector('.modal-cart-block');
                    if (cartModal) {
                        cartModal.classList.add('open');
                        loadCartItems();
                    }
                } else {
                    showNotification(data.message || 'Failed to add product to cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred. Please try again.', 'error');
            })
            .finally(() => {
                addCartBtn.innerHTML = originalText;
                addCartBtn.disabled = false;
            });
        });
    }

    // Quick view functionality
    function initQuickView() {
        document.addEventListener('click', function(e) {
            const quickViewBtn = e.target.closest('.quick-view-btn');
            if (!quickViewBtn) return;

            e.preventDefault();
            e.stopPropagation();

            const productId = quickViewBtn.getAttribute('data-product-id');
            const productSlug = quickViewBtn.getAttribute('data-product-slug');

            if (productSlug) {
                // Redirect to product page
                window.location.href = `/product/${productSlug}`;
            } else if (productId) {
                // Load product via API and show in modal
                loadQuickViewProduct(productId);
            }
        });
    }

    // Load product for quick view
    function loadQuickViewProduct(productId) {
        // Get product slug from data attribute or fetch from API
        const productItem = document.querySelector(`[data-item="${productId}"]`);
        const productSlug = productItem?.querySelector('.quick-view-btn')?.getAttribute('data-product-slug');
        
        if (productSlug) {
            // Redirect to product page for quick view
            window.location.href = `/product/${productSlug}`;
        } else {
            // Try to find product by ID in products list
            fetch(`/api/products?per_page=100`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.data) {
                        const product = data.data.data.find(p => p.id == productId);
                        if (product) {
                            window.location.href = `/product/${product.slug}`;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading product:', error);
                });
        }
    }

    // Populate quick view modal
    function populateQuickViewModal(product, modal) {
        // Update modal content with product data
        const productName = modal.querySelector('.product-name');
        if (productName) productName.textContent = product.name;

        const productPrice = modal.querySelector('.product-price');
        if (productPrice) {
            const price = product.sale_price || product.price;
            productPrice.textContent = `$${parseFloat(price).toFixed(2)}`;
        }

        const productImage = modal.querySelector('.product-img img');
        if (productImage && product.image) {
            productImage.src = product.image.startsWith('http') ? product.image : `/storage/${product.image}`;
        }

        // Set product ID for add to cart
        const addCartBtn = modal.querySelector('.add-cart-btn');
        if (addCartBtn) {
            addCartBtn.setAttribute('data-product-id', product.id);
        }
    }

    // Update cart count
    function updateCartCount() {
        fetch('/api/cart/count', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const count = data.data?.count || data.count || 0;
                    const cartCountElements = document.querySelectorAll('.cart-count, .cart-count-number, .cart-quantity, [data-cart-count]');
                    cartCountElements.forEach(el => {
                        el.textContent = count;
                        if (el.style) {
                            el.style.display = count > 0 ? 'block' : 'none';
                        }
                    });
                }
            })
            .catch(error => console.error('Error updating cart count:', error));
    }

    // Load cart items
    function loadCartItems() {
        fetch('/api/cart', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const cartList = document.querySelector('.list-cart, .list-product.cart-items, .cart-items');
                    if (cartList) {
                        cartList.innerHTML = '';
                        // API returns data.data.items or data.data directly
                        const items = data.data?.items || data.data || [];
                        if (items && items.length > 0) {
                            let total = 0;
                            items.forEach(item => {
                                const cartItem = createCartItemElement(item);
                                cartList.appendChild(cartItem);
                                const price = parseFloat(item.product?.sale_price || item.product?.price || item.unit_price || 0);
                                total += price * item.quantity;
                            });
                            
                            // Update total - use API total if available, otherwise calculate
                            const totalFromAPI = data.data?.total || total;
                            const totalElement = document.querySelector('.total-price');
                            if (totalElement) {
                                totalElement.textContent = totalFromAPI.toFixed(2);
                            }
                        } else {
                            cartList.innerHTML = '<div class="text-center py-10 text-secondary">Your cart is empty</div>';
                            const totalElement = document.querySelector('.total-price');
                            if (totalElement) {
                                totalElement.textContent = '0.00';
                            }
                        }
                    }
                }
            })
            .catch(error => console.error('Error loading cart:', error));
    }

    // Create cart item element
    function createCartItemElement(item) {
        const div = document.createElement('div');
        div.className = 'product-item item pb-5 flex items-center justify-between gap-3 border-b border-line';
        
        // Get image URL - match Laravel asset() helper logic
        function getImageUrl(path) {
            if (!path) return '/assets/images/product/perch-bottal.webp';
            
            // Full URL
            if (path.startsWith('http://') || path.startsWith('https://')) {
                return path;
            }
            
            // Asset path (assets/ or /assets/)
            if (path.startsWith('assets/') || path.startsWith('/assets/')) {
                return path.startsWith('/') ? path : '/' + path;
            }
            
            // Storage path - Laravel asset('storage/' . $path)
            // If path already has storage/, use it, otherwise add it
            if (path.startsWith('storage/') || path.startsWith('/storage/')) {
                return path.startsWith('/') ? path : '/' + path;
            }
            
            // Default: assume it's a storage path
            return '/storage/' + path;
        }
        
        const imageUrl = getImageUrl(item.product?.image);
        
        const price = parseFloat(item.product?.sale_price || item.product?.price || 0);
        const totalPrice = price * item.quantity;
        
        div.innerHTML = `
            <div class="infor flex items-center gap-5">
                <div class="bg-img">
                    <img src="${imageUrl}" alt="${item.product?.name || 'Product'}" class="w-[100px] aspect-square flex-shrink-0 rounded-lg object-cover" />
                </div>
                <div>
                    <div class="name text-button">${item.product?.name || 'Product'}</div>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="product-price text-title">$${price.toFixed(2)}</div>
                        ${item.size ? `<span class="text-sm text-secondary2">Size: ${item.size}</span>` : ''}
                        ${item.color ? `<span class="text-sm text-secondary2">Color: ${item.color}</span>` : ''}
                    </div>
                    <div class="text-sm text-secondary2 mt-1">Qty: ${item.quantity} × $${price.toFixed(2)} = $${totalPrice.toFixed(2)}</div>
                </div>
            </div>
            <button class="remove-cart-item button-main sm:py-3 py-2 sm:px-5 px-4 bg-red hover:bg-red-700 text-white rounded-full cursor-pointer" data-cart-id="${item.id}">Remove</button>
        `;
        
        // Add remove functionality
        const removeBtn = div.querySelector('.remove-cart-item');
        if (removeBtn) {
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                removeCartItem(item.id);
            });
        }
        
        return div;
    }
    
    // Remove cart item
    function removeCartItem(cartId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        fetch(`/api/cart/remove/${cartId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount();
                loadCartItems();
                showNotification('Item removed from cart', 'success');
            } else {
                showNotification(data.message || 'Failed to remove item', 'error');
            }
        })
        .catch(error => {
            console.error('Error removing cart item:', error);
            showNotification('An error occurred', 'error');
        });
    }

    // Show notification
    function showNotification(message, type = 'success') {
        // Remove existing notifications
        const existing = document.querySelector('.notification');
        if (existing) existing.remove();

        const notification = document.createElement('div');
        notification.className = `notification fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Quick shop functionality
    function initQuickShop() {
        document.addEventListener('click', function(e) {
            const quickShopBtn = e.target.closest('.quick-shop-btn');
            if (!quickShopBtn) return;

            e.preventDefault();
            e.stopPropagation();

            const productId = quickShopBtn.getAttribute('data-product-id');
            const productItem = quickShopBtn.closest('.product-item');
            const quickShopBlock = productItem?.querySelector('.quick-shop-block');
            
            if (quickShopBlock) {
                quickShopBlock.classList.toggle('hidden');
            }
        });
        
        // Handle size selection
        document.addEventListener('click', function(e) {
            const sizeItem = e.target.closest('.size-item');
            if (!sizeItem || !sizeItem.closest('.quick-shop-block')) return;
            
            e.preventDefault();
            e.stopPropagation();
            
            // Remove active class from siblings
            const siblings = sizeItem.parentElement.querySelectorAll('.size-item');
            siblings.forEach(sib => sib.classList.remove('active'));
            
            // Add active class to clicked item
            sizeItem.classList.add('active');
        });
        
        // Handle color selection
        document.addEventListener('click', function(e) {
            const colorItem = e.target.closest('.color-item');
            if (!colorItem || !colorItem.closest('.quick-shop-block')) return;
            
            e.preventDefault();
            e.stopPropagation();
            
            // Remove active class from siblings
            const siblings = colorItem.parentElement.querySelectorAll('.color-item');
            siblings.forEach(sib => sib.classList.remove('active'));
            
            // Add active class to clicked item
            colorItem.classList.add('active');
        });
    }

    // Initialize checkout button
    function initCheckoutButton() {
        const checkoutForm = document.getElementById('checkout-form');
        const checkoutBtn = document.getElementById('checkout-link');
        
        if (!checkoutForm || !checkoutBtn) {
            // Retry after a delay if not found
            setTimeout(initCheckoutButton, 500);
            return;
        }

        // Get form action URL
        const checkoutUrl = checkoutForm.getAttribute('action');
        if (!checkoutUrl || checkoutUrl === '#') {
            console.error('Checkout URL not found');
            return;
        }

        // Remove any existing handlers by cloning the form
        const newForm = checkoutForm.cloneNode(true);
        const newBtn = newForm.querySelector('#checkout-link');
        checkoutForm.parentNode.replaceChild(newForm, checkoutForm);

        // Direct navigation function
        const navigateToCheckout = function() {
            console.log('Navigating to:', checkoutUrl);
            // Use replace to avoid back button issues
            window.location.replace(checkoutUrl);
            // Fallback if replace doesn't work
            setTimeout(function() {
                if (window.location.href.indexOf(checkoutUrl) === -1) {
                    window.location.href = checkoutUrl;
                }
            }, 100);
        };

        // Handle form submission - prevent default and navigate
        newForm.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            navigateToCheckout();
            return false;
        }, true);

        // Handle button click - prevent default and navigate
        if (newBtn) {
            newBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                navigateToCheckout();
                return false;
            }, true);
            
            // Also handle mousedown to catch early
            newBtn.addEventListener('mousedown', function(e) {
                if (e.button === 0) { // Left click
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);
        }
    }

    // Load checkout cart items
    function loadCheckoutCartItems() {
        fetch('/api/cart', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const checkoutList = document.querySelector('.list-product-checkout');
                    if (checkoutList) {
                        checkoutList.innerHTML = '';
                        const items = data.data?.items || data.data || [];
                        if (items && items.length > 0) {
                            let total = 0;
                            items.forEach(item => {
                                const checkoutItem = createCheckoutItemElement(item);
                                checkoutList.appendChild(checkoutItem);
                                const price = parseFloat(item.product?.sale_price || item.product?.price || item.unit_price || 0);
                                total += price * item.quantity;
                            });
                            
                            // Update total - use API total if available
                            const totalFromAPI = data.data?.total || total;
                            const totalElement = document.querySelector('.total-cart, .checkout-total');
                            if (totalElement) {
                                totalElement.textContent = totalFromAPI.toFixed(2);
                            }
                        } else {
                            checkoutList.innerHTML = '<div class="text-center py-10 text-secondary">Your cart is empty</div>';
                            const totalElement = document.querySelector('.total-cart, .checkout-total');
                            if (totalElement) {
                                totalElement.textContent = '0.00';
                            }
                        }
                    }
                }
            })
            .catch(error => console.error('Error loading checkout cart:', error));
    }
    
    // Load cart page items
    function loadCartPageItems() {
        fetch('/api/cart', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const cartList = document.querySelector('.list-product-main');
                    if (cartList) {
                        cartList.innerHTML = '';
                        const items = data.data?.items || data.data || [];
                        if (items && items.length > 0) {
                            let subtotal = 0;
                            items.forEach(item => {
                                const cartItem = createCartPageItemElement(item);
                                cartList.appendChild(cartItem);
                                const price = parseFloat(item.product?.sale_price || item.product?.price || item.unit_price || 0);
                                subtotal += price * item.quantity;
                            });
                            
                            // Update subtotal
                            const subtotalElement = document.querySelector('.total-product');
                            if (subtotalElement) {
                                subtotalElement.textContent = subtotal.toFixed(2).split('.')[0];
                                const centsElement = subtotalElement.nextElementSibling;
                                if (centsElement && centsElement.tagName === 'SPAN') {
                                    centsElement.textContent = '.' + subtotal.toFixed(2).split('.')[1];
                                }
                            }
                            
                            // Update total (subtotal - discount + shipping)
                            updateCartPageTotal(subtotal);
                        } else {
                            cartList.innerHTML = '<div class="text-center py-10 text-secondary col-span-full">Your cart is empty</div>';
                            updateCartPageTotal(0);
                        }
                    }
                }
            })
            .catch(error => console.error('Error loading cart page items:', error));
    }
    
    // Create cart page item element (table row format)
    function createCartPageItemElement(item) {
        const row = document.createElement('div');
        row.className = 'product-item-cart flex items-center py-4 border-b border-line';
        row.setAttribute('data-cart-id', item.id);
        
        // Get image URL
        function getImageUrl(path) {
            if (!path) return '/assets/images/product/perch-bottal.webp';
            if (path.startsWith('http://') || path.startsWith('https://')) return path;
            if (path.startsWith('assets/') || path.startsWith('/assets/')) {
                return path.startsWith('/') ? path : '/' + path;
            }
            if (path.startsWith('storage/') || path.startsWith('/storage/')) {
                return path.startsWith('/') ? path : '/' + path;
            }
            return '/storage/' + path;
        }
        
        const imageUrl = getImageUrl(item.product?.image);
        const price = parseFloat(item.product?.sale_price || item.product?.price || item.unit_price || 0);
        const totalPrice = price * item.quantity;
        
        row.innerHTML = `
            <div class="w-1/2 flex items-center gap-4">
                <div class="bg-img">
                    <img src="${imageUrl}" alt="${item.product?.name || 'Product'}" class="w-20 h-20 object-cover rounded-lg" />
                </div>
                <div>
                    <div class="name text-button font-semibold">${item.product?.name || 'Product'}</div>
                    ${item.size || item.color ? `
                        <div class="text-sm text-secondary2 mt-1">
                            ${item.size ? `Size: ${item.size}` : ''}
                            ${item.size && item.color ? ' | ' : ''}
                            ${item.color ? `Color: ${item.color}` : ''}
                        </div>
                    ` : ''}
                </div>
            </div>
            <div class="w-1/12 text-center">
                <div class="product-price text-title">$${price.toFixed(2)}</div>
            </div>
            <div class="w-1/6 flex items-center justify-center">
                <div class="quantity-block flex items-center gap-3 border border-line rounded-lg px-3 py-2">
                    <i class="ph-bold ph-minus cursor-pointer text-lg quantity-decrease" data-cart-id="${item.id}"></i>
                    <div class="quantity text-button font-semibold">${item.quantity}</div>
                    <i class="ph-bold ph-plus cursor-pointer text-lg quantity-increase" data-cart-id="${item.id}"></i>
                </div>
            </div>
            <div class="w-1/6 text-center">
                <div class="total-price text-title">$${totalPrice.toFixed(2)}</div>
            </div>
        `;
        
        // Add quantity update handlers
        const decreaseBtn = row.querySelector('.quantity-decrease');
        const increaseBtn = row.querySelector('.quantity-increase');
        const quantityElement = row.querySelector('.quantity');
        const totalPriceElement = row.querySelector('.total-price');
        
        if (decreaseBtn) {
            decreaseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const cartId = this.getAttribute('data-cart-id');
                let qty = parseInt(quantityElement.textContent) || 1;
                if (qty > 1) {
                    qty--;
                    updateCartItemQuantity(cartId, qty, quantityElement, totalPriceElement, price);
                }
            });
        }
        
        if (increaseBtn) {
            increaseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const cartId = this.getAttribute('data-cart-id');
                let qty = parseInt(quantityElement.textContent) || 1;
                qty++;
                updateCartItemQuantity(cartId, qty, quantityElement, totalPriceElement, price);
            });
        }
        
        return row;
    }
    
    // Update cart item quantity
    function updateCartItemQuantity(cartId, quantity, quantityElement, totalPriceElement, unitPrice) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        fetch(`/api/cart/update/${cartId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                quantityElement.textContent = quantity;
                const totalPrice = unitPrice * quantity;
                totalPriceElement.textContent = '$' + totalPrice.toFixed(2);
                updateCartCount();
                loadCartPageItems(); // Reload to update totals
            } else {
                showNotification(data.message || 'Failed to update quantity', 'error');
            }
        })
        .catch(error => {
            console.error('Error updating quantity:', error);
            showNotification('An error occurred', 'error');
        });
    }
    
    // Update cart page total
    function updateCartPageTotal(subtotal) {
        const discountElement = document.querySelector('.discount');
        const discount = discountElement ? parseFloat(discountElement.textContent) || 0 : 0;
        
        // Get shipping cost
        const shippingRadio = document.querySelector('input[name="ship"]:checked');
        let shipping = 0;
        if (shippingRadio) {
            if (shippingRadio.value) {
                shipping = parseFloat(shippingRadio.value.replace(/[{}]/g, '')) || 0;
            } else if (shippingRadio.id === 'shipping') {
                shipping = 0; // Free shipping
            } else if (shippingRadio.id === 'local') {
                shipping = 30;
            } else if (shippingRadio.id === 'flat') {
                shipping = 40;
            }
        }
        
        const total = subtotal - discount + shipping;
        
        // Update total display - format like $116.00
        const totalElement = document.querySelector('.total-cart');
        if (totalElement) {
            const totalParts = total.toFixed(2).split('.');
            totalElement.textContent = totalParts[0];
            const nextSibling = totalElement.nextElementSibling;
            if (nextSibling && nextSibling.tagName === 'SPAN') {
                nextSibling.textContent = '.' + totalParts[1];
            } else {
                totalElement.textContent = total.toFixed(2);
            }
        }
    }
    
    // Handle shipping selection change
    document.addEventListener('change', function(e) {
        if (e.target.name === 'ship') {
            const cartList = document.querySelector('.list-product-main');
            if (cartList && cartList.children.length > 0) {
                // Recalculate total with new shipping
                fetch('/api/cart', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const items = data.data?.items || data.data || [];
                        let subtotal = 0;
                        items.forEach(item => {
                            const price = parseFloat(item.product?.sale_price || item.product?.price || item.unit_price || 0);
                            subtotal += price * item.quantity;
                        });
                        updateCartPageTotal(subtotal);
                    }
                });
            }
        }
    });

    // Create checkout item element
    function createCheckoutItemElement(item) {
        const div = document.createElement('div');
        div.className = 'product-item-checkout flex items-center justify-between gap-3 py-4 border-b border-line';
        
        // Get image URL - use same function as cart items
        function getImageUrl(path) {
            if (!path) return '/assets/images/product/perch-bottal.webp';
            if (path.startsWith('http://') || path.startsWith('https://')) return path;
            if (path.startsWith('assets/') || path.startsWith('/assets/')) {
                return path.startsWith('/') ? path : '/' + path;
            }
            if (path.startsWith('storage/') || path.startsWith('/storage/')) {
                return path.startsWith('/') ? path : '/' + path;
            }
            return '/storage/' + path;
        }
        const imageUrl = getImageUrl(item.product?.image);
        
        const price = parseFloat(item.product?.sale_price || item.product?.price || 0);
        const totalPrice = price * item.quantity;
        
        div.innerHTML = `
            <div class="infor flex items-center gap-3">
                <div class="bg-img">
                    <img src="${imageUrl}" alt="${item.product?.name || 'Product'}" class="w-[60px] aspect-square flex-shrink-0 rounded-lg object-cover" />
                </div>
                <div>
                    <div class="name text-sm font-semibold">${item.product?.name || 'Product'}</div>
                    <div class="text-xs text-secondary2 mt-1">
                        ${item.size ? `Size: ${item.size} ` : ''}
                        ${item.color ? `Color: ${item.color}` : ''}
                    </div>
                    <div class="text-xs text-secondary2 mt-1">Qty: ${item.quantity}</div>
                </div>
            </div>
            <div class="text-title">$${totalPrice.toFixed(2)}</div>
        `;
        
        return div;
    }

    // Initialize all functionality
    function init() {
        initAddToCart();
        initQuickView();
        initQuickShop();
        updateCartCount();
        
        // Load cart on page load
        if (document.querySelector('.modal-cart-block')) {
            loadCartItems();
        }
        
        // Load checkout cart items if on checkout page
        if (document.querySelector('.list-product-checkout')) {
            loadCheckoutCartItems();
        }
        
        // Load cart page items if on cart page
        if (document.querySelector('.list-product-main')) {
            loadCartPageItems();
        }
        
        // Initialize checkout button handler
        initCheckoutButton();
        
        // Load cart when cart modal opens
        const cartModal = document.querySelector('.modal-cart-block');
        if (cartModal) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        if (cartModal.classList.contains('open')) {
                            loadCartItems();
                        }
                    }
                });
            });
            observer.observe(cartModal, { attributes: true });
        }
    }

    // Make functions globally accessible
    window.updateCartCount = updateCartCount;
    window.loadCartItems = loadCartItems;
    window.loadCartPageItems = loadCartPageItems;
    window.removeCartItem = removeCartItem;
    window.showNotification = showNotification;

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
