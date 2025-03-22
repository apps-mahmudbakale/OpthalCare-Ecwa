<?php $__env->startSection('title', 'Vital Care Settings'); ?>

<?php $__env->startSection('vendor-style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/libs/select2/select2.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/libs/sweetalert2/sweetalert2.css')); ?>" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-style'); ?>
    <!-- Page -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/css/pages/cards-advance.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('vendor-script'); ?>
    <script src="<?php echo e(asset('assets/vendor/libs/select2/select2.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/libs/swiper/swiper.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/libs/sweetalert2/sweetalert2.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
    <script src="<?php echo e(asset('assets/js/cards-advance.js')); ?>"></script>
    
    <script src="https://unpkg.com/papaparse@latest/papaparse.min.js"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Settings</span>
    </h4>

    <div class="row">
        <!-- Monthly Campaign State -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">System Settings</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="MonthlyCampaign" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#editSystem">View/Update</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6>Change System Settings Here</h6>
                    <form action="<?php echo e(route('app.update.system.settings')); ?>" method="POST" enctype="multipart/form-data"
                        class="row">
                        <?php echo csrf_field(); ?>
                        <div class="form-group col-md-6">
                            Clinic Name
                            <input type="text" name="clinic_name" value="<?php echo e($system->clinic_name); ?>"
                                class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            Clinic Logo
                            <input type="file" name="logo" value="" class="form-control">
                        </div>
