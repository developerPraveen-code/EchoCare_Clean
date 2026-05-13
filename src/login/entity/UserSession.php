<?php

// USER STORY #12: User Admin Logout
// USER STORY #26: Donee Logout
// USER STORY #31: Fundraiser Logout
// USER STORY #43: Platform Manager Logout
// Entity: UserSession manages logged-in user session data.

class UserSession
{
    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }

    public function requireLogin(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /index.php?page=login');
            exit();
        }
    }
}