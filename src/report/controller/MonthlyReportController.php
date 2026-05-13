<?php

// USER STORY: Generate/View Monthly Report
// BCE Role: Controller

require_once __DIR__ . '/../entity/MonthlyReport.php';

class MonthlyReportController
{
    private MonthlyReport $monthlyReport;

    public function __construct()
    {
        $this->monthlyReport = new MonthlyReport();
    }

    public function generateReport(): array
    {
        return $this->monthlyReport->generateReport();
    }
}