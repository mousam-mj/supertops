<script src="{{ asset('assets/js/phosphor-icons.js') }}"></script>
<script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}?v={{ filemtime(public_path('assets/js/main.js')) }}"></script>
@include('partials.ecommerce-tracking-js')
<script src="{{ asset('assets/js/cart.js') }}?v={{ filemtime(public_path('assets/js/cart.js')) }}"></script>