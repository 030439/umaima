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
        pageLength: 10,
        ajax: {
            url: "/api/receivingReport",
            headers: {
                "X-CSRF-TOKEN": csrfToken // Add CSRF token to request headers
            },
            data: function(d) {
                // Check if the date range input has a value
                var fromdate = $('#fromdate').val(); // Get the value of the date range input
                    if (fromdate) {
                        d.fromdate = fromdate;   // To date
                    }
                    var todate = $('#todate').val(); 
                    if (todate) {
                        d.todate = todate;   // To date
                    }
                    var paymentType = $('#paymentType').val(); 
                    if(paymentType){
                        d.payment=paymentType;
                    }
                // You can also add other data here as needed
            },
            type: "POST", // Ensure the correct HTTP method is used
            dataSrc: "data" // Server response should contain the "data" key for rows
        },
        columns: [   // Map to 'name' in the returned JSON
            { data: 'id',title:"Date" },       // Map to 'id' in the returned JSON
            // { data: 'id',title:"Payment" },     // Map to 'name' in the returned JSON
            { data: 'id',title:"account" },       // Map to 'id' in the returned JSON
            { data: 'id',title:"amount" }, 
            { data: 'id',title:"allotee" }, 
            { data: 'id',title:"expense" },
            { data: 'id',title:"Narration" },
            { data: 'id',title:"Receipt" },
            { data: 'id',title:"Actions" },    
        ],
        columnDefs: [
            
            
            {
                targets: 0,
                render: function (t, e, a, s) {
                    return (a.paydate
                    );
                },
                
            },
            // {
            //     targets: 1,
            //     render: function (t, e, a, s) {
            //         a = a.payment_type;
            //         if(a==1){
            //             return ('<span class="badge px-2 bg-label-success" text-capitalized="">credit</span>');
            //         }else{
            //             return ('<span class="badge px-2 bg-label-primary" text-capitalized="">Debit</span>');
            //         }
            //     },
            // },
            {
                targets: 1,
                render: function (t, e, a, s) {
                    return'<h6 class="mb-0 align-items-center d-flex w-px-100 ' +
                              a.bank +
                              '">' +a.bank+
                              a.account +
                              "</h6>";
                },
               
            },
            {
                targets: 2,
                responsivePriority: 1,
                render: function (t, e, a, s) {
                    return (
                        a.amount 
                    );
                }
            },
            {
                targets: 3,
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
                targets: 4,
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
                targets: 5,
                responsivePriority: 1,
                render: function (t, e, a, s) {
                    return (
                        a.narration 
                    );
                }
            },
            {
                targets: 6,
                responsivePriority: 1,
                render: function (t, e, a, s) {
                    return (
                        a.receipt_id 
                    );
                }
            },
            {
                targets: 7,
                responsivePriority: 1,
                render: function (t, e, a, s) {
                    return '<div class="d-flex justify-content-sm-start align-items-sm-center"><button class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button><div class="dropdown-menu dropdown-menu-end m-0"><a href="/payment-detail/'+a.id+'" class="dropdown-item">View</a><a href="/payment-edit/'+a.id+'" class="dropdown-item">Edit</a><a href="javascript:void(0);" onclick="deletePayment('+a.id+')"class="dropdown-item">Delete</a></div></div>';
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
                        action: function (e, dt, node, config) {
                            ledgerPrint(e, dt, node, config); // your custom function
                        },
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
                                                e.classList.contains("order-name")
                                                    ? (s += e.lastChild.firstChild.textContent)
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
                    }
                    

                ],
            }
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

        $('#paymentType').on('change', function () {
            t.ajax.reload(function (json) {
            });
        });
        $('#fromdate').on('change', function () {
            t.ajax.reload(function (json) {
            });
        });
        $('#todate').on('change', function () {
            t.ajax.reload(function (json) {
            });
        });
});


















function ledgerPrint() {
    var scheme = $('#paymentType').val();
    var fromdate_ = $('#fromdate').val(); 
    var todate_ = $('#todate').val(); 

    if(!scheme){
      return   alert("Please select a Scheme", "danger");
    }
    if(!fromdate_){
      return   alert("Please select a From date", "danger");
    }
    if(!todate_){
      return   alert("Please select a to date", "danger");
    }


    $.ajax({
        method: "POST",
        url: "/api/ledgerPrintReceivingReport",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        data: {
            startDate: fromdate_,
            endDate: todate_,
            scheme: scheme,
        },
        success: function(data) {
            if (data) {
               $("#result").html($.parseHTML(data));
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
}



  function ledgerPrintRes() 
    {
      var scheme = $('#paymentType').val();
      var fromdate_ = $('#fromdate').val(); 
      var todate_ = $('#todate').val(); 

      if(!scheme){
        return   alert("Please select a Scheme", "danger");
      }
      if(!fromdate_){
        return   alert("Please select a From date", "danger");
      }
      if(!todate_){
        return   alert("Please select a to date", "danger");
      }


      $.ajax({
          method: "POST",
          url: "/api/ledgerPrintReceivingReport",
          headers: {
              "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
          },
          data: {
              startDate: fromdate_,
              endDate: todate_,
              scheme: scheme,
          },
          success: function(data) {
            var printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(data);
            printWindow.document.close();

            // Wait for the new window to finish loading before printing
            printWindow.onload = function () {
                printWindow.focus();
                printWindow.print();
                // Optionally close after printing
                printWindow.close();
            };
        },
          error: function(xhr, status, error) {
              console.error("AJAX Error:", status, error);
          }
      });
    }
