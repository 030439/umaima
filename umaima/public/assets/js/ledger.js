"use strict";
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

function callAjax(){
        var dateRange = $('#flatpickr-range').val(); // Get the value of the date range input
        if (dateRange) {
            // Split the date range into start and end dates
            var dates = dateRange.split(' to ');
            startDate = dates[0]; // From date
            endDate = dates[1];   // To date
        }
        var paymentType = $('#paymentType').val(); 
        if(paymentType){
            payment=paymentType;
        }
        var subcat = $('#subcat').val(); 
        if(subcat){
            d.subcat=subcat;
        }

        $.ajax({
            method: "POST",
            url: "/api/getLedger",
            data:{
                startDate: startDate,
                endDate: endDate,
                payment: payment,
                subcat: subcat
            },
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: d,
            success: function(data) {
                if (data.success) {
                    // Handle success
                    var table = $('#ledgerTable').DataTable();
                    table.clear().draw();
                    table.rows.add(data.ledger).draw();
                } else {
                    // Handle error
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


$('#paymentType').on('change', function () {
    $("#subcat").val('');
    var paymentType = $('#paymentType').val(); 
    paymentType==1?fetchAlloties():fetchExpenseHeads();
});

$('#subcat').on('change', function () {
    callAjax();
});

// $('#subcat').on('change', function () {
//     t.ajax.reload(function (json) {
//     });
// });
