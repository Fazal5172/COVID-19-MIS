<?php
require_once __DIR__ . '/includes/autoloader.php';
Auth::checkSession();

$role = Auth::getRole();
$allowedRoles = ['Hospital Head', 'City Head', 'Country Head', 'Admin'];
if (!in_array($role, $allowedRoles)) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'] ?? null;
if ($id) {
    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT usertype FROM registration WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $targetUser = $stmt->fetch();
        
        if ($targetUser) {
            $managedRoles = User::getManagedRoles($role);
            if (in_array($targetUser['usertype'], $managedRoles)) {
                User::delete($id);
                $_SESSION['flash_success'] = "User account removed successfully.";
            } else {
                $_SESSION['flash_error'] = "Authorization Error: You do not have permission to delete this user role.";
            }
        }
    } catch (Exception $e) {
        $_SESSION['flash_error'] = "Database Error: " . $e->getMessage();
    }
}
header("Location: web.php");
exit();
