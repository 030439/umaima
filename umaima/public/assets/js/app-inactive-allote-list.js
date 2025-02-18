"use strict";
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
$(function() {
    let e, a, s;
    s = (isDarkStyle ? (e = config.colors_dark.borderColor, a = config.colors_dark.bodyBg, config.colors_dark) : (e = config.colors.borderColor, a = config.colors.bodyBg, config.colors)).headingColor;

    var t, n = $(".datatables-users"),
        i = $(".select2"),
        r = "app-user-view-account.html",
        o = {
            1: { title: "Pending", class: "bg-label-warning" },
            2: { title: "Active", class: "bg-label-success" },
            3: { title: "Inactive", class: "bg-label-secondary" }
        };

    if (i.length) {
        i = i.wrap('<div class="position-relative"></div>').select2({
            placeholder: "Select Country",
            dropdownParent: i.parent()
        });
    }

    if (n.length) {
        t = n.DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            pageLength: 10,
            ajax: {
                url: "/api/getInActiveAllotees",
                headers: {
                    "X-CSRF-TOKEN": csrfToken // Add CSRF token to request headers
                },
                type: "POST", // Ensure the correct HTTP method is used
                dataSrc: "data" // Server response should contain the "data" key for rows
            },
            columns: [   // Map to 'name' in the returned JSON
                { data: 'id',title:"Name" },       // Map to 'id' in the returned JSON
                { data: 'id',title:"Plot-No" },     // Map to 'name' in the returned JSON
                { data: 'id',title:"Amount" },       // Map to 'id' in the returned JSON
                { data: 'id',title:"Paid" }, 
                { data: 'id',title:"Due" },   
            ],
            columnDefs: [
             
             
                {
                    targets: 0,
                    render: function(t, e, a, s) {
                        return '<span class="text-heading">' + a.allote + "</span>";
                    }
                    
                },
                {
                    targets: 1,
                    render: function(t, e, a, s) {
                        return '<span class="text-heading">' + a.plot_number + "</span>";
                    }
                },
                {
                    targets: 2,
                    render: function(t, e, a, s) {
                        return '<span class="text-heading">' + a.amount + "</span>";
                    }
                },
                {
                    targets: 3,
                    render: function(t, e, a, s) {
                        return '<span class="text-heading">' + a.paid + "</span>";
                    }
                },
                {
                    targets: 4,
                    render: function(t, e, a, s) {
                        return '<span class="text-heading">' + a.totalDue + "</span>";
                    }
                },
                
              
            ],
            order: [[2, "desc"]],
            dom: '<"row"<"col-md-2"<"ms-n2"l>><"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0 mt-n6 mt-md-0"fB>>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "_MENU_",
                search: "",
                searchPlaceholder: "Search User",
                paginate: {
                    next: '<i class="ti ti-chevron-right ti-sm"></i>',
                    previous: '<i class="ti ti-chevron-left ti-sm"></i>'
                }
            },
            buttons: [
                {
                extend: "collection",
                className: "btn btn-label-secondary dropdown-toggle mx-4 waves-effect waves-light",
                text: '<i class="ti ti-upload me-2 ti-xs"></i>Export',
                buttons: [{
                    extend: "print",
                    text: '<i class="ti ti-printer me-2" ></i>Print',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5],
                        format: {
                            body: function(t, e, a) {
                                var s;
                                return t.length <= 0 ? t : (t = $.parseHTML(t), s = "", $.each(t, function(t, e) {
                                    void 0 !== e.classList && e.classList.contains("user-name") ? s += e.lastChild.firstChild.textContent : void 0 === e.innerText ? s += e.textContent : s += e.innerText;
                                }), s);
                            }
                        }
                    },
                    customize: function(t) {
                        $(t.document.body).css("color", s).css("border-color", e).css("background-color", a);
                        $(t.document.body).find("table").addClass("compact").css("color", "inherit").css("border-color", "inherit").css("background-color", "inherit");
                    }
                }, {
                    extend: "csv",
                    text: '<i class="ti ti-file-text me-2" ></i>Csv',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5],
                        format: {
                            body: function(t, e, a) {
                                var s;
                                return t.length <= 0 ? t : (t = $.parseHTML(t), s = "", $.each(t, function(t, e) {
                                    void 0 !== e.classList && e.classList.contains("user-name") ? s += e.lastChild.firstChild.textContent : void 0 === e.innerText ? s += e.textContent : s += e.innerText;
                                }), s);
                            }
                        }
                    }
                }, {
                    extend: "excel",
                    text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5],
                        format: {
                            body: function(t, e, a) {
                                var s;
                                return t.length <= 0 ? t : (t = $.parseHTML(t), s = "", $.each(t, function(t, e) {
                                    void 0 !== e.classList && e.classList.contains("user-name") ? s += e.lastChild.firstChild.textContent : void 0 === e.innerText ? s += e.textContent : s += e.innerText;
                                }), s);
                            }
                        }
                    }
                }, {
                    extend: "pdf",
                    text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                    className: "dropdown-item",
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5],
                        format: {
                            body: function(t, e, a) {
                                var s;
                                return t.length <= 0 ? t : (t = $.parseHTML(t), s = "", $.each(t, function(t, e) {
                                    void 0 !== e.classList && e.classList.contains("user-name") ? s += e.lastChild.firstChild.textContent : void 0 === e.innerText ? s += e.textContent : s += e.innerText;
                                }), s);
                            }
                        }
                    }
                }],
            },
            {
                text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Allote</span>',
                className: "add-new btn btn-primary mb-6 mb-md-0 waves-effect waves-light",
                attr: {
                    onclick: "window.location.href='/create-allote'"
                },
                init: function (e, a, t) {
                    $(a).removeClass("btn-secondary");
                }
            }
        ]
        });
    }

    // Delete record functionality
    $(".datatables-users").on("click", ".delete-record", function() {
        if (confirm("Are you sure you want to delete this record?")) {
            var t = $(this).closest("tr");
            t.fadeOut(300, function() {
                t.remove();
            });
        }
    });
});

