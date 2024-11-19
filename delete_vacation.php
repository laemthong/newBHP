<?php
include 'connect/connection.php';

$id = $_GET['vacation_id']; // รับค่า ID

$sql = "DELETE FROM vacation_leave WHERE vacation_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('ลบข้อมูลสำเร็จ'); window.location.href='vacation_leave.php';</script>";
} else {
    echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล'); window.history.back();</script>";
}
?>
