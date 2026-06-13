<?php
class Auth {
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login($email, $password, $requiredRole) {
        self::init();
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT * FROM registration WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user) {
                $passwordMatch = false;
                // Secure check: verify BCRYPT, and fallback to plain-text for legacy dump compatibility
                if (password_verify($password, $user['password'])) {
                    $passwordMatch = true;
                } elseif ($password === $user['password']) {
                    $passwordMatch = true;
                }

                if ($passwordMatch) {
                    if ($user['usertype'] === $requiredRole) {
                        $_SESSION['u_type'] = $requiredRole;
                        $_SESSION['u_name'] = $user['name'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['user_id'] = $user['id'];
                        return true;
                    } else {
                        return "Incorrect user role. Selected: " . htmlspecialchars($requiredRole) . ", Registered: " . htmlspecialchars($user['usertype']);
                    }
                }
            }
            return "Invalid email or password.";
        } catch (Exception $e) {
            return "Database Error: " . $e->getMessage();
        }
    }

    public static function logout() {
        self::init();
        $_SESSION = [];
        session_destroy();
    }

    public static function checkSession() {
        self::init();
        if (!isset($_SESSION['u_type']) || !isset($_SESSION['u_name'])) {
            header("Location: index.php");
            exit();
        }
    }

    public static function getRole() {
        self::init();
        return $_SESSION['u_type'] ?? null;
    }

    public static function getName() {
        self::init();
        return $_SESSION['u_name'] ?? null;
    }

    public static function getEmail() {
        self::init();
        return $_SESSION['email'] ?? null;
    }
}
