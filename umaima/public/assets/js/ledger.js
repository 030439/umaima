"use strict";
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
$(function () {
    let e, s, a;
    a = (
        isDarkStyle
            ? ((e = config.colors_dark.borderColor),
              (s = config.colors_dark.bodyBg),
              config.colors_dark)
            : ((e = config.colors.borderColor),
              (s = config.colors.bodyBg),
              config.colors)
    ).headingColor;
    var t,
        n = $(".datatables-products"),
        i = {
            1: { title: "Scheduled", class: "bg-label-warning" },
            2: { title: "Publish", class: "bg-label-success" },
            3: { title: "Inactive", class: "bg-label-danger" },
        },
        o = {
            0: { title: "Household" },
            1: { title: "Office" },
            2: { title: "Electronics" },
            3: { title: "Shoes" },
            4: { title: "Accessories" },
            5: { title: "Game" },
        },
        c = { 0: { title: "Out_of_Stock" }, 1: { title: "In_Stock" } },
        r = { 0: { title: "Out of Stock" }, 1: { title: "In Stock" } };
    n.length &&
    ((t = n.DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        pageLength: 200,
        ajax: {
            url: "/api/getLedger",
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
                    var paymentType = $('#paymentType').val(); 
                    if(paymentType){
                        d.payment=paymentType;
                    }
                    var subcat = $('#subcat').val(); 
                    if(subcat){
                        d.subcat=subcat;
                    }
                // You can also add other data here as needed
            },
            type: "POST", // Ensure the correct HTTP method is used
            dataSrc: "data" // Server response should contain the "data" key for rows
        },
        columns: [   // Map to 'name' in the returned JSON
            { data: 'id',title:"Date" },       // Map to 'id' in the returned JSON
            {data:'id',title:"Receipt No"},
            { data: 'id',title:"Payment" },     // Map to 'name' in the returned JSON
            { data: 'id',title:"account" },       // Map to 'id' in the returned JSON
            { data: 'id',title:"amount" }, 
            { data: 'id',title:"Narration" }, 
        ],
        columnDefs: [
            
            
            {
                targets: 0,
                render: function (t, e, a, s) {
                    return (a.paydate
                    );
                },
                
            },
            {
                targets: 1,
                render: function (t, e, a, s) {
                    return (a.receipt_id
                    );
                },
                
            },
            {
                targets: 2,
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
                targets: 3,
                render: function (t, e, a, s) {
                    return'<h6 class="mb-0 align-items-center d-flex w-px-100 ' +
                              a.bank +
                              '">' +a.bank+
                              a.account +
                              "</h6>";
                },
               
            },
            {
                targets: 4,
                responsivePriority: 1,
                render: function (t, e, a, s) {
                    return (
                        a.amount 
                    );
                }
            },
            {
                targets: 5,
                responsivePriority: 1,
                render: function (t, e, a, s) {
                    return (
                        a.narration 
                    );
                }
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
        $(".dataTables_length").addClass("mx-n2"),
        $(".dt-buttons").addClass("d-flex flex-wrap mb-6 mb-sm-0")),
        $(".datatables-products tbody").on(
            "click",
            ".delete-record",
            function () {
                t.row($(this).parents("tr")).remove().draw();
            }
        ),
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


        function getAlloteDetail() {
            var dateRangeer = $('#flatpickr-range').val(); // Get the value of the date range input
            var _startDate = ""; 
            var _endDate = "";
        
            if (dateRangeer) {
                // Split the date range into start and end dates
                var dates_ = dateRangeer.split(' to ');
                if (dates_.length === 2) {  // Ensure we have two dates
                    _startDate = dates_[0].trim(); // From date
                    _endDate = dates_[1].trim();   // To date
                }
            }
        
            var _subcat = $('#subcat').val();
        
            $.ajax({
                method: "POST",
                url: "/api/alloteData",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                data: {
                    startDate: _startDate,
                    endDate: _endDate,
                    subcat: _subcat
                },
                success: function(data) {
                    if (data.success) {
                        var totalAmount = 0;
                        var totalPaidAmount = 0;
                        var totalPendingAmount = 0;
        
                        console.log("Data received:", data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        }
        

        $('#paymentType').on('change', function () {
            t.ajax.reload(function (json) {
                $("#subcat").val('');
                var paymentType = $('#paymentType').val(); 
                paymentType==1?fetchAlloties():fetchExpenseHeads();
            });
        });
        $('#subcat').on('change', function () {
            getAlloteDetail();
            t.ajax.reload(function (json) {
            });
        });
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

    $("#"+selectId).select2();
}

function fetchExpenseHeads() {
    $.ajax({
        method: "POST",
        url: "/get-account-heads",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        success: function(data) {
            if (data.success) {
                populateDropdown("subcat", data.expenses);
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

function fetchAlloties() {
    $.ajax({
        method: "POST",
        url: "/api/getAllotiesNames",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        success: function(data) {
            if (data.success) {
                populateDropdown("subcat", data.alloties);
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
