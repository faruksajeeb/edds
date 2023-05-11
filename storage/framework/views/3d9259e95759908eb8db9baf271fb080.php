<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> 
        Company Settings
     <?php $__env->endSlot(); ?>
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="page-header py-3 my-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Company Settings</h3>
                        </div>
                    </div>
                </div>

                <form action="<?php echo e(route('company-setting')); ?>" method="POST" class="needs-validation" novalidate>
                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Company Name <span class="text-danger">*</span></label>
                                <input name="company_name" class="form-control <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text"
                                    value="<?php echo e($companySettings ? $companySettings->company_name : old('company_name')); ?>" placeholder="Enter company name" required>
                                    <div class="invalid-feedback error_msg company_name_err">Company Name is required!</div>
                                <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Contact Person</label>
                                <input name="contact_person" class="form-control "
                                    value="<?php echo e((old('contact_person')) ? old('contact_person'):($companySettings ? $companySettings->contact_person : '')); ?>"
                                    paceholder="Enter contact person" type="text">
                                    
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input name="address" class="form-control" placeholder="Enter company address"
                                    value="<?php echo e((old('address')) ? old('address'):(($companySettings) ? $companySettings->address :'')); ?>" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>Country</label>

                                <input class="form-control" placeholder="Enter country name"
                                    value="<?php echo e((old('country')) ? old('country'):($companySettings ? $companySettings->country : '')); ?>" type="text">
                                
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>City</label>
                                <input name="city" class="form-control" placeholder="Enter city name"
                                    value="<?php echo e((old('city')) ? old('city'):($companySettings ? $companySettings->city : '')); ?>" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>State/Province</label>
                                <input name="state" class="form-control" placeholder="Enter state/province"
                                    value="<?php echo e((old('state')) ? old('state'):($companySettings ? $companySettings->state : '')); ?>" type="text">

                                
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label>Postal Code</label>
                                <input name="postal_code" class="form-control"
                                    value="<?php echo e((old('postal_code')) ? old('postal_code'):($companySettings ? $companySettings->postal_code : '')); ?>"
                                    type="text" placeholder="Enter posta code">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" class="form-control" placeholder="Enter email"
                                    value="<?php echo e((old('email')) ? old('email'):($companySettings ? $companySettings->email : '')); ?>" type="email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input name="phone_number" class="form-control"
                                    value="<?php echo e((old('phone_number')) ? old('phone_number'):($companySettings ? $companySettings->phone_number : '')); ?>"
                                    type="text" placeholder="Enter phone number">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input name="mobile_number" class="form-control"
                                    value="<?php echo e((old('mobile_number')) ? old('mobile_number'):($companySettings ? $companySettings->mobile_number : '')); ?>"
                                    type="text" placeholder="Enter mobile number">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Fax</label>
                                <input name="fax" class="form-control" placeholder="Enter fax"
                                    value="<?php echo e((old('fax')) ? old('fax'):($companySettings ? $companySettings->fax : '')); ?>" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Website Url</label>
                                <input name="website_url" class="form-control" placeholder="Enter website url"
                                    value="<?php echo e((old('website_url')) ?old('website_url'):($companySettings ? $companySettings->website_url : '')); ?>"
                                    type="text">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="submit-section">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <button class="btn btn-lg btn-outline-secondary submit-btn rounded-pill">Save
                                Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/edds/resources/views/settings/company-setting.blade.php ENDPATH**/ ?>