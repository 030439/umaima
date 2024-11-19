"use strict";

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
$(function () {
    let e, a, s;
    s = (
        isDarkStyle
            ? ((e = config.colors_dark.borderColor),
              (a = config.colors_dark.bodyBg),
              config.colors_dark)
            : ((e = config.colors.borderColor),
              (a = config.colors.bodyBg),
              config.colors)
    ).headingColor;
    var t,
        n = $(".datatables-order"),
        r = {
            1: { title: "Dispatched", class: "bg-label-warning" },
            2: { title: "Delivered", class: "bg-label-success" },
            3: { title: "Out for Delivery", class: "bg-label-primary" },
            4: { title: "Ready to Pickup", class: "bg-label-info" },
        },
        o = {
            1: { title: "Paid", class: "text-success" },
            2: { title: "Pending", class: "text-warning" },
            3: { title: "Failed", class: "text-danger" },
            4: { title: "Cancelled", class: "text-secondary" },
        };
    n.length &&
        ((t = n.DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollX: true,
            pageLength: 10,
            ajax: {
                url: "/api/getPayments",
                headers: {
                    "X-CSRF-TOKEN": csrfToken // Add CSRF token to request headers
                },
                data: function(d) {
                    // Check if the date range input has a value
                    var dateRange = $('#flatpickr-range').val(); // Get the value of the date range input
                    if (dateRange) {
                        // Split the date range into start and end dates
                        var dates = dateRange.split(' to ');
                        d.startDate = dates[0]; // From date
                        d.endDate = dates[1];   // To date
                    }
                    // You can also add other data here as needed
                },
                type: "POST", // Ensure the correct HTTP method is used
                dataSrc: "data" // Server response should contain the "data" key for rows
            },
            columnDefs: [
                {
                    className: "control",
                    searchable: !1,
                    orderable: !1,
                    responsivePriority: 2,
                    targets: 0,
                    render: function (t, e, a, s) {
                        return "";
                    },
                },
                {
                    targets: 1,
                    orderable: !1,
                    checkboxes: {
                        selectAllRender:
                            '<input type="checkbox" class="form-check-input">',
                    },
                    render: function () {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input" >';
                    },
                    searchable: !1,
                },
                {
                    targets: 2,
                    render: function (t, e, a, s) {
                        return (a.paydate
                        );
                    },
                    
                },
                {
                    targets: 3,
                    render: function (t, e, a, s) {
                        a = a.payment_type;
                        if(a==1){
                            return ('<span class="badge px-2 bg-label-success" text-capitalized="">credit</span>');
                        }else{
                            return ('<span class="badge px-2 bg-label-primary" text-capitalized="">Debit</span>');
                        }
                    },
                },
                {
                    targets: 4,
                    render: function (t, e, a, s) {
                        return'<h6 class="mb-0 align-items-center d-flex w-px-100 ' +
                                  a.bank +
                                  '">' +
                                  a.account +
                                  "</h6>";
                    },
                   
                },
                {
                    targets: 5,
                    responsivePriority: 1,
                    render: function (t, e, a, s) {
                        return (
                            a.amount 
                        );
                    }
                },
                {
                    targets: 6,
                    responsivePriority: 1,
                    render: function (t, e, a, s) {
                        var n = a.fullname,
                            r = a.phone
                            if(!r){r="";}
                            if(n){
                        return (
                            '<div class="d-flex justify-content-start align-items-center order-name text-nowrap">' +
                           
                            '<div class="d-flex flex-column"><h6 class="m-0"><a href="pages-profile-user.html" class="text-heading">' +
                            n +
                            "</a></h6><small>" +
                            r +
                            "</small></div></div>"
                        );
                    }else{
                        return("-");
                    }
                    },
                },
                {
                    targets: 7,
                    render: function (t, e, a, s) {
                        if(a.expense){
                            return (a.expense
                            );
                        }else{
                            return ("-");
                        }
                    },
                    
                },
                {
                    targets: -1,
                    title: "Actions",
                    searchable: !1,
                    orderable: !1,
                    render: function (t, e, a, s) {
                        return '<div class="d-flex justify-content-sm-start align-items-sm-center"><button class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button><div class="dropdown-menu dropdown-menu-end m-0"><a href="app-ecommerce-order-details.html" class="dropdown-item">View</a><a href="javascript:0;" class="dropdown-item delete-record">Delete</a></div></div>';
                    },
                },
            ],
            order: [3, "asc"],
            dom: '<"card-header py-0 d-flex flex-column flex-md-row align-items-center"<f><"d-flex align-items-center justify-content-md-end gap-2 justify-content-center"l<"dt-action-buttons"B>>>t<"row mx-1"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            lengthMenu: [10, 40, 60, 80, 100],
            language: {
                sLengthMenu: "_MENU_",
                search: "",
                searchPlaceholder: "Search Order",
                info: "Displaying _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    next: '<i class="ti ti-chevron-right ti-sm"></i>',
                    previous: '<i class="ti ti-chevron-left ti-sm"></i>',
                },
            },
            buttons: [
                {
                    extend: "collection",
                    className:
                        "btn btn-info dropdown-toggle waves-effect waves-light",
                    text: '<i class="ti ti-upload ti-xs me-2"></i>Export',
                    buttons: [
                        {
                            extend: "print",
                            text: '<i class="ti ti-printer me-2"></i>Print',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (t, e, a) {
                                        var s;
                                        return t.length <= 0
                                            ? t
                                            : ((t = $.parseHTML(t)),
                                              (s = ""),
                                              $.each(t, function (t, e) {
                                                  void 0 !== e.classList &&
                                                  e.classList.contains(
                                                      "order-name"
                                                  )
                                                      ? (s +=
                                                            e.lastChild
                                                                .firstChild
                                                                .textContent)
                                                      : void 0 === e.innerText
                                                      ? (s += e.textContent)
                                                      : (s += e.innerText);
                                              }),
                                              s);
                                    },
                                },
                            },
                            customize: function (t) {
                                $(t.document.body)
                                    .css("color", s)
                                    .css("border-color", e)
                                    .css("background-color", a),
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
                            text: '<i class="ti ti-file me-2"></i>Csv',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (t, e, a) {
                                        var s;
                                        return t.length <= 0
                                            ? t
                                            : ((t = $.parseHTML(t)),
                                              (s = ""),
                                              $.each(t, function (t, e) {
                                                  void 0 !== e.classList &&
                                                  e.classList.contains(
                                                      "order-name"
                                                  )
                                                      ? (s +=
                                                            e.lastChild
                                                                .firstChild
                                                                .textContent)
                                                      : void 0 === e.innerText
                                                      ? (s += e.textContent)
                                                      : (s += e.innerText);
                                              }),
                                              s);
                                    },
                                },
                            },
                        },
                        {
                            extend: "excel",
                            text: '<i class="ti ti-file-export me-2"></i>Excel',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (t, e, a) {
                                        var s;
                                        return t.length <= 0
                                            ? t
                                            : ((t = $.parseHTML(t)),
                                              (s = ""),
                                              $.each(t, function (t, e) {
                                                  void 0 !== e.classList &&
                                                  e.classList.contains(
                                                      "order-name"
                                                  )
                                                      ? (s +=
                                                            e.lastChild
                                                                .firstChild
                                                                .textContent)
                                                      : void 0 === e.innerText
                                                      ? (s += e.textContent)
                                                      : (s += e.innerText);
                                              }),
                                              s);
                                    },
                                },
                            },
                        },
                        {
                            extend: "pdf",
                            text: '<i class="ti ti-file-text me-2"></i>Pdf',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (t, e, a) {
                                        var s;
                                        return t.length <= 0
                                            ? t
                                            : ((t = $.parseHTML(t)),
                                              (s = ""),
                                              $.each(t, function (t, e) {
                                                  void 0 !== e.classList &&
                                                  e.classList.contains(
                                                      "order-name"
                                                  )
                                                      ? (s +=
                                                            e.lastChild
                                                                .firstChild
                                                                .textContent)
                                                      : void 0 === e.innerText
                                                      ? (s += e.textContent)
                                                      : (s += e.innerText);
                                              }),
                                              s);
                                    },
                                },
                            },
                        },
                        {
                            extend: "copy",
                            text: '<i class="ti ti-copy me-2"></i>Copy',
                            className: "dropdown-item",
                            exportOptions: {
                                columns: [2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (t, e, a) {
                                        var s;
                                        return t.length <= 0
                                            ? t
                                            : ((t = $.parseHTML(t)),
                                              (s = ""),
                                              $.each(t, function (t, e) {
                                                  void 0 !== e.classList &&
                                                  e.classList.contains(
                                                      "order-name"
                                                  )
                                                      ? (s +=
                                                            e.lastChild
                                                                .firstChild
                                                                .textContent)
                                                      : void 0 === e.innerText
                                                      ? (s += e.textContent)
                                                      : (s += e.innerText);
                                              }),
                                              s);
                                    },
                                },
                            },
                        },
                    ],
                },
                {
                    text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Payment</span>',
                    className: "add-new btn btn-primary mb-6 mb-md-0 waves-effect waves-light ml-2",
                    attr: {
                        onclick: "window.location.href='/add-payment'",
                    },
                    init: function (e, a, t) {
                        $(a).removeClass("btn-secondary");
                    }
                },
            ],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (t) {
                            return "Details of " + t.data().customer;
                        },
                    }),
                    type: "column",
                    renderer: function (t, e, a) {
                        a = $.map(a, function (t, e) {
                            return "" !== t.title
                                ? '<tr data-dt-row="' +
                                      t.rowIndex +
                                      '" data-dt-column="' +
                                      t.columnIndex +
                                      '"><td>' +
                                      t.title +
                                      ":</td> <td>" +
                                      t.data +
                                      "</td></tr>"
                                : "";
                        }).join("");
                        return (
                            !!a &&
                            $('<table class="table"/><tbody />').append(a)
                        );
                    },
                },
            },
        })),
        $(".dataTables_length").addClass("ms-n2"),
        $(".dt-action-buttons").addClass("pt-0"),
        $(".dataTables_filter").addClass("ms-n3 mb-0 mb-md-6")),
        $(".datatables-order tbody").on("click", ".delete-record", function () {
            t.row($(this).parents("tr")).remove().draw();
        }),
        setTimeout(() => {
            $(".dataTables_filter .form-control").removeClass(
                "form-control-sm"
            ),
                $(".dataTables_length .form-select").removeClass(
                    "form-select-sm"
                );
        }, 300);

        var flatpickrInstance = flatpickr("#flatpickr-range", {
            mode: "range",
            dateFormat: "Y-m-d",
            onClose: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    var fromDate = selectedDates[0].toISOString().split('T')[0];  // Get 'from' date
                    var toDate = selectedDates[1].toISOString().split('T')[0];    // Get 'to' date
        
                    // Refresh the DataTable with the selected date range
                    t.ajax.reload(function(json) {
                        // If you want to modify the data after reload (optional)
                        console.log('Data reloaded with date range:', fromDate, toDate);
                    }, false); // Set to false to avoid resetting paging
                }
            }
        });
});

