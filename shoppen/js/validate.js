document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('register-form');

    if (registerForm) {
        registerForm.getElementById('submit-btn').addEventListener('click', function(event) {
            // Clear all error messages before validation
            document.querySelectorAll('.error-message').forEach(msg => msg.style.display = 'none');

            // Take input values
            const customer_name = document.getElementById('customer_name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('confirm-password').value.trim();
            const contact = document.getElementById('contact').value.trim();

            // Define regex patterns
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email validation pattern
            const phoneRegex = /^[0-9+\-\s]{7,15}$/; // Basic phone number validation pattern (7-15 digits, can include +, -, and spaces)
            const passRegex = /^(?=.*\d).{8,}$/; // Password must be at least 8 characters long and contain at least one number

            let isValid = true;

            // Validate inputs
            if(!customer_name || !email || !password || !confirmPassword || !contact) {
                // Show an error message for missing fields
                document.getElementById('missing-fields-error').style.display = 'block';
                isValid = false;
                return; // Exit early if any field is empty
            }

            if (cusomer_name.length < 2) {
                document.getElementById('name_error').style.display = 'block';
                isValid = false;
            }

            if (!emailRegex.test(email)) {
                document.getElementById('email_error').style.display = 'block';
                isValid = false;
            }

            if (!passRegex.test(password)) {
                document.getElementById('password_error').style.display = 'block';
                isValid = false;
            }

            if (password !== confirmPassword) {
                document.getElementById('confirm_password_error').style.display = 'block';
                isValid = false;
            }

            if (!phoneRegex.test(contact)) {
                document.getElementById('contact_error').style.display = 'block';
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); // Prevent form submission if validation fails
            } else {
                // Give visual feedback for successful validation
                const btn = document.getElementById('submit-btn');
                btn.textContent = 'Submitting...';
                btn.disabled = true; // Disable the button to prevent multiple submissions

                // Send the form data to action for processing
                var formData = new FormData(registerForm);

                fetch('../actions/register_action.php', {
                    method: 'POST',
                    body: formData
                })
                // Parse the response as JSON
                .then(response => response.json())
                .then(function(data) {
                    console.log(data.message); // Log the response for debugging

                    if (data.success) {
                        // Redirect to the login page on successful registration
                        window.location.href = '../login.php';
                    }
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                    });
            }
        });
    }
});