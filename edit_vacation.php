<?php
// เชื่อมต่อฐานข้อมูล
include 'connect/connection.php';

// รับค่าตัวแปรจาก URL
$id = $_GET['vacation_id'] ?? '';

// หากไม่มี id ส่งกลับไปยังหน้า vacation_leave.php
if (!$id) {
    header("Location: Show_leave.php");
    exit;
}

// ดึงข้อมูลการลาเพื่อแสดงในแบบฟอร์ม
$sql = "SELECT * FROM vacation_leave WHERE vacation_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$vacation = $result->fetch_assoc();

// ถ้าหากข้อมูลไม่พบ
if (!$vacation) {
    echo "ไม่พบข้อมูลการลา";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vacation_name = $_POST['vacation_name'] ?? '';
    $vacation_rank = $_POST['vacation_rank'] ?? '';
    $vacation_accumulateDay = $_POST['vacation_accumulateDay'] ?? 0;
    $vacation_rightsDay = $_POST['vacation_rightsDay'] ?? 0;
    $vacation_sumDay = $_POST['vacation_sumDay'] ?? 0;
    $vacation_since = $_POST['vacation_since'] ?? '';
    $vacation_numPhone = $_POST['vacation_numPhone'] ?? '';
    $vacation_allow = $_POST['vacation_allow'] ?? $vacation['vacation_allow'];
    $vacation_date = $_POST['vacation_date'] ?? $vacation['vacation_date']; // Default to original value

    // Validate the date format for vacation_date
    if ($vacation_date && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $vacation_date)) {
        die("Invalid date format for vacation_date. Please use YYYY-MM-DD.");
    }

    $typeVacation_id = $_POST['typeVacation_id'] ?? 0;
    $vacation_setDay = $_POST['vacation_setDay'] ?? 0;
    $vacation_level = $_POST['vacation_level'] ?? '';
    $vacation_formwork = $_POST['vacation_formwork'] ?? '';
    $vacation_nameWorkinstead = $_POST['vacation_nameWorkinstead'] ?? $vacation['vacation_nameWorkinstead'];
    $vacation_WorkinsteadRank = $_POST['vacation_WorkinsteadRank'] ?? $vacation['vacation_WorkinsteadRank'];

    // SQL Update
    $update_sql = "UPDATE vacation_leave SET 
        vacation_name = ?, vacation_rank = ?, vacation_accumulateDay = ?, vacation_rightsDay = ?, vacation_sumDay = ?, 
        vacation_since = ?, vacation_numPhone = ?, vacation_allow = ?, vacation_date = ?, 
        typeVacation_id = ?, vacation_setDay = ?, vacation_level = ?, vacation_formwork = ?, 
        vacation_nameWorkinstead = ?, vacation_WorkinsteadRank = ? 
        WHERE vacation_id = ?";
    $update_stmt = $conn->prepare($update_sql);

    if ($update_stmt === false) {
        die("SQL error: " . $conn->error);
    }

    $update_stmt->bind_param(
        "ssiiissssississi",
        $vacation_name,
        $vacation_rank,
        $vacation_accumulateDay,
        $vacation_rightsDay,
        $vacation_sumDay,
        $vacation_since,
        $vacation_numPhone,
        $vacation_allow,
        $vacation_date,
        $typeVacation_id,
        $vacation_setDay,
        $vacation_level,
        $vacation_formwork,
        $vacation_nameWorkinstead,
        $vacation_WorkinsteadRank,
        $id
    );

    if ($update_stmt->execute()) {
        header("Location: Show_leave.php");
        exit;
    } else {
        echo "Error updating record: " . $update_stmt->error;
    }
}

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลการลา</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
</head>

