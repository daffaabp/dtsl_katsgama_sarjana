"use strict";

var KTAppEcommerceSettings = {
    init: function() {
        // Helper function untuk validasi URL
        const isSafeUrl = function(url) {
            try {
                const parsedUrl = new URL(url);
                return ['http:', 'https:'].includes(parsedUrl.protocol);
            } catch (e) {
                return false;
            }
        };

        // Helper function untuk membuat elemen gambar dengan aman
        const createSafeImage = function(src, classes, altText) {
            const img = document.createElement('img');
            if (src && isSafeUrl(src)) {
                img.setAttribute('src', src);
            } else {
                img.setAttribute('src', 'default-placeholder.png'); // fallback image
            }
            img.setAttribute('class', classes);
            img.setAttribute('alt', altText || 'image');
            return img;
        };

        // Form Validation untuk Multiple Forms
        [
            "kt_ecommerce_settings_general_form",
            "kt_ecommerce_settings_general_store",
            "kt_ecommerce_settings_general_localization",
            "kt_ecommerce_settings_general_products",
            "kt_ecommerce_settings_general_customers"
        ].forEach((formId => {
            const form = document.getElementById(formId);
            if (!form) return;

            const requiredElements = form.querySelectorAll(".required");
            var targetElement;
            
            var validationConfig = {
                fields: {},
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            };

            requiredElements.forEach((element => {
                const row = element.closest(".row");
                
                // Find input element
                targetElement = row.querySelector("input") || 
                              row.querySelector("textarea") || 
                              row.querySelector("select");
                
                if (targetElement) {
                    const fieldName = targetElement.getAttribute("name");
                    validationConfig.fields[fieldName] = {
                        validators: {
                            notEmpty: {
                                message: element.innerText + " is required"
                            }
                        }
                    };
                }
            }));

            // Initialize form validation
            var formValidation = FormValidation.formValidation(form, validationConfig);

            // Submit button handler
            const submitButton = form.querySelector('[data-kt-ecommerce-settings-type="submit"]');
            submitButton.addEventListener("click", function(e) {
                e.preventDefault();
                
                formValidation && formValidation.validate().then(function(status) {
                    console.log("validated!");
                    
                    if (status == "Valid") {
                        submitButton.setAttribute("data-kt-indicator", "on");
                        submitButton.disabled = true;
                        
                        setTimeout(function() {
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
        }));

        // Initialize Tagify
        document.querySelectorAll('[data-kt-ecommerce-settings-type="tagify"]')
            .forEach(element => {
                new Tagify(element);
            });

        // Initialize Select2 with Flags
        (() => {
            const countryTemplateHandler = (data) => {
                if (!data.id) return data.text;
                
                // Create container
                const container = document.createElement("span");
                
                // Get country flag URL
                const countryImageUrl = data.element.getAttribute("data-kt-select2-country");
                
                // Create and append flag image if URL is valid
                if (countryImageUrl) {
                    const flagImage = createSafeImage(
                        countryImageUrl,
                        "rounded-circle h-20px me-2",
                        "country flag"
                    );
                    container.appendChild(flagImage);
                }
                
                // Add country name safely
                const textNode = document.createTextNode(data.text || "");
                container.appendChild(textNode);
                
                return $(container);
            };

            // Initialize Select2
            $('[data-kt-ecommerce-settings-type="select2_flags"]').select2({
                placeholder: "Select a country",
                minimumResultsForSearch: Infinity,
                templateSelection: countryTemplateHandler,
                templateResult: countryTemplateHandler
            });
        })();
    }
};

KTUtil.onDOMContentLoaded(function() {
    KTAppEcommerceSettings.init();
});