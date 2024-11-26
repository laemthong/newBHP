<?php
include 'connect/connection.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ดึงข้อมูลจากฟอร์ม
        $person_id = $_POST['person_id'];
        $person_name = $_POST['person_name'];
        $person_gender = $_POST['person_gender'];
        $person_rank = $_POST['person_rank'];
        $person_formwork = $_POST['person_formwork'];
        $person_level = $_POST['person_level'];
        $person_salary = $_POST['person_salary'];
        $person_nickname = $_POST['person_nickname'];
        $person_born = convertThaiDateToMySQLDate($_POST['day'], $_POST['month'], $_POST['year']);
        $person_dateAccepting = convertThaiDateToMySQLDate($_POST['accept_day'], $_POST['accept_month'], $_POST['accept_year']);
        $person_typeHire = $_POST['person_typeHire'];
        $person_positionAllowance = $_POST['person_positionAllowance'];
        $person_phone = $_POST['person_phone'];
        $person_specialQualification = $_POST['person_specialQualification'];
        $person_blood = $_POST['person_blood'];
        $person_cardNum = $_POST['person_cardNum'];
        $person_CardExpired = convertThaiDateToMySQLDate($_POST['Expired_day'], $_POST['Expired_month'], $_POST['Expired_year']);
        $person_DocNumber = $_POST['person_DocNumber'];
        $person_SuppNumber = $_POST['person_SuppNumber'];
        $person_POSVNumber = $_POST['person_POSVNumber'];
        $person_image = null;

        // ตรวจสอบและจัดการอัปโหลดรูปภาพ
        if (isset($_FILES['person_image']) && $_FILES['person_image']['error'] === UPLOAD_ERR_OK) {
            $person_image = file_get_contents($_FILES['person_image']['tmp_name']);
        }

        // เตรียม SQL
        $sql = "INSERT INTO personnel (
                    person_id, person_name, person_gender, person_rank, person_formwork,
                    person_level, person_salary, person_nickname, person_born,
                    person_dateAccepting, person_typeHire, person_positionAllowance,
                    person_phone, person_specialQualification, person_blood,
                    person_cardNum, person_CardExpired, person_DocNumber,
                    person_SuppNumber, person_POSVNumber, person_image
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            'sssssssssssssssssssss',
            $person_id, $person_name, $person_gender, $person_rank, $person_formwork,
            $person_level, $person_salary, $person_nickname, $person_born,
            $person_dateAccepting, $person_typeHire, $person_positionAllowance,
            $person_phone, $person_specialQualification, $person_blood,
            $person_cardNum, $person_CardExpired, $person_DocNumber,
            $person_SuppNumber, $person_POSVNumber, $person_image
        );

        // บันทึกข้อมูล
        if ($stmt->execute()) {
            $_SESSION['success'] = "บันทึกข้อมูลสำเร็จ!";
        } else {
            throw new Exception("เกิดข้อผิดพลาด: " . $stmt->error);
        }
    }
} catch (Exception $e) {
    // เก็บข้อความข้อผิดพลาดใน session
    $_SESSION['error'] = $e->getMessage();
} finally {
    // ปิด statement และ connection
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();

    // กลับไปยังหน้าฟอร์ม
    header("Location: form_person.php");
    exit();
}

// ฟังก์ชันแปลงวันที่
function convertThaiDateToMySQLDate($day, $month, $year) {
    $year = $year - 543; // แปลง พ.ศ. เป็น ค.ศ.
    return "$year-$month-$day"; // ส่งคืนวันที่ในรูปแบบ YYYY-MM-DD
}
?>
