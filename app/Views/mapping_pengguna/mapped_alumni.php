<div class="container-fluid" x-data="ui">

    <!--begin::Card-->
    <div class="card">
         <!--begin::Card header-->
         <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Data Alumni</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-125px">Nama</th>
                        <th class="min-w-125px">Angkatan</th>
                        <th class="min-w-125px">Bidang Pekerjaan / Jabatan</th>
                        <th class="min-w-125px">Propinsi Asal</th>
                        <th class="min-w-125px">Riwayat Akademik</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="text-gray-600 fw-semibold">
                    <!--begin::Table row-->
                    <?php foreach ($alumni as $al) : ?>
                        <tr>
                            <!--begin::User=-->
                            <td class="d-flex align-items-center">
                                <!--begin:: Avatar -->
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="<?= site_url() ?>program_sarjana/detail/<?= $al['id'] ?>">
                                        <div class="symbol-label">
                                            <img src="<?php echo site_url() ?>assets/media/avatars/avatar1.png" alt="Francis Mitcham" class="w-100" />
                                        </div>
                                    </a>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::User details-->
                                <div class="d-flex flex-column">
                                    <a href="<?= site_url() ?>program_sarjana/detail/<?= $al['id'] ?>" class="text-gray-800 text-hover-primary mb-1"><?= esc($al['nama']) ?></a>
                                </div>
                                <!--begin::User details-->
                            </td>
                            <!--end::User=-->
                            <!--begin::Role=-->
                            <td>
                                <?= $al['tmasuk'] ?>
                            </td>
                            <!--end::Role=-->
                            <!--begin::Last login=-->
                            <td>
                                <?= $al['occupation'] ?> <br />
                                <?= $al['jabatan'] ?>
                            </td>
                            <!--end::Last login=-->
                            <!--begin::Two step=-->
                            <td><?= $al['propinsi'] ?></td>
                            <!--end::Two step=-->
                            <!--begin::Joined-->
                            <td>
                                <?php foreach ($al['riwayat_akademik'] as $rwak) : ?>
                                    <?php echo $rwak['jenjang'] ?> <?php echo $rwak['universitas'] ?> <br />
                                <?php endforeach ?>
                            </td>
                            <!--begin::Joined-->
                            <!--begin::Action=-->
                            <td class="text-end">
                                <a href="<?=site_url()?>pengguna/delete_mapping/?pengguna_id=<?=$pengguna_id?>&alumni_id=<?=$al['id']?>" class="btn btn-sm btn-primary">Delete Mapping</a>
                            </td>
                            <!--end::Action=-->
                        </tr>
                    <?php endforeach ?>

                    <!--end::Table row-->
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
</div>