<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.setting-image-reset-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var field = btn.closest('[data-setting-image-field]');
            if (!field) {
                return;
            }
            var resetFlag = field.querySelector('.setting-image-reset-flag');
            var preview = field.querySelector('.setting-image-preview');
            var fileInput = field.querySelector('.setting-image-file');
            if (resetFlag) {
                resetFlag.value = '1';
            }
            if (preview && btn.dataset.defaultUrl) {
                preview.src = btn.dataset.defaultUrl;
            }
            if (fileInput) {
                fileInput.value = '';
            }
            btn.disabled = true;
            btn.classList.add('disabled');
        });
    });

    document.querySelectorAll('.setting-image-file').forEach(function (input) {
        input.addEventListener('change', function () {
            var field = input.closest('[data-setting-image-field]');
            if (!field || !input.files || !input.files[0]) {
                return;
            }
            var preview = field.querySelector('.setting-image-preview');
            var resetFlag = field.querySelector('.setting-image-reset-flag');
            if (resetFlag) {
                resetFlag.value = '0';
            }
            if (preview) {
                preview.src = URL.createObjectURL(input.files[0]);
            }
            var resetBtn = field.querySelector('.setting-image-reset-btn');
            if (resetBtn) {
                resetBtn.disabled = false;
                resetBtn.classList.remove('disabled');
            }
        });
    });
});
</script>
