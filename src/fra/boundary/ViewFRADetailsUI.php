require_once __DIR__ . '/../../login/entity/UserSession.php';

$userSession = new UserSession();
$userSession->requireLogin();

<?php

require_once __DIR__ . '/../controller/ViewFRADetailsController.php';

$controller = new ViewFRADetailsController();

$fraId = (int) ($_GET['fraId'] ?? 0);

$fra = $controller->getFRA($fraId);
?>

<!DOCTYPE html>
<html>
<head>
<title>View FRA Details</title>
<link rel="stylesheet" href="/css/style.css">
</head>

<body>

<div class="page-center">

<section class="dashboard-card">

<h1><?= htmlspecialchars($fra['title']) ?></h1>

<p><?= htmlspecialchars($fra['description']) ?></p>

<p><strong>Category:</strong> <?= $fra['category'] ?></p>

<p><strong>Status:</strong> <?= $fra['status'] ?></p>

<p><strong>Goal:</strong> $<?= $fra['goalAmount'] ?></p>

<p><strong>Raised:</strong> $<?= $fra['amountRaised'] ?></p>

<p><strong>Views:</strong> <?= $fra['views'] ?></p>

<?php
$backPage = ($_SESSION['user']['role'] === 'fundraiser')
    ? '/index.php?page=search_my_fra'
    : '/index.php?page=search_all_fra';
?>

<a href="<?= $backPage ?>" class="secondary-btn">
Back
</a>

</section>

</div>

</body>
</html>