document.addEventListener('DOMContentLoaded', function() {
    var loginForm = document.getElementById('login-form');

    // Attach a submit event listener to the form
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var userId = document.getElementById('userid').value;
        var password = document.getElementById('password').value;

        // Perform input validation if necessary
        if (userId === '' || password === '') {
            alert('Please enter both user ID and password.');
            return false;
        }

        // Construct FormData object from form
        var formData = new FormData(loginForm);

        // Perform the AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'login.php', true);

        // Set up what happens when the request is successful
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Process the response
                var response = JSON.parse(xhr.responseText);

                // Check if the login was successful
                if (response.success) {
                    // Redirect to the appropriate page based on the role
                    window.location.href = response.redirectUrl;
                } else {
                    // Show error message
                    alert(response.message);
                }
            } else {
                // Something went wrong with the request
                alert('There was an error. Please try again later.');
            }
        };

        // Send the FormData
        xhr.send(formData);
    });
});
