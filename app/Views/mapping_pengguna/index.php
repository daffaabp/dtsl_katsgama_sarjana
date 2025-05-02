<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
Mapping Pengguna
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid" x-data="ui">
    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Data Pengguna</h3>
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
                        <span><?= $pengguna['nama'] ?></span>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Alamat Email / Username</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        <span><?= $pengguna['username'] ?></span>
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
                        <span><?= $pengguna['angkatan'] ?></span>
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

</div>
<?php
    if(isset($isMapped) && $isMapped){
        include('mapped_alumni.php');
    } else {
        include('alumni.php');
    }
?>

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
        Alpine.data('ui', () => ({
            advanceSearchPengguna: Alpine.$persist(false),
            async handleDelete(id) {
                let sw = await Swal.fire({
                    html: `Apakah anda yakin untuk menghapus data ini ?`,
                    icon: "info",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batalkan',
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: 'btn btn-primary'
                    }
                });
                if (sw.isConfirmed) {
                    let req = await fetch(site_url + 'program_sarjana/delete/' + id);
                    if (req.ok) {
                        let rt = await Swal.fire({
                            text: 'Data berhasil dihapus',
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                        if (rt.isConfirmed) {
                            location.reload();
                        }
                    }
                }

            }
        }))
    })
</script>
<?= $this->endSection() ?>