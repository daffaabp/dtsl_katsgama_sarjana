<div x-show="loading" class="mt-8 text-center">Loading data...</div>
<div class="card card-flush h-lg-100" id="kt_contacts_main" x-show="!loading">
    <div class="card-body pt-5">
        <div class="d-flex gap-7 align-items-center">
            <div class="symbol symbol-circle symbol-100px">
                <img x-show="alumni.photo" :src="'<?= site_url() ?>photos/'+alumni.photo" alt="image" />
                <img x-show="!alumni.photo" src="<?= site_url() ?>assets/media/avatars/avatar1.png" alt="image" />
            </div>
            <div class="d-flex flex-column gap-2">
                <h3 class="mb-0" x-text="alumni.nama"></h3>
                <div class="d-flex align-items-center gap-2">
                    <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor" />
                            <path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <a class="text-muted text-hover-primary" x-text="alumni.email"></a>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 20H19V21C19 21.6 18.6 22 18 22H6C5.4 22 5 21.6 5 21V20ZM19 3C19 2.4 18.6 2 18 2H6C5.4 2 5 2.4 5 3V4H19V3Z" fill="currentColor" />
                            <path opacity="0.3" d="M19 4H5V20H19V4Z" fill="currentColor" />
                        </svg>
                    </span>
                    <a href="#" class="text-muted text-hover-primary" x-text="alumni.nowa"></a>
                </div>
            </div>
        </div>
        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x fs-6 fw-semibold mt-6 mb-8">
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_contact_view_general">
                    <span class="svg-icon svg-icon-4 me-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 2.375L2 9.575V20.575C2 21.175 2.4 21.575 3 21.575H9C9.6 21.575 10 21.175 10 20.575V14.575C10 13.975 10.4 13.575 11 13.575H13C13.6 13.575 14 13.975 14 14.575V20.575C14 21.175 14.4 21.575 15 21.575H21C21.6 21.575 22 21.175 22 20.575V9.575L13 2.375C12.4 1.875 11.6 1.875 11 2.375Z" fill="currentColor" />
                        </svg>
                    </span>
                    <span>Info</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_contact_view_activity">
                    <span class="svg-icon svg-icon-4 me-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.0077 19.2901L12.9293 17.5311C12.3487 17.1993 11.6407 17.1796 11.0426 17.4787L6.89443 19.5528C5.56462 20.2177 4 19.2507 4 17.7639V5C4 3.89543 4.89543 3 6 3H17C18.1046 3 19 3.89543 19 5V17.5536C19 19.0893 17.341 20.052 16.0077 19.2901Z" fill="currentColor" />
                        </svg>
                    </span>
                    <span>Riwayat Akademik</span>
                </a>
            </li>
        </ul>
        <div class="tab-content" id="">
            <div class="tab-pane fade show active" id="kt_contact_view_general" role="tabpanel">
                <div class="d-flex flex-column gap-5 mt-7">
                    <div class="d-flex flex-column gap-1">
                        <div class="fw-bold text-muted">Bidang Pekerjaan - <span x-text="alumni.occupation"></span></div>
                        <div class="fw-bold fs-6" x-text="alumni.instansi"></div>
                        <div class="fs-7">
                            <span class="fw-bold">Jabatan: </span>
                            <span x-text="alumni.jabatan"></span>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <div class="fw-bold text-muted">Propinsi Asal</div>
                        <div class="fw-bold fs-6" x-text="alumni.propinsi"></div>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <div class="fw-bold text-muted">Alamat</div>
                        <div class="fs-6" x-text="alumni.alamat"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="kt_contact_view_activity" role="tabpanel">
                <div class="">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-40px symbol-circle">
                            <h1>S1</h1>
                        </div>
                        <div class="ms-4">
                            <div class="fs-6 fw-bold text-gray-900 text-hover-primary mb-1" x-text="S1.universitas"></div>
                            <div class="fw-semibold fs-6 text-muted">Prodi: <span x-text="S1.prodi"></span></div>
                            <div class="fw-semibold fs-7 text-muted">Tahun Masuk: <span x-text="S1.tmasuk"></span> - Tahun Lulus: <span x-text="S1.tlulus"></span></div>
                        </div>
                    </div>
                    <div class="mb-8"></div>
                    <div x-show="S2.universitas">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-40px symbol-circle">
                                <h1>S2</h1>
                            </div>
                            <div class="ms-4">
                                <div class="fs-6 fw-bold text-gray-900 text-hover-primary mb-1" x-text="S2.universitas"></div>
                                <div class="fw-semibold fs-6 text-muted" x-show="S2.prodi">Prodi: <span x-text="S2.prodi"></span></div>
                                <div class="fw-semibold fs-7 text-muted">Tahun Masuk: <span x-text="S2.tmasuk"></span> - Tahun Lulus <span x-text="S2.tlulus"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-8"></div>
                    <div x-show="!!S3.universitas">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-40px symbol-circle">
                                <h1>S3</h1>
                            </div>
                            <div class="ms-4">
                                <div class="fs-6 fw-bold text-gray-900 text-hover-primary mb-1" x-text="S3.universitas"></div>
                                <div class="fw-semibold fs-6 text-muted" x-show="!!S3.prodi">Prodi: <span x-text="S3.prodi"></span></div>
                                <div class="fw-semibold fs-7 text-muted">Tahun Masuk: <span x-text="S3.tmasuk"></span> - Tahun Lulus <span x-text="S3.tlulus"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>