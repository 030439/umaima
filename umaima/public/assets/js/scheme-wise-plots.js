"use strict";
var sid=$("#sid").attr('title');
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
            responsive: true,
            scrollX: true,
            pageLength: 10,
            ajax: {
                url: "/api/scheme-plots/"+sid,
                headers: {
                    "X-CSRF-TOKEN": csrfToken // Add CSRF token to request headers
                },
                type: "POST", // Ensure the correct HTTP method is used
                dataSrc: "data" // Server response should contain the "data" key for rows
            },
            columns: [   // Map to 'name' in the returned JSON
                { data: 'id',title:"Scheme" },       // Map to 'id' in the returned JSON
                { data: 'id',title:"Plot-number" },     // Map to 'name' in the returned JSON
                { data: 'id',title:"plot-size" },       // Map to 'id' in the returned JSON
                { data: 'id',title:"plot-location" }, 
                { data: 'id',title:"status" }, 
                // { data: 'id',title:"actions" },    
            ],
            columnDefs: [
               
                {
                    targets: 0,
                    responsivePriority: 4,
                    render: function(t, e, a, s) {
                        var n = a.scheme
                        return '<div class="d-flex justify-content-start align-items-center user-name">' +
                            '<div class="d-flex flex-column"><a href="' + r + '" class="text-heading text-truncate"><span class="fw-medium">' + n + "</span></a></div></div>";
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
                        return '<span class="text-heading">' + a.size + "</span>";
                    }
                },
                {
                    targets: 3,
                    render: function(t, e, a, s) {
                        return '<span class="text-heading">' + a.location + "</span>";
                    }
                },
                {
                    targets: 4,
                    render: function(t, e, a, s) {
                        a = a.status;
                        var status_bg;
                        var status_title;
                        if (a === 1) {
                            status_title="Active"
                            status_bg='bg-label-success';
                        } else if (a === 2) {
                            status_title="Pending"
                                   status_bg='bg-label-warning';
                        } else if (a === 0) {
                            status_title="Inactive"
                            status_bg='bg-label-secondary';
                        }
                        return '<span class="badge ' + status_bg + '" text-capitalized>' +status_title+ "</span>";
                    }
                },
                // {
                //     targets: -1,
                //     title: "Actions",
                //     searchable: false,
                //     orderable: false,
                //     render: function(t, e, a, s) {
                //         return `
                //             <div class="d-flex align-items-center">
                //                 <a href="javascript:;" 
                //                    class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill edit-record" 
                //                    data-id="${a.id}" 
                //                    onclick="showEditModal(${a.id})">
                //                     <i class="ti ti-eye ti-md"></i>
                //                 </a>
                //                 <a href="${r}" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill">
                //                     <i class="ti ti-edit ti-md"></i>
                //                 </a>
                //                 <a href="javascript:;" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill delete-record">
                //                     <i class="ti ti-trash ti-md"></i>
                //                 </a>
                //             </div>`;
                //     }
                    
                // }
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
                text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Scheme Plot</span>',
                className: "add-new btn btn-primary mb-6 mb-md-0 waves-effect waves-light",
                attr: {
                    onclick: "window.location.href='/add-scheme-plot'"
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
  function showEditModal(id) {
    // Populate modal fields or perform actions based on the `id`
    console.log("Editing record with ID:", id);
    getUser(id);
    const addCCModal = new bootstrap.Modal(document.getElementById('addNewCCModal'));
    addCCModal.show();
}


