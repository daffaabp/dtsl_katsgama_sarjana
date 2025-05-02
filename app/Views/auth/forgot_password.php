<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>Forgot password</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="<?php echo site_url(); ?>assets/media/logos/favicon.ico" />
    <!--begin::Fonts-->
	<link rel="stylesheet" href="<?=site_url()?>assets/css/fonts.css" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="<?php echo site_url(); ?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo site_url(); ?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <style>
        .loginWrap {
            background-color: #fff;
            padding: 50px;
            border-radius: 10px;
            border: 2px #E7F6F2 solid;
        }

        .logoWrap {
            text-align: center;
        }

        .logoImg {
            width: 130px;
        }

        .loginLabel {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }
        body {
            background: url(<?= site_url('/assets/media/auth/login.jpg')?>) ;
            background-position: center;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-theme-mode");
            } else {
                if (localStorage.getItem("data-theme") !== null) {
                    themeMode = localStorage.getItem("data-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" x-data="loginData()">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-lg-500px p-10">
                        <!--begin::Form-->
                        <div class="loginWrap">
                            <div class="logoWrap">
                                <img class="logoImg" src="<?= site_url() ?>assets/media/logos/logo1.png" />
                            </div>
                            <form @submit.prevent="handleSubmit" class="form w-100" novalidate="novalidate" id="login_form" action="<?= site_url() ?>forgot" method="POST">
                                <?= csrf_field() ?>
                                <div class="text-center mb-11">
                                    <h3 class="text-dark fw-bolder mb-3">Forgot Password</h3>
                                </div>

                                <?php if (session()->get('error')) : ?>
                                    <div class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                                        <span class="svg-icon svg-icon-2hx svg-icon-danger me-4 mb-5 mb-sm-0">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="currentColor"></path>
                                                <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <div class="d-flex flex-column pe-0 pe-sm-10">
                                            <h5 class="mb-1">Error</h5>
                                            <span><?= session()->get('error') ?></span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="bi bi-x fs-1 text-danger"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>

                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::Email-->
                                    <label for="username" class="loginLabel">Alamat Email</label>
                                    <input type="text" value="<?= old('username') ?>" placeholder="Email" name="username" autocomplete="off" class="form-control bg-transparent" />
                                    <!--end::Email-->
                                </div>
                                <!--end::Input group=-->

                                <!--begin::Submit button-->
                                <div class="d-grid mb-10">
                                    <button type="submit" class="btn btn-primary">
                                        <!--begin::Indicator label-->
                                        <span x-show="!loading">Kirim Password</span>
                                        <!--end::Indicator label-->
                                        <!--begin::Indicator progress-->
                                        <span x-show="loading">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                        <!--end::Indicator progress-->
                                    </button>
                                </div>
                                <!--end::Submit button-->
                            </form>
                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <!--begin::Link-->
                                <a href="<?= site_url() ?>login" class="link-primary">Back to Login</a>
                                <!--end::Link-->
                            </div>
                        </div>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Form-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="<?php echo site_url(); ?>assets/plugins/global/plugins.bundle.js"></script>
    <script src="<?php echo site_url(); ?>assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used by this page)-->
    <script src="<?php echo site_url(); ?>assets/js/alpine.js" defer></script>
    <?php if (isset($_GET['p'])) : ?>
        <script>
            Swal.fire({
                text: "Password berhasil diganti, silahkan login kembali",
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
        const login_form = document.getElementById("login_form");
        const fv = FormValidation.formValidation(login_form, {
            fields: {
                username: {
                    validators: {
                        notEmpty: {
                            message: "Username is required",
                        },
                        emailAddress: {
                            message: "Username harus valid email",
                        },
                    },
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: "Password is required",
                        },
                    },
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".fv-row",
                    eleInvalidClass: "",
                    eleValidClass: "",
                }),
            },
        });

        function loginData() {
            return {
                loading: false,
                async handleSubmit() {
                    const status = await fv.validate();
                    if (status == "Valid") {
                        this.loading = true;
                        login_form.submit();
                    }
                }
            }
        }
    </script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>