require_once __DIR__ . '/../../login/entity/UserSession.php';

$userSession = new UserSession();
$userSession->requireLogin();

<?php

require_once __DIR__ . '/../controller/FavoriteController.php';

$controller = new FavoriteController();

$fraId = (int) ($_GET['fraId'] ?? 0);

$controller->saveFavorite(
    $_SESSION['user']['id'],
    $fraId
);

header('Location: /index.php?page=view_saved_fra');
exit();