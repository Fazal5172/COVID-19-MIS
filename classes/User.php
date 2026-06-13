<?php
class User {
    public static function findByEmail($email) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM registration WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public static function create($name, $email, $password, $userType) {
        $db = Database::getConnection();
        
        // Securely hash passwords for high standards of safety
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $db->prepare("INSERT INTO registration (name, email, password, usertype) VALUES (:name, :email, :password, :usertype)");
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'usertype' => $userType
        ]);
    }

    public static function delete($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM registration WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public static function getByRoles($roles) {
        $db = Database::getConnection();
        if (empty($roles)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($roles), '?'));
        $stmt = $db->prepare("SELECT * FROM registration WHERE usertype IN ($placeholders) ORDER BY id DESC");
        $stmt->execute($roles);
        return $stmt->fetchAll();
    }

    public static function getManagedRoles($currentRole) {
        $hierarchy = [
            'Hospital Head' => ['Receptionist', 'Lab Technician', 'Doctor'],
            'City Head' => ['Receptionist', 'Lab Technician', 'Doctor', 'Hospital Head'],
            'Country Head' => ['Receptionist', 'Lab Technician', 'Doctor', 'Hospital Head', 'City Head'],
            'Admin' => ['Receptionist', 'Lab Technician', 'Doctor', 'Hospital Head', 'City Head', 'Country Head']
        ];
        return $hierarchy[$currentRole] ?? [];
    }
}
