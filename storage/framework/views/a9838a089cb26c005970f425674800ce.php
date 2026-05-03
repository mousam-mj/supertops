<?php $__env->startSection('title', 'Edit Main Category'); ?>
<?php $__env->startSection('page-title', 'Edit Main Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Main Category Information</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.main-categories.update', $category)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="name" 
                                   name="name" 
                                   value="<?php echo e(old('name', $category->name)); ?>" 
                                   required>
                            <?php $__errorArgs = ['name'];
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

                        <div class="col-md-6 mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="slug" 
                                   name="slug" 
                                   value="<?php echo e(old('slug', $category->slug)); ?>">
                            <?php $__errorArgs = ['slug'];
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
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" 
                                   class="form-control <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="<?php echo e(old('sort_order', $category->sort_order ?? 0)); ?>">
                            <?php $__errorArgs = ['sort_order'];
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

                        <div class="col-md-6 mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="is_active" 
                                    name="is_active">
                                <option value="1" <?php echo e(old('is_active', $category->is_active) == 1 ? 'selected' : ''); ?>>Active</option>
                                <option value="0" <?php echo e(old('is_active', $category->is_active) == 0 ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                            <?php $__errorArgs = ['is_active'];
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
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Category Image</label>
                        <?php
                            $hasImage = !empty($category->image);
                            $imageExists = false;
                            if ($hasImage) {
                                try {
                                    $imageExists = \Illuminate\Support\Facades\Storage::disk('public')->exists($category->image);
                                } catch (\Exception $e) {
                                    $imageExists = false;
                                }
                            }
                        ?>
                        
                        <?php if($hasImage && $imageExists): ?>
                            <div class="mb-3 p-3 border rounded bg-light">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <label class="form-label text-muted small mb-0 fw-semibold">Current Image:</label>
                                    <span class="badge bg-success">Image Set</span>
                                </div>
                                <div class="position-relative d-inline-block">
                                    <img src="<?php echo e(storage_asset($category->image)); ?>" 
                                         alt="<?php echo e($category->name); ?>" 
                                         id="currentCategoryImage"
                                         class="img-thumbnail border"
                                         style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); object-fit: cover; display: block; border: 2px solid #dee2e6 !important;">
                                    <input type="hidden" name="remove_image" value="0" id="removeImageInput">
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="removeImageBtn" onclick="toggleRemoveImage('image')">
                                            <i class="bi bi-trash me-1"></i>Remove Image
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-file-image me-1"></i>File: <?php echo e(basename($category->image)); ?>

                                </small>
                            </div>
                        <?php elseif($hasImage && !$imageExists): ?>
                            <div class="alert alert-warning mb-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>Image path exists in database but file not found: <code><?php echo e($category->image); ?></code>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mb-3">
                                <i class="bi bi-info-circle me-2"></i>No image currently set for this category. Upload an image below.
                            </div>
                        <?php endif; ?>
                        
                        <div class="mb-2">
                            <label class="form-label text-muted small fw-semibold"><?php echo e($hasImage && $imageExists ? 'Upload New Image (will replace current):' : 'Upload Image:'); ?></label>
                            <input type="file" 
                                   class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   onchange="previewImage(this, 'imagePreview', 'previewImg')">
                            <?php $__errorArgs = ['image'];
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
                        <small class="form-text text-muted d-block mb-2">
                            <i class="bi bi-info-circle me-1"></i>Recommended size: 800x400px. Max size: 2MB. 
                            <?php if($hasImage && $imageExists): ?>
                                Leave empty to keep current image.
                            <?php endif; ?>
                        </small>
                        <div id="imagePreview" class="mt-2 p-2 border rounded bg-light" style="display: none;">
                            <label class="form-label text-muted small mb-2 fw-semibold">Preview:</label>
                            <img id="previewImg" src="" alt="Preview" class="img-thumbnail border" style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); object-fit: cover; display: block; border: 2px solid #dee2e6 !important;">
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3 fw-bold">Category Page UI/Content Settings</h5>
                    <p class="text-muted mb-4">Configure the content and images displayed on the category page.</p>

                    <hr class="my-4">
                    <h5 class="mb-3">Hero Section</h5>

                    <div class="mb-3">
                        <label for="hero_image" class="form-label">Hero Image</label>
                        <?php if($category->hero_image): ?>
                            <div class="mb-2 position-relative d-inline-block">
                                <img src="<?php echo e(storage_asset($category->hero_image)); ?>" 
                                     alt="Hero" 
                                     id="currentHeroImage"
                                     style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                                <input type="hidden" name="remove_hero_image" value="0" id="removeHeroImageInput">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="toggleRemoveImage('hero_image')">
                                    <i class="bi bi-trash me-1"></i>Remove
                                </button>
                            </div>
                        <?php endif; ?>
                        <input type="file" 
                               class="form-control <?php $__errorArgs = ['hero_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="hero_image" 
                               name="hero_image" 
                               accept="image/*"
                               onchange="previewImage(this, 'heroImagePreview', 'heroPreviewImg')">
                        <?php $__errorArgs = ['hero_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Main banner image for category page. Recommended size: 1920x600px. Max size: 5MB</small>
                        <div id="heroImagePreview" class="mt-2" style="display: none;">
                            <img id="heroPreviewImg" src="" alt="Preview" style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="hero_text" class="form-label">Hero Text</label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['hero_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="hero_text" 
                                   name="hero_text" 
                                   value="<?php echo e(old('hero_text', $category->hero_text)); ?>"
                                   placeholder="e.g. Loved For A Lifetime, FOR EVERY SHADE IN YOU">
                            <?php $__errorArgs = ['hero_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="form-text text-muted">Main heading text displayed on hero banner</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="hero_button_text" class="form-label">Button Text</label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['hero_button_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="hero_button_text" 
                                   name="hero_button_text" 
                                   value="<?php echo e(old('hero_button_text', $category->hero_button_text ?? 'Shop Now')); ?>">
                            <?php $__errorArgs = ['hero_button_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="form-text text-muted">Text for hero button (default: Shop Now)</small>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Promotional Banners (3 Blocks)</h5>

                    <?php
                        $bannerImages = old('banner_images', is_array($category->banner_images) ? $category->banner_images : []);
                        $bannerTexts = old('banner_texts', is_array($category->banner_texts) ? $category->banner_texts : []);
                        while(count($bannerImages) < 3) $bannerImages[] = null;
                        while(count($bannerTexts) < 3) $bannerTexts[] = '';
                    ?>

                    <?php for($i = 0; $i < 3; $i++): ?>
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Banner <?php echo e($i + 1); ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Banner Image <?php echo e($i + 1); ?></label>
                                <?php if(!empty($bannerImages[$i])): ?>
                                    <div class="mb-2 position-relative d-inline-block">
                                        <img src="<?php echo e(storage_asset($bannerImages[$i])); ?>" 
                                             alt="Banner <?php echo e($i + 1); ?>" 
                                             style="max-width: 300px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                                        <input type="hidden" name="remove_banner_image[<?php echo e($i); ?>]" value="0" id="removeBannerImageInput<?php echo e($i); ?>">
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="toggleRemoveBannerImage(<?php echo e($i); ?>)">
                                            <i class="bi bi-trash me-1"></i>Remove
                                        </button>
                                    </div>
                                <?php endif; ?>
                                <input type="file" 
                                       class="form-control" 
                                       name="banner_images[]" 
                                       accept="image/*"
                                       onchange="previewBannerImage(this, <?php echo e($i); ?>)">
                                <small class="form-text text-muted">Recommended size: 600x400px. Max size: 2MB</small>
                                <div id="bannerImagePreview<?php echo e($i); ?>" class="mt-2" style="display: none;">
                                    <img id="bannerPreviewImg<?php echo e($i); ?>" src="" alt="Preview" style="max-width: 300px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Banner Text <?php echo e($i + 1); ?></label>
                                <input type="text" 
                                       class="form-control" 
                                       name="banner_texts[]" 
                                       value="<?php echo e($bannerTexts[$i] ?? ''); ?>"
                                       placeholder="e.g. Drinkware, Barware, Kitchenware">
                                <small class="form-text text-muted">Text to display on this banner</small>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>

                    <hr class="my-4">
                    <h5 class="mb-3">Bottom Banner Section</h5>

                    <div class="mb-3">
                        <label for="bottom_banner_image" class="form-label">Bottom Banner Image</label>
                        <?php if($category->bottom_banner_image): ?>
                            <div class="mb-2 position-relative d-inline-block">
                                <img src="<?php echo e(storage_asset($category->bottom_banner_image)); ?>" 
                                     alt="Bottom Banner" 
                                     id="currentBottomBannerImage"
                                     style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                                <input type="hidden" name="remove_bottom_banner_image" value="0" id="removeBottomBannerImageInput">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="toggleRemoveImage('bottom_banner_image')">
                                    <i class="bi bi-trash me-1"></i>Remove
                                </button>
                            </div>
                        <?php endif; ?>
                        <input type="file" 
                               class="form-control <?php $__errorArgs = ['bottom_banner_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="bottom_banner_image" 
                               name="bottom_banner_image" 
                               accept="image/*"
                               onchange="previewImage(this, 'bottomBannerImagePreview', 'bottomBannerPreviewImg')">
                        <?php $__errorArgs = ['bottom_banner_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Bottom section banner. Recommended size: 1920x400px. Max size: 5MB</small>
                        <div id="bottomBannerImagePreview" class="mt-2" style="display: none;">
                            <img id="bottomBannerPreviewImg" src="" alt="Preview" style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bottom_banner_text" class="form-label">Bottom Banner Text</label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['bottom_banner_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="bottom_banner_text" 
                               name="bottom_banner_text" 
                               value="<?php echo e(old('bottom_banner_text', $category->bottom_banner_text)); ?>"
                               placeholder="e.g. Created to be loved for a lifetime">
                        <?php $__errorArgs = ['bottom_banner_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Text displayed on bottom banner</small>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Testimonial Section</h5>

                    <div class="mb-3">
                        <label for="testimonial_text" class="form-label">Testimonial/Quote Text</label>
                        <textarea class="form-control <?php $__errorArgs = ['testimonial_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="testimonial_text" 
                                  name="testimonial_text" 
                                  rows="3"
                                  placeholder="e.g. I absolutely love this shop! The products are high-quality..."><?php echo e(old('testimonial_text', $category->testimonial_text)); ?></textarea>
                        <?php $__errorArgs = ['testimonial_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Customer testimonial or quote text displayed on category page</small>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Additional Banner (Optional)</h5>

                    <div class="mb-3">
                        <label for="additional_banner_image" class="form-label">Additional Banner Image</label>
                        <?php if($category->additional_banner_image): ?>
                            <div class="mb-2 position-relative d-inline-block">
                                <img src="<?php echo e(storage_asset($category->additional_banner_image)); ?>" 
                                     alt="Additional Banner" 
                                     id="currentAdditionalBannerImage"
                                     style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                                <input type="hidden" name="remove_additional_banner_image" value="0" id="removeAdditionalBannerImageInput">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="toggleRemoveImage('additional_banner_image')">
                                    <i class="bi bi-trash me-1"></i>Remove
                                </button>
                            </div>
                        <?php endif; ?>
                        <input type="file" 
                               class="form-control <?php $__errorArgs = ['additional_banner_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="additional_banner_image" 
                               name="additional_banner_image" 
                               accept="image/*"
                               onchange="previewImage(this, 'additionalBannerImagePreview', 'additionalBannerPreviewImg')">
                        <?php $__errorArgs = ['additional_banner_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Optional additional banner. Recommended size: 1920x400px. Max size: 5MB</small>
                        <div id="additionalBannerImagePreview" class="mt-2" style="display: none;">
                            <img id="additionalBannerPreviewImg" src="" alt="Preview" style="max-width: 400px; max-height: 300px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); object-fit: cover;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="additional_banner_text" class="form-label">Additional Banner Text</label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['additional_banner_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="additional_banner_text" 
                               name="additional_banner_text" 
                               value="<?php echo e(old('additional_banner_text', $category->additional_banner_text)); ?>"
                               placeholder="e.g. Palettes, Check & Coutour">
                        <?php $__errorArgs = ['additional_banner_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="form-text text-muted">Text displayed on additional banner</small>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?php echo e(route('admin.main-categories.index')); ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <div class="d-flex gap-2">
                            <button type="reset" class="btn btn-warning" onclick="resetForm()">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Main Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Store original form values for reset functionality
    <?php
        $originalBannerTexts = old('banner_texts', is_array($category->banner_texts) ? $category->banner_texts : []);
        while(count($originalBannerTexts) < 3) {
            $originalBannerTexts[] = '';
        }
    ?>
    const originalFormValues = {
        name: <?php echo json_encode(old('name', $category->name), 512) ?>,
        slug: <?php echo json_encode(old('slug', $category->slug), 512) ?>,
        sort_order: <?php echo json_encode(old('sort_order', $category->sort_order ?? 0), 512) ?>,
        is_active: <?php echo json_encode(old('is_active', $category->is_active ? 1 : 0), 512) ?>,
        hero_text: <?php echo json_encode(old('hero_text', $category->hero_text ?? ''), 512) ?>,
        hero_button_text: <?php echo json_encode(old('hero_button_text', $category->hero_button_text ?? 'Shop Now'), 512) ?>,
        bottom_banner_text: <?php echo json_encode(old('bottom_banner_text', $category->bottom_banner_text ?? ''), 512) ?>,
        testimonial_text: <?php echo json_encode(old('testimonial_text', $category->testimonial_text ?? ''), 512) ?>,
        additional_banner_text: <?php echo json_encode(old('additional_banner_text', $category->additional_banner_text ?? ''), 512) ?>,
        banner_texts: <?php echo json_encode($originalBannerTexts, 15, 512) ?>
    };

    function previewImage(input, previewId, imgId) {
        const preview = document.getElementById(previewId);
        const previewImg = document.getElementById(imgId);
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }

    function previewBannerImage(input, index) {
        previewImage(input, 'bannerImagePreview' + index, 'bannerPreviewImg' + index);
    }

    function toggleRemoveImage(type) {
        let removeInput, removeBtn, currentImg;
        
        if (type === 'image') {
            removeInput = document.getElementById('removeImageInput');
            removeBtn = document.getElementById('removeImageBtn');
            currentImg = document.getElementById('currentCategoryImage');
        } else if (type === 'hero_image') {
            removeInput = document.getElementById('removeHeroImageInput');
            removeBtn = document.querySelector('[onclick*="hero_image"]');
            currentImg = document.getElementById('currentHeroImage');
        } else if (type === 'bottom_banner_image') {
            removeInput = document.getElementById('removeBottomBannerImageInput');
            removeBtn = document.querySelector('[onclick*="bottom_banner_image"]');
            currentImg = document.getElementById('currentBottomBannerImage');
        } else if (type === 'additional_banner_image') {
            removeInput = document.getElementById('removeAdditionalBannerImageInput');
            removeBtn = document.querySelector('[onclick*="additional_banner_image"]');
            currentImg = document.getElementById('currentAdditionalBannerImage');
        }
        
        if (removeInput && removeInput.value == '0') {
            removeInput.value = '1';
            if (removeBtn) {
                removeBtn.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Undo Remove';
                removeBtn.classList.remove('btn-outline-danger');
                removeBtn.classList.add('btn-danger');
            }
            if (currentImg) {
                currentImg.style.opacity = '0.5';
            }
        } else if (removeInput) {
            removeInput.value = '0';
            if (removeBtn) {
                removeBtn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                removeBtn.classList.remove('btn-danger');
                removeBtn.classList.add('btn-outline-danger');
            }
            if (currentImg) {
                currentImg.style.opacity = '1';
            }
        }
    }

    function toggleRemoveBannerImage(index) {
        const removeInput = document.getElementById('removeBannerImageInput' + index);
        const removeBtn = document.querySelector('[onclick*="toggleRemoveBannerImage(' + index + ')"]');
        
        if (removeInput && removeInput.value == '0') {
            removeInput.value = '1';
            if (removeBtn) {
                removeBtn.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Undo';
                removeBtn.classList.remove('btn-outline-danger');
                removeBtn.classList.add('btn-danger');
            }
        } else if (removeInput) {
            removeInput.value = '0';
            if (removeBtn) {
                removeBtn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                removeBtn.classList.remove('btn-danger');
                removeBtn.classList.add('btn-outline-danger');
            }
        }
    }

    function resetForm() {
        if (confirm('Are you sure you want to reset the form? All unsaved changes will be lost.')) {
            // Reset all text inputs to original values
            const nameField = document.getElementById('name');
            if (nameField) nameField.value = originalFormValues.name;
            
            const slugField = document.getElementById('slug');
            if (slugField) slugField.value = originalFormValues.slug;
            
            const sortOrderField = document.getElementById('sort_order');
            if (sortOrderField) sortOrderField.value = originalFormValues.sort_order;
            
            const isActiveField = document.getElementById('is_active');
            if (isActiveField) isActiveField.value = originalFormValues.is_active;
            
            // Reset UI content fields
            const heroText = document.getElementById('hero_text');
            if (heroText) heroText.value = originalFormValues.hero_text || '';
            
            const heroButtonText = document.getElementById('hero_button_text');
            if (heroButtonText) heroButtonText.value = originalFormValues.hero_button_text || 'Shop Now';
            
            const bottomBannerText = document.getElementById('bottom_banner_text');
            if (bottomBannerText) bottomBannerText.value = originalFormValues.bottom_banner_text || '';
            
            const testimonialText = document.getElementById('testimonial_text');
            if (testimonialText) testimonialText.value = originalFormValues.testimonial_text || '';
            
            const additionalBannerText = document.getElementById('additional_banner_text');
            if (additionalBannerText) additionalBannerText.value = originalFormValues.additional_banner_text || '';
            
            // Reset banner texts
            const bannerTextInputs = document.querySelectorAll('input[name="banner_texts[]"]');
            bannerTextInputs.forEach((input, index) => {
                if (input && originalFormValues.banner_texts && originalFormValues.banner_texts[index] !== undefined) {
                    input.value = originalFormValues.banner_texts[index] || '';
                } else {
                    input.value = '';
                }
            });
            
            // Reset all remove image inputs
            const removeInputs = document.querySelectorAll('input[type="hidden"][name^="remove"]');
            removeInputs.forEach(input => {
                if (input) {
                    input.value = '0';
                }
            });
            
            // Reset all remove buttons to original state
            const removeButtons = document.querySelectorAll('button[onclick*="toggleRemoveImage"], button[onclick*="toggleRemoveBannerImage"]');
            removeButtons.forEach(btn => {
                if (btn) {
                    btn.classList.remove('btn-danger');
                    btn.classList.add('btn-outline-danger');
                    const icon = btn.querySelector('i');
                    if (icon && icon.classList.contains('bi-arrow-counterclockwise')) {
                        btn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                    }
                }
            });
            
            // Hide all image previews
            const previews = document.querySelectorAll('[id$="Preview"]');
            previews.forEach(preview => {
                if (preview) {
                    preview.style.display = 'none';
                }
            });
            
            // Show and restore all current images to original state
            const currentImageIds = ['currentCategoryImage', 'currentHeroImage', 'currentBottomBannerImage', 'currentAdditionalBannerImage'];
            currentImageIds.forEach(id => {
                const img = document.getElementById(id);
                if (img) {
                    img.style.display = 'block';
                    img.style.opacity = '1';
                    img.style.visibility = 'visible';
                }
            });
            
            // Reset banner image remove buttons
            for (let i = 0; i < 3; i++) {
                const removeInput = document.getElementById('removeBannerImageInput' + i);
                if (removeInput) {
                    removeInput.value = '0';
                }
                const removeBtn = document.querySelector('[onclick*="toggleRemoveBannerImage(' + i + ')"]');
                if (removeBtn) {
                    removeBtn.classList.remove('btn-danger');
                    removeBtn.classList.add('btn-outline-danger');
                    removeBtn.innerHTML = '<i class="bi bi-trash me-1"></i>Remove';
                }
            }
            
            // Reset file inputs
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                if (input) {
                    input.value = '';
                }
            });
            
            // Reload page to ensure everything is reset to original state from server
            window.location.reload();
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/admin/main-categories/edit.blade.php ENDPATH**/ ?>