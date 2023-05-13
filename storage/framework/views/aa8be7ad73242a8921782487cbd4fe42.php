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
        User Responses
     <?php $__env->endSlot(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title py-1"><i class="fa fa-table"></i>
                                <?php if(request()->get('status') == 'archived'): ?>
                                    Archived
                                <?php endif; ?> User Responses
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Response</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        <?php if(request()->get('status') == 'archived'): ?>
                                            Archived
                                        <?php endif; ?> User Responses
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php if(request()->get('status') != 'archived'): ?>
                                <a href="<?php echo e(url('/user_responses?status=archived')); ?>">Archived User Responses</a>
                            <?php else: ?>
                                <a href="<?php echo e(url('/user_responses')); ?>">User Responses</a>
                            <?php endif; ?>
                            <?php if((request()->get('status') == 'archived') && ($user_responses->total() >0)): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.restore')): ?>
                                    <div class="float-end">
                                        <a href="" class="btn btn-primary btn-sm btn-restore-all"
                                            onclick="event.preventDefault(); restoreAllConfirmation()"><i
                                                class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                        <form id="restore-all-form" action="<?php echo e(route('user_responses.restore-all')); ?>"
                                            style="display:inline" method="POST">
                                            <?php echo method_field('POST'); ?>
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <form action="" method="GET">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="status"
                                value="<?php echo e(request()->get('status') == 'archived' ? 'archived' : ''); ?>">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <select name="search_respodent" class="form-select" id="search_respodent">
                                        <option value="">Select respondent</option>
                                        <?php $__currentLoopData = $respondents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                    
                                            <option value="<?php echo e($val->id); ?>" <?php echo e($val->id==old('responden_id')?'selected':''); ?>><?php echo e($val->option_value); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 px-0">
                                    <div class="input-group">
                                        <input type="text" name="search_text" value="" class="form-control"
                                            placeholder="Search by text">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary mx-1 filter_btn" name="submit_btn" type="submit"
                                                value="search">
                                                <i class="fa fa-search"></i> Filter
                                            </button>
                                            <a href='<?php echo e(request()->get('status') == 'archived' ? url('/user_responses?status=archived') : url('/user_responses')); ?>'
                                                class="btn btn-xs btn-primary me-1 refresh_btn"><i class="fa fa-refresh"></i></a>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.export')): ?>
                                                
                                                

                                                <button class="btn btn-xs btn-success float-end me-1 export_btn" name="submit_btn"
                                                    value="export" type="submit">
                                                    <i class="fa-solid fa-download"></i> Export
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.create')): ?>
                                        
                                    <?php endif; ?>
                                </div>

                            </div>
                        </form>
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Gender</th>
                                    <th>Respondent</th>
                                    <th>Response At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $user_responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($index + $user_responses->firstItem()); ?></td>
                                        <td><?php echo e($val->full_name); ?></td>
                                        <td><?php echo e($val->email); ?></td>
                                        <td><?php echo e($val->mobile_no); ?></td>
                                        <td><?php echo e($val->gender); ?></td>
                                        <td><?php echo e(isset($val->respondent) ? $val->respondent->option_value : ''); ?></td>
                                      
                                        <td><?php echo e($val->created_at); ?></td>
                        <td class="text-nowrap">
                            <?php if(request()->get('status') == 'archived'): ?>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.restore')): ?>
                                    <a href="" class="btn btn-primary btn-sm btn-restore-<?php echo e($val->id); ?>"
                                        onclick="event.preventDefault(); restoreConfirmation(<?php echo e($val->id); ?>)"><i
                                            class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                    <form id="restore-form-<?php echo e($val->id); ?>"
                                        action="<?php echo e(route('user_responses.restore', Crypt::encryptString($val->id))); ?>"
                                        method="POST" style="display: none">
                                        <?php echo method_field('POST'); ?>
                                        <?php echo csrf_field(); ?>
                                    </form>
                                <?php endif; ?>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.force_delete')): ?>
                                    <a href="" class="btn btn-danger btn-sm btn-force-delete-<?php echo e($val->id); ?>"
                                        onclick="event.preventDefault(); forceDelete(<?php echo e($val->id); ?>)"><i
                                            class="fa-solid fa-remove"></i> Force Delete</a>
                                    <form id="force-delete-form-<?php echo e($val->id); ?>" style="display: none"
                                        action="<?php echo e(route('user_responses.force-delete', Crypt::encryptString($val->id))); ?>"
                                        method="POST">
                                        <?php echo method_field('DELETE'); ?>
                                        <?php echo csrf_field(); ?>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.edit')): ?>
                                    <?php if($val->status == 1): ?>
                                        
                                    <?php endif; ?>
                                <?php endif; ?>
                                 
                                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.verify')): ?>
                                 
                                     <a href=""
                                         class="btn btn-outline-success btn-sm"><i class="fas fa-check"></i> Verify</a>
                                 
                             <?php endif; ?>
                             <button class="btn btn-sm btn-secondary me-1 mt-1" data-bs-toggle="modal" data-bs-target="#detailModal" 
                                            wire:click.prevent="orderDetail('<?php echo e(Crypt::encryptString($val->id)); ?>')">
                                                <i class="fa-solid fa-magnifying-glass-plus"></i></button>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_response.delete')): ?>
                                    <a href="" class="btn btn-outline-danger btn-sm btn-delete-<?php echo e($val->id); ?>"
                                        onclick="event.preventDefault(); confirmDelete(<?php echo e($val->id); ?>)"><i
                                            class="fa-solid fa-trash"></i> Delete</a>
                                    <form id="delete-form-<?php echo e($val->id); ?>" style="display: none"
                                        action="<?php echo e(route('user_responses.destroy', Crypt::encryptString($val->id))); ?>"
                                        method="POST">
                                        <?php echo method_field('DELETE'); ?>
                                        <?php echo csrf_field(); ?>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>

                        </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        </table>
                        <?php echo e($user_responses->withQueryString()->links()); ?>

                    </div>
                </div>
            </div>
        </div>
        </div>

        <?php $__env->startPush('scripts'); ?>
            <script></script>
        <?php $__env->stopPush(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp8.1.6\htdocs\laravel\edds\resources\views/user_response/index.blade.php ENDPATH**/ ?>