<body>
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4>แก้ไขข้อมูลการลา</h4>
            </div>
            <div class="card-body">
                <form action="edit_vacation.php?vacation_id=<?= $vacation['vacation_id'] ?>" method="POST">
                    <div class="mb-3">
                        <label for="vacation_name" class="form-label">ชื่อ-สกุล</label>
                        <input type="text" class="form-control" id="vacation_name" name="vacation_name"
                            value="<?= htmlspecialchars($vacation['vacation_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="vacation_rank" class="form-label">ตำแหน่ง</label>
                        <input type="text" class="form-control" id="vacation_rank" name="vacation_rank"
                            value="<?= htmlspecialchars($vacation['vacation_rank']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="vacation_accumulateDay" class="form-label">วันพักผ่อนสะสม</label>
                        <input type="number" class="form-control" id="vacation_accumulateDay"
                            name="vacation_accumulateDay" value="<?= $vacation['vacation_accumulateDay'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="vacation_rightsDay" class="form-label">สิทธิวันพักผ่อนประจำปี</label>
                        <input type="number" class="form-control" id="vacation_rightsDay" name="vacation_rightsDay"
                            value="<?= $vacation['vacation_rightsDay'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="vacation_sumDay" class="form-label">รวมเป็นกี่วัน</label>
                        <input type="number" class="form-control" id="vacation_sumDay" name="vacation_sumDay"
                            value="<?= $vacation['vacation_sumDay'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="vacation_since" class="form-label">ตั้งแต่วันที่</label>
                        <input type="text" class="form-control" id="vacation_since" name="vacation_since"
                            value="<?= htmlspecialchars($vacation['vacation_since']) ?>" placeholder="เลือกช่วงวันที่"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="vacation_numPhone" class="form-label">หมายเลขโทรศัพท์</label>
                        <input type="text" class="form-control" id="vacation_numPhone" name="vacation_numPhone"
                            value="<?= $vacation['vacation_numPhone'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="typeVacation_id" class="form-label">ประเภทการลา</label>
                        <select class="form-control" id="typeVacation_id" name="typeVacation_id" required>
                            <option value="1" <?= $vacation['typeVacation_id'] == 1 ? 'selected' : '' ?>>ลาพักผ่อน</option>
                            <option value="2" <?= $vacation['typeVacation_id'] == 2 ? 'selected' : '' ?>>ลาป่วย</option>
                            <option value="3" <?= $vacation['typeVacation_id'] == 3 ? 'selected' : '' ?>>ลาคลอดบุตร
                            </option>
                            <option value="4" <?= $vacation['typeVacation_id'] == 4 ? 'selected' : '' ?>>ลากิจส่วนตัว
                            </option>
                        </select>
                    </div>
                    <!-- ฟิลด์เพิ่มเติมในฟอร์มแก้ไข -->
                    <div class="mb-3">
                        <label for="vacation_allow" class="form-label">อนุญาตหรือไม่</label>
                        <select class="form-control" id="vacation_allow" name="vacation_allow" required>
                            <option value="อนุญาต" <?= $vacation['vacation_allow'] == 'อนุญาต' ? 'selected' : '' ?>>อนุญาต
                            </option>
                            <option value="ไม่อนุญาต" <?= $vacation['vacation_allow'] == 'ไม่อนุญาต' ? 'selected' : '' ?>>
                                ไม่อนุญาต
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="vacation_setDay" class="form-label">กำหนดวัน (วัน)</label>
                        <input type="number" class="form-control" id="vacation_setDay" name="vacation_setDay"
                            value="<?= $vacation['vacation_setDay'] ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="vacation_level" class="form-label">ระดับข้าราชการ:</label>
                        <select name="vacation_level" id="vacation_level" class="form-select" required>
                            <option value="">เลือกระดับ</option>
                            <option value="ระดับทักษะพิเศษ" <?= $vacation['vacation_level'] == "ระดับทักษะพิเศษ" ? 'selected' : '' ?>>ระดับทักษะพิเศษ</option>
                            <option value="ระดับอาวุโส" <?= $vacation['vacation_level'] == "ระดับอาวุโส" ? 'selected' : '' ?>>ระดับอาวุโส</option>
                            <option value="ระดับชำนาญงาน" <?= $vacation['vacation_level'] == "ระดับชำนาญงาน" ? 'selected' : '' ?>>ระดับชำนาญงาน</option>
                            <option value="ระดับปฏิบัติงาน" <?= $vacation['vacation_level'] == "ระดับปฏิบัติงาน" ? 'selected' : '' ?>>ระดับปฏิบัติงาน</option>
                            <option value="พลเรือน (ประเภทวิชาการ)" <?= $vacation['vacation_level'] == "พลเรือน (ประเภทวิชาการ)" ? 'selected' : '' ?>>พลเรือน (ประเภทวิชาการ)</option>
                            <option value="ระดับเชี่ยวชาญ" <?= $vacation['vacation_level'] == "ระดับเชี่ยวชาญ" ? 'selected' : '' ?>>ระดับเชี่ยวชาญ</option>
                            <option value="ระดับชำนาญการพิเศษ" <?= $vacation['vacation_level'] == "ระดับชำนาญการพิเศษ" ? 'selected' : '' ?>>ระดับชำนาญการพิเศษ</option>
                            <option value="ระดับชำนาญการ" <?= $vacation['vacation_level'] == "ระดับชำนาญการ" ? 'selected' : '' ?>>ระดับชำนาญการ</option>
                            <option value="ระดับปฏิบัติการ" <?= $vacation['vacation_level'] == "ระดับปฏิบัติการ" ? 'selected' : '' ?>>ระดับปฏิบัติการ</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="vacation_formwork" class="form-label">ปฏิบัติการที่ (สังกัด)</label>
                        <select name="vacation_formwork" class="form-control" id="vacation_formwork" required>
                            <option value="">เลือกปฏิบัติการ</option>
                            <?php
                            $work_group_sql = "SELECT group_id, group_name FROM work_group";
                            $work_group_result = $conn->query($work_group_sql);

                            while ($row = $work_group_result->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($row['group_id']) ?>"
                                    <?= $vacation['vacation_formwork'] == $row['group_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['group_name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>


                    <!-- แสดงชื่อและตำแหน่งผู้แทนเฉพาะเมื่อ typeVacation_id = 1 -->
                    <?php if ($vacation['typeVacation_id'] == 1): ?>
                        <div class="mb-3">
                            <label for="vacation_nameWorkinstead" class="form-label">ชื่อผู้ปฏิบัติงานแทน</label>
                            <input type="text" class="form-control" id="vacation_nameWorkinstead"
                                name="vacation_nameWorkinstead" value="<?= $vacation['vacation_nameWorkinstead'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="vacation_WorkinsteadRank" class="form-label">ตำแหน่งผู้ปฏิบัติงานแทน</label>
                            <input type="text" class="form-control" id="vacation_WorkinsteadRank"
                                name="vacation_WorkinsteadRank" value="<?= $vacation['vacation_WorkinsteadRank'] ?>">
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-success">บันทึกการเปลี่ยนแปลง</button>
                    <a href="Show_leave.php" class="btn btn-secondary">ยกเลิก</a>
                </form>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // กำหนด Flatpickr สำหรับ "ตั้งแต่วันที่" ให้เลือกแบบช่วง (Range Mode)
                    flatpickr("#vacation_since", {
                        mode: "range", // เปิดใช้งานเลือกช่วงวันที่
                        dateFormat: "d/m/Y", // รูปแบบวันที่
                        locale: "th", // ใช้ภาษาไทย (อาจต้องเพิ่ม locale TH ถ้าจำเป็น)
                        minDate: "today", // ป้องกันการเลือกวันที่ย้อนหลัง
                        defaultDate: "<?= str_replace(' to ', ' to ', $vacation['vacation_since']) ?>", // กำหนดค่าเริ่มต้น
                        onChange: function (selectedDates) {
                            if (selectedDates.length === 2) { // ตรวจสอบว่าผู้ใช้เลือกครบสองวันที่
                                const startDate = selectedDates[0];
                                const endDate = selectedDates[1];
                                const diffTime = endDate - startDate;
                                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // รวมวันแรก
                                document.getElementById('vacation_setDay').value = diffDays >= 0 ? diffDays : 0;
                            } else {
                                document.getElementById('vacation_setDay').value = ''; // เคลียร์ค่าเมื่อเลือกไม่ครบ
                            }
                        }
                    });
                });
            </script>

        </div>
    </div>
</body>

</html>