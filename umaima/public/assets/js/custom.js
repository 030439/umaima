function deleteFunction(url, id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        customClass: {
            confirmButton: "btn btn-primary me-3 waves-effect waves-light",
            cancelButton: "btn btn-label-secondary waves-effect waves-light",
        },
        buttonsStyling: false,
    }).then(function (result) {
        if (result.isConfirmed) {
            // Show loading dialog
            Swal.fire({
                title: "Processing...",
                text: "Please wait",
                icon: "info",
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                willOpen: () => {
                    Swal.showLoading();
                },
            });

            // Wait for 0.5 seconds before sending the AJAX request
            setTimeout(function () {
                $.ajax({
                    url: url,
                    method: "POST",
                    data: {
                        id: id,
                        // Include CSRF token if required
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            customClass: {
                                confirmButton: "btn btn-success waves-effect waves-light",
                            },
                        }).then(() => {
                            Swal.close();
                            // Refresh the DataTable
                            $(".datatables-users").DataTable().ajax.reload(null, false); // `false` to retain pagination
                           
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "Something went wrong. Please try again.",
                            customClass: {
                                confirmButton: "btn btn-danger waves-effect waves-light",
                            },
                        });
                    }
                });
            }, 500); // Delay of 0.5 seconds (500 milliseconds)
        }
    });
}
