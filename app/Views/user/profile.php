<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
Edit Profile
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid" x-data="ui">
    <!--begin::Form-->
    <form @submit.prevent='handleSubmit' class="form" method="POST" action="" id="addForm">
        <?= csrf_field() ?>
        <!--begin::Basic info-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Profile Detail</h3>
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
                            <input type="text" name="nama" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('nama', $alumni['nama']) ?>" />
                            <span class="text-danger"><?= $validation->getError('nama') ?></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Alamat Email</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="email" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('email', $alumni['email']) ?>" />
                            <span class="text-danger"><?= $validation->getError('email') ?></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nomer WA</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="nowa" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('nowa', $alumni['nowa']) ?>" />
                            <span class="text-danger"><?= $validation->getError('nowa') ?></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-semibold fs-6">Nomer Telp</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="notelp" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('notelp', $alumni['notelp']) ?>" />
                            <span class="text-danger"><?= $validation->getError('notelp') ?></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Alamat Rumah</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="alamat" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('alamat', $alumni['alamat']) ?>" />
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            <span class="">Propinsi</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="propinsi" aria-label="Select a Country" data-control="select2" data-placeholder="Pilih Propinsi..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih Propinsi</option>
                                <?php foreach ($propinsi as $prop) : ?>
                                    <option value="<?= $prop['id'] ?>" <?= (old('propinsi', $alumni['prop_id']) == $prop['id']) ? 'selected' : ''; ?>><?= $prop['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->


                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            <span class="">Bidang Pekerjaan</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="bidang_kerja" aria-label="Select a Country" data-control="select2" data-placeholder="Pilih Bidang Kerja..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih Bidang Kerja...</option>
                                <?php foreach ($occupations as $occp) : ?>
                                    <option value="<?= $occp['id'] ?>" <?= (old('bidang_kerja', $alumni['occupation_id']) == $occp['id']) ? 'selected' : ''; ?>><?= $occp['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-semibold fs-6">Instansi</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="instansi" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('instansi', $alumni['instansi']) ?>" />
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label  fw-semibold fs-6">Jabatan</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="jabatan" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('jabatan', $alumni['jabatan']) ?>" />
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

        <!--begin::Akademik info-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Riwayat Akademik</h3>
                </div>
                <!--end::Card title-->
            </div>
            <!--begin::Card header-->
            <!--begin::Content-->
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                <!-- form wrapper -->
                <div class="notice  rounded border-warning border border-dashed mb-9 p-6">
                    <h6 class="m-0">Riwayat S1</h6>
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama Universitas</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="s1_universitas" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('s1_universitas', (isset($S1['universitas'])) ? $S1['universitas'] : '') ?>" />
                            <span class="text-danger"><?= $validation->getError('s1_universitas') ?></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tahun Masuk</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="s1_tmasuk" aria-label="Select a prodi" data-control="select2" data-placeholder="Pilih Tahun Masuk..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih Tahun Masuk...</option>
                                <?php foreach ($angkatan as $ak) : ?>
                                    <option value="<?= $ak['tahun'] ?>" <?= (old('s1_tmasuk', (isset($S1['tmasuk'])) ? $S1['tmasuk'] : '') == $ak['tahun']) ? 'selected' : '' ?>><?= $ak['tahun'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="text-danger"><?= $validation->getError('s1_tmasuk') ?></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Tahun Lulus</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="s1_tlulus" aria-label="Select a prodi" data-control="select2" data-placeholder="Pilih Tahun Lulus..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih Tahun Lulus...</option>
                                <?php foreach ($angkatan as $ak) : ?>
                                    <option value="<?= $ak['tahun'] ?>" <?= (old('s1_tlulus', isset($S1['tlulus']) ? $S1['tlulus'] : '') == $ak['tahun']) ? 'selected' : '' ?>><?= $ak['tahun'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="text-danger"><?= $validation->getError('s1_tlulus') ?></span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--end::Input group-->
                    <div class="row mb-6" x-data="{show:false}">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Prodi</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input  @click="show=true" x-show="!show" type="text" name="s1_prodi" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('s1_prodi', (isset($S1['prodi'])) ? $S1['prodi'] : '') ?>" />
                            <span class="text-danger"><?= $validation->getError('s1_prodi') ?></span>
                            <div x-show="show">
                                <select name="s1_prodi_alt" aria-label="Select a prodi" data-control="select2" data-placeholder="Pilih Prodi..." class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">Pilih Prodi</option>
                                    <?php foreach ($prodi as $prd) : ?>
                                        <option value="<?= $prd['nprodi'] ?>"><?= $prd['nprodi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!-- end form wrapper -->

                <!-- form wrapper -->
                <div class="notice rounded border-warning border border-dashed mb-9 p-6">
                    <h6 class="m-0">Riwayat S2</h6>
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Nama Universitas</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="s2_universitas" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('s2_universitas', (isset($S2['universitas'])) ? $S2['universitas'] : '') ?>" />
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Tahun Masuk</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="s2_tmasuk" aria-label="Select a prodi" data-control="select2" data-placeholder="Pilih Tahun Masuk..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih Tahun Masuk...</option>
                                <?php foreach ($angkatan as $ak) : ?>
                                    <option value="<?= $ak['tahun'] ?>" <?= (old('s2_tmasuk', (isset($S2['tmasuk'])) ?  $S2['tmasuk'] : '') == $ak['tahun']) ? 'selected' : '' ?>><?= $ak['tahun'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Tahun Lulus</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="s2_tlulus" aria-label="Select a prodi" data-control="select2" data-placeholder="Pilih Tahun Lulus..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih Tahun Lulus...</option>
                                <?php foreach ($angkatan as $ak) : ?>
                                    <option value="<?= $ak['tahun'] ?>" <?= (old('s2_tlulus', isset($S2['tlulus']) ? $S2['tlulus'] : '') == $ak['tahun']) ? 'selected' : '' ?>><?= $ak['tahun'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--end::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Prodi</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="s2_prodi" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('s2_prodi', isset($S2['prodi']) ? $S2['prodi'] : '') ?>" />
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!-- end form wrapper -->

                <!-- form wrapper -->
                <div class="notice  rounded border-warning border border-dashed mb-9 p-6">
                    <h6 class="m-0">Riwayat S3</h6>
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Nama Universitas</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="s3_universitas" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('s3_universitas', (isset($S3['universitas'])) ? $S3['universitas'] : '') ?>" />
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Tahun Masuk</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="s3_tmasuk" aria-label="Select a prodi" data-control="select2" data-placeholder="Pilih Tahun Masuk..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih Tahun Masuk...</option>
                                <?php foreach ($angkatan as $ak) : ?>
                                    <option value="<?= $ak['tahun'] ?>" <?= (old('s3_tmasuk', (isset($S3['tmasuk'])) ? $S3['tmasuk'] : '') == $ak['tahun']) ? 'selected' : '' ?>><?= $ak['tahun'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Tahun Lulus</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="s3_tlulus" aria-label="Select a prodi" data-control="select2" data-placeholder="Pilih Tahun Lulus..." class="form-select form-select-solid form-select-lg fw-semibold">
                                <option value="">Pilih Tahun Lulus...</option>
                                <?php foreach ($angkatan as $ak) : ?>
                                    <option value="<?= $ak['tahun'] ?>" <?= (old('s3_tlulus', (isset($S3['tlulus'])) ? $S3['tlulus'] : '') == $ak['tahun']) ? 'selected' : '' ?>><?= $ak['tahun'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--end::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Prodi</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="s3_prodi" class="form-control form-control-lg form-control-solid" placeholder="" value="<?= old('s3_prodi', (isset($S3['prodi'])) ? $S3['prodi'] : '') ?>" />
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!-- end form wrapper -->

            </div>
            <!--end::Card body-->
            <!--end::Content-->
        </div>
        <!--end::Akademik info-->

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
        var addForm = document.getElementById('addForm')
        $(addForm.querySelector('[name="s1_prodi_alt"]')).on('change', function() {
            var s1_prodi = addForm.querySelector('[name="s1_prodi_alt"]').value;
            addForm.querySelector('[name="s1_prodi"]').value = s1_prodi;
        });
        var rules = {
            fields: {
                'nama': {
                    validators: {
                        notEmpty: {
                            message: 'Nama Prodi Harus diisi'
                        }
                    }
                },
                'email': {
                    validators: {
                        notEmpty: {
                            message: 'Alamat Email Harus diisi'
                        },
                        emailAddress: {
                            message: 'Alamat Email Harus Valid'
                        }
                    }
                },
                'nowa': {
                    validators: {
                        notEmpty: {
                            message: 'Nomor WA Harus diisi'
                        }
                    }
                },
                's1_tmasuk': {
                    validators: {
                        notEmpty: {
                            message: 'Tahun Masuk Harus diisi'
                        }
                    }
                },
                's1_tlulus': {
                    validators: {
                        notEmpty: {
                            message: 'Tahun Lulus Harus diisi'
                        }
                    }
                },
                's1_prodi': {
                    validators: {
                        notEmpty: {
                            message: 'Prodi Harus diisi'
                        }
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

        Alpine.data('ui', () => ({
            loading: false,
            async handleSubmit() {
                let status = await validator.validate();
                if (status == 'Valid') {
                    this.loading = true;
                    addForm.submit();
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