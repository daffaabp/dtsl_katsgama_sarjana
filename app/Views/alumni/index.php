<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('title') ?>
Data Alumni
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
						<input type="text" class="form-control form-control-solid ps-10" name="q" value="<?= (!empty($req['q'])) ? $req['q'] : '';  ?>" placeholder="Cari berdasarkan nama" />
					</div>
					<!--end::Input group-->
					<!--begin:Action-->
					<div class="d-flex align-items-center">
						<button type="submit" class="btn btn-primary me-5">Search</button>
						<a @click.prevent="advanceSearch = !advanceSearch" class="btn btn-link">
							<span x-text="advanceSearch ? 'Hide Filter' : 'Advanced Filter'"></span>
						</a>
					</div>
					<!--end:Action-->
				</div>
				<!--end::Compact form-->
				<!--begin::Advance form-->
				<div class="collapse" :class="advanceSearch ? 'show':''" id="kt_advanced_search_form">
					<!--begin::Separator-->
					<div class="separator separator-dashed mt-9 mb-6"></div>
					<!--end::Separator-->
					<!--begin::Row-->
					<div class="row g-8 mb-8">
						<!--begin::Col-->
						<div class="col-xxl-12">
							<div class="row g-8">

								<!--begin::Col-->
								<div class="col-lg-4">
									<label class="fs-6 form-label fw-bold text-dark">Propinsi Asal</label>
									<!--begin::Select-->
									<select name="province" class="form-select" data-control="select2" data-placeholder="Select an option">
										<option value="0">Semua Propinsi</option>
										<?php foreach ($provinces as $pr) : ?>
											<option <?= ((!empty($req['province'])) && $req['province'] == $pr['id']) ? 'selected' : '' ?> value="<?= $pr['id'] ?>"><?= esc($pr['nama']) ?></option>
										<?php endforeach ?>
									</select>
									<!--end::Select-->
								</div>
								<!--end::Col-->
								<!--begin::Col-->
								<div class="col-lg-4">
									<label class="fs-6 form-label fw-bold text-dark">Bidang Kerja</label>
									<!--begin::Dialer-->
									<select name="occupation" class="form-select" data-control="select2" data-placeholder="Select an option">
										<option value="0">Semua Bidang</option>
										<?php foreach ($occupations as $oc) : ?>
											<option <?= ((!empty($req['occupation'])) && $req['occupation'] == $oc['id']) ? 'selected' : '' ?> value="<?= $oc['id'] ?>"><?= esc($oc['name']) ?></option>
										<?php endforeach ?>
									</select>
									<!--end::Dialer-->
								</div>
								<!--end::Col-->

								<!--begin::Col-->
								<div class="col-lg-4">
									<label class="fs-6 form-label fw-bold text-dark">Angkatan</label>
									<!--begin::Select-->
									<select name="tmasuk" class="form-select" data-control="select2" data-placeholder="Pilih Angkatan">
										<option value="0">Semua Angkatan</option>
										<?php foreach ($angkatan as $tm) : ?>
											<option <?= ((!empty($req['tmasuk'])) && $req['tmasuk'] == $tm['tahun']) ? 'selected' : '' ?> value="<?= esc($tm['tahun']) ?>"><?= esc($tm['tahun']) ?></option>
										<?php endforeach ?>
									</select>
									<!--end::Select-->
								</div>
								<!--end::Col-->

							</div>
						</div>
						<!--end::Col-->
					</div>

					<div class="row g-8 mb-8">
						<!--begin::Col-->
						<div class="col-xxl-12">
							<div class="row g-8">
								<!--begin::Col-->
								<div class="col-lg-4">
									<label class="fs-6 form-label fw-bold text-dark">Prodi</label>
									<!--begin::Select-->
									<select name="prodi" class="form-select" data-control="select2" data-placeholder="Select an option">
										<option value="0">Semua Prodi</option>
										<?php foreach ($prodi as $prod) : ?>
											<option <?= ((!empty($req['prodi'])) && $req['prodi'] == $prod['id']) ? 'selected' : '' ?> value="<?= $prod['id'] ?>"><?= esc($prod['nprodi']) ?></option>
										<?php endforeach ?>
									</select>
									<!--end::Select-->
								</div>
								<!--end::Col-->

								<!--begin::Col-->
								<div class="col-lg-4">
									<label class="fs-6 form-label fw-bold text-dark">Prodi Lainya</label>
									<input type="text" name="prodiAlt" class="form-control form-control-lg form-control-solid" placeholder="Cari prodi lainya" value="<?= (!empty($req['prodiAlt'])) ? $req['prodiAlt'] : '';  ?>" />
								</div>
								<!--end::Col-->

								<!--begin::Col-->
								<div class="col-lg-4">
									<label class="fs-6 form-label fw-bold text-dark">Jabatan</label>
									<input type="text" name="jabatan" class="form-control form-control-lg form-control-solid" placeholder="Cari Berdasarkan Jabatan" value="<?= (!empty($req['jabatan'])) ? $req['jabatan'] : '';  ?>" />
								</div>
								<!--end::Col-->
							</div>
						</div>
						<!--end::Col-->
					</div>

					<div class="row g-8 mb-8">
						<!--begin::Col-->
						<div class="col-xxl-12">
							<div class="row g-8">
								<!--begin::Col-->
								<div class="col-lg-4">
									<label class="fs-6 form-label fw-bold text-dark">Instansi</label>
									<input type="text" name="instansi" class="form-control form-control-lg form-control-solid" placeholder="Cari Berdasarkan Instansi" value="<?= (!empty($req['instansi'])) ? $req['instansi'] : '';  ?>" />
								</div>
								<!--end::Col-->
							</div>
						</div>
						<!--end::Col-->
					</div>

					<button class="btn btn-primary btn-sm">Apply Filter</button>
					<a href="<?= site_url() ?>alumni" class="btn btn-primary btn-sm">Reset</a>

				</div>
				<!--end::Advance form-->
			</div>
			<!--end::Card body-->
		</div>
		<!--end::Card-->
	</form>
	<!--end::Form Search-->

	<!--begin::Card-->
	<div class="card">
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
						<th class="text-end min-w-100px">Detail</th>
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
											<?php if (isset($al['photo']) && !empty($al['photo'])) : ?>
												<img src="<?php echo site_url() ?>photos/<?= $al['photo'] ?>" class="w-100" />
											<?php else : ?>
												<img src="<?php echo site_url() ?>assets/media/avatars/avatar1.png" class="w-100" />
											<?php endif; ?>
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
								<?= $al['instansi'] ?> <br />
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
								<div class="d-flex justify-content-end flex-shrink-0">
									<div @click.prevent="handleView(<?= $al['id'] ?>)" class="btn btn-sm btn-primary">Lihat</div>
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
	<!--end::Card-->
	<div class="modal fade" tabindex="-1" id="detailModal">
		<!--begin::Modal dialog-->
		<div class="modal-dialog mw-650px">
			<!--begin::Modal content-->
			<div class="modal-content">
				<!--begin::Modal header-->
				<div class="modal-header pb-0 border-0 justify-content-end">
					<!--begin::Close-->
					<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
						<span class="svg-icon svg-icon-1">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
								<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
							</svg>
						</span>
						<!--end::Svg Icon-->
					</div>
					<!--end::Close-->
				</div>
				<!--begin::Modal header-->
				<!--begin::Modal body-->
				<div class="modal-body scroll-y">
					<!--begin::Users-->
					<div class="mb-15">
						<!--begin::List-->
						<div class="mh-500px scroll-y me-n7 pe-7">
							<?php include('modal_content.php') ?>
						</div>
						<!--end::List-->
					</div>
					<!--end::Users-->
				</div>
				<!--end::Modal body-->
			</div>
			<!--end::Modal content-->
		</div>
		<!--end::Modal dialog-->
	</div>




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
		var detailModal = new bootstrap.Modal(document.getElementById('detailModal'));

		Alpine.data('ui', () => ({
			advanceSearch: Alpine.$persist(false),
			loading: false,
			alumni: {
				nama: '',
				email: '',
				nowa: '',
				notelp: '',
				alamat: '',
				jabatan: '',
				instansi: '',
				propinsi: '',
				occupation: '',
			},
			S1: {
				universitas: '',
				tmasuk: '',
				tlulus: '',
				prodi: '',
			},
			S2: {
				universitas: '',
				tmasuk: '',
				tlulus: '',
				prodi: '',
			},
			S3: {
				universitas: '',
				tmasuk: '',
				tlulus: '',
				prodi: '',
			},
			resetdata() {
				this.alumni = {
					nama: '',
					email: '',
					nowa: '',
					notelp: '',
					alamat: '',
					jabatan: '',
					instansi: '',
					propinsi: '',
					occupation: ''
				};
				this.S1 = {
					universitas: '',
					tmasuk: '',
					tlulus: '',
					prodi: ''
				};
				this.S2 = {
					universitas: '',
					tmasuk: '',
					tlulus: '',
					prodi: ''
				};
				this.S3 = {
					universitas: '',
					tmasuk: '',
					tlulus: '',
					prodi: ''
				};
			},
			async handleView(id) {
				try {
					this.resetdata();
					this.loading = true;
					detailModal.show();
					let req = await fetch(site_url + 'alumni/info/' + id);
					this.loading = false;
					if (req.ok) {
						let res = await req.json();
						this.alumni = {
							...res.alumni
						};
						this.S1 = {
							...res.S1
						};
						this.S2 = {
							...res.S2
						};
						this.S3 = {
							...res.S3
						};
					}
				} catch (error) {

				}
			},
		}))
	})
</script>
<?= $this->endSection() ?>