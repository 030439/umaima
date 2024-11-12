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

function installmets() {
    $.ajax({
        method: "POST",
        url: "/api/get-installments",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        success: function(data) {
            if (data.success) {
                populateDropdown("installment", data.installment);
                populateDropdown("duration", data.duration);
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
installmets();
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
    selectPlot.addEventListener("change", function () {
        const plotId = selectPlot.value;
        if (plotId) {
            fetchPlotsDetails(plotId);
        } else {
            resetPlots();
        }
    });

    // Function to fetch and populate plots
    function fetchPlots(plotId) {
        $.ajax({
            method: "post",
            url: `/api/get-plots-by-scheme`,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            data:{id:plotId}, // Your endpoint for fetching plots
            success: function (response) {
                if (response.success && response.plots) {
                    populateDropdown('plot',response.plots);
                    
                } else {
                    showToast("Failed to fetch plots", "danger");
                }
            },
            error: function () {
                showToast("Error fetching plots", "danger");
            }
        });
    }

    function fetchPlotsDetails(schemeId) {
        $.ajax({
            method: "post",
            url: `/api/get-plots-detail`,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            data:{id:schemeId}, // Your endpoint for fetching plots
            success: function (response) {
                if (response.success && response.detail) {
                    $("#category").val(response.detail[0].category);
                    $("#location").val(response.detail[0].location);
                    $("#plot-size").val(response.detail[0].size);
                } else {
                    showToast("Failed to fetch plots", "danger");
                }
            },
            error: function () {
                showToast("Error fetching plots", "danger");
            }
        });
    }


    // Function to reset plot dropdown to default
    function resetPlots() {
        selectPlot.innerHTML = '<option value="">Select</option>';
    }

    const actionButton = document.getElementById("actionButton");
    const tabButtons = document.querySelectorAll('.nav-link[data-bs-toggle="tab"]');

    // Loop through each tab and add event listener
    tabButtons.forEach(tab => {
        tab.addEventListener("shown.bs.tab", function (event) {
            const activeTab = event.target.getAttribute("data-bs-target");
            
            // Check if the active tab is the "Installment" tab
            if (activeTab === "#form-tabs-social") { // Ensure this ID matches your "Installment" tab
                actionButton.disabled = false;
                actionButton.classList.add("text-success");
            } else {
                actionButton.disabled = true;
                actionButton.classList.remove("text-success"); 
            }
        });
    });

    actionButton.addEventListener("click", function () {

        var paymentDetailsTab = new bootstrap.Tab(document.querySelector('#form-tabs-detail'));
        paymentDetailsTab.show();
            submitForm();
    });
    function submitForm() {
        // Create a new FormData object from the form
        const formData = new FormData(document.getElementById("checkSchedule"));
        fetch("/api/show-payment-schedule", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
        })
        .then(response => response.json()) // Assuming JSON response
        .then(data => {
            // Pass the data to a function to render the table
            renderTable(data);
        })
        .catch(error => console.error("Error:", error));
    }

    function renderTable(response) {
        if(response){
            
            let rows = '';
            let totalPlots = 0;
            response.forEach(item => {
                console.log(item);
              rows += `<tr>
                          <td>${item.payment}</td>
                          <td>${item.amount}</td>
                          <td>${item.date}</td>
                       </tr>`;
                       totalPlots += parseFloat(item.amount);
            });
            
            // Insert rows into the table body
            document.getElementById("paymentDetailsTableBody").innerHTML = rows;
            document.getElementById("totalPlots").innerText = totalPlots;
        }else{
            document.getElementById("paymentDetailsTableBody").innerHTML = '<tr><td colspan="5">Error loading data.</td></tr>';
        }
       
    }

    function confirmForm() {
        // Create a new FormData object from the form
        const formData = new FormData(document.getElementById("checkSchedule"));
        fetch("/api/confirm-schedule", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
        })
        .then(response => response.json()) // Assuming JSON response
        .then(data => {
            // Pass the data to a function to render the table
            renderTable(data);
        })
        .catch(error => console.error("Error:", error));
    }

    const formButton = document.getElementById("confirm-btn");
    formButton.addEventListener("click", function () {
            confirmForm();
    });