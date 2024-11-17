
const formButton = document.getElementById("add-btn");
    formButton.addEventListener("click", function () {
    confirmForm();
});

function confirmForm(event) {
    // Show loading dialog for 1 second before submitting the form
    Swal.fire({
        title: "Processing...",
        text: "Please wait",
        icon: "info",
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        willOpen: () => {
            Swal.showLoading(); // Show the loading spinner
        },
    });

    // Wait for 1 second before submitting the form
    setTimeout(function () {
        // Create a new FormData object from the form
        const formData = new FormData(document.getElementById("bankform"));

        fetch("/api/banks/store", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json(); // Assuming JSON response
        })
        .then(data => {
            Swal.close(); // Close the loading dialog
            
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000
                });

                // Redirect after success
                setTimeout(function() {
                    window.location.href = "/banks/list";
                }, 2000); 
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message,
                });
            }
        })
        .catch(error => {
            Swal.close(); // Close the loading dialog
            
            console.error("Error:", error);
            Swal.fire({
                icon: 'error',
                text: error,
            });
        });
    }, 1000); // Delay of 1 second (1000 milliseconds)
}





