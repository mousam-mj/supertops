<script>
window.dataLayer = window.dataLayer || [];
window.pushEcommerceEvent = function (eventName, ecommercePayload) {
    if (!eventName || !ecommercePayload) {
        return;
    }
    window.dataLayer.push({ ecommerce: null });
    window.dataLayer.push({
        event: eventName,
        ecommerce: ecommercePayload
    });
};
</script>
