/**
 * Search functionality with autocomplete suggestions
 */
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.modal-search-block .form-search input[type="text"]');
    const searchModal = document.querySelector('.modal-search-block');
    const searchModalMain = document.querySelector('.modal-search-block .modal-search-main');
    const suggestionsContainer = document.createElement('div');
    suggestionsContainer.className = 'search-suggestions absolute top-full left-0 right-0 mt-2 bg-white border border-line rounded-xl shadow-lg z-[100] max-h-96 overflow-y-auto';
    suggestionsContainer.style.display = 'none';
    suggestionsContainer.style.minWidth = '100%';
    
    let searchTimeout;
    let currentSearchQuery = '';

    if (!searchInput) return;

    // Insert suggestions container after the search form
    const searchForm = searchInput.closest('.form-search');
    if (searchForm) {
        searchForm.style.position = 'relative';
        searchForm.appendChild(suggestionsContainer);
    }

    // Handle input with debounce
    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        currentSearchQuery = query;

        // Clear previous timeout
        clearTimeout(searchTimeout);

        if (query.length < 2) {
            suggestionsContainer.style.display = 'none';
            return;
        }

        // Debounce search - wait 300ms after user stops typing
        searchTimeout = setTimeout(() => {
            performSearch(query);
        }, 300);
    });

    // Handle Enter key
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const query = e.target.value.trim();
            if (query.length > 0) {
                window.location.href = `/shop?search=${encodeURIComponent(query)}`;
            }
        } else if (e.key === 'Escape') {
            suggestionsContainer.style.display = 'none';
        }
    });

    // Close suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchForm.contains(e.target)) {
            suggestionsContainer.style.display = 'none';
        }
    });

    // Perform search via API
    function performSearch(query) {
        if (query.length < 2) {
            suggestionsContainer.style.display = 'none';
            return;
        }

        // Show loading state
        suggestionsContainer.innerHTML = '<div class="p-4 text-center text-secondary">Searching...</div>';
        suggestionsContainer.style.display = 'block';

        fetch(`/api/products/search?q=${encodeURIComponent(query)}&limit=8`)
            .then(response => response.json())
            .then(data => {
                // Check if query hasn't changed during fetch
                if (query !== currentSearchQuery) {
                    return;
                }

                if (data.success && data.data && data.data.length > 0) {
                    displaySuggestions(data.data, query);
                } else {
                    suggestionsContainer.innerHTML = `
                        <div class="p-4 text-center text-secondary">
                            <p class="body1 mb-2">No products found</p>
                            <p class="caption1">Try different keywords</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                suggestionsContainer.innerHTML = `
                    <div class="p-4 text-center text-red">
                        <p class="body1">Error searching products</p>
                    </div>
                `;
            });
    }

    // Display search suggestions
    function displaySuggestions(products, query) {
        const suggestionsHTML = products.map(product => {
            // Handle image URL
            let imageUrl = '/assets/images/product/perch-bottal.webp';
            if (product.image) {
                if (product.image.startsWith('http://') || product.image.startsWith('https://')) {
                    imageUrl = product.image;
                } else if (product.image.startsWith('assets/') || product.image.startsWith('/assets/')) {
                    imageUrl = product.image.startsWith('/') ? product.image : '/' + product.image;
                } else {
                    imageUrl = '/storage/' + product.image;
                }
            }
            
            const price = parseFloat(product.sale_price || product.price || 0);
            const originalPrice = product.sale_price ? parseFloat(product.price || 0) : null;
            const discount = originalPrice && originalPrice > 0 ? Math.round((1 - price / originalPrice) * 100) : 0;

            return `
                <a href="/product/${product.slug}" class="search-suggestion-item flex items-center gap-4 p-4 hover:bg-surface duration-300 border-b border-line last:border-b-0" onclick="event.stopPropagation();">
                    <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-surface">
                        <img src="${imageUrl}" alt="${product.name}" class="w-full h-full object-cover" onerror="this.src='/assets/images/product/perch-bottal.webp'" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-title text-sm font-semibold truncate">${highlightQuery(product.name, query)}</div>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-title text-sm">$${parseFloat(price).toFixed(2)}</span>
                            ${originalPrice ? `<span class="text-secondary2 text-xs"><del>$${parseFloat(originalPrice).toFixed(2)}</del></span>` : ''}
                            ${discount > 0 ? `<span class="text-green text-xs font-semibold">-${discount}%</span>` : ''}
                        </div>
                    </div>
                </a>
            `;
        }).join('');

        suggestionsContainer.innerHTML = suggestionsHTML;
        suggestionsContainer.style.display = 'block';
    }

    // Highlight search query in text
    function highlightQuery(text, query) {
        if (!query) return text;
        const regex = new RegExp(`(${query})`, 'gi');
        return text.replace(regex, '<mark class="bg-yellow">$1</mark>');
    }

    // Handle keyword buttons click
    const keywordButtons = document.querySelectorAll('.list-keyword .item');
    keywordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const keyword = this.textContent.trim();
            searchInput.value = keyword;
            searchInput.dispatchEvent(new Event('input'));
        });
    });

    // Handle search icon click in modal
    const searchIcon = searchForm?.querySelector('.search-icon-click, .ph-magnifying-glass');
    if (searchIcon) {
        searchIcon.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const query = searchInput.value.trim();
            if (query.length > 0) {
                window.location.href = `/shop?search=${encodeURIComponent(query)}`;
            }
        });
    }
});

