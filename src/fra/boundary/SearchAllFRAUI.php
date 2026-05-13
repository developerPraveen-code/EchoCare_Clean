<?php
require_once __DIR__ . '/../../login/entity/UserSession.php';

$userSession = new UserSession();
$userSession->requireLogin();

if ($_SESSION['user']['role'] !== 'donee') {
    header('Location: /index.php?page=login');
    exit();
}
?>

<?php

require_once __DIR__ . '/../controller/SearchAllFRAController.php';

$controller = new SearchAllFRAController();

$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $results = $controller->searchAllFRA(
        $_POST['keyword']
    );
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Search All FRA</title>
<link rel="stylesheet" href="/css/style.css">
</head>

<body>

<div class="page-center">

<section class="dashboard-card">

<h1>Search All FRA</h1>

<form method="POST">

<div class="form-group">
<label>Keyword</label>
<input type="text" name="keyword">
</div>

<button class="btn-primary">
Search
</button>

</form>

<table class="table">

<?php foreach ($results as $fra): ?>

<tr>

<td><?= htmlspecialchars($fra['title']) ?></td>

<td>

<a class="action-link"
href="/index.php?page=view_fra_details&fraId=<?= $fra['fraId'] ?>">
View
</a>

|

<a class="action-link"
href="/index.php?page=save_favorite&fraId=<?= $fra['fraId'] ?>">
Save
</a>

</td>

</tr>

<?php endforeach; ?>

</table>

<a href="/index.php?page=donee_dashboard"
class="secondary-btn">
Back
</a>

</section>

</div>

</body>
</html>