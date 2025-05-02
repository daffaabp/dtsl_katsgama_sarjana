<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
Ganti Password
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid" x-data="ui">
    <!--begin::Form-->
    <form @submit.prevent='handleSubmit' class="form" method="POST" action="<?= site_url() ?>change_password" id="passwordForm">
        <?= csrf_field() ?>
        <!--begin::Basic info-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Password</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->
            <!--begin::Content-->
            <div id="kt_account_settings_profile_details" class="collapse show">

                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Current Password</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="password" name="password" class="form-control form-control-lg form-control-solid" placeholder="" value="" />
                            <span class="text-danger"><?= $validation->getError('password') ?></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Password Baru</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="password" name="new_password" class="form-control form-control-lg form-control-solid" placeholder="" value="" />
                            <span class="text-danger"><?= $validation->getError('new_password') ?></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Confirm Password</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="password" name="new_password_confirm" class="form-control form-control-lg form-control-solid" placeholder="" value="" />
                            <span class="text-danger"><?= $validation->getError('new_password_confirm') ?></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->


                </div>
                <!--end::Card body-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Basic info-->


        <!--begin::Actions-->
        <div class="card-footer d-flex justify-content-center py-6">
            <button type="submit" class="btn btn-primary" x-show="!loading">Save Changes</button>
            <button class="btn btn-primary" x-show="loading">Loading...</button>
        </div>
        <!--end::Actions-->

    </form>
    <!--end::Form-->
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<?php if (session()->get('error')) : ?>
    <script>
        Swal.fire({
            text: "<?= session()->get('error') ?>",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    </script>
<?php endif; ?>
<?php if (session()->get('success')) : ?>
    <script>
        Swal.fire({
            text: "<?= session()->get('success') ?>",
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Ok",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    </script>
<?php endif; ?>
<script>
    document.addEventListener('alpine:init', () => {
        var passwordForm = document.getElementById('passwordForm')
        var rules = {
            fields: {
                'password': {
                    validators: {
                        notEmpty: {
                            message: 'Password harus diisi'
                        }
                    }
                },
                'new_password': {
                    validators: {
                        notEmpty: {
                            message: 'Password baru harus diisi'
                        },
                    }
                },
                'new_password_confirm': {
                    validators: {
                        identical: {
                            compare: function() {
                                return passwordForm.querySelector('[name="new_password"]').value;
                            },
                            message: 'Password tidak sama',
                        },
                    }
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        };
        var validator = FormValidation.formValidation(passwordForm, rules);

        Alpine.data('ui', () => ({
            loading: false,
            async handleSubmit() {
                let status = await validator.validate();
                if (status == 'Valid') {
                    this.loading = true;
                    passwordForm.submit();
                } else {
                    Swal.fire({
                        text: "Periksa data kembali",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            }

        }))
    })
</script>
<?= $this->endSection() ?>