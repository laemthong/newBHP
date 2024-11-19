<?php
// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
include 'connect/connection.php';

// ตรวจสอบว่ามีการส่งฟอร์มมา
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

    // แปลงรูปแบบวันที่
    $person_born = !empty($_POST['person_born']) ? date("Y-m-d", strtotime($_POST['person_born'])) : null;
    $person_positionNum = isset($_POST['person_positionNum']) ? intval($_POST['person_positionNum']) : null;
    $person_dateAccepting = !empty($_POST['person_dateAccepting']) ? date("Y-m-d", strtotime($_POST['person_dateAccepting'])) : null;
    $person_typeHire = $_POST['person_typeHire'] ?? null;
    
   // ดึงปีจากวันที่เกิดและวันที่รับเข้าทำงาน (ใช้ปี ค.ศ.)
$person_yearBorn = !empty($person_born) ? intval(date("Y", strtotime($person_born))) : null;
$person_yearAccepting = !empty($person_dateAccepting) ? intval(date("Y", strtotime($person_dateAccepting))) : null;


    $person_positionAllowance = isset($_POST['person_positionAllowance']) ? floatval($_POST['person_positionAllowance']) : null;
    $person_phone = $_POST['person_phone'] ?? null;
    $person_specialQualification = $_POST['person_specialQualification'] ?? null;
    $person_blood = $_POST['person_blood'] ?? null;
    $person_cardNum = $_POST['person_cardNum'] ?? null;
    $person_CardExpired = !empty($_POST['person_CardExpired']) ? date("Y-m-d", strtotime($_POST['person_CardExpired'])) : null;

    // เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูล
    $sql = "INSERT INTO personnel (
                person_id, person_name, person_gender, person_rank, person_formwork, person_level, 
                person_salary, person_nickname, person_born, person_positionNum, person_dateAccepting, 
                person_typeHire, person_yearBorn, person_yearAccepting, person_positionAllowance, 
                person_phone, person_specialQualification, person_blood, person_cardNum, person_CardExpired
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("เตรียมคำสั่ง SQL ล้มเหลว: " . $conn->error);
    }

    // ผูกตัวแปรกับคำสั่ง SQL
    $stmt->bind_param(
        "isssssdssisiiidsssss", // รูปแบบตัวแปรต้องตรงกับประเภทข้อมูล
        $person_id,             // i (integer)
        $person_name,           // s (string)
        $person_gender,         // s (string)
        $person_rank,           // s (string)
        $person_formwork,       // s (string)
        $person_level,          // s (string)
        $person_salary,         // d (double)
        $person_nickname,       // s (string)
        $person_born,           // s (string - date)
        $person_positionNum,    // i (integer)
        $person_dateAccepting,  // s (string - date)
        $person_typeHire,       // s (string)
        $person_yearBorn,       // i (integer)
        $person_yearAccepting,  // i (integer)
        $person_positionAllowance, // d (double)
        $person_phone,          // s (string)
        $person_specialQualification, // s (string)
        $person_blood,          // s (string)
        $person_cardNum,        // s (string)
        $person_CardExpired     // s (string - date)
    );

    if ($stmt->execute()) {
        $_SESSION['success'] = true; // ตั้งค่า session เพื่อบอกว่าบันทึกสำเร็จ
    } 

    $stmt->close();
    $conn->close();

    header("Location: form_person.php"); // เปลี่ยนเส้นทางกลับไปยังหน้า form_person.php
    exit();
}
?>