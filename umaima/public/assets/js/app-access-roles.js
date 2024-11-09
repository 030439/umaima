"use strict";
$(function () {
    var t,
        e = $(".datatables-users"),
        s = {
            1: { title: "Pending", class: "bg-label-warning" },
            2: { title: "Active", class: "bg-label-success" },
            3: { title: "Inactive", class: "bg-label-secondary" },
        },
        o = "app-user-view-account.html";

    e.length &&
        (t = e.DataTable({
            ajax: assetsPath + "json/user-list.json",
            columns: [
                { data: "id" },
                { data: "id" },
                { data: "full_name" },
                { data: "role" },
                { data: "current_plan" },
                { data: "billing" },
                { data: "status" },
                { data: "" },
            ],
            columnDefs: [
                {
                    className: "control",
                    orderable: !1,
                    searchable: !1,
                    responsivePriority: 2,
                    targets: 0,
                    render: function () {
                        return "";
                    },
                },
                {
                    targets: 1,
                    orderable: !1,
                    checkboxes: {
                        selectAllRender: '<input type="checkbox" class="form-check-input">',
                    },
                    render: function () {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input" >';
                    },
                    searchable: !1,
                },
                {
                    targets: 2,
                    responsivePriority: 4,
                    render: function (t, e, a) {
                        var s = a.full_name,
                            i = a.email,
                            r = a.avatar;
                        return (
                            '<div class="d-flex justify-content-left align-items-center">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar avatar-sm me-4">' +
                            (r
                                ? '<img src="' +
                                  assetsPath +
                                  "img/avatars/" +
                                  r +
                                  '" alt="Avatar" class="rounded-circle">'
                                : '<span class="avatar-initial rounded-circle bg-label-' +
                                  ["success", "danger", "warning", "info", "primary", "secondary"][
                                      Math.floor(6 * Math.random())
                                  ] +
                                  '">' +
                                  ((r = ((s = a.full_name).match(/\b\w/g) || []).shift() || "") +
                                      (r.pop() || "")).toUpperCase() +
                                  "</span>") +
                            '</div></div><div class="d-flex flex-column"><a href="' +
                            o +
                            '" class="text-heading text-truncate"><span class="fw-medium">' +
                            s +
                            "</span></a><small>@" +
                            i +
                            "</small></div></div>"
                        );
                    },
                },
                {
                    targets: 3,
                    render: function (t, e, a) {
                        a = a.role;
                        return (
                            "<span class='text-truncate d-flex align-items-center text-heading'>" +
                            {
                                Subscriber:
                                    '<i class="ti ti-crown ti-md text-primary me-2"></i>',
                                Author:
                                    '<i class="ti ti-edit ti-md text-warning me-2"></i>',
                                Maintainer:
                                    '<i class="ti ti-user ti-md text-success me-2"></i>',
                                Editor:
                                    '<i class="ti ti-chart-pie ti-md text-info me-2"></i>',
                                Admin:
                                    '<i class="ti ti-device-desktop ti-md text-danger me-2"></i>',
                            }[a] +
                            a +
                            "</span>"
                        );
                    },
                },
                {
                    targets: 4,
                    render: function (t, e, a) {
                        return '<span class="text-heading">' + a.current_plan + "</span>";
                    },
                },
                {
                    targets: 6,
                    render: function (t, e, a) {
                        a = a.status;
                        return (
                            '<span class="badge ' +
                            s[a].class +
                            '" text-capitalized>' +
                            s[a].title +
                            "</span>"
                        );
                    },
                },
                {
                    targets: -1,
                    title: "Actions",
                    searchable: !1,
                    orderable: !1,
                    render: function () {
                        return (
                            '<div class="d-flex align-items-center">' +
                            '<a href="javascript:;" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill delete-record"><i class="ti ti-trash ti-md"></i></a>' +
                            '<a href="' +
                            o +
                            '" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill"><i class="ti ti-eye ti-md"></i></a>' +
                            '<a href="javascript:;" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-md"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-end m-0">' +
                            '<a href="javascript:;" class="dropdown-item">Edit</a>' +
                            '<a href="javascript:;" class="dropdown-item">Suspend</a>' +
                            "</div></div>"
                        );
                    },
                },
            ],
            order: [[2, "desc"]],
            dom: '<"row"<"col-md-2"<l>><"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0"fB>>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "Show _MENU_",
                search: "",
                searchPlaceholder: "Search User",
                paginate: {
                    next: '<i class="ti ti-chevron-right ti-sm"></i>',
                    previous: '<i class="ti ti-chevron-left ti-sm"></i>',
                },
            },
            buttons: [
                
                {
                    extend: "collection",
                    className:
                        "btn btn-label-secondary dropdown-toggle me-4 waves-effect waves-light border-left-0 border-right-0 rounded",
                    text:
                        '<i class="ti ti-upload ti-xs me-sm-1 align-text-bottom"></i> <span class="d-none d-sm-inline-block">Export</span>',
                    buttons: [
                        {
                            extend: "print",
                            text: '<i class="ti ti-printer me-1" ></i>Print',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [3, 4, 5, 6, 7],
                                format: {
                                    body: function (t, e, a) {
                                        var n;
                                        return t.length <= 0
                                            ? t
                                            : ((t = $.parseHTML(t)),
                                              (n = ""),
                                              $.each(t, function (t, e) {
                                                  void 0 !== e.classList &&
                                                  e.classList.contains("user-name")
                                                      ? (n += e.lastChild.firstChild.textContent)
                                                      : void 0 === e.innerText
                                                      ? (n += e.textContent)
                                                      : (n += e.innerText);
                                              }),
                                              n);
                                    },
                                },
                            },
                            customize: function (t) {
                                $(t.document.body)
                                    .css("color", config.colors.headingColor)
                                    .css("border-color", config.colors.borderColor)
                                    .css("background-color", config.colors.bodyBg);
                                $(t.document.body)
                                    .find("table")
                                    .addClass("compact")
                                    .css("color", "inherit")
                                    .css("border-color", "inherit")
                                    .css("background-color", "inherit");
                            },
                        },
                        {
                            extend: "csv",
                            text: '<i class="ti ti-file-text me-1" ></i>Csv',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [3, 4, 5, 6, 7],
                                format: {
                                    body: function (t, e, a) {
                                        var n;
                                        return t.length <= 0
                                            ? t
                                            : ((t = $.parseHTML(t)),
                                              (n = ""),
                                              $.each(t, function (t, e) {
                                                  void 0 !== e.classList &&
                                                  e.classList.contains("user-name")
                                                      ? (n += e.lastChild.firstChild.textContent)
                                                      : void 0 === e.innerText
                                                      ? (n += e.textContent)
                                                      : (n += e.innerText);
                                              }),
                                              n);
                                    },
                                },
                            },
                        },
                        {
                            extend: "excel",
                            text: '<i class="ti ti-file-spreadsheet me-1"></i>Excel',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [3, 4, 5, 6, 7],
                                format: {
                                    body: function (t, e, a) {
                                        var n;
                                        return t.length <= 0
                                            ? t
                                            : ((t = $.parseHTML(t)),
                                              (n = ""),
                                              $.each(t, function (t, e) {
                                                  void 0 !== e.classList &&
                                                  e.classList.contains("user-name")
                                                      ? (n += e.lastChild.firstChild.textContent)
                                                      : void 0 === e.innerText
                                                      ? (n += e.textContent)
                                                      : (n += e.innerText);
                                              }),
                                              n);
                                    },
                                },
                            },
                        },
                        {
                            extend: "pdf",
                            text: '<i class="ti ti-file-description me-1"></i>Pdf',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [3, 4, 5, 6, 7],
                                format: {
                                    body: function (t, e, a) {
                                        var n;
                                        return t.length <= 0
                                            ? t
                                            : ((t = $.parseHTML(t)),
                                              (n = ""),
                                              $.each(t, function (t, e) {
                                                  void 0 !== e.classList &&
                                                  e.classList.contains("user-name")
                                                      ? (n += e.lastChild.firstChild.textContent)
                                                      : void 0 === e.innerText
                                                      ? (n += e.textContent)
                                                      : (n += e.innerText);
                                              }),
                                              n);
                                    },
                                },
                            },
                        },
                    ],
                },
                {
                    text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New Role</span>',
                    className: "add-new btn btn-primary mb-6 mb-md-0 waves-effect waves-light",
                    attr: {
                        "data-bs-toggle": "modal", 
                        "data-bs-target": "#addRoleModal"
                    },
                    init: function (e, a, t) {
                        $(a).removeClass("btn-secondary");
                    }
                }
            ],
        }));
});



