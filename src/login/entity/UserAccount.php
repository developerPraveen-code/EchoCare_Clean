<?php

// USER STORY #11: User Admin Login
// USER STORY #25: Donee Login
// USER STORY #30: Fundraiser Login
// USER STORY #41: Platform Manager Login

class UserAccount
{
    public function verify(string $email, string $password, string $role): ?array
    {
        // Validate input
        if (empty($email) || empty($password) || empty($role)) {
            return null;
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        // TODO: Verify password against database hash
        // This is a placeholder - implement actual password verification
        // Example: if (!password_verify($password, $hashedPasswordFromDB)) { return null; }

        return [
            'id' => $this->getUserIdByRole($role),
            'email' => $email,
            'role' => $role,
            'name' => $this->getRoleName($role)
        ];
    }

    private function getUserIdByRole(string $role): int
    {
        return match ($role) {
            'user_admin' => 1,
            'donee' => 2,
            'fundraiser' => 3,
            'platform_manager' => 4,
            default => 0
        };
    }

    private function getRoleName(string $role): string
    {
        return match ($role) {
            'user_admin' => 'System Admin',
            'donee' => 'Donee User',
            'fundraiser' => 'Fundraiser User',
            'platform_manager' => 'Platform Manager',
            default => 'User'
        };
    }
}