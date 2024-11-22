<?php
// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
include 'connect/connection.php';
session_start();

try {
    // ตรวจสอบว่ามีการส่งฟอร์มมา
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $person_id = isset($_POST['person_id']) ? intval($_POST['person_id']) : null;
        $person_name = $_POST['person_name'] ?? null;
        $person_gender = $_POST['person_gender'] ?? null;
        $person_rank = $_POST['person_rank'] ?? null;
        $person_formwork = $_POST['person_formwork'] ?? null;
        $person_level = $_POST['person_level'] ?? null;
        $person_salary = isset($_POST['person_salary']) ? floatval($_POST['person_salary']) : null;
        $person_nickname = $_POST['person_nickname'] ?? null;

        // แปลงวันที่เกิด (person_born)
        $born_day = $_POST['day'] ?? null;
        $born_month = $_POST['month'] ?? null;
        $born_year_thai = $_POST['year'] ?? null;
        if ($born_day && $born_month && $born_year_thai) {
            $person_born = sprintf("%04d-%02d-%02d", intval($born_year_thai - 543), intval($born_month), intval($born_day));
        } else {
            $person_born = null;
        }

        // แปลงวันที่บรรจุ (person_dateAccepting)
        $accept_day = $_POST['accept_day'] ?? null;
        $accept_month = $_POST['accept_month'] ?? null;
        $accept_year_thai = $_POST['accept_year'] ?? null;
        if ($accept_day && $accept_month && $accept_year_thai) {
            $person_dateAccepting = sprintf("%04d-%02d-%02d", intval($accept_year_thai - 543), intval($accept_month), intval($accept_day));
        } else {
            $person_dateAccepting = null;
        }

        // ข้อมูลเพิ่มเติม
        $person_positionNum = isset($_POST['person_positionNum']) ? intval($_POST['person_positionNum']) : null;
        $person_typeHire = $_POST['person_typeHire'] ?? null;
        $person_positionAllowance = isset($_POST['person_positionAllowance']) ? floatval($_POST['person_positionAllowance']) : null;
        $person_phone = $_POST['person_phone'] ?? null;
        $person_specialQualification = $_POST['person_specialQualification'] ?? null;
        $person_blood = $_POST['person_blood'] ?? null;
        $person_cardNum = $_POST['person_cardNum'] ?? null;
        
        // แปลงวันที่หมดอายุบัตร (person_CardExpired)
        $Expired_day = $_POST['Expired_day'] ?? null;
        $Expired_month = $_POST['Expired_month'] ?? null;
        $Expired_year_thai = $_POST['Expired_year'] ?? null;
        if ($Expired_day && $Expired_month && $Expired_year_thai) {
            $person_CardExpired = sprintf("%04d-%02d-%02d", intval($Expired_year_thai - 543), intval($Expired_month), intval($Expired_day));
        } else {
            $person_CardExpired = null;
        }


        // ข้อมูลใหม่ที่เพิ่ม
        $person_DocNumber = $_POST['person_DocNumber'] ?? null;
        $person_SuppNumber = $_POST['person_SuppNumber'] ?? null;
        $person_POSVNumber = $_POST['person_POSVNumber'] ?? null;


        // ตรวจสอบข้อมูลที่จำเป็น
        if (!$person_id || !$person_name || !$person_gender || !$person_born || !$person_dateAccepting) {
            throw new Exception("กรุณากรอกข้อมูลที่จำเป็นให้ครบถ้วน รวมถึงวันที่เกิดและวันที่บรรจุ");
        }

        // SQL สำหรับเพิ่มข้อมูล
        $sql = "INSERT INTO personnel (
            person_id, person_name, person_gender, person_rank, person_formwork,
            person_level, person_salary, person_nickname, person_born,
            person_dateAccepting, person_typeHire, person_positionAllowance,
            person_phone, person_specialQualification, person_blood,
            person_cardNum, person_CardExpired, person_DocNumber,
            person_SuppNumber, person_POSVNumber
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        
        // เตรียมคำสั่ง SQL
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("การเตรียมคำสั่ง SQL ล้มเหลว: " . $conn->error);
        }
        
        // ผูกตัวแปรกับคำสั่ง SQL
        $stmt->bind_param(
            "ssssssssssssssssssss",
            $person_id, $person_name, $person_gender, $person_rank, $person_formwork,
            $person_level, $person_salary, $person_nickname, $person_born,
            $person_dateAccepting, $person_typeHire, $person_positionAllowance,
            $person_phone, $person_specialQualification, $person_blood,
            $person_cardNum, $person_CardExpired, $person_DocNumber,
            $person_SuppNumber, $person_POSVNumber
        );
        
        

        // ดำเนินการบันทึกข้อมูล
        if ($stmt->execute()) {
            $_SESSION['success'] = "บันทึกข้อมูลสำเร็จ!";
        } else {
            throw new Exception("เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $stmt->error);
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
} finally {
    if (isset($stmt))
        $stmt->close();
    if (isset($conn))
        $conn->close();
    header("Location: form_person.php");
    exit();
}
?>


