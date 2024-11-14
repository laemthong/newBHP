<?php
// เชื่อมต่อฐานข้อมูล
include 'connect/connection.php';

// ตรวจสอบว่ามีการส่ง id มาจาก URL หรือไม่
if (isset($_GET['id'])) {
    $person_id = $_GET['id'];

    // ดึงข้อมูลของแถวที่ต้องการแก้ไขจากฐานข้อมูล
    $sql = "SELECT * FROM personnel WHERE person_id = $person_id";
    $result = $conn->query($sql);

    // ตรวจสอบว่ามีข้อมูลในฐานข้อมูลหรือไม่
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "ไม่พบข้อมูล";
        exit();
    }
}

// ตรวจสอบว่ามีการส่งข้อมูลที่แก้ไขกลับมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $person_id = $_POST['person_id'];
    $name = $_POST['person_name'];
    $gender = $_POST['person_gender'];
    $rank = $_POST['person_rank'];
    $formwork = $_POST['person_formwork'];
    $level = $_POST['person_level'];
    $salary = $_POST['person_salary'];
    $nickname = $_POST['person_nickname'];
    $born = $_POST['person_born'];
    $positionNum = $_POST['person_positionNum'];
    $dateAccepting = $_POST['person_dateAccepting'];
    $typeHire = $_POST['person_typeHire'];
    $yearBorn = intval(date("Y", strtotime($born)));
    $yearAccepting = intval(date("Y", strtotime($dateAccepting)));
    $positionAllowance = $_POST['person_positionAllowance'];
    $phone = $_POST['person_phone'];
    $specialQualification = $_POST['person_specialQualification'];
    $blood = $_POST['person_blood'];
    $cardNum = $_POST['person_cardNum'];
    $cardExpired = $_POST['person_CardExpired'];

    // อัพเดตข้อมูลในฐานข้อมูล
    $sql = "UPDATE personnel SET 
                person_name = '$name', 
                person_gender = '$gender', 
                person_rank = '$rank', 
                person_formwork = '$formwork', 
                person_level = '$level', 
                person_salary = '$salary', 
                person_nickname = '$nickname', 
                person_born = '$born', 
                person_positionNum = '$positionNum', 
                person_dateAccepting = '$dateAccepting', 
                person_typeHire = '$typeHire', 
                person_yearBorn = '$yearBorn', 
                person_yearAccepting = '$yearAccepting', 
                person_positionAllowance = '$positionAllowance', 
                person_phone = '$phone', 
                person_specialQualification = '$specialQualification', 
                person_blood = '$blood', 
                person_cardNum = '$cardNum', 
                person_CardExpired = '$cardExpired'
            WHERE person_id = $person_id";

    if ($conn->query($sql) === TRUE) {
        echo "แก้ไขข้อมูลสำเร็จ";
        header("Location: personnel.php"); // กลับไปยังหน้าแสดงตาราง
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลบุคคล</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">แก้ไขข้อมูลบุคคล</h2>
        <form action="edit_person.php" method="post">
            <input type="hidden" name="person_id" value="<?php echo $row['person_id']; ?>">

            <div class="mb-3">
                <label for="person_name" class="form-label">ชื่อ-สกุล</label>
                <input type="text" class="form-control" id="person_name" name="person_name" value="<?php echo $row['person_name']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="person_gender" class="form-label">เพศ</label>
                <input type="text" class="form-control" id="person_gender" name="person_gender" value="<?php echo $row['person_gender']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="person_rank" class="form-label">ตำแหน่ง</label>
                <input type="text" class="form-control" id="person_rank" name="person_rank" value="<?php echo $row['person_rank']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="person_formwork" class="form-label">ปฏิบัติการที่</label>
                <input type="text" class="form-control" id="person_formwork" name="person_formwork" value="<?php echo $row['person_formwork']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="person_level" class="form-label">ระดับ</label>
                <input type="text" class="form-control" id="person_level" name="person_level" value="<?php echo $row['person_level']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="person_salary" class="form-label">เงินเดือน</label>
                <input type="number" class="form-control" id="person_salary" name="person_salary" value="<?php echo $row['person_salary']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="person_nickname" class="form-label">ชื่อเล่น</label>
                <input type="text" class="form-control" id="person_nickname" name="person_nickname" value="<?php echo $row['person_nickname']; ?>">
            </div>

            <div class="mb-3">
                <label for="person_born" class="form-label">วันเกิด</label>
                <input type="date" class="form-control" id="person_born" name="person_born" value="<?php echo $row['person_born']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="person_positionNum" class="form-label">เลขที่ตำแหน่ง</label>
                <input type="number" class="form-control" id="person_positionNum" name="person_positionNum" value="<?php echo $row['person_positionNum']; ?>">
            </div>

            <div class="mb-3">
                <label for="person_dateAccepting" class="form-label">วันบรรจุ</label>
                <input type="date" class="form-control" id="person_dateAccepting" name="person_dateAccepting" value="<?php echo $row['person_dateAccepting']; ?>">
            </div>

            <div class="mb-3">
                <label for="person_typeHire" class="form-label">ประเภทการจ้าง</label>
                <input type="text" class="form-control" id="person_typeHire" name="person_typeHire" value="<?php echo $row['person_typeHire']; ?>">
            </div>

            <div class="mb-3">
                <label for="person_positionAllowance" class="form-label">เงินประจำตำแหน่ง</label>
                <input type="number" class="form-control" id="person_positionAllowance" name="person_positionAllowance" value="<?php echo $row['person_positionAllowance']; ?>">
            </div>

            <div class="mb-3">
                <label for="person_phone" class="form-label">เบอร์โทรศัพท์</label>
                <input type="text" class="form-control" id="person_phone" name="person_phone" value="<?php echo $row['person_phone']; ?>">
            </div>

            <div class="mb-3">
                <label for="person_specialQualification" class="form-label">วุฒิและพรสวรรค์</label>
                <input type="text" class="form-control" id="person_specialQualification" name="person_specialQualification" value="<?php echo $row['person_specialQualification']; ?>">
            </div>

            <div class="mb-3">
                <label for="person_blood" class="form-label">กรุ๊ปเลือด</label>
                <input type="text" class="form-control" id="person_blood" name="person_blood" value="<?php echo $row['person_blood']; ?>">
            </div>

            <div class="mb-3">
                <label for="person_cardNum" class="form-label">เลขบัตรข้าราชการ</label>
                <input type="text" class="form-control" id="person_cardNum" name="person_cardNum" value="<?php echo $row['person_cardNum']; ?>">
            </div>

            <div class="mb-3">
                <label for="person_CardExpired" class="form-label">วันหมดอายุบัตรข้าราชการ</label>
                <input type="date" class="form-control" id="person_CardExpired" name="person_CardExpired" value="<?php echo $row['person_CardExpired']; ?>">
            </div>

            <button type="submit" class="btn btn-success">บันทึกการแก้ไข</button>
            <a href="personnel.php" class="btn btn-secondary">ยกเลิก</a>
        </form>
    </div>
</body>
</html>
