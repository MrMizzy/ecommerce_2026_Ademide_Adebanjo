<?php
require_once '../core/core.php';
require_once 'layout/header.php'; 
?>

<main class="login-container">
    <h2>Login</h2>

    <?php if (get_flash('error')): ?>
        <div class="error-alert"style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 15px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form id="login-form" action="../actions/login_action.php" method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" id="login-btn">Login</button>
    </form>

    <div class="register-link" style="margin-top: 20px;">
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</main>

<?php require_once 'layout/footer.php'; ?>