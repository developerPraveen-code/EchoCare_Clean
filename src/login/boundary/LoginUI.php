<?php

// USER STORY #11: User Admin Login
// USER STORY #25: Donee Login
// USER STORY #30: Fundraiser Login
// USER STORY #41: Platform Manager Login
// Boundary: LoginUI displays the login form and sends user input to LoginController.

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$error = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);

$selectedRole = $_POST['role'] ?? '';
$emailValue = $_POST['email'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EchoCare Login</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>

<div class="page-center">

    <section class="login-card">

        <div class="logo-pill">
            <img
                src="/images/echocare-logo.png"
                alt="EchoCare Logo"
                class="login-logo-full"
            >
        </div>

        <h1>Sign in</h1>

        <p class="subtitle">
            Welcome to EchoCare's Fund Raising Website. Choose your account type to continue.
        </p>

        <?php if ($error): ?>
            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/index.php?page=login_process">

            <div class="form-group">
                <label for="role">I am logging in as</label>
                <select id="role" name="role" required>
                    <option value="" disabled <?= $selectedRole === '' ? 'selected' : '' ?>>
                        Select account type...
                    </option>

                    <option value="user_admin" <?= $selectedRole === 'user_admin' ? 'selected' : '' ?>>
                        User Admin
                    </option>

                    <option value="donee" <?= $selectedRole === 'donee' ? 'selected' : '' ?>>
                        Donee
                    </option>

                    <option value="fundraiser" <?= $selectedRole === 'fundraiser' ? 'selected' : '' ?>>
                        Fundraiser
                    </option>

                    <option value="platform_manager" <?= $selectedRole === 'platform_manager' ? 'selected' : '' ?>>
                        Platform Manager
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    placeholder="you@company.com"
                    value="<?= htmlspecialchars($emailValue) ?>"
                    required
                >
            </div>

            <div class="form-group">
                <div class="form-row">
                    <label for="password">Password</label>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>

                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required
                >
            </div>

            <label class="checkbox-row">
                <input type="checkbox" name="remember">
                Remember me for 30 days
            </label>

            <button type="submit" class="btn-primary">
                Log In
            </button>

            <div class="divider-text">
                or continue with
            </div>

            <div class="bottom-text">
                Don’t have an account?
                <a href="#" class="small-link">Request access</a>
            </div>

        </form>

    </section>

</div>

</body>
</html>