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
        Basic Settings
     <?php $__env->endSlot(); ?>
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="page-header py-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Basic Settings</h3>
                        </div>
                    </div>
                </div>

                <form action="<?php echo e(route('basic-setting')); ?>" method="POST" class="needs-validation" novalidate>
                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Default Country</label>
                                <select name="default_country" class="select form-control  <?php $__errorArgs = ['default_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="Bangladesh" <?php echo e(($basicSettings && ($basicSettings->default_country == 'Bangladesh') ) ? 'selected' : ''); ?>>Bangladesh</option>
                                    <option value="India" <?php echo e(($basicSettings && ($basicSettings->default_country == 'India') ) ? 'selected' : ''); ?>>India</option>
                                    <option value="Pakisthan" <?php echo e(($basicSettings && ($basicSettings->default_country == 'Pakisthan') ) ? 'selected' : ''); ?>>Pakisthan</option>
                                    <option value="Miyanmar" <?php echo e(($basicSettings && ($basicSettings->default_country == 'Miyanmar') ) ? 'selected' : ''); ?>>Miyanmar</option>
                                    <option value="Nepal" <?php echo e(($basicSettings && ($basicSettings->default_country == 'Nepal') ) ? 'selected' : ''); ?>>Nepal</option>
                                    <option value="Bhutan" <?php echo e(($basicSettings && ($basicSettings->default_country == 'Bhutan') ) ? 'selected' : ''); ?>>Bhutan</option>
                                    <option value="Srilanka" <?php echo e(($basicSettings && ($basicSettings->default_country == 'Srilanka') ) ? 'selected' : ''); ?>>Srilanka</option>
                                </select>
                                <?php $__errorArgs = ['default_country'];
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
                                <label>Date Format</label>
                                <select name="date_format" class="select form-control  <?php $__errorArgs = ['date_format'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">                                    
                                    <option value="Y-m-d" <?php echo e(($basicSettings && ($basicSettings->date_format == 'Y-m-d') ) ? 'selected' : ''); ?>>2016-05-15</option>
                                    <option value="d/m/Y" <?php echo e(($basicSettings && ($basicSettings->date_format == 'd/m/Y') ) ? 'selected' : ''); ?>>15/05/2016</option>
                                    <option value="d.m.Y" <?php echo e(($basicSettings && ($basicSettings->date_format == 'd.m.Y') ) ? 'selected' : ''); ?>>15.05.2016</option>
                                    <option value="d-m-Y" <?php echo e(($basicSettings && ($basicSettings->date_format == 'd-m-Y') ) ? 'selected' : ''); ?>>15-05-2016</option>
                                    <option value="m/d/Y" <?php echo e(($basicSettings && ($basicSettings->date_format == 'm/d/Y') ) ? 'selected' : ''); ?>>05/15/2016</option>
                                    <option value="Y/m/d" <?php echo e(($basicSettings && ($basicSettings->date_format == 'Y/m/d') ) ? 'selected' : ''); ?>>2016/05/15</option>
                                    <option value="M d Y" <?php echo e(($basicSettings && ($basicSettings->date_format == 'M d Y') ) ? 'selected' : ''); ?>>May 15 2016</option>
                                    <option value="d M Y" <?php echo e(($basicSettings && ($basicSettings->date_format == 'd M Y') ) ? 'selected' : ''); ?>>15 May 2016</option>
                                </select>
                                <?php $__errorArgs = ['date_format'];
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
                                <label>Timezone</label>
                                <select name="timezone" class="select form-control  <?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="Asia/Dhaka" <?php echo e(($basicSettings && ($basicSettings->timezone == 'Asia/Dhaka') ) ? 'selected' : ''); ?>>(UTC +6:00) Asia/Dhaka</option>
                                    <option value="America/New_York" <?php echo e(($basicSettings && ($basicSettings->timezone == 'America/New_York') ) ? 'selected' : ''); ?>>(UTC -5:00) America/New_York</option>
                                </select>
                                <?php $__errorArgs = ['timezone'];
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
                                <label>Default Language</label>
                                <select name="default_language" class="select form-control  <?php $__errorArgs = ['default_language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="English" <?php echo e(($basicSettings && ($basicSettings->default_language == 'English') ) ? 'selected' : ''); ?>>English</option>
                                    <option value="Bangla" <?php echo e(($basicSettings && ($basicSettings->default_language == 'Bangla') ) ? 'selected' : ''); ?>>Bangla</option>
                                    <option value="French" <?php echo e(($basicSettings && ($basicSettings->default_language == 'French') ) ? 'selected' : ''); ?>>French</option>
                                </select>
                                <?php $__errorArgs = ['default_language'];
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
                                <label>Currency Code</label>
                                <select name="currency_code" class="select form-control  <?php $__errorArgs = ['currency_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="BDT" <?php echo e(($basicSettings && ($basicSettings->currency_code == 'BDT') ) ? 'selected' : ''); ?>>BDT</option>
                                    <option value="USD" <?php echo e(($basicSettings && ($basicSettings->currency_code == 'USD') ) ? 'selected' : ''); ?>>USD</option>
                                    <option value="Pound" <?php echo e(($basicSettings && ($basicSettings->currency_code == 'Pound') ) ? 'selected' : ''); ?>>Pound</option>
                                    <option value="EURO" <?php echo e(($basicSettings && ($basicSettings->currency_code == 'EURO') ) ? 'selected' : ''); ?>>EURO</option>
                                    <option value="Ringgit" <?php echo e(($basicSettings && ($basicSettings->currency_code == 'Ringgit') ) ? 'selected' : ''); ?>>Ringgit</option>
                                </select>
                                <?php $__errorArgs = ['currency_code'];
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
                                <label>Currency Symbol</label>
                                <select name="currency_symbol" class="select form-control  <?php $__errorArgs = ['currency_symbol'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="৳" <?php echo e(($basicSettings && ($basicSettings->currency_symbol == '৳') ) ? 'selected' : ''); ?>>৳</option>
                                    <option value="$" <?php echo e(($basicSettings && ($basicSettings->currency_symbol == '$') ) ? 'selected' : ''); ?>>$</option>
                                    <option value="£" <?php echo e(($basicSettings && ($basicSettings->currency_symbol == '£') ) ? 'selected' : ''); ?>>£</option>
                                    <option value="€" <?php echo e(($basicSettings && ($basicSettings->currency_symbol == '€') ) ? 'selected' : ''); ?>>€</option>
                                    <option value="RM" <?php echo e(($basicSettings && ($basicSettings->currency_symbol == 'RM') ) ? 'selected' : ''); ?>>RM</option>
                                </select>
                                <?php $__errorArgs = ['currency_symbol'];
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
<?php /**PATH /var/www/html/edds/resources/views/settings/basic-setting.blade.php ENDPATH**/ ?>