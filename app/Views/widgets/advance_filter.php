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