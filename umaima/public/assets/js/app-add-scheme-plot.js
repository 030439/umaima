const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
function showToast(message, type) {
    const toastContainer = document.getElementById("toastContainer");

    const toast = document.createElement("div");
    toast.classList.add("toast", "fade", "show", `bg-${type}`);
    toast.setAttribute("role", "alert");
    toast.setAttribute("aria-live", "assertive");
    toast.setAttribute("aria-atomic", "true");

    toast.innerHTML = `
        <div class="toast-body text-white">
            ${message}
        </div>
    `;

    // Append the toast to the container
    toastContainer.appendChild(toast);

    // Remove toast after 5 seconds
    setTimeout(() => {
        toast.classList.remove("show");
        toast.classList.add("hide");
        toast.addEventListener("transitionend", () => toast.remove());
    }, 5000);
}

function fetchSchemeDetails() {
    $.ajax({
        method: "POST",
        url: "/api/get-scheme-details",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        success: function(data) {
            if (data.success) {
                populateDropdown("plotSize", data.plotSizes);
                populateDropdown("plotLocation", data.plotLocations);
                populateDropdown("schemeSelection", data.scheme);
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

// Call fetchSchemeDetails when the page loads or form initializes
document.addEventListener("DOMContentLoaded", function () {
    fetchSchemeDetails();
});

function saveSchemePlot(plot) {
   
    $.ajax({
        method: "POST",
        url: "/api/create-scheme-plot",
        data: { plot: plot },
        headers: {
            "X-CSRF-TOKEN": csrfToken
        },
        success: function(data) {
            if (data.success==true) {
                showToast(data.message, "success");
                setTimeout(() => {
                    window.location.href = "/plots";
                }, 2000);
            } else {
                showToast("Error: " + data.message, "danger");
            }
        },
        error: function(jqXHR) {
            const errorResponse = jqXHR.responseJSON;
            if (errorResponse && errorResponse.error) {
                showToast("Error: " + errorResponse.message, "danger");
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                showToast("An error occurred while saving the scheme.", "danger");
            }
        }
    });
}



document.getElementById("schemePlotForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent default form submission
    let isValid = true;

    // Reset all fields to remove previous error states
    const fields = document.querySelectorAll(".form-control, .form-select");
    fields.forEach(field => {
        field.classList.remove("is-invalid");
        const errorContainer = field.nextElementSibling;
        if (errorContainer && errorContainer.classList.contains("invalid-feedback")) {
            errorContainer.style.display = "none";
        }
    });

    // Validate Scheme Selection
    const schemeSelection = document.getElementById("schemeSelection");
    if (schemeSelection.value === "") {
        setError(schemeSelection, "Please select a scheme.");
        isValid = false;
    }

    // Validate Plot Number
    const plotNumber = document.getElementById("plotNumber");
    if (plotNumber.value.trim() === "") {
        setError(plotNumber, "Please enter the plot number.");
        isValid = false;
    }

    // Validate Plot Size
    const plotSize = document.getElementById("plotSize");
    if (plotSize.value === "") {
        setError(plotSize, "Please select the plot size.");
        isValid = false;
    }

    // Validate Plot Location
    const plotLocation = document.getElementById("plotLocation");
    if (plotLocation.value === "") {
        setError(plotLocation, "Please select the plot location.");
        isValid = false;
    }
    const plotCat = document.getElementById("plotCat");
    if (plotCat.value === "") {
        setError(plotCat, "Please select the plot plot Category.");
        isValid = false;
    }

    if (isValid) {
        const scheme = {
            scheme: schemeSelection.value,
            plotNumber: plotNumber.value,
            plotSize: plotSize.value,
            plotLocation: plotLocation.value,
            plotCat:plotCat.value
        };

        saveSchemePlot(scheme); // Call save function to handle form submission
    }
});

function setError(element, message) {
    element.classList.add("is-invalid");
    const errorContainer = element.nextElementSibling;
    if (errorContainer && errorContainer.classList.contains("invalid-feedback")) {
        errorContainer.style.display = "block";
        errorContainer.innerText = message;
    }
}
