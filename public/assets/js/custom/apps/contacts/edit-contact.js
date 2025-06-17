"use strict";

var KTAppContactEdit = {
    init: function () {
        var t;

        // Form Validation
        (() => {
            const t = document.getElementById("kt_ecommerce_settings_general_form");
            if (!t) return;

            const e = t.querySelectorAll(".required");
            var n, o = {
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

            e.forEach((t => {
                const e = t.closest(".fv-row").querySelector("input");
                e && (n = e);
                const r = t.closest(".fv-row").querySelector("select");
                r && (n = r);
                const i = n.getAttribute("name");
                o.fields[i] = {
                    validators: {
                        notEmpty: {
                            message: t.innerText + " is required"
                        }
                    }
                }
            }));

            var r = FormValidation.formValidation(t, o);

            const i = t.querySelector('[data-kt-contacts-type="submit"]');
            i.addEventListener("click", function(t) {
                t.preventDefault();
                r && r.validate().then(function(t) {
                    console.log("validated!");
                    if (t == "Valid") {
                        i.setAttribute("data-kt-indicator", "on");
                        i.disabled = true;
                        setTimeout(function() {
                            i.removeAttribute("data-kt-indicator");
                            i.disabled = false;
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
        })();

        // Safe Select2 Template Function
        t = function(t) {
            if (!t.id) return t.text;
            
            // Create elements safely using DOM API
            const container = document.createElement("span");
            
            // Sanitize country image URL
            const countryImageUrl = t.element.getAttribute("data-kt-select2-country");
            if (countryImageUrl && this.isSafeUrl(countryImageUrl)) {
                const img = document.createElement("img");
                img.setAttribute("src", countryImageUrl);
                img.setAttribute("class", "rounded-circle me-2");
                img.setAttribute("style", "height:19px;");
                img.setAttribute("alt", "country flag");
                container.appendChild(img);
            }
            
            // Add text safely
            const textNode = document.createTextNode(t.text || "");
            container.appendChild(textNode);
            
            return container;
        };

        // URL Safety Check
        t.isSafeUrl = function(url) {
            try {
                const parsedUrl = new URL(url);
                return ['http:', 'https:'].includes(parsedUrl.protocol);
            } catch (e) {
                return false;
            }
        };

        // Initialize Select2
        $('[data-kt-ecommerce-settings-type="select2_flags"]').select2({
            placeholder: "Select a country",
            minimumResultsForSearch: Infinity,
            templateSelection: t,
            templateResult: t
        });
    }
};

KTUtil.onDOMContentLoaded(function() {
    KTAppContactEdit.init();
});