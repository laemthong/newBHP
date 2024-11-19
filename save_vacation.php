<?php
// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
include 'connect/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<pre>';
    print_r($_POST); // แสดงค่าที่ส่งมาจากฟอร์ม
    echo '</pre>';
}

// รับข้อมูลจากฟอร์ม
$vacation_date = $_POST['vacation_date'] ?? null;
$typeVacation_id = $_POST['typeVacation_id'] ?? null;
$vacation_name = $_POST['vacation_name'] ?? null;
$vacation_rank = $_POST['vacation_rank'] ?? null;
$vacation_accumulateDay = $_POST['vacation_accumulateDay'] ?? null;
$vacation_rightsDay = $_POST['vacation_rightsDay'] ?? null;
$vacation_sumDay = $_POST['vacation_sumDay'] ?? null;
$vacation_setDay = $_POST['vacation_setDay'] ?? null;
$vacation_formwork = $_POST['vacation_formwork'] ?? null;
$vacation_numPhone = $_POST['vacation_numPhone'] ?? null;
$vacation_nameWorkinstead = $_POST['vacation_nameWorkinstead'] ?? null;
$vacation_WorkinsteadRank = $_POST['vacation_WorkinsteadRank'] ?? null;
$vacation_allow = $_POST['vacation_allow'] ?? null;
$vacation_level = $_POST['vacation_level'] ?? null;
$vacation_since = $_POST['vacation_since'] ?? null;



// เตรียมคำสั่ง SQL
$sql = "INSERT INTO vacation_leave (
    vacation_date,
    typeVacation_id,
    vacation_name,
    vacation_rank,
    vacation_accumulateDay,
    vacation_rightsDay,
    vacation_sumDay,
    vacation_setDay,
    vacation_formwork,
    vacation_numPhone,
    vacation_nameWorkinstead,
    vacation_WorkinsteadRank,
    vacation_allow,
    vacation_level,
    vacation_since
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// ใช้ Prepared Statement เพื่อป้องกัน SQL Injection
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssiiiisisssss", // จำนวนตัวแปรต้องตรงกับฟิลด์ใน SQL
    $vacation_date,
    $typeVacation_id,
    $vacation_name,
    $vacation_rank,
    $vacation_accumulateDay,
    $vacation_rightsDay,
    $vacation_sumDay,
    $vacation_setDay,
    $vacation_formwork, // ต้องตรงกับฟิลด์ในฐานข้อมูล
    $vacation_numPhone,
    $vacation_nameWorkinstead,
    $vacation_WorkinsteadRank,
    $vacation_allow,
    $vacation_level,
    $vacation_since
);

// ดำเนินการคำสั่ง SQL
if ($stmt->execute()) {
    echo "<script>alert('บันทึกข้อมูลสำเร็จ!'); window.location.href='vacation_leave.php';</script>";
} else {
    echo "เกิดข้อผิดพลาด: " . $stmt->error;
}

// ปิดการเชื่อมต่อ
$stmt->close();
$conn->close();
?>