<!--                        <div class="form-group col-md-6">-->
<!--                            Clinic Favicon-->
<!--                            <input type="file" name="favicon" value="" class="form-control">-->
<!--                        </div>-->
                        <div class="form-group col-md-6">
                            Footer
                            <input type="text" class="form-control" name="footer" value="<?php echo e($system->footer); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            Medical Record Number Prefix
                            <input type="text" class="form-control" name="number_prefix"
                                value="<?php echo e($system->number_prefix); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <p></p>
                            <div class="text-light small fw-medium mb-3">Insurrance Providers</div>
                            <label class="switch">
                                <input type="checkbox" name="insurance_providers"
                                    <?php echo e($system->insurance_providers ? 'checked' : ''); ?> class="switch-input">
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                                <span class="switch-label"><?php echo e($system->insurance_providers ? 'ON' : 'OFF'); ?> </span>
                            </label>
                        </div>
                        <div class="form-group col-md-4">
                            <p></p>
                            <div class="text-light small fw-medium mb-3">Auto Billing</div>
                            <label class="switch">
                                <input type="checkbox" name="auto_bill" <?php echo e($system->auto_bill ? 'checked' : ''); ?>

                                    class="switch-input">
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                                <span class="switch-label"><?php echo e($system->auto_bill ? 'ON' : 'OFF'); ?> </span>
                            </label>

                        </div>
                        <div class="form-group col-md-4">
                            <p></p>
                            <div class="text-light small fw-medium mb-3">Auto Check-In</div>
                            <label class="switch">
                                <input type="checkbox" name="check_in" <?php echo e($system->check_in ? 'checked' : ''); ?>

                                    class="switch-input">
                                <span class="switch-toggle-slider">
                                    <span class="switch-on"></span>
                                    <span class="switch-off"></span>
                                </span>
                                <span class="switch-label"><?php echo e($system->check_in ? 'ON' : 'OFF'); ?> </span>
                            </label>

                        </div>
                        <div class="form-group col-md-12">
                            Address
                            <textarea class="form-control" rows="10" name="address"><?php echo e($system->address); ?></textarea>
                        </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Departments</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="earningReports" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#newDepartment">New Department</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pb-0">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('department', [])->html();
} elseif ($_instance->childHasBeenRendered('YsVM05a')) {
    $componentId = $_instance->getRenderedChildComponentId('YsVM05a');
    $componentTag = $_instance->getRenderedChildComponentTagName('YsVM05a');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('YsVM05a');
} else {
    $response = \Livewire\Livewire::mount('department', []);
    $html = $response->html();
    $_instance->logRenderedChild('YsVM05a', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            </div>
        </div>
        <!--/ Earning Reports -->

        <!-- Browser States -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Documents</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#newDocument">New Document</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('document', [])->html();
} elseif ($_instance->childHasBeenRendered('kG8SU1N')) {
    $componentId = $_instance->getRenderedChildComponentId('kG8SU1N');
    $componentTag = $_instance->getRenderedChildComponentTagName('kG8SU1N');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('kG8SU1N');
} else {
    $response = \Livewire\Livewire::mount('document', []);
    $html = $response->html();
    $_instance->logRenderedChild('kG8SU1N', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">ICD</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#new-icd-modal">New ICD</a>
                          <a class="dropdown-item" href="javascript:void(0);" id="import-icd" data-request-url="<?php echo e(route('app.icd.create')); ?>"
                             data-toggle="modal" data-target="#global-modal">Import ICD</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('i-c-d', [])->html();
} elseif ($_instance->childHasBeenRendered('hUb7tHj')) {
    $componentId = $_instance->getRenderedChildComponentId('hUb7tHj');
    $componentTag = $_instance->getRenderedChildComponentTagName('hUb7tHj');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('hUb7tHj');
} else {
    $response = \Livewire\Livewire::mount('i-c-d', []);
    $html = $response->html();
    $_instance->logRenderedChild('hUb7tHj', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php echo $__env->make('_partials._modals.modal-new-icd', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Patient Tags</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#modal-new-tag">New Tag</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('tags', [])->html();
} elseif ($_instance->childHasBeenRendered('DFn6ltL')) {
    $componentId = $_instance->getRenderedChildComponentId('DFn6ltL');
    $componentTag = $_instance->getRenderedChildComponentTagName('DFn6ltL');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('DFn6ltL');
} else {
    $response = \Livewire\Livewire::mount('tags', []);
    $html = $response->html();
    $_instance->logRenderedChild('DFn6ltL', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php echo $__env->make('_partials._modals.modal-new-tag', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Vital Reference</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#modal-new-vital-ref">New Reference</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('vital-refs', [])->html();
} elseif ($_instance->childHasBeenRendered('C8pMkEh')) {
    $componentId = $_instance->getRenderedChildComponentId('C8pMkEh');
    $componentTag = $_instance->getRenderedChildComponentTagName('C8pMkEh');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('C8pMkEh');
} else {
    $response = \Livewire\Livewire::mount('vital-refs', []);
    $html = $response->html();
    $_instance->logRenderedChild('C8pMkEh', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php echo $__env->make('_partials._modals.modal-new-vital-ref', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
      <div class="col-xl-6 col-md-6 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between">
            <div class="card-title m-0 me-2">
              <h5 class="m-0 me-2">Payment Methods</h5>
            </div>
            <div class="dropdown">
              <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList">
                <a class="dropdown-item" href="javascript:void(0);" id="add-payment-method"
                   data-request-url="<?php echo e(route('app.payments.new-method')); ?>">Add Payment Method</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('payment-methods', [])->html();
} elseif ($_instance->childHasBeenRendered('amTyJSq')) {
    $componentId = $_instance->getRenderedChildComponentId('amTyJSq');
    $componentTag = $_instance->getRenderedChildComponentTagName('amTyJSq');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('amTyJSq');
} else {
    $response = \Livewire\Livewire::mount('payment-methods', []);
    $html = $response->html();
    $_instance->logRenderedChild('amTyJSq', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php echo $__env->make('_partials._modals.modal-new-cash-point', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          </div>
        </div>
      </div>
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Cash Points</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#modal-new-cash-point">New Cash Point</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('cashpoints', [])->html();
} elseif ($_instance->childHasBeenRendered('xSLsWA3')) {
    $componentId = $_instance->getRenderedChildComponentId('xSLsWA3');
    $componentTag = $_instance->getRenderedChildComponentTagName('xSLsWA3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('xSLsWA3');
} else {
    $response = \Livewire\Livewire::mount('cashpoints', []);
    $html = $response->html();
    $_instance->logRenderedChild('xSLsWA3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php echo $__env->make('_partials._modals.modal-new-cash-point', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
        <?php if($system->insurance_providers): ?>
            <!-- Sales By Country -->
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">HMO Groups</h5>
                            
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="salesByCountry" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesByCountry">
                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                    data-bs-target="#newHmoGroup">New Hmo Group</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('hmo-groups', [])->html();
} elseif ($_instance->childHasBeenRendered('104aYPN')) {
    $componentId = $_instance->getRenderedChildComponentId('104aYPN');
    $componentTag = $_instance->getRenderedChildComponentTagName('104aYPN');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('104aYPN');
} else {
    $response = \Livewire\Livewire::mount('hmo-groups', []);
    $html = $response->html();
    $_instance->logRenderedChild('104aYPN', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                </div>
            </div>
            <!--/ Sales By Country -->
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">HMO Plans</h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="salesByCountry" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesByCountry">
                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                    data-bs-target="#newHmoGroup">New Hmo Group</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('hmo-groups', [])->html();
} elseif ($_instance->childHasBeenRendered('Ps4k98t')) {
    $componentId = $_instance->getRenderedChildComponentId('Ps4k98t');
    $componentTag = $_instance->getRenderedChildComponentTagName('Ps4k98t');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Ps4k98t');
} else {
    $response = \Livewire\Livewire::mount('hmo-groups', []);
    $html = $response->html();
    $_instance->logRenderedChild('Ps4k98t', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!--/ Sales By Country -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Religions</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="salesByCountry" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesByCountry">
                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#new-religion-modal">New Religion</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('religions', [])->html();
} elseif ($_instance->childHasBeenRendered('87ctrnd')) {
    $componentId = $_instance->getRenderedChildComponentId('87ctrnd');
    $componentTag = $_instance->getRenderedChildComponentTagName('87ctrnd');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('87ctrnd');
} else {
    $response = \Livewire\Livewire::mount('religions', []);
    $html = $response->html();
    $_instance->logRenderedChild('87ctrnd', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </div>
            </div>
        </div>
        <!--/ Sales By Country -->
        <h2>Tariffs</h2>
        <!--/ Browser States -->
        <div class="col-md-6 col-xl-4 mb-4">

            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Admissions</h4>
                    <p class="small">Manage Wards, Beds, Routes for Fluid Chart</p>
                    <a href="<?php echo e(route('app.settings.admission')); ?>"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>

        </div>
<!--        <div class="col-md-6 col-xl-4 mb-4">-->
<!---->
<!--            <div class="card h-100">-->
<!--                <div class="card-body">-->
<!--                    <h4 class="mb-2 pb-1">Antenatal</h4>-->
<!--                    <p class="small">Manage Antenatal Locations, Packages, and Other Data</p>-->
<!--                    <a href="<?php echo e(route('app.settings.antenatal')); ?>"-->
<!--                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--        </div>-->
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Consultations</h4>
                    <p class="small">Configure Consultation Locations, Manage Specialties, Consultation Documentation
                        Templates</p>
                    <a href="<?php echo e(route('app.settings.consultations')); ?>"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>
        </div>
        
        
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Laboratory</h4>
                    <p class="small">Configure Laboratory Locations, Manage Lab Tests, Report Layouts</p>
                    <a href="<?php echo e(route('app.settings.laboratory')); ?>"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Medical Procedures</h4>
                    <p class="small">Manage Medical Procedures, Locations, Categories</p>
                    <a href="<?php echo e(route('app.settings.procedures')); ?>"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Pharmacy</h4>
                    <p class="small">Configure Pharmacy Locations, Manage Drugs and Batches and Drug Inventory</p>
                    <a href="<?php echo e(route('app.settings.pharmacy')); ?>"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="mb-2 pb-1">Radiology</h4>
                    <p class="small">Configure Radiology Locations, Manage Radiological Investigations, Report Layouts</p>
                    <a href="<?php echo e(route('app.settings.radiology')); ?>"
                        class="btn btn-primary w-100 waves-effect waves-light">Open</a>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('_partials/_modals/modal-system-settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('_partials._modals.global-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $('#import-icd').on('click', function() {
      var requestUrl = $(this).data('request-url');

      $.ajax({
        url: requestUrl,
        type: 'GET',
        success: function(response) {
          // Assuming the response contains the HTML for the modal content
          $('#global-modal .modal-body').html(response);
          $('#global-modal').modal('show');
        },
        error: function(xhr, status, error) {
          // Handle errors
          console.error(error);
        }
      });
    });
    $('#add-payment-method').on('click', function() {
      var requestUrl = $(this).data('request-url');

      $.ajax({
        url: requestUrl,
        type: 'GET',
        success: function(response) {
          // Assuming the response contains the HTML for the modal content
          $('#global-modal .modal-body').html(response);
          $('#global-modal').modal('show');
        },
        error: function(xhr, status, error) {
          // Handle errors
          console.error(error);
        }
      });
    });
  });
</script>

<?php echo $__env->make('layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mahmoud-bakale/sandbox/OpthalCare/resources/views/settings/index.blade.php ENDPATH**/ ?>