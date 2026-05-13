<?php

// USER STORY: Generate/View Monthly Report
// BCE Role: Entity

class MonthlyReport
{
    public function generateReport(): array
    {
        $fraList = $_SESSION['fra_list'] ?? [];
        $donationList = $_SESSION['donation_list'] ?? [];

        $totalFundsRaised = 0;
        $completedFRA = 0;

        foreach ($fraList as $fra) {
            $totalFundsRaised += $fra['amountRaised'] ?? 0;

            if (($fra['status'] ?? '') === 'Completed') {
                $completedFRA++;
            }
        }

        $totalDonations = count($donationList);
        $averageDonation = 0;

        if ($totalDonations > 0) {
            $sum = 0;

            foreach ($donationList as $donation) {
                $sum += $donation['amount'] ?? 0;
            }

            $averageDonation = $sum / $totalDonations;
        }

        return [
            'month' => date('F'),
            'year' => date('Y'),
            'totalFundsRaised' => $totalFundsRaised,
            'totalDonations' => $totalDonations,
            'completedFRA' => $completedFRA,
            'averageDonation' => $averageDonation
        ];
    }
}