<?php

// USER STORY #44: Generate Daily Report
// BCE Role: Entity
// Generates daily fundraising and donation report.

class DailyReport
{
    public function generateDailyReport(string $selectedDate): array
    {
        $fraList = $_SESSION['fra_list'] ?? [];
        $donationList = $_SESSION['donation_list'] ?? [];

        $totalFundsRaised = 0;
        $totalDonations = 0;
        $totalTransactions = 0;
        $completedFRA = 0;

        foreach ($donationList as $donation) {
            $donationDate = $donation['donationDate'] ?? '';

            if ($donationDate === $selectedDate) {
                $totalFundsRaised += $donation['amount'] ?? 0;
                $totalDonations++;
                $totalTransactions++;
            }
        }

        foreach ($fraList as $fra) {
            if (($fra['status'] ?? '') === 'Completed') {
                $completedFRA++;
            }
        }

        return [
            'selectedDate' => $selectedDate,
            'totalFundsRaised' => $totalFundsRaised,
            'totalDonations' => $totalDonations,
            'totalTransactions' => $totalTransactions,
            'completedFRA' => $completedFRA
        ];
    }
}