<?php
class Patient {
    // Receptionist activities
    public static function createReceptionistActivity($name, $email, $age, $address, $mobile, $date) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO receptionist_activity (patient_name, patientemail, patientage, patient_address, patient_mobileno, patient_visitingdate) VALUES (:name, :email, :age, :address, :mobile, :date)");
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'age' => $age,
            'address' => $address,
            'mobile' => $mobile,
            'date' => $date
        ]);
    }

    public static function getReceptionistActivities() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM receptionist_activity ORDER BY Id DESC");
        return $stmt->fetchAll();
    }

    // Lab Technician activities
    public static function createLabActivity($name, $email, $age, $status, $covidType, $date) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO labtechnician_activity (p_name, p_email, p_age, test_status, covid_type, test_date) VALUES (:name, :email, :age, :status, :covidType, :date)");
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'age' => $age,
            'status' => $status,
            'covidType' => $covidType,
            'date' => $date
        ]);
    }

    public static function getLabActivities() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM labtechnician_activity ORDER BY ID DESC");
        return $stmt->fetchAll();
    }

    // Doctor activities
    public static function createDoctorActivity($name, $email, $age, $status, $covidType, $admissionDate, $vaccineName, $vaccineDose, $vaccinationDate, $dischargeDate) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO doctor_activity (name, email, age, test_status, covid_type, admission_date, vaccine_name, vaccine_dose, vaccination_date, discharge_date) VALUES (:name, :email, :age, :status, :covidType, :admissionDate, :vaccineName, :vaccineDose, :vaccinationDate, :dischargeDate)");
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'age' => $age,
            'status' => $status,
            'covidType' => $covidType,
            'admissionDate' => $admissionDate,
            'vaccineName' => $vaccineName,
            'vaccineDose' => $vaccineDose,
            'vaccinationDate' => $vaccinationDate,
            'dischargeDate' => $dischargeDate
        ]);
    }

    public static function getDoctorActivities() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM doctor_activity ORDER BY iD DESC");
        return $stmt->fetchAll();
    }
}
