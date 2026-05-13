<?php

// USER STORY: Create/View/Update User Profile
// BCE Role: Entity

class UserProfile
{
    public function initialiseData(): void
    {
        if (!isset($_SESSION['user_profiles'])) {
            $_SESSION['user_profiles'] = [
                [
                    'profileId' => 1,
                    'userId' => 1,
                    'fullName' => 'System Admin',
                    'phone' => '90000001',
                    'address' => 'Singapore',
                    'role' => 'user_admin',
                    'status' => 'Active'
                ],
                [
                    'profileId' => 2,
                    'userId' => 2,
                    'fullName' => 'Donee User',
                    'phone' => '90000002',
                    'address' => 'Singapore',
                    'role' => 'donee',
                    'status' => 'Active'
                ]
            ];
        }
    }

    // USER STORY: Create User Profile
    public function createProfile(string $fullName, string $phone, string $address, string $role): string
    {
        $this->initialiseData();

        $newId = count($_SESSION['user_profiles']) + 1;

        $_SESSION['user_profiles'][] = [
            'profileId' => $newId,
            'userId' => $newId,
            'fullName' => $fullName,
            'phone' => $phone,
            'address' => $address,
            'role' => $role,
            'status' => 'Active'
        ];

        return 'User profile created successfully.';
    }

    // USER STORY: View User Profiles
    public function getAllProfiles(): array
    {
        $this->initialiseData();
        return $_SESSION['user_profiles'];
    }

    // USER STORY: View Specific User Profile
    public function getProfile(int $profileId): ?array
    {
        $this->initialiseData();

        foreach ($_SESSION['user_profiles'] as $profile) {
            if ($profile['profileId'] === $profileId) {
                return $profile;
            }
        }

        return null;
    }

    // USER STORY: Update User Profile
    public function updateProfile(int $profileId, string $fullName, string $phone, string $address, string $role): string
    {
        $this->initialiseData();

        foreach ($_SESSION['user_profiles'] as &$profile) {
            if ($profile['profileId'] === $profileId) {
                $profile['fullName'] = $fullName;
                $profile['phone'] = $phone;
                $profile['address'] = $address;
                $profile['role'] = $role;

                return 'User profile updated successfully.';
            }
        }

        return 'User profile not found.';
    }
}