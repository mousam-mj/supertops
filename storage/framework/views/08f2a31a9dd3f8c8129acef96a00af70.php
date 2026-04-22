<?php $__env->startSection('title', 'Edit ' . $policy_page->title); ?>
<?php $__env->startSection('page-title', 'Edit ' . $policy_page->title); ?>

<?php $__env->startSection('content'); ?>
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?php echo e($policy_page->title); ?></h5>
                <a href="<?php echo e(url('/' . $policy_page->slug)); ?>" target="_blank" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View on site
                </a>
            </div>
            <div class="card-body">
                <form id="policy-page-form" action="<?php echo e(route('admin.policy-pages.update', $policy_page)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="mb-3">
                        <label for="title" class="form-label">Page Title <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="title"
                               name="title"
                               value="<?php echo e(old('title', $policy_page->title)); ?>"
                               required>
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                            <label for="content" class="form-label mb-0">Content</label>
                            <button type="button" id="toggle-html-mode" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-code-slash me-1"></i> <span id="toggle-html-label">Edit as HTML</span>
                            </button>
                        </div>
                        <div id="editor-wrap" class="border rounded overflow-hidden">
                            <div id="editor" class="bg-white" style="min-height: 400px;"></div>
                            <textarea class="form-control font-monospace small <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> d-none"
                                      id="content"
                                      name="content"
                                      rows="18"
                                      placeholder="Paste or type HTML here (e.g. <p>, <strong>, <a>, <ul>)"><?php echo e(old('content', $policy_page->content)); ?></textarea>
                        </div>
                        <small class="text-muted d-block mt-1">Use the toolbar for formatting, or switch to <strong>Edit as HTML</strong> to paste raw HTML. Content saved while in <strong>Edit as HTML</strong> is stored exactly as entered (no code change).</small>
                        <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                   <?php echo e(old('is_active', $policy_page->is_active) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="is_active">Active (show this page on the website)</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer bg-light border-top py-3 d-flex gap-2 flex-wrap">
                <button type="submit" form="policy-page-form" class="btn btn-primary">
                    <i class="bi bi-check-lg me-2"></i> Save changes
                </button>
                <a href="<?php echo e(route('admin.policy-pages.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('policy-page-form');
    var textarea = document.getElementById('content');
    var editorWrap = document.getElementById('editor-wrap');
    var toggleBtn = document.getElementById('toggle-html-mode');
    var toggleLabel = document.getElementById('toggle-html-label');
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [5, 6, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link'],
                ['clean']
            ]
        }
    });
    if (textarea && textarea.value.trim()) quill.clipboard.dangerouslyPasteHTML(textarea.value);
    var isHtmlMode = false;
    var editorEl = document.getElementById('editor');
    toggleBtn.addEventListener('click', function() {
        isHtmlMode = !isHtmlMode;
        if (isHtmlMode) {
            // Do NOT overwrite textarea with Quill HTML – preserve raw HTML (like CKEditor HTML support)
            editorEl.classList.add('d-none');
            textarea.classList.remove('d-none');
            toggleLabel.textContent = 'Visual editor';
        } else {
            quill.clipboard.dangerouslyPasteHTML(textarea.value || '');
            editorEl.classList.remove('d-none');
            textarea.classList.add('d-none');
            toggleLabel.textContent = 'Edit as HTML';
        }
    });
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (isHtmlMode) {
            textarea.classList.remove('d-none');
            // Submit raw textarea value as-is (no Quill transformation)
        } else {
            textarea.value = quill.root.innerHTML;
        }
        form.submit();
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/policy-pages/edit.blade.php ENDPATH**/ ?>