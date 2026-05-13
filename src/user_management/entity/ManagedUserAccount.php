<?php

// USER STORY #6: Create User Account
// USER STORY #7: View User Accounts
// USER STORY #8: Update User Account
// USER STORY #9: Suspend User Account
// BCE Role: Entity

class ManagedUserAccount
{
    public function initialiseData(): void
    {
        if (!isset($_SESSION['managed_user_accounts'])) {
            $_SESSION['managed_user_accounts'] = [
                [
                    'userId' => 1,
                    'username' => 'System Admin',
                    'email' => 'admin@echocare.com',
                    'role' => 'user_admin',
                    'permission' => 'Full Access',
                    'status' => 'Active'
                ],
                [
                    'userId' => 2,
                    'username' => 'Donee User',
                    'email' => 'donee@echocare.com',
                    'role' => 'donee',
                    'permission' => 'Donation Access',
                    'status' => 'Active'
                ],
                [
                    'userId' => 3,
                    'username' => 'Fundraiser User',
                    'email' => 'fundraiser@echocare.com',
                    'role' => 'fundraiser',
                    'permission' => 'Campaign Access',
                    'status' => 'Active'
                ],
                [
                    'userId' => 4,
                    'username' => 'Platform Manager',
                    'email' => 'pm@echocare.com',
                    'role' => 'platform_manager',
                    'permission' => 'Platform Access',
                    'status' => 'Active'
                ]
            ];
        }
    }

    // USER STORY #6: Create User Account
    public function createAccount(string $username, string $email, string $role): string
    {
        $this->initialiseData();

        $newId = count($_SESSION['managed_user_accounts']) + 1;

        $_SESSION['managed_user_accounts'][] = [
            'userId' => $newId,
            'username' => $username,
            'email' => $email,
            'role' => $role,
            'permission' => $this->defaultPermission($role),
            'status' => 'Active'
        ];

        return 'User account created successfully.';
    }

    // USER STORY #7: View User Accounts
    public function getAllAccounts(): array
    {
        $this->initialiseData();
        return $_SESSION['managed_user_accounts'];
    }

    // USER STORY #8: Update User Account
    public function getAccount(int $userId): ?array
    {
        $this->initialiseData();

        foreach ($_SESSION['managed_user_accounts'] as $account) {
            if ($account['userId'] === $userId) {
                return $account;
            }
        }

        return null;
    }

    // USER STORY #8: Update User Account
    public function updateUserAccount(int $userId, string $permission): string
    {
        $this->initialiseData();

        foreach ($_SESSION['managed_user_accounts'] as &$account) {
            if ($account['userId'] === $userId) {
                $account['permission'] = $permission;
                return 'User account updated successfully.';
            }
        }

        return 'Update failed. User account not found.';
    }

    // USER STORY #9: Suspend User Account
    public function suspendAccount(int $userId): string
    {
        $this->initialiseData();

        foreach ($_SESSION['managed_user_accounts'] as &$account) {
            if ($account['userId'] === $userId) {
                $account['status'] = 'Suspended';
                return 'User account suspended successfully.';
            }
        }

        return 'User account not found.';
    }

    private function defaultPermission(string $role): string
    {
        return match ($role) {
            'user_admin' => 'Full Access',
            'donee' => 'Donation Access',
            'fundraiser' => 'Campaign Access',
            'platform_manager' => 'Platform Access',
            default => 'Basic Access'
        };
    }
}