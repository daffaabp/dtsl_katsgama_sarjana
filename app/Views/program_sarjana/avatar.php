<!--begin::Form-->
<form class="form" method="POST" action="<?= site_url() ?>program_sarjana/edit_avatar" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= $id ?>" />
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
                    <label class="col-lg-4 col-form-label fw-semibold fs-6">Photo</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Image input-->
                        <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('<?php echo site_url() ?>assets/media/avatars/avatar1.png')">
                            <!--begin::Preview existing avatar-->
                            <?php if (isset($alumni['photo']) && !empty($alumni['photo'])) : ?>
                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?php echo site_url() ?>photos/<?=$alumni['photo']?>)"></div>
                            <?php else : ?>
                                <div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?php echo site_url() ?>assets/media/avatars/avatar1.png)"></div>
                            <?php endif; ?>
                            <!--end::Preview existing avatar-->
                            <!--begin::Label-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <!--begin::Inputs-->
                                <input type="file" name="file" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Label-->
                            <!--begin::Cancel-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Cancel-->
                            <!--begin::Remove-->
                            <!-- <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                <i class="bi bi-x fs-2"></i>
                            </span> -->
                            <!--end::Remove-->
                        </div>
                        <!--end::Image input-->
                        <!--begin::Hint-->
                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                        <span class="text-danger"><?= $validation->getError('avatar') ?></span>

                        <!--end::Hint-->

                        <!--begin::Actions-->
                        <div class="mt-8" x-data="{loading: false}">
                            <button type="submit" class="btn btn-primary btn-sm" @click="loading=true" x-show="!loading">Upload Photo</button>
                            <button class="btn btn-primary btn-sm" x-show="loading">Loading...</button>
                        </div>
                        <!--end::Actions-->

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



</form>
<!--end::Form-->