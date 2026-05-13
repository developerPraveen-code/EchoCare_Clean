<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Validate page parameter - only allow whitelisted pages
$allowedPages = [
    'login', 'login_process', 'logout',
    'admin_dashboard', 'donee_dashboard', 'fundraiser_dashboard', 'platform_manager_dashboard',
    'create_fra', 'view_my_fra', 'edit_fra', 'disable_fra', 'search_my_fra', 'search_all_fra',
    'view_fra_details', 'save_favorite', 'view_saved_fra', 'search_favorite_fra',
    'view_posted_views', 'view_shortlist_count', 'search_completed_history', 'view_completed_history',
    'search_donation_history', 'view_donation_history',
    'view_category', 'create_fra_category', 'search_category', 'suspend_category', 'update_category',
    'create_user_profile', 'view_user_profiles', 'view_user_profile', 'update_user_profile',
    'daily_report', 'weekly_report', 'monthly_report'
];

$page = isset($_GET['page']) && in_array($_GET['page'], $allowedPages, true) ? $_GET['page'] : 'login';

switch ($page) {

    // Sprint 1 - Login / Logout
    case 'login': require_once '../src/login/boundary/LoginUI.php'; break;
    case 'login_process': require_once '../src/login/controller/LoginController.php'; break;
    case 'logout': require_once '../src/login/boundary/LogoutUI.php'; break;

    // Dashboards
    case 'admin_dashboard': require_once '../src/admin/boundary/AdminDashboard.php'; break;
    case 'donee_dashboard': require_once '../src/donee/boundary/DoneeDashboard.php'; break;
    case 'fundraiser_dashboard': require_once '../src/fundraiser/boundary/FundraiserDashboard.php'; break;
    case 'platform_manager_dashboard': require_once '../src/platform_manager/boundary/PlatformManagerDashboard.php'; break;

    // Sprint 2 - FRA / Favourite
    case 'create_fra': require_once '../src/fra/boundary/CreateFRAUI.php'; break;
    case 'view_my_fra': require_once '../src/fra/boundary/ViewFRAUI.php'; break;
    case 'edit_fra': require_once '../src/fra/boundary/EditFRAUI.php'; break;
    case 'disable_fra': require_once '../src/fra/boundary/DisableFRAUI.php'; break;
    case 'search_my_fra': require_once '../src/fra/boundary/SearchFRAUI.php'; break;
    case 'search_all_fra': require_once '../src/fra/boundary/SearchAllFRAUI.php'; break;
    case 'view_fra_details': require_once '../src/fra/boundary/ViewFRADetailsUI.php'; break;
    case 'save_favorite': require_once '../src/fra/boundary/FavoriteUI.php'; break;
    case 'view_saved_fra': require_once '../src/fra/boundary/ViewSavedFRAUI.php'; break;

    // Sprint 3 - FRA history / donation / category
    case 'search_favorite_fra': require_once '../src/fra/boundary/SearchFavouriteListUI.php'; break;
    case 'view_posted_views': require_once '../src/fra/boundary/ViewPostedViewsUI.php'; break;
    case 'view_shortlist_count': require_once '../src/fra/boundary/ViewShortlistUI.php'; break;
    case 'search_completed_history': require_once '../src/fra/boundary/SearchHistoryUI.php'; break;
    case 'view_completed_history': require_once '../src/fra/boundary/ViewHistoryUI.php'; break;

    case 'search_donation_history': require_once '../src/donation/boundary/SearchDonationHistoryUI.php'; break;
    case 'view_donation_history': require_once '../src/donation/boundary/ViewDonationHistoryUI.php'; break;

    case 'view_category': require_once '../src/category/boundary/ViewCategoryUI.php'; break;
    case 'create_fra_category': require_once '../src/category/boundary/CreateFRACategoryUI.php'; break;

    // Sprint 4 - User management / Monthly report
    case 'create_user_profile': require_once '../src/user_management/boundary/CreateUserProfileUI.php'; break;
    case 'view_user_profiles': require_once '../src/user_management/boundary/ViewUserProfilesUI.php'; break;
    case 'view_user_profile': require_once '../src/user_management/boundary/ViewUserProfileUI.php'; break;
    case 'update_user_profile': require_once '../src/user_management/boundary/UpdateUserProfileUI.php'; break;

    case 'create_user_account': require_once '../src/user_management/boundary/CreateUserAccountUI.php'; break;
    case 'view_user_accounts': require_once '../src/user_management/boundary/ViewUserAccountsUI.php'; break;
    case 'suspend_user_account': require_once '../src/user_management/boundary/SuspendUserAccountUI.php'; break;

    case 'monthly_report': require_once '../src/report/boundary/MonthlyReportUI.php'; break;

    // Sprint 5 - Update account / category management / daily weekly reports
    case 'update_user_account': require_once '../src/user_management/boundary/UpdateUserAccountUI.php'; break;

    case 'update_fra_category': require_once '../src/category/boundary/UpdateFRACategoryUI.php'; break;
    case 'search_category': require_once '../src/category/boundary/SearchCategoryUI.php'; break;
    case 'suspend_fra_category': require_once '../src/category/boundary/SuspendFRACategoryUI.php'; break;

    case 'daily_report': require_once '../src/report/boundary/DailyReportUI.php'; break;
    case 'weekly_report': require_once '../src/report/boundary/WeeklyReportUI.php'; break;

    default:
        echo "<h1>404 Page Not Found</h1>";
        break;
}