<?php

// USER STORY: View Specific User Profile
// BCE Role: Boundary

require_once __DIR__ . '/../../login/entity/UserSession.php';
require_once __DIR__ . '/../controller/ViewUserProfileController.php';

$userSession = new UserSession();
$userSession->requireLogin();

if ($_SESSION['user']['role'] !== 'user_admin') {
    header('Location: /index.php?page=login');
    exit();
}

$controller = new ViewUserProfileController();

$profileId = (int) ($_GET['profileId'] ?? 0);

$profile = $controller->getProfile($profileId);

if (!$profile) {
    die('Profile not found.');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View User Profile</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div class="page-center">
<section class="dashboard-card">

<h1>User Profile Details</h1>

<p><strong>ID:</strong> <?= $profile['profileId'] ?></p>
<p><strong>Name:</strong> <?= htmlspecialchars($profile['fullName']) ?></p>
<p><strong>Phone:</strong> <?= htmlspecialchars($profile['phone']) ?></p>
<p><strong>Address:</strong> <?= htmlspecialchars($profile['address']) ?></p>
<p><strong>Role:</strong> <?= htmlspecialchars($profile['role']) ?></p>
<p><strong>Status:</strong> <?= htmlspecialchars($profile['status']) ?></p>

<a href="/index.php?page=update_user_profile&profileId=<?= $profile['profileId'] ?>"
   class="btn-primary"
   style="display:block;text-align:center;margin-top:20px;padding:14px;text-decoration:none;">
   Update Profile
</a>

<a href="/index.php?page=view_user_profiles" class="secondary-btn">
    Back
</a>

</section>
</div>

</body>
</html>