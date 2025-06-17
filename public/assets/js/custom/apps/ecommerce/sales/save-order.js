"use strict";

var KTAppEcommerceSalesSaveOrder = function() {
    var e, t;

    // Helper function untuk sanitasi URL
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

    return {
        init: function() {
            (() => {
                $("#kt_ecommerce_edit_order_date").flatpickr({
                    altInput: true,
                    altFormat: "d F, Y",
                    dateFormat: "Y-m-d"
                });

                // Safe Select2 template function
                const r = function(e) {
                    if (!e.id) return e.text;
                    
                    const container = document.createElement("span");
                    
                    // Create and append image safely
                    const countryImageUrl = e.element.getAttribute("data-kt-select2-country");
                    if (countryImageUrl) {
                        const img = createSafeImage(
                            countryImageUrl,
                            "rounded-circle h-20px me-2",
                            "country flag"
                        );
                        container.appendChild(img);
                    }
                    
                    // Add text safely
                    const textNode = document.createTextNode(e.text || "");
                    container.appendChild(textNode);
                    
                    return $(container);
                };

                // Initialize Select2 components
                $("#kt_ecommerce_edit_order_billing_country").select2({
                    placeholder: "Select a country",
                    minimumResultsForSearch: Infinity,
                    templateSelection: r,
                    templateResult: r
                });

                $("#kt_ecommerce_edit_order_shipping_country").select2({
                    placeholder: "Select a country",
                    minimumResultsForSearch: Infinity,
                    templateSelection: r,
                    templateResult: r
                });

                // Initialize DataTable
                e = document.querySelector("#kt_ecommerce_edit_order_product_table");
                t = $(e).DataTable({
                    order: [],
                    scrollY: "400px",
                    scrollCollapse: true,
                    paging: false,
                    info: false,
                    columnDefs: [{
                        orderable: false,
                        targets: 0
                    }]
                });
            })();

            // Search functionality
            document.querySelector('[data-kt-ecommerce-edit-order-filter="search"]')
                .addEventListener("keyup", function(e) {
                    t.search(e.target.value).draw();
                });

            // Shipping form toggle
            (() => {
                const e = document.getElementById("kt_ecommerce_edit_order_shipping_form");
                document.getElementById("same_as_billing").addEventListener("change", (t => {
                    t.target.checked ? e.classList.add("d-none") : e.classList.remove("d-none");
                }));
            })();

            // Product selection handling
            (() => {
                const t = e.querySelectorAll('[type="checkbox"]');
                const r = document.getElementById("kt_ecommerce_edit_order_selected_products");
                const o = document.getElementById("kt_ecommerce_edit_order_total_price");

                t.forEach((e => {
                    e.addEventListener("change", (t => {
                        const originalProduct = e.closest("tr")
                            .querySelector('[data-kt-ecommerce-edit-order-filter="product"]');
                        
                        // Create new container safely
                        const newContainer = document.createElement("div");
                        const productId = originalProduct.getAttribute("data-kt-ecommerce-edit-order-id");
                        
                        // Create inner container
                        const innerDiv = document.createElement("div");
                        innerDiv.className = "d-flex align-items-center border border-dashed rounded p-3 bg-body";
                        
                        // Clone product content safely
                        const productContent = originalProduct.cloneNode(true);
                        
                        // Clear and set new classes
                        newContainer.className = "col my-2";
                        newContainer.setAttribute("data-kt-ecommerce-edit-order-id", productId);
                        
                        // Safely transfer content
                        while (productContent.firstChild) {
                            innerDiv.appendChild(productContent.firstChild);
                        }
                        
                        newContainer.appendChild(innerDiv);

                        if (t.target.checked) {
                            r.appendChild(newContainer);
                        } else {
                            const existingProduct = r.querySelector(`[data-kt-ecommerce-edit-order-id="${productId}"]`);
                            if (existingProduct) {
                                r.removeChild(existingProduct);
                            }
                        }
                        
                        updateTotalPrice();
                    }));
                }));

                const updateTotalPrice = () => {
                    const emptyMessage = r.querySelector("span");
                    const selectedProducts = r.querySelectorAll('[data-kt-ecommerce-edit-order-filter="product"]');

                    if (selectedProducts.length < 1) {
                        emptyMessage.classList.remove("d-none");
                        o.textContent = "0.00";
                    } else {
                        emptyMessage.classList.add("d-none");
                        calculateTotal(selectedProducts);
                    }
                };

                const calculateTotal = elements => {
                    let total = 0;
                    elements.forEach((element => {
                        const priceElement = element.querySelector('[data-kt-ecommerce-edit-order-filter="price"]');
                        const price = parseFloat(priceElement.textContent);
                        total = parseFloat(total + price);
                    }));
                    o.textContent = total.toFixed(2);
                };
            })();

            // Form validation
            (() => {
                let e;
                const t = document.getElementById("kt_ecommerce_edit_order_form");
                const r = document.getElementById("kt_ecommerce_edit_order_submit");

                e = FormValidation.formValidation(t, {
                    fields: {
                        payment_method: {
                            validators: {
                                notEmpty: {
                                    message: "Payment method is required"
                                }
                            }
                        },
                        shipping_method: {
                            validators: {
                                notEmpty: {
                                    message: "Shipping method is required"
                                }
                            }
                        },
                        order_date: {
                            validators: {
                                notEmpty: {
                                    message: "Order date is required"
                                }
                            }
                        },
                        billing_order_address_1: {
                            validators: {
                                notEmpty: {
                                    message: "Address line 1 is required"
                                }
                            }
                        },
                        billing_order_postcode: {
                            validators: {
                                notEmpty: {
                                    message: "Postcode is required"
                                }
                            }
                        },
                        billing_order_state: {
                            validators: {
                                notEmpty: {
                                    message: "State is required"
                                }
                            }
                        },
                        billing_order_country: {
                            validators: {
                                notEmpty: {
                                    message: "Country is required"
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: ""
                        })
                    }
                });

                r.addEventListener("click", (o => {
                    o.preventDefault();
                    e && e.validate().then((function(e) {
                        console.log("validated!");
                        if (e == "Valid") {
                            r.setAttribute("data-kt-indicator", "on");
                            r.disabled = true;
                            setTimeout(() => {
                                r.removeAttribute("data-kt-indicator");
                                Swal.fire({
                                    text: "Form has been successfully submitted!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then((e) => {
                                    if (e.isConfirmed) {
                                        r.disabled = false;
                                        window.location = t.getAttribute("data-kt-redirect");
                                    }
                                });
                            }, 2000);
                        } else {
                            Swal.fire({
                                html: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    }));
                }));
            })();
        }
    };
}();

KTUtil.onDOMContentLoaded(function() {
    KTAppEcommerceSalesSaveOrder.init();
});