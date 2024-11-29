<?php
include 'connect/connection.php';

ini_set('display_errors', 1); // เปิดการแสดงข้อผิดพลาด
error_reporting(E_ALL);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ตรวจสอบค่าที่ส่งมาจากฟอร์ม
        $person_id = !empty($_POST['person_id']) ? $_POST['person_id'] : null;
        $person_name = !empty($_POST['person_name']) ? $_POST['person_name'] : null;
        $person_gender = !empty($_POST['person_gender']) ? $_POST['person_gender'] : null;
        $person_rank = !empty($_POST['person_rank']) ? $_POST['person_rank'] : null;
        $person_formwork = !empty($_POST['person_formwork']) ? $_POST['person_formwork'] : null;
        $person_level = !empty($_POST['person_level']) ? $_POST['person_level'] : null;
        $person_salary = !empty($_POST['person_salary']) ? $_POST['person_salary'] : null;
        $person_nickname = !empty($_POST['person_nickname']) ? $_POST['person_nickname'] : null;

        // แปลงวันที่
        $person_born = convertThaiDateToMySQLDate($_POST['day'] ?? null, $_POST['month'] ?? null, $_POST['year'] ?? null);
        $person_dateAccepting = convertThaiDateToMySQLDate($_POST['accept_day'] ?? null, $_POST['accept_month'] ?? null, $_POST['accept_year'] ?? null);
        $person_CardExpired = convertThaiDateToMySQLDate($_POST['Expired_day'] ?? null, $_POST['Expired_month'] ?? null, $_POST['Expired_year'] ?? null);

        // ข้อมูลเพิ่มเติม
        $person_typeHire = !empty($_POST['person_typeHire']) ? $_POST['person_typeHire'] : null;
        $person_positionAllowance = !empty($_POST['person_positionAllowance']) ? $_POST['person_positionAllowance'] : null;
        $person_phone = !empty($_POST['person_phone']) ? $_POST['person_phone'] : null;
        $person_specialQualification = !empty($_POST['person_specialQualification']) ? $_POST['person_specialQualification'] : null;
        $person_status = !empty($_POST['person_status']) ? $_POST['person_status'] : null;
        $person_note = !empty($_POST['person_note']) ? $_POST['person_note'] : null;
        $person_cardNum = !empty($_POST['person_cardNum']) ? $_POST['person_cardNum'] : null;
        $person_DocNumber = !empty($_POST['person_DocNumber']) ? $_POST['person_DocNumber'] : null;
        $person_SuppNumber = !empty($_POST['person_SuppNumber']) ? $_POST['person_SuppNumber'] : null;
        $person_POSVNumber = !empty($_POST['person_POSVNumber']) ? $_POST['person_POSVNumber'] : null;

        // เตรียมคำสั่ง SQL
        $sql = "INSERT INTO personnel (
            person_id, person_name, person_gender, person_rank, person_formwork, 
            person_level, person_salary, person_nickname, person_born, 
            person_dateAccepting, person_typeHire, person_positionAllowance, 
            person_phone, person_specialQualification, person_status, 
            person_note, person_cardNum, person_CardExpired, person_DocNumber, 
            person_SuppNumber, person_POSVNumber
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error);
        }

        $stmt->bind_param(
            'sssssssssssssssssssss',
            $person_id, $person_name, $person_gender, $person_rank, $person_formwork,
            $person_level, $person_salary, $person_nickname, $person_born,
            $person_dateAccepting, $person_typeHire, $person_positionAllowance,
            $person_phone, $person_specialQualification, $person_status,
            $person_note, $person_cardNum, $person_CardExpired, $person_DocNumber,
            $person_SuppNumber, $person_POSVNumber
        );

        // บันทึกข้อมูล
        if ($stmt->execute()) {
            $_SESSION['success'] = "บันทึกข้อมูลสำเร็จ!";
        } else {
            throw new Exception("เกิดข้อผิดพลาด: " . $stmt->error);
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
    header("Location: form_person.php");
    exit();
}

// ฟังก์ชันแปลงวันที่
function convertThaiDateToMySQLDate($day, $month, $year) {
    if (empty($day) || empty($month) || empty($year)) {
        return null;
    }
    $year = $year - 543;
    return sprintf('%04d-%02d-%02d', $year, $month, $day);
}
?>
