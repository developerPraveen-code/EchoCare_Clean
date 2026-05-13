<?php

// USER STORY: Generate/View Monthly Report
// BCE Role: Boundary

require_once __DIR__ . '/../../login/entity/UserSession.php';
require_once __DIR__ . '/../controller/MonthlyReportController.php';

$userSession = new UserSession();
$userSession->requireLogin();

if ($_SESSION['user']['role'] !== 'platform_manager') {
    header('Location: /index.php?page=login');
    exit();
}

$controller = new MonthlyReportController();
$report = $controller->generateReport();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Monthly Report</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div class="page-center">
<section class="dashboard-card">

<h1>Monthly Report</h1>

<table class="table">
<tr>
    <th>Month</th>
    <td><?= htmlspecialchars($report['month']) ?></td>
</tr>
<tr>
    <th>Year</th>
    <td><?= htmlspecialchars($report['year']) ?></td>
</tr>
<tr>
    <th>Total Funds Raised</th>
    <td>$<?= number_format($report['totalFundsRaised'], 2) ?></td>
</tr>
<tr>
    <th>Total Donations</th>
    <td><?= $report['totalDonations'] ?></td>
</tr>
<tr>
    <th>Completed FRA</th>
    <td><?= $report['completedFRA'] ?></td>
</tr>
<tr>
    <th>Average Donation</th>
    <td>$<?= number_format($report['averageDonation'], 2) ?></td>
</tr>
</table>

<a href="/index.php?page=platform_manager_dashboard" class="secondary-btn">Back</a>

</section>
</div>

</body>
</html>