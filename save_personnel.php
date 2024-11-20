<?php
// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
include 'connect/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจากฟอร์มและแปลงค่าว่างเป็น null
    $person_id = isset($_POST['person_id']) ? intval($_POST['person_id']) : null;
    $person_name = $_POST['person_name'] ?? null;
    $person_gender = $_POST['person_gender'] ?? null;
    $person_rank = $_POST['person_rank'] ?? null;
    $person_formwork = $_POST['person_formwork'] ?? null;
    $person_level = $_POST['person_level'] ?? null;
    $person_salary = isset($_POST['person_salary']) ? floatval($_POST['person_salary']) : null;
    $person_nickname = $_POST['person_nickname'] ?? null;

    // รวมข้อมูลวันเดือนปีเกิด
    $born_day = $_POST['born_day'] ?? null;
    $born_month = $_POST['born_month'] ?? null;
    $born_year = $_POST['born_year'] ?? null;
    if ($born_day && $born_month && $born_year) {
        $person_born = "$born_day/$born_month/$born_year"; // รูปแบบ DD/MM/YYYY
    } else {
        $person_born = null; // หากกรอกไม่ครบ
    }

    // รวมข้อมูลวันที่บรรจุ
    $accepting_day = $_POST['person_dateAccepting_day'] ?? null;
    $accepting_month = $_POST['person_dateAccepting_month'] ?? null;
    $accepting_year = $_POST['person_dateAccepting_year'] ?? null;
    if ($accepting_day && $accepting_month && $accepting_year) {
        $person_dateAccepting = "$accepting_day/$accepting_month/$accepting_year"; // รูปแบบ DD/MM/YYYY
    } else {
        $person_dateAccepting = null; // หากกรอกไม่ครบ
    }

    $person_typeHire = $_POST['person_typeHire'] ?? null;
    $person_positionAllowance = isset($_POST['person_positionAllowance']) ? floatval($_POST['person_positionAllowance']) : null;
    $person_phone = $_POST['person_phone'] ?? null;
    $person_specialQualification = $_POST['person_specialQualification'] ?? null;
    $person_blood = $_POST['person_blood'] ?? null;
    $person_cardNum = $_POST['person_cardNum'] ?? null;
    $person_CardExpired = $_POST['person_CardExpired'] ?? null;

    // ตรวจสอบข้อมูลที่จำเป็นก่อนบันทึก
    if (empty($person_name) || empty($person_gender) || empty($person_born)) {
        $_SESSION['error'] = "กรุณากรอกข้อมูลที่จำเป็นให้ครบถ้วน (ชื่อ, เพศ, วันเดือนปีเกิด)";
        header("Location: form_person.php");
        exit();
    }

    // เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูล
    $sql = "INSERT INTO personnel (
                person_id, person_name, person_gender, person_rank, person_formwork, person_level, 
                person_salary, person_nickname, person_born, person_positionNum, person_dateAccepting, 
                person_typeHire, person_positionAllowance, 
                person_phone, person_specialQualification, person_blood, person_cardNum, person_CardExpired
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("เตรียมคำสั่ง SQL ล้มเหลว: " . $conn->error);
    }

    // ผูกตัวแปรกับ SQL
    $stmt->bind_param(
        "isssssdsisssdsssss", // รูปแบบตัวแปรต้องตรงกับประเภทข้อมูล
        $person_id,             // i (integer)
        $person_name,           // s (string)
        $person_gender,         // s (string)
        $person_rank,           // s (string)
        $person_formwork,       // s (string)
        $person_level,          // s (string)
        $person_salary,         // d (double)
        $person_nickname,       // s (string)
        $person_born,           // s (string)
        $person_positionNum,    // i (integer)
        $person_dateAccepting,  // s (string)
        $person_typeHire,       // s (string)
        $person_positionAllowance, // d (double)
        $person_phone,          // s (string)
        $person_specialQualification, // s (string)
        $person_blood,          // s (string)
        $person_cardNum,        // s (string)
        $person_CardExpired     // s (string)
    );

    // ดำเนินการบันทึกข้อมูล
    if ($stmt->execute()) {
        $_SESSION['success'] = "บันทึกข้อมูลสำเร็จ!";
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาด: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: form_person.php"); // เปลี่ยนเส้นทางกลับไปยังหน้า form_person.php
    exit();
}
?>