function fetchPermissions() {
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/permissions-listing')
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const permissions = data.permissions;
                    const tableBody = document.querySelector('#permissionsTable tbody');
                    tableBody.innerHTML = ''; // Clear existing rows

                    // Group permissions by category
                    const categories = {};

                    permissions.forEach(permission => {
                        const [category, action] = permission.name.split('.');
                        if (!categories[category]) {
                            categories[category] = [];
                        }
                        categories[category].push({ ...permission, action });
                    });

                    // Iterate over each category and create a row for it
                    Object.keys(categories).forEach(category => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="text-nowrap fw-medium text-heading">${capitalize(category)}</td>
                            <td>
                                <div class="d-flex justify-content-start">
                                    <!-- Select All Checkbox -->
                                    <div class="form-check mb-0 me-4">
                                        <input class="form-check-input select-all-checkbox" type="checkbox" id="selectAll_${category}">
                                        <label class="form-check-label" for="selectAll_${category}">
                                             All
                                        </label>
                                    </div>

                                    <!-- Individual Permission Checkboxes -->
                                    ${categories[category].map(permission => `
                                        <div class="form-check mb-0 me-4 me-lg-12">
                                            <input class="form-check-input permission-checkbox" type="checkbox" id="${permission.name}" name="permissions[]" value="${permission.id}">
                                            <label class="form-check-label" for="${permission.name}">
                                                ${capitalize(permission.action)}
                                            </label>
                                        </div>
                                    `).join('')}
                                </div>
                            </td>
                        `;
                        tableBody.appendChild(row);

                        // Add event listener for the "Select All" checkbox
                        const selectAllCheckbox = row.querySelector(`#selectAll_${category}`);
                        const permissionCheckboxes = row.querySelectorAll('.permission-checkbox');

                        selectAllCheckbox.addEventListener('change', function() {
                            permissionCheckboxes.forEach(checkbox => {
                                checkbox.checked = selectAllCheckbox.checked;
                            });
                        });
                    });
                } else {
                    console.error('Error fetching permissions:', data.message);
                }
            })
            .catch(error => console.error('Fetch error:', error));
    });
}

// Utility function to capitalize words
function capitalize(word) {
    return word.charAt(0).toUpperCase() + word.slice(1);
}

fetchPermissions();





