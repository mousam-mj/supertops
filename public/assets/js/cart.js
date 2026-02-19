// Cart functionality for dynamic products
(function() {
    'use strict';

    // Add to cart functionality
    let isAddingToCart = false; // Prevent double clicks
    
    function initAddToCart() {
        document.addEventListener('click', function(e) {
            const addCartBtn = e.target.closest('.add-cart-btn');
            if (!addCartBtn) return;

            // Skip if already processing or if it's from product detail page (handled separately)
            if (addCartBtn.closest('.product-infor')) {
                return; // Let product detail page handler take care of it
            }

            // Prevent double clicks
            if (isAddingToCart || addCartBtn.disabled) {
                e.preventDefault();
                e.stopPropagation();
                return;
            }

            e.preventDefault();
            e.stopPropagation();

            const productId = addCartBtn.getAttribute('data-product-id');
            if (!productId) {
                console.error('Product ID not found');
                return;
            }

            // Set flag to prevent double clicks
            isAddingToCart = true;

            // Get size and color if available
            const sizeItem = addCartBtn.closest('.product-item')?.querySelector('.size-item.active');
            const colorItem = addCartBtn.closest('.product-item')?.querySelector('.color-item.active');
            
            const size = sizeItem?.getAttribute('data-size') || null;
            const color = colorItem?.getAttribute('data-color') || null;

            // Show loading state
            const originalText = addCartBtn.innerHTML;
            const originalDisabled = addCartBtn.disabled;
            addCartBtn.innerHTML = '<i class="ph ph-spinner ph-spin text-xl"></i> Adding...';
            addCartBtn.disabled = true;
            addCartBtn.style.pointerEvents = 'none';

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
                    
                    // Open cart modal - use layout's modal (last in DOM when home has duplicates)
                    const allCart = document.querySelectorAll('.modal-cart-block .modal-cart-main');
                    const cartModalMain = allCart.length ? allCart[allCart.length - 1] : null;
                    if (cartModalMain) {
                        cartModalMain.classList.add('open');
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
                // Always reset button state
                addCartBtn.innerHTML = originalText;
                addCartBtn.disabled = originalDisabled;
                addCartBtn.style.pointerEvents = '';
                isAddingToCart = false;
            });
        });
    }

    // Quick view functionality - open modal with product (capture:true to run first)
    function initQuickView() {
        document.addEventListener('click', function(e) {
            const quickViewBtn = e.target.closest('.quick-view-btn');
            if (!quickViewBtn) return;

            e.preventDefault();
            e.stopPropagation();

            let productId = quickViewBtn.getAttribute('data-product-id');
            let productSlug = quickViewBtn.getAttribute('data-product-slug');
            if (!productSlug && !productId) {
                const productItem = quickViewBtn.closest('.product-item, [data-item]');
                if (productItem) {
                    productId = productId || productItem.getAttribute('data-item');
                    const slugEl = productItem.querySelector('[data-product-slug]');
                    productSlug = productSlug || (slugEl ? slugEl.getAttribute('data-product-slug') : null);
                }
            }

            if (productSlug) {
                loadQuickViewProductBySlug(productSlug);
            } else if (productId) {
                loadQuickViewProductById(productId);
            } else {
                console.warn('[QUICK VIEW] No product slug or id found');
            }
        }, true);

        // Close quick view on overlay/close click
        document.addEventListener('click', function(e) {
            if (e.target.closest('.modal-quickview-block .close-btn') || (e.target.closest('.modal-quickview-block') && !e.target.closest('.modal-quickview-main'))) {
                const all = document.querySelectorAll('.modal-quickview-block .modal-quickview-main');
                const main = all.length ? all[all.length - 1] : null;
                if (main) {
                    main.classList.remove('open');
                    document.body.style.overflow = '';
                }
            }
        });
        document.querySelectorAll('.modal-quickview-main').forEach(function(m) {
            m.addEventListener('click', function(e) { e.stopPropagation(); });
        });
    }

    function getQuickViewModal() {
        const all = document.querySelectorAll('.modal-quickview-block .modal-quickview-main');
        return all.length ? all[all.length - 1] : null;
    }

    function loadQuickViewProductBySlug(slug) {
        fetch(`/api/products/${encodeURIComponent(slug)}`, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
            .then(response => response.ok ? response.json() : null)
            .then(data => {
                if (data && data.success && data.data) {
                    showQuickViewModal(data.data);
                } else {
                    window.location.href = `/product/${slug}`;
                }
            })
            .catch(() => { window.location.href = `/product/${slug}`; });
    }

    function loadQuickViewProductById(productId) {
        const productItem = document.querySelector(`[data-item="${productId}"]`);
        const slug = productItem?.querySelector('.quick-view-btn')?.getAttribute('data-product-slug');
        if (slug) {
            loadQuickViewProductBySlug(slug);
        } else {
            fetch(`/api/products?per_page=100`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data?.data) {
                        const p = data.data.data.find(x => x.id == productId);
                        if (p?.slug) loadQuickViewProductBySlug(p.slug);
                    }
                })
                .catch(() => {});
        }
    }

    function getImageUrl(path) {
        if (!path) return '/assets/images/product/perch-bottal.webp';
        if (path.startsWith('http')) return path;
        if (path.startsWith('assets/') || path.startsWith('/assets/')) return path.startsWith('/') ? path : '/' + path;
        return path.startsWith('storage/') ? '/' + path : '/storage/' + path;
    }

    function showQuickViewModal(product) {
        const main = getQuickViewModal();
        if (!main) return;

        const img = product.image || (product.images && product.images[0]);
        const imgUrl = getImageUrl(img);
        const listImg = main.querySelector('.list-img');
        if (listImg) {
            listImg.innerHTML = `<div class="bg-img w-full aspect-[3/4] max-md:w-[150px] max-md:flex-shrink-0 rounded-[20px] overflow-hidden md:mt-6"><img src="${imgUrl}" alt="${(product.name || '').replace(/"/g, '&quot;')}" class="w-full h-full object-cover" /></div>`;
        }

        const category = main.querySelector('.product-infor .category');
        if (category) category.textContent = product.category?.name || '';

        const name = main.querySelector('.product-infor .name');
        if (name) name.textContent = product.name || '';

        const price = main.querySelector('.product-infor .product-price');
        const salePrice = parseFloat(product.sale_price || product.price || 0);
        const origPrice = parseFloat(product.price || 0);
        if (price) price.textContent = '₹' + salePrice.toFixed(2);
        const origEl = main.querySelector('.product-infor .product-origin-price');
        if (origEl) {
            origEl.style.display = origPrice > salePrice ? 'block' : 'none';
            const del = origEl.querySelector('del');
            if (del) del.textContent = '₹' + origPrice.toFixed(2);
        }
        const saleEl = main.querySelector('.product-infor .product-sale');
        if (saleEl && origPrice > salePrice) {
            const pct = Math.round(((origPrice - salePrice) / origPrice) * 100);
            saleEl.textContent = '-' + pct + '%';
            saleEl.style.display = 'inline-block';
        }

        const addCart = main.querySelector('.add-cart-btn');
        if (addCart) {
            addCart.setAttribute('data-product-id', product.id);
        }
        const viewLink = main.querySelector('.view-product-link');
        if (viewLink && product.slug) viewLink.href = '/product/' + product.slug;

        main.classList.add('open');
        document.body.style.overflow = 'hidden';
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
                    // Use layout's modal (last in DOM when home has duplicates)
                    const allBlocks = document.querySelectorAll('.modal-cart-block');
                    const cartBlock = allBlocks.length ? allBlocks[allBlocks.length - 1] : null;
                    const cartList = cartBlock ? cartBlock.querySelector('.list-cart, .list-product.cart-items, .cart-items') : document.querySelector('.list-cart, .list-product.cart-items, .cart-items');
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
                            const totalElement = cartBlock ? cartBlock.querySelector('.total-price') : document.querySelector('.total-price');
                            if (totalElement) {
                                totalElement.textContent = totalFromAPI.toFixed(2);
                            }
                            
                            // Update freeship progress
                            const morePriceEl = cartBlock ? cartBlock.querySelector('.more-price') : null;
                            const progressLine = cartBlock ? cartBlock.querySelector('.tow-bar-block .progress-line') : null;
                            if (morePriceEl && progressLine) {
                                const moneyForFreeship = 150;
                                const remaining = Math.max(0, moneyForFreeship - totalFromAPI);
                                morePriceEl.textContent = remaining.toFixed(2);
                                const progressPercent = totalFromAPI >= moneyForFreeship ? 100 : (totalFromAPI / moneyForFreeship * 100);
                                progressLine.style.width = progressPercent + '%';
                            }
                        } else {
                            cartList.innerHTML = '<div class="text-center py-10 text-secondary">Your cart is empty</div>';
                            const totalElement = cartBlock ? cartBlock.querySelector('.total-price') : document.querySelector('.total-price');
                            if (totalElement) {
                                totalElement.textContent = '0.00';
                            }
                            // Reset freeship progress
                            const morePriceEl = cartBlock ? cartBlock.querySelector('.more-price') : null;
                            const progressLine = cartBlock ? cartBlock.querySelector('.tow-bar-block .progress-line') : null;
                            if (morePriceEl) morePriceEl.textContent = '150.00';
                            if (progressLine) progressLine.style.width = '0%';
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
            <div class="infor flex items-center gap-5 w-full">
                <div class="bg-img">
                    <img src="${imageUrl}" alt="${item.product?.name || 'Product'}" class="w-[100px] aspect-square flex-shrink-0 rounded-lg object-cover" />
                </div>
                <div class="flex-1">
                    <div class="name text-button">${item.product?.name || 'Product'}</div>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="product-price text-title">₹${price.toFixed(2)}</div>
                        ${item.size ? `<span class="text-sm text-secondary2">Size: ${item.size}</span>` : ''}
                        ${item.color ? `<span class="text-sm text-secondary2">Color: ${item.color}</span>` : ''}
                    </div>
                    <div class="flex items-center gap-3 mt-3">
                        <div class="quantity-block flex items-center gap-2 border border-line rounded-lg px-2 py-1">
                            <i class="ph-bold ph-minus cursor-pointer text-sm quantity-decrease text-secondary2 hover:text-black" data-cart-id="${item.id}"></i>
                            <div class="quantity text-button font-semibold min-w-[30px] text-center">${item.quantity}</div>
                            <i class="ph-bold ph-plus cursor-pointer text-sm quantity-increase text-secondary2 hover:text-black" data-cart-id="${item.id}"></i>
                        </div>
                        <div class="text-sm text-secondary2 item-total-price">= ₹${totalPrice.toFixed(2)}</div>
                    </div>
                </div>
            </div>
            <button class="remove-cart-item button-main sm:py-3 py-2 sm:px-5 px-4 bg-red hover:bg-red-700 text-white rounded-full cursor-pointer flex-shrink-0" data-cart-id="${item.id}">Remove</button>
        `;
        
        // Add remove functionality - using direct event listener
        const removeBtn = div.querySelector('.remove-cart-item');
        if (removeBtn) {
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                const cartId = this.getAttribute('data-cart-id') || item.id;
                if (cartId) {
                    removeCartItem(cartId);
                }
            });
        }

        // Add quantity increase/decrease functionality
        const decreaseBtn = div.querySelector('.quantity-decrease');
        const increaseBtn = div.querySelector('.quantity-increase');
        const quantityElement = div.querySelector('.quantity');
        const totalPriceElement = div.querySelector('.item-total-price');

        if (decreaseBtn && quantityElement) {
            decreaseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                const cartId = this.getAttribute('data-cart-id') || item.id;
                let qty = parseInt(quantityElement.textContent) || 1;
                if (qty > 1) {
                    qty--;
                    updateCartItemQuantityInModal(cartId, qty, quantityElement, totalPriceElement, price);
                } else if (qty === 1) {
                    // Remove item when quantity reaches 0
                    if (confirm('Remove this item from cart?')) {
                        removeCartItem(cartId);
                    }
                }
            });
        }

        if (increaseBtn && quantityElement) {
            increaseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                const cartId = this.getAttribute('data-cart-id') || item.id;
                let qty = parseInt(quantityElement.textContent) || 1;
                qty++;
                updateCartItemQuantityInModal(cartId, qty, quantityElement, totalPriceElement, price);
            });
        }
        
        return div;
    }

    // Update cart item quantity in modal
    function updateCartItemQuantityInModal(cartId, quantity, quantityElement, totalPriceElement, unitPrice) {
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
                if (totalPriceElement) {
                    totalPriceElement.textContent = `= ₹${totalPrice.toFixed(2)}`;
                }
                // Reload cart to update totals
                loadCartItems();
                updateCartCount();
            } else {
                showNotification(data.message || 'Failed to update quantity', 'error');
            }
        })
        .catch(error => {
            console.error('Error updating quantity:', error);
            showNotification('An error occurred', 'error');
        });
    }
    
    // Remove cart item
    function removeCartItem(cartId) {
        if (!cartId) {
            console.error('Cart ID is required to remove item');
            showNotification('Error: Cart ID not found', 'error');
            return;
        }
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        // Show loading state
        const removeBtn = document.querySelector(`.remove-cart-item[data-cart-id="${cartId}"]`);
        if (removeBtn) {
            removeBtn.disabled = true;
            removeBtn.style.opacity = '0.5';
            removeBtn.style.pointerEvents = 'none';
        }
        
        fetch(`/api/cart/remove/${cartId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Failed to remove item');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                updateCartCount();
                loadCartItems();
                // Also reload cart page if on cart page
                if (document.querySelector('.list-product-main')) {
                    loadCartPageItems();
                }
                showNotification('Item removed from cart', 'success');
            } else {
                showNotification(data.message || 'Failed to remove item', 'error');
            }
        })
        .catch(error => {
            console.error('Error removing cart item:', error);
            showNotification(error.message || 'An error occurred while removing item', 'error');
        })
        .finally(() => {
            // Reset button state
            if (removeBtn) {
                removeBtn.disabled = false;
                removeBtn.style.opacity = '';
                removeBtn.style.pointerEvents = '';
            }
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

    // Quick shop = opens Quick View modal (same as Quick View, for quick add-to-cart)
    function initQuickShop() {
        document.addEventListener('click', function(e) {
            const quickShopBtn = e.target.closest('.quick-shop-btn');
            if (!quickShopBtn) return;
            e.preventDefault();
            e.stopPropagation();
            let slug = quickShopBtn.getAttribute('data-product-slug');
            let id = quickShopBtn.getAttribute('data-product-id');
            if (!slug && id) {
                const qv = quickShopBtn.closest('.product-item')?.querySelector('.quick-view-btn');
                if (qv) slug = qv.getAttribute('data-product-slug');
            }
            if (slug) loadQuickViewProductBySlug(slug);
            else if (id) loadQuickViewProductById(id);
        }, true);
        
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
            <div class="w-2/5 flex items-center gap-4">
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
                <div class="product-price text-title">₹${price.toFixed(2)}</div>
            </div>
            <div class="w-1/6 flex items-center justify-center">
                <div class="quantity-block flex items-center gap-3 border border-line rounded-lg px-3 py-2">
                    <i class="ph-bold ph-minus cursor-pointer text-lg quantity-decrease" data-cart-id="${item.id}"></i>
                    <div class="quantity text-button font-semibold">${item.quantity}</div>
                    <i class="ph-bold ph-plus cursor-pointer text-lg quantity-increase" data-cart-id="${item.id}"></i>
                </div>
            </div>
            <div class="w-1/6 text-center">
                <div class="total-price text-title">₹${totalPrice.toFixed(2)}</div>
            </div>
            <div class="w-1/12 text-center">
                <button class="remove-cart-item-btn text-red hover:text-red-700 cursor-pointer font-semibold text-sm underline" data-cart-id="${item.id}">
                    Remove
                </button>
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

        // Add remove button functionality
        const removeBtn = row.querySelector('.remove-cart-item-btn');
        if (removeBtn) {
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const cartId = this.getAttribute('data-cart-id');
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    removeCartItem(cartId);
                }
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
                totalPriceElement.textContent = '₹' + totalPrice.toFixed(2);
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
            <div class="text-title">₹${totalPrice.toFixed(2)}</div>
        `;
        
        return div;
    }

    // Initialize event delegation for remove buttons (fallback)
    function initRemoveButtonDelegation() {
        // Use event delegation on cart modal container
        document.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-cart-item');
            if (!removeBtn) return;
            
            // Only handle if inside cart modal
            const cartModal = removeBtn.closest('.modal-cart-block');
            if (!cartModal) return;
            
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            const cartId = removeBtn.getAttribute('data-cart-id');
            if (cartId) {
                removeCartItem(cartId);
            }
        }, true); // Use capture phase to catch early
        
        // Also handle quantity decrease/increase with delegation
        document.addEventListener('click', function(e) {
            const decreaseBtn = e.target.closest('.quantity-decrease');
            const increaseBtn = e.target.closest('.quantity-increase');
            
            if (!decreaseBtn && !increaseBtn) return;
            
            const cartModal = (decreaseBtn || increaseBtn).closest('.modal-cart-block');
            if (!cartModal) return;
            
            const btn = decreaseBtn || increaseBtn;
            const cartId = btn.getAttribute('data-cart-id');
            if (!cartId) return;
            
            const itemElement = btn.closest('.product-item.item, .item');
            if (!itemElement) return;
            
            const quantityElement = itemElement.querySelector('.quantity');
            const totalPriceElement = itemElement.querySelector('.item-total-price');
            
            if (!quantityElement) return;
            
            let qty = parseInt(quantityElement.textContent) || 1;
            const priceText = itemElement.querySelector('.product-price')?.textContent || '0';
            const unitPrice = parseFloat(priceText.replace(/[₹,]/g, '')) || 0;
            
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            if (decreaseBtn) {
                if (qty > 1) {
                    qty--;
                    updateCartItemQuantityInModal(cartId, qty, quantityElement, totalPriceElement, unitPrice);
                } else if (qty === 1) {
                    if (confirm('Remove this item from cart?')) {
                        removeCartItem(cartId);
                    }
                }
            } else if (increaseBtn) {
                qty++;
                updateCartItemQuantityInModal(cartId, qty, quantityElement, totalPriceElement, unitPrice);
            }
        }, true);
    }

    // Initialize all functionality
    function init() {
        initAddToCart();
        initQuickView();
        initQuickShop();
        initRemoveButtonDelegation(); // Add event delegation
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
    window.openQuickView = function(slug) { if(slug) loadQuickViewProductBySlug(slug); };

    // Run when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
