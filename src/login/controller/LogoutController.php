<?php

// USER STORY #12: User Admin Logout
// USER STORY #26: Donee Logout
// USER STORY #31: Fundraiser Logout
// USER STORY #43: Platform Manager Logout
// Controller: LogoutController handles the logout request and asks UserSession to destroy the session.

require_once __DIR__ . '/../boundary/UserSession.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$userSession = new UserSession();
$userSession->logout();

header('Location: /index.php?page=login');
exit();