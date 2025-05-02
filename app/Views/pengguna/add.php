<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
Data Pengguna
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid" x-data="ui">
    <!--begin::Form-->
    <form @submit.prevent='handleSubmit' class="form" method="POST" action="<?= site_url() ?>pengguna/add" id="addForm">
        <?= csrf_field() ?>
        <!--begin::Basic info-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Profile Pengguna</h3>
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama Lengkap</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="nama" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('nama') ?>" />
                            <span class="text-danger"><?= $validation->getError('nama') ?></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6" x-data="{show:true}" @click="show=false">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Alamat Email</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="email" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('email') ?>" />
                            <span class="text-danger" x-show="show"><?= $validation->getError('email') ?></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 required col-form-label fw-semibold fs-6">
                            <span class="">Role</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="role" aria-label="Select a Country" data-control="select2" data-placeholder="Pilih Role" class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih Role</option>
                                <?php foreach ($roles as $role) : ?>
                                    <option value="<?= $role['id'] ?>" <?= (old('role') == $role['id']) ? 'selected' : ''; ?>><?= $role['role'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="text-danger"><?= $validation->getError('role') ?></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 required col-form-label fw-semibold fs-6">
                            <span class="">Status</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="active" aria-label="Select a Country" data-control="select2" data-placeholder="Pilih Propinsi" class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih Status</option>
                                <option value="1" <?= (old('status') == 1) ? 'selected' : ''; ?>>Aktif</option>
                                <option value="0" <?= (old('status') != 1) ? 'selected' : ''; ?>>Tidak Aktif</option>
                            </select>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Angkatan</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="angkatan" aria-label="Select a prodi" data-control="select2" data-placeholder="Pilih Angkatan" class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih Angkatan</option>
                                <?php foreach ($angkatan as $ak) : ?>
                                    <option value="<?= $ak['tahun'] ?>" <?= (old('angkatan') == $ak['tahun']) ? 'selected' : '' ?>><?= $ak['tahun'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="text-danger"><?= $validation->getError('angkatan') ?></span>
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
            <div class="collapse show">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Password</label>
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
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Confirm Password</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="password" name="password2" class="form-control form-control-lg form-control-solid" placeholder="" value="" />
                            <span class="text-danger"><?= $validation->getError('password2') ?></span>
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
<?php if (session()->get('success')) : ?>
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
<script>
    document.addEventListener('alpine:init', () => {
        var addForm = document.getElementById('addForm')
        var rules = {
            fields: {
                'nama': {
                    validators: {
                        notEmpty: {
                            message: 'Nama Harus diisi'
                        }
                    }
                },
                'email': {
                    validators: {
                        notEmpty: {
                            message: 'Email Harus diisi'
                        },
                        emailAddress: {
                            message: 'Email tidak valid'
                        }
                    }
                },
                'role': {
                    validators: {
                        notEmpty: {
                            message: 'Role harus dipilih'
                        }
                    }
                },
                'active': {
                    validators: {
                        notEmpty: {
                            message: 'Status harus dipilih'
                        }
                    }
                },
                'angkatan': {
                    validators: {
                        notEmpty: {
                            message: 'Angkatan harus dipilih'
                        }
                    }
                },
                'password': {
                    validators: {
                        notEmpty: {
                            message: 'Password harus diisi'
                        }
                    }
                },
                'password2': {
                    validators: {
                        notEmpty: {
                            message: 'Confirm Password harus diisi'
                        },
                        identical: {
                            compare: function() {
                                return addForm.querySelector('[name="password"]').value;
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
        var validator = FormValidation.formValidation(addForm, rules);
        $(addForm.querySelector('[name="angkatan"]')).on('change', function() {
            validator.revalidateField('angkatan');
        });
        $(addForm.querySelector('[name="active"]')).on('change', function() {
            validator.revalidateField('active');
        });
        $(addForm.querySelector('[name="role"]')).on('change', function() {
            validator.revalidateField('role');
        });

        Alpine.data('ui', () => ({
            loading: false,
            async handleSubmit() {
                this.loading = true;
                let status = await validator.validate();
                if (status == 'Valid') {
                    addForm.submit();
                } else {
                    this.loading = false;
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