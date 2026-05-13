<?php

// USER STORY #45: Generate Weekly Report
// BCE Role: Entity
// Generates weekly fundraising performance report.

class WeeklyReport
{
    public function generateWeeklyReport(string $startDate, string $endDate): array
    {
        $fraList = $_SESSION['fra_list'] ?? [];
        $donationList = $_SESSION['donation_list'] ?? [];

        $totalFundsRaised = 0;
        $totalDonations = 0;
        $totalTransactions = 0;
        $completedFRA = 0;

        foreach ($donationList as $donation) {
            $donationDate = $donation['donationDate'] ?? '';

            if ($donationDate >= $startDate && $donationDate <= $endDate) {
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
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalFundsRaised' => $totalFundsRaised,
            'totalDonations' => $totalDonations,
            'totalTransactions' => $totalTransactions,
            'completedFRA' => $completedFRA
        ];
    }
}