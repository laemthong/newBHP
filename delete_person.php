<?php
// เชื่อมต่อฐานข้อมูล
include 'connect/connection.php';

// ตรวจสอบว่ามีการส่งค่า id มาจาก URL หรือไม่
if (isset($_GET['id'])) {
    $person_id = $_GET['id'];

    // ลบข้อมูลในฐานข้อมูล
    $sql = "DELETE FROM personnel WHERE person_id = $person_id";

    if ($conn->query($sql) === TRUE) {
        echo "ลบข้อมูลสำเร็จ";
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล: " . $conn->error;
    }
} else {
    echo "ไม่พบข้อมูลที่ต้องการลบ";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();

// กลับไปยังหน้าแสดงตาราง
header("Location: personnel.php");
exit();
?>
