"use strict";
document.addEventListener("DOMContentLoaded", function () {
    FormValidation.formValidation(document.getElementById("addRoleForm"), {
        fields: {
            modalRoleName: {
                validators: {
                    notEmpty: {
                        message: "Please enter role name"
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: "",
                rowSelector: ".col-12"
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        }
    }).on("core.form.valid", function() {
        // Handle form submission if valid
        var formData = new FormData(document.getElementById("addRoleForm"));
        
        // Append the selected permissions to the FormData object
        const selectedPermissions = Array.from(document.querySelectorAll('input[name="permissions[]"]:checked')).map(cb => cb.value);
        selectedPermissions.forEach(permission => formData.append('permissions[]', permission));

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        fetch("/roles", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": csrfToken // Add CSRF token to request headers
            }
        })
        .then(response => response.json()) // Assuming a JSON response
        .then(data => {
            $(".modal-backdrop").hide();
            if (data.status === 'success') {
                // Handle success (reset form, show success message, etc.)
                showToast("Role created successfully!", "success");
                setTimeout(() => {
                    location.reload(); // Reload the page
                }, 2000);
            } else {
                // Handle failure
                showToast("Error: " + data.message, "danger");
            }
        })
        .catch(error => {
            // Handle errors during fetch
            showToast("An error occurred: " + error.message, "danger");
        });
    });
});

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
