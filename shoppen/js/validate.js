document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('register-form');

    if (registerForm) {
        registerForm.addEventListener('submit', function(event) {
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
                // If validation fails, return early and do not proceed with form submission
                console.log('Validation failed');
                event.preventDefault(); // Prevent the form from submitting
                return;
            } else {
                // Give visual feedback for successful validation
                const btn = document.getElementById('submit-btn');
                btn.innerText = 'Submitting...';
                btn.disabled = true; // Disable the button to prevent multiple submissions

                // Since event listener is on the form's submit event and is synchronous,
                // we don't need to call submit() here. The form will submit naturally after this function completes if no errors are found.
            }
        });
    }

    const loginForm = document.getElementById('login-form');

    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            let isValid = true;

            // Ensure the email is in a valid format
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                isValid = false;
            }

            // Ensure password is not empty
            if (password.trim() === '') {
                alert("Password cannot be empty.");
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault(); 
            } else {
                document.getElementById('login-btn').innerText = 'Logging in...';
                document.getElementById('login-btn').disabled = true;
            }
        });
    }
});