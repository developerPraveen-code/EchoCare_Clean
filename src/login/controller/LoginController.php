<?php

// USER STORY #11: User Admin Login
// USER STORY #25: Donee Login
// USER STORY #30: Fundraiser Login
// USER STORY #41: Platform Manager Login
// Controller: LoginController validates login input and asks UserAccount entity to verify account details.

require_once __DIR__ . '/../entity/UserAccount.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

$userAccount = new UserAccount();

if ($email === '' || $password === '' || $role === '') {
    $_SESSION['login_error'] = 'Please fill in all login fields.';
    header('Location: /index.php?page=login');
    exit();
}

$user = $userAccount->verify($email, $password, $role);

if ($user === null) {
    $_SESSION['login_error'] = 'Invalid email, password, or role selected.';
    header('Location: /index.php?page=login');
    exit();
}

$_SESSION['user'] = $user;

switch ($user['role']) {
    case 'user_admin':
        header('Location: /index.php?page=admin_dashboard');
        break;

    case 'donee':
        header('Location: /index.php?page=donee_dashboard');
        break;

    case 'fundraiser':
        header('Location: /index.php?page=fundraiser_dashboard');
        break;

    case 'platform_manager':
        header('Location: /index.php?page=platform_manager_dashboard');
        break;

    default:
        $_SESSION['login_error'] = 'Unknown user role.';
        header('Location: /index.php?page=login');
        break;
}

exit();