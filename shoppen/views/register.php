<?php
require_once "../core/core.php";
require_once "layout/header.php";
?>

<main class="register-container">
    <h2>Create an Account</h2>

    <!-- Display error messages -->
    <?php if ($error = get_flash('error')): ?>
        <div class="error-message" style="color: red; padding: 10px; border: 1px solid red;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <!-- Registration form -->
    <form id="register-form" action="../actions/register_action.php" method="POST">
        <div class="form-group">
            <label for="customer_name">Full Name:</label>
            <input type="text" id="customer_name" name="customer_name" required>
            <span class="error-msg" id="name-error" style="color: red; display: none;">Name must be atleast 2 characters long.</span>
        </div>

        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>
            <span class="error-msg" id="email-error" style="color: red; display: none;">Please enter a valid email address.</span>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <span class="error-msg" id="password-error" style="color: red; display: none;">Password must be at least 8 characters and include uppercase, lowercase, number, and special character.</span>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <span class="error-msg" id="confirm-password-error" style="color: red; display: none;">Passwords do not match.</span>
        </div>

        <div class="form-group">
            <label for="country">Country:</label>
            <select name="country" id="country">
                <option value="">Select a country</option>
                <option value="Ghana">Ghana</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Kenya">Kenya</option>
                <option value="South Africa">South Africa</option>
            </select>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>
        </div>

        <div class="form-group">
            <label for="contact">Contact Number:</label>
            <input type="text" id="contact" name="contact" required>
            <span class="error-msg" id="contact-error" style="color: red; display: none;">Please enter a valid contact number.</span>
        </div>

        <button type="submit" id="submit-btn">Register</button>
        <span class="error-msg" id="missing-fields-error" style="color: red; display: none;">Please fill in all required fields.</span>
    </form>
</main>

<?php require_once ('layout/footer.php'); ?>