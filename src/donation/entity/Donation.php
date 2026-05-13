<?php

// USER STORY #34: Search Donation History
// USER STORY #35: View Donation History
// BCE Role: Entity
// Stores and retrieves donee donation history records.

class Donation
{
    public function initialiseData(): void
    {
        if (!isset($_SESSION['donation_list'])) {
            $_SESSION['donation_list'] = [
                [
                    'donationId' => 1,
                    'doneeId' => 2,
                    'fraTitle' => 'School Supplies Donation Drive',
                    'category' => 'Education',
                    'amount' => 50.00,
                    'donationDate' => '2026-05-01',
                    'status' => 'Completed'
                ],
                [
                    'donationId' => 2,
                    'doneeId' => 2,
                    'fraTitle' => 'Community Meal Support',
                    'category' => 'Food Support',
                    'amount' => 30.00,
                    'donationDate' => '2026-05-05',
                    'status' => 'Completed'
                ]
            ];
        }
    }

    // USER STORY #35: View Donation History
    public function getDonationHistory(int $doneeId): array
    {
        $this->initialiseData();

        return array_values(array_filter($_SESSION['donation_list'], function ($donation) use ($doneeId) {
            return $donation['doneeId'] === $doneeId;
        }));
    }

    // USER STORY #34: Search Donation History
    public function searchDonationHistory(int $doneeId, string $keyword): array
    {
        $history = $this->getDonationHistory($doneeId);

        return array_values(array_filter($history, function ($donation) use ($keyword) {
            return $keyword === '' ||
                stripos($donation['fraTitle'], $keyword) !== false ||
                stripos($donation['category'], $keyword) !== false ||
                stripos($donation['status'], $keyword) !== false ||
                stripos($donation['donationDate'], $keyword) !== false;
        }));
    }
}