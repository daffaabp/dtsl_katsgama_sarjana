"use strict";

var KTAppEcommerceSettings = {
    init: function () {
        const formIds = [
            "kt_ecommerce_settings_general_form",
            "kt_ecommerce_settings_general_store",
            "kt_ecommerce_settings_general_localization",
            "kt_ecommerce_settings_general_products",
            "kt_ecommerce_settings_general_customers"
        ];

        formIds.forEach((formId) => {
            const formElement = document.getElementById(formId);
            if (!formElement) return;

            const requiredLabels = formElement.querySelectorAll(".required");
            let inputElement;
            const validationConfig = {
                fields: {},
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            };

            requiredLabels.forEach((label) => {
                const row = label.closest(".row");
                const input = row.querySelector("input");
                const textarea = row.querySelector("textarea");
                const select = row.querySelector("select");

                inputElement = input || textarea || select;
                if (!inputElement) return;

                const fieldName = inputElement.getAttribute("name");
                validationConfig.fields[fieldName] = {
                    validators: {
                        notEmpty: {
                            message: label.innerText + " is required"
                        }
                    }
                };
            });

            const validator = FormValidation.formValidation(formElement, validationConfig);

            const submitButton = formElement.querySelector('[data-kt-ecommerce-settings-type="submit"]');
            submitButton.addEventListener("click", function (e) {
                e.preventDefault();

                if (!validator) return;

                validator.validate().then(function (status) {
                    console.log("validated!");
                    if (status === "Valid") {
                        submitButton.setAttribute("data-kt-indicator", "on");
                        submitButton.disabled = true;

                        setTimeout(function () {
                            submitButton.removeAttribute("data-kt-indicator");
                            submitButton.disabled = false;

                            Swal.fire({
                                text: "Form has been successfully submitted!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }, 2000);
                    } else {
                        Swal.fire({
                            text: "Oops! There are some error(s) detected.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            });
        });

        document.querySelectorAll('[data-kt-ecommerce-settings-type="tagify"]').forEach((el) => {
            new Tagify(el);
        });

        (() => {
            const formatCountryOption = (option) => {
                if (!option.id) return option.text;

                const span = document.createElement("span");

                const img = document.createElement("img");
                const imgSrc = option.element.getAttribute("data-kt-select2-country");
                img.setAttribute("src", imgSrc);
                img.setAttribute("class", "rounded-circle h-20px me-2");
                img.setAttribute("alt", "image");

                const textNode = document.createTextNode(option.text);

                span.appendChild(img);
                span.appendChild(textNode);

                return $(span);
            };

            $('[data-kt-ecommerce-settings-type="select2_flags"]').select2({
                placeholder: "Select a country",
                minimumResultsForSearch: Infinity,
                templateSelection: formatCountryOption,
                templateResult: formatCountryOption
            });
        })();
    }
};

KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceSettings.init();
});
