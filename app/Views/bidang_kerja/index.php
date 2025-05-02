<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
Data Bidang Kerja
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid" x-data="ui">
	<!--begin::Form Search-->
	<form action="" method="GET">
		<!--begin::Card-->
		<div class="card mb-7">
			<!--begin::Card body-->
			<div class="card-body">
				<!--begin::Compact form-->
				<div class="d-flex align-items-center">
					<!--begin::Input group-->
					<div class="position-relative w-md-400px me-md-2">
						<!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
						<span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
								<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
							</svg>
						</span>
						<!--end::Svg Icon-->
						<input type="text" class="form-control form-control-solid ps-10" name="q" value="<?= (!empty($req['q'])) ? $req['q'] : '';  ?>" placeholder="Cari" />
						<input type="hidden" name="id" :value="formData.id" />
					</div>
					<!--end::Input group-->
					<!--begin:Action-->
					<div class="d-flex align-items-center">
						<button type="submit" class="btn btn-primary me-5">Search</button>
					</div>
					<!--end:Action-->
				</div>
				<!--end::Compact form-->
			</div>
			<!--end::Card body-->
		</div>
		<!--end::Card-->
	</form>
	<!--end::Form Search-->


	<!--begin::Card-->
	<div class="card">
		<!--begin::Card header-->
		<div class="card-header border-0 pt-6">
			<!--begin::Card title-->
			<div class="card-title">

			</div>
			<!--begin::Card title-->
			<!--begin::Card toolbar-->
			<div class="card-toolbar">
				<!--begin::Toolbar-->
				<div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
					<!--begin::Add user-->
					<a @click.prevent="handleAdd" class="btn btn-primary">
						Tambah Bidang Kerja
					</a>
					<!--end::Add user-->
				</div>
				<!--end::Toolbar-->
			</div>
			<!--end::Card toolbar-->
		</div>
		<!--end::Card header-->
		<!--begin::Card body-->
		<div class="card-body py-4">
			<!--begin::Table-->
			<table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
				<!--begin::Table head-->
				<thead>
					<!--begin::Table row-->
					<tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
						<th class="min-w-125px">Nama Prodi</th>
						<th class="min-w-125px">Created At</th>
						<th class="min-w-125px">Updated At</th>
						<th class="text-end min-w-100px">Actions</th>
					</tr>
					<!--end::Table row-->
				</thead>
				<!--end::Table head-->
				<!--begin::Table body-->
				<tbody class="text-gray-600 fw-semibold">
					<!--begin::Table row-->
					<?php foreach ($bidangKerja as $bk) : ?>
						<tr>
							<!--end::Role=-->
							<!--begin::Last login=-->
							<td>
								<?= $bk['name'] ?>
							</td>
							<!--end::Last login=-->

							<!--begin::Joined-->
							<td><?= $bk['created_at'] ?></td>
							<!--begin::Joined-->

							<!--begin::Joined-->
							<td><?= $bk['updated_at'] ?></td>
							<!--begin::Joined-->
							<!--begin::Action=-->
							<td class="text-end">
								<div class="d-flex justify-content-end flex-shrink-0">
									<a @click.prevent="handleEdit(<?= $bk['id'] ?>)" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
										<!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
										<span class="svg-icon svg-icon-3">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
												<path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
											</svg>
										</span>
										<!--end::Svg Icon-->
									</a>
									<a @click.prevent="handleDelete(<?= $bk['id'] ?>)" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
										<!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
										<span class="svg-icon svg-icon-3">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
												<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
												<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
											</svg>
										</span>
										<!--end::Svg Icon-->
									</a>
								</div>
							</td>
							<!--end::Action=-->
						</tr>
					<?php endforeach ?>

					<!--end::Table row-->
				</tbody>
				<!--end::Table body-->
			</table>
			<!--end::Table-->
			<div class="separator separator-dashed mt-9 mb-3"></div>
			<div class="py-3">
				<?= $pager->links() ?>
			</div>

		</div>
		<!--end::Card body-->
	</div>

	<!--begin::Modal Add-->
	<div class="modal fade" tabindex="-1" id="add_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="add_form" @submit.prevent="handleAddPost" autocomplete="off">
					<div class="modal-header">
						<h5 class="modal-title">
							Tambah Data Bidang Kerja
						</h5>
						<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
							<span class="svg-icon svg-icon-1"></span>
						</div>
					</div>
					<div class="modal-body">
						<div>
							<div class="fv-row">
								<label class="col-form-label required fw-semibold fs-6">Bidang Kerja</label>
								<input type="text" x-model="formData.name" name="name" class="form-control form-control-lg form-control-solid" placeholder="" value="" />
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>

			</div>
		</div>
	</div>
	<!--end::Modal Add-->

	<!--begin::Modal Edit-->
	<div class="modal fade" tabindex="-1" id="edit_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="edit_form" @submit.prevent="handleEditPost" autocomplete="off">
					<div class="modal-header">
						<h5 class="modal-title">
							Edit Data Bidang Kerja
						</h5>
						<div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
							<span class="svg-icon svg-icon-1"></span>
						</div>
					</div>

					<div class="modal-body">
						<div>
							<div class="fv-row">
								<label class="col-form-label required fw-semibold fs-6">Bidang Kerja</label>
								<input type="text" x-model="formData.name" name="name" required class="form-control form-control-lg form-control-solid" placeholder="" value="" />
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!--end::Modal Edit-->

	<!--end::Card-->
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
	document.addEventListener('alpine:init', () => {
		var rules = {
			fields: {
				'nama': {
					validators: {
						notEmpty: {
							message: 'Bidang Kerja Harus diisi'
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
		var add_modal = new bootstrap.Modal(document.getElementById('add_modal'));
		var add_form = document.getElementById('add_form')
		var addValidator = FormValidation.formValidation(add_form, rules);

		var edit_modal = new bootstrap.Modal(document.getElementById('edit_modal'));
		var edit_form = document.getElementById('edit_form')
		var editValidator = FormValidation.formValidation(edit_form, rules);

		Alpine.data('ui', () => ({
			formData: {
				name: ''
			},
			loading: false,
			async handleAdd(id) {
				this.formData = {
					name: '',
				}
				add_modal.show();
			},
			async handleAddPost(e) {
				let status = await addValidator.validate();
				if (status == 'Valid') {
					try {
						let req = await fetch(site_url + 'bidang_kerja/add', {
							headers: {
								'Content-Type': 'application/json'
							},
							method: 'POST',
							body: JSON.stringify(this.formData)
						});
						if (req.ok) {
							let res = await req.json();
							this.loading = false;
							if (res.error) {
								Swal.fire({
									text: res.error,
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok",
									customClass: {
										confirmButton: "btn btn-primary"
									}
								});
							} else {
								add_modal.hide();
								let rt = await Swal.fire({
									text: 'Data berhasil ditambahkan',
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
					} catch (error) {
						console.log(error);
					}
				}
			},
			async handleEdit(id) {
				edit_modal.show();
				try {
					this.loading = true;
					let req = await fetch(site_url + 'bidang_kerja/edit/' + id);
					this.loading = false;
					if (req.ok) {
						let res = await req.json();
						this.formData = res;
					}
				} catch (error) {

				}
			},
			async handleEditPost(id) {
				let status = await addValidator.validate();
				if (status == 'Valid') {
					try {
						let req = await fetch(site_url + 'bidang_kerja/edit/' + this.formData.id, {
							headers: {
								'Content-Type': 'application/json'
							},
							method: 'POST',
							body: JSON.stringify(this.formData)
						});
						if (req.ok) {
							let res = await req.json();
							this.loading = false;
							if (res.error) {
								Swal.fire({
									text: res.error,
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok",
									customClass: {
										confirmButton: "btn btn-primary"
									}
								});
							} else {
								edit_modal.hide();
								let rt = await Swal.fire({
									text: 'Data berhasil diubah',
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
					} catch (error) {
						console.log(error);
					}
				}
			},
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
					let req = await fetch(site_url + 'bidang_kerja/delete/' + id);
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