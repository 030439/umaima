"use strict";

!function () {
    window.Helpers.initCustomOptionCheck();

    var flatpickrElements = [].slice.call(document.querySelectorAll(".flatpickr-validation"));
    flatpickrElements && flatpickrElements.forEach(element => {
        element.flatpickr({
            allowInput: true,
            monthSelectorType: "static"
        });
    });

    var validationForms = document.querySelectorAll(".needs-validation");
    Array.prototype.slice.call(validationForms).forEach(function (form) {
        form.addEventListener("submit", function (event) {
            if (form.checkValidity()) {
                alert("Submitted!!!");
            } else {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add("was-validated");
        }, false);
    });
}();

document.addEventListener("DOMContentLoaded", function (event) {
    const form = document.getElementById("formValidationExamples"),
        selectAllote = jQuery(form.querySelector('[name="allote"]')),
        selectScheme = jQuery(form.querySelector('[name="scheme"]')),
        selectPlot = jQuery(form.querySelector('[name="plot"]')),
        formValidator = FormValidation.formValidation(form, {
            fields: {
                allote: {
                    validators: {
                        notEmpty: { message: "Please select an allote" }
                    }
                },
                cnic: {
                    validators: {
                        notEmpty: { message: "Please enter your CNIC" },
                        stringLength: { min: 13, max: 13, message: "CNIC must be 13 characters long" },
                        regexp: { regexp: /^[0-9]+$/, message: "CNIC must consist of digits only" }
                    }
                },
                scheme: {
                    validators: {
                        notEmpty: { message: "Please select a scheme" }
                    }
                },
                plot: {
                    validators: {
                        notEmpty: { message: "Please select a plot" }
                    }
                },
                category: {
                    validators: {
                        notEmpty: { message: "Please enter a category" }
                    }
                },
                location: {
                    validators: {
                        notEmpty: { message: "Please enter a location" }
                    }
                },
                'plot-size': {
                    validators: {
                        notEmpty: { message: "Please enter a plot size" }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger,
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: "",
                    rowSelector: ".col-md-6"
                }),
                submitButton: new FormValidation.plugins.SubmitButton,
                defaultSubmit: new FormValidation.plugins.DefaultSubmit,
                autoFocus: new FormValidation.plugins.AutoFocus
            },
            init: validator => {
                validator.on("plugins.message.placed", function (event) {
                    if (event.element.parentElement.classList.contains("input-group")) {
                        event.element.parentElement.insertAdjacentElement("afterend", event.messageElement);
                    }
                    if (event.element.parentElement.parentElement.classList.contains("custom-option")) {
                        event.element.closest(".row").insertAdjacentElement("afterend", event.messageElement);
                    }
                });
            }
        });

    selectAllote.length && (
        selectAllote.wrap('<div class="position-relative"></div>'),
        selectAllote.select2({
            placeholder: "Select allote",
            dropdownParent: selectAllote.parent()
        }).on("change", function () {
            formValidator.revalidateField("allote");
        })
    );

    selectScheme.length && (
        selectScheme.wrap('<div class="position-relative"></div>'),
        selectScheme.select2({
            placeholder: "Select scheme",
            dropdownParent: selectScheme.parent()
        }).on("change", function () {
            formValidator.revalidateField("scheme");
        })
    );

    selectPlot.length && (
        selectPlot.wrap('<div class="position-relative"></div>'),
        selectPlot.select2({
            placeholder: "Select plot",
            dropdownParent: selectPlot.parent()
        }).on("change", function () {
            formValidator.revalidateField("plot");
        })
    );
});


function populateDropdown(selectId, items) {
    const selectElement = document.getElementById(selectId);
    selectElement.innerHTML = "<option value=''>Select</option>"; // Reset options

    items.forEach(item => {
        const option = document.createElement("option");
        option.value = item.value;
        option.textContent = item.label;
        selectElement.appendChild(option);
    });
}

function fetchSchemeDetails() {
    $.ajax({
        method: "POST",
        url: "/api/get-alloties",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        success: function(data) {
            if (data.success) {
                populateDropdown("allote", data.allotes);
                populateDropdown("scheme", data.scheme);
            } else {
                showToast("Error: " + data.message, "danger");
            }
        },
        error: function(jqXHR) {
            const errorResponse = jqXHR.responseJSON;
            if (errorResponse && errorResponse.error) {
                showToast("Error: " + errorResponse.message, "danger");
            } else {
                showToast("Failed to load scheme details.", "danger");
            }
        }
    });
}
fetchSchemeDetails();

    const selectScheme = document.getElementById("scheme");
    const selectPlot = document.getElementById("plot");

    // Event listener for scheme selection change
    selectScheme.addEventListener("change", function () {
        const schemeId = selectScheme.value;
        if (schemeId) {
            fetchPlots(schemeId);
        } else {
            resetPlots();
        }
    });

    // Function to fetch and populate plots
    function fetchPlots(schemeId) {
        $.ajax({
            method: "post",
            url: `/api/get-plots-by-scheme`,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            data:{id:schemeId}, // Your endpoint for fetching plots
            success: function (response) {
                if (response.success && response.plots) {
                    populateDropdown(response.plots);
                } else {
                    showToast("Failed to fetch plots", "danger");
                }
            },
            error: function () {
                showToast("Error fetching plots", "danger");
            }
        });
    }

    // Function to populate plots dropdown
    function populatePlots(plots) {
        resetPlots(); // Clear existing options first
        plots.forEach(plot => {
            const option = document.createElement("option");
            option.value = plot.id; // Assuming each plot has an `id`
            option.text = plot.name; // Assuming each plot has a `name`
            selectPlot.add(option);
        });
    }

    // Function to reset plot dropdown to default
    function resetPlots() {
        selectPlot.innerHTML = '<option value="">Select</option>';
    }