function getRoles(){
    
    $.ajax({
      method:"post",
      url:"/api/roles-read",
      headers: {
          "X-CSRF-TOKEN": csrfToken // Add CSRF token to request headers
      },
      success: function(data) {
        const roleSelect = $('#user-roles');
        roleSelect.empty(); // Clear existing options
        roleSelect.append('<option value="">Select a role</option>'); // Add placeholder

        // Loop through roles and add them to the select dropdown
        data.forEach(function(role) {
          roleSelect.append(`<option value="${role.name}">${role.name}</option>`);
        });
      },
      error: function() {
        console.error('Could not load roles.');
      }
    });
  }
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
  getRoles();
  function saveUsers(user){
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    $.ajax({
      method:"post",
      url:"/api/user-create",
      data:{user:user},
      headers: {
          "X-CSRF-TOKEN": csrfToken // Add CSRF token to request headers
      },
      success: function(data) {
        $(".modal-backdrop").hide();
        $("#addUser").hide();
            if (data.success==true) {
                // Handle success (you could reset the form, show success message, etc.)
                showToast(data.message, "success");
                setTimeout(() => {
                     window.location.reload(); // Reload the page
                }, 2000); 
            } else {
                // Handle failure
                showToast("Error: " + data.message, "danger");

            }
      },
      error: function() {
        console.error('Could not load roles.');
      }
    });
  }
  document.getElementById("editUserForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent default form submission
    let isValid = true;

    // Reset all fields to remove previous error states
    const fields = document.querySelectorAll(".form-control, .form-select");
    fields.forEach(field => {
      field.classList.remove("is-invalid");
      const errorContainer = field.nextElementSibling;
      if (errorContainer && errorContainer.classList.contains("invalid-feedbacks")) {
        errorContainer.style.display = "none";
      }
    });

    // Validate First Name
    const firstName = document.getElementById("modalEditUserFirstName");
    if (firstName.value.trim() === "") {
      setError(firstName, "Please enter your first name.");
      isValid = false;
    }

    // Validate Last Name
    const lastName = document.getElementById("modalEditUserLastName");
    if (lastName.value.trim() === "") {
      setError(lastName, "Please enter your last name.");
      isValid = false;
    }

    // Validate Username
    const username = document.getElementById("modalEditUserName");
    if (username.value.trim() === "") {
      setError(username, "Please enter a username.");
      isValid = false;
    }

    // Validate User Role
    const userRole = document.getElementById("user-roles");
    if (userRole.value === "") {
      setError(userRole, "Please select a user role.");
      isValid = false;
    }

    // Validate Email
    const email = document.getElementById("modalEditUserEmail");
    if (!validateEmail(email.value)) {
      setError(email, "Please enter a valid email.");
      isValid = false;
    }

    // Validate Password
    const password = document.getElementById("modalPassword");
    if (password.value.trim().length < 8) {
      setError(password, "Password must be at least 8 characters.");
      isValid = false;
    }

    if (isValid) {
      if (isValid) {
      const user = {
        firstName: firstName.value,
        lastName: lastName.value,
        username: username.value,
        role: userRole.value,
        email: email.value,
        password: password.value,
        status: document.getElementById("editBillingAddress").checked,
      };

      saveUsers(user);
    }
  }
  });

  function setError(input, message) {
    input.classList.add("is-invalid");
    const errorContainer = input.nextElementSibling;
    if (errorContainer && errorContainer.classList.contains("invalid-feedbacks")) {
      errorContainer.innerText = message;
      errorContainer.style.display = "block";
    }
  }

  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }
  function getUser(id){
    
    $.ajax({
      method:"post",
      url:"/api/get-user",
      data:{id:id},
      headers: {
          "X-CSRF-TOKEN": csrfToken // Add CSRF token to request headers
      },
      success: function(data) {
        if(data.success){
            const user = data.user;
            // Update the table with user data
            updateTableWithUserData(user);
        }
        else{
            console.log(data.user);
        }
      },
      error: function() {
        console.error('Could not load roles.');
      }
    });
  }
  function updateTableWithUserData(user) {
    // Update the table cells with the user data
    $('.user-name .avatar img').attr('src', user.avatar_url); // Assuming you want to update the avatar image
    $('.user-name .fw-medium').text(user.fname + ' ' + user.lname); 
    $('tr td:contains("Role:")').next('td').find('span').text(user.roles); // Assuming you have a 'role' field in the response
    $('tr td:contains("Email:")').next('td').find('span').text(user.email); // Assuming you have a 'plan' field in the response
    $('tr td:contains("Username:")').next('td').text(user.username); // Billing info
    $('tr td:contains("Status:")').next('td').find('.badge').each(function() {
        // Update the text based on user status
        $(this).text(user.status === 1 ? 'Active' : (user.status === 2 ? 'Inactive' : 'Unknown'));
    
        // Change the badge color based on user status
        if (user.status === 1) {
            $(this).removeClass('bg-label-warning bg-label-secondary')
                   .addClass('bg-label-success');
        } else if (user.status === 2) {
            $(this).removeClass('bg-label-success bg-label-secondary')
                   .addClass('bg-label-warning');
        } else if (user.status === 0) {
            $(this).removeClass('bg-label-success bg-label-warning')
                   .addClass('bg-label-secondary');
        }
    });
    
  }
  function showEditModal(id) {
    // Populate modal fields or perform actions based on the `id`
    console.log("Editing record with ID:", id);
    getUser(id);
    const addCCModal = new bootstrap.Modal(document.getElementById('addNewCCModal'));
    addCCModal.show();
}
