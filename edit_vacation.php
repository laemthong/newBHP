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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลการลา</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="photo/รพ.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="dashboard.php"><img src="photo/รพ.png" alt="Logo"
                                    style="width: 100px; height: 100px;"></a>
                        </div>

                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                                height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark"
                                    style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20"
                                preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">เมนู</li>

                        <li class="sidebar-item active ">
                            <a href="dashboard.php" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>หน้าหลัก</span>
                            </a>


                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="fas fa-user-cog"></i>
                                <span>บุคลากร</span>
                            </a>

                            <ul class="submenu ">

                                <li class="submenu-item  ">
                                    <a href="personnel.php" class="submenu-link">แสดงข้อมูลบุคลากร</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="form_person.php" class="submenu-link">เพิ่ม / ลบ / แก้ไข </a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="component-badge.html" class="submenu-link">Badge</a>

                                </li>


                            </ul>


                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="fa fa-address-card"></i>
                                <span>การลา</span>
                            </a>

                            <ul class="submenu ">

                                <li class="submenu-item  ">
                                    <a href="Show_leave.php" class="submenu-link">แสดงข้อมูลการลา</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="vacation_leave.php" class="submenu-link">ลาพักผ่อน</a>

                                </li>



                                <li class="submenu-item  ">
                                    <a href="extra-component-date-picker.html" class="submenu-link">Date Picker</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="extra-component-sweetalert.html" class="submenu-link">Sweet Alert</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="extra-component-toastify.html" class="submenu-link">Toastify</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="extra-component-rating.html" class="submenu-link">Rating</a>

                                </li>

                            </ul>


                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-grid-1x2-fill"></i>
                                <span>Layouts</span>
                            </a>

                            <ul class="submenu ">

                                <li class="submenu-item  ">
                                    <a href="layout-default.html" class="submenu-link">Default Layout</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="layout-vertical-1-column.html" class="submenu-link">1 Column</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="layout-vertical-navbar.html" class="submenu-link">Vertical Navbar</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="layout-rtl.html" class="submenu-link">RTL Layout</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="layout-horizontal.html" class="submenu-link">Horizontal Menu</a>

                                </li>

                            </ul>


                        </li>

                        <li class="sidebar-title">อื่นๆ</li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="	fas fa-cog"></i>
                                <span>ตั้งค่า</span>
                            </a>

                            <ul class="submenu ">

                                <li class="submenu-item  ">
                                    <a href="form-element-input.html" class="submenu-link">Input</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="form-element-input-group.html" class="submenu-link">Input Group</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="form-element-select.html" class="submenu-link">Select</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="form-element-radio.html" class="submenu-link">Radio</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="form-element-checkbox.html" class="submenu-link">Checkbox</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="form-element-textarea.html" class="submenu-link">Textarea</a>

                                </li>


                            </ul>


                        <li class="sidebar-item activee ">
                            <a href="logout.php" class='sidebar-link'>
                                <i class="	fas fa-power-off"></i>
                                <span>ออกจากระบบ</span>
                            </a>


                        </li>




                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="container my-5">
                <div class="form-container">
                    <h2 class="text-center mb-4">แก้ไขข้อมูลการลา</h2>
                    <form action="edit_vacation.php?vacation_id=<?= $vacation['vacation_id'] ?>" method="POST">
                        <input type="hidden" name="vacation_id" value="<?= $vacation['vacation_id'] ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="vacation_date" class="form-label">วันที่ปัจจุบัน:</label>
                                <input type="text" class="form-control" id="vacation_date" name="vacation_date"
                                    value="<?= htmlspecialchars($vacation['vacation_date']) ?>" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="typeVacation_id" class="form-label">ประเภทการลา:</label>
                                <select class="form-select" id="typeVacation_id" name="typeVacation_id" required>
                                    <option value="1" <?= $vacation['typeVacation_id'] == 1 ? 'selected' : '' ?>>ลาพักผ่อน
                                    </option>
                                    <option value="2" <?= $vacation['typeVacation_id'] == 2 ? 'selected' : '' ?>>ลาป่วย
                                    </option>
                                    <option value="3" <?= $vacation['typeVacation_id'] == 3 ? 'selected' : '' ?>>ลาคลอดบุตร
                                    </option>
                                    <option value="4" <?= $vacation['typeVacation_id'] == 4 ? 'selected' : '' ?>>
                                        ลากิจส่วนตัว</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="vacation_name" class="form-label">ชื่อ-สกุล:</label>
                                <input type="text" class="form-control" id="vacation_name" name="vacation_name"
                                    value="<?= htmlspecialchars($vacation['vacation_name']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label for="vacation_rank" class="form-label">ตำแหน่ง:</label>
                                <input type="text" class="form-control" id="vacation_rank" name="vacation_rank"
                                    value="<?= htmlspecialchars($vacation['vacation_rank']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label for="vacation_accumulateDay" class="form-label">วันพักผ่อนสะสม:</label>
                                <input type="number" class="form-control" id="vacation_accumulateDay"
                                    name="vacation_accumulateDay" value="<?= $vacation['vacation_accumulateDay'] ?>"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label for="vacation_rightsDay" class="form-label">สิทธิวันพักผ่อนประจำปี:</label>
                                <input type="number" class="form-control" id="vacation_rightsDay"
                                    name="vacation_rightsDay" value="<?= $vacation['vacation_rightsDay'] ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label for="vacation_sumDay" class="form-label">รวมเป็นกี่วัน:</label>
                                <input type="number" class="form-control" id="vacation_sumDay" name="vacation_sumDay"
                                    value="<?= $vacation['vacation_sumDay'] ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label for="vacation_since" class="form-label">ตั้งแต่วันที่:</label>
                                <input type="text" class="form-control" id="vacation_since" name="vacation_since"
                                    value="<?= htmlspecialchars($vacation['vacation_since']) ?>"
                                    placeholder="เลือกช่วงวันที่" required>
                            </div>

                            <div class="col-md-6">
                                <label for="vacation_numPhone" class="form-label">เบอร์โทรศัพท์:</label>
                                <input type="text" class="form-control" id="vacation_numPhone" name="vacation_numPhone"
                                    value="<?= $vacation['vacation_numPhone'] ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">ระดับข้าราชการ:</label>
                                <select name="vacation_level" class="form-select" required>
                                    <option value="">เลือกระดับ</option>
                                    <option value="ระดับทักษะพิเศษ" <?php if ($vacation['vacation_level'] == 'ระดับทักษะพิเศษ')
                                        echo 'selected'; ?>>
                                        ระดับทักษะพิเศษ</option>
                                    <option value="ระดับอาวุโส" <?php if ($vacation['vacation_level'] == 'ระดับอาวุโส')
                                        echo 'selected'; ?>>ระดับอาวุโส</option>
                                    <option value="ระดับชำนาญงาน" <?php if ($vacation['vacation_level'] == 'ระดับชำนาญงาน')
                                        echo 'selected'; ?>>
                                        ระดับชำนาญงาน</option>
                                    <option value="ระดับปฏิบัติงาน" <?php if ($vacation['vacation_level'] == 'ระดับปฏิบัติงาน')
                                        echo 'selected'; ?>>
                                        ระดับปฏิบัติงาน</option>
                                    <option value="พลเรือน (ประเภทวิชาการ)" <?php if ($vacation['vacation_level'] == 'พลเรือน (ประเภทวิชาการ)')
                                        echo 'selected'; ?>>
                                        พลเรือน (ประเภทวิชาการ)</option>
                                    <option value="ระดับเชี่ยวชาญ" <?php if ($vacation['vacation_level'] == 'ระดับเชี่ยวชาญ')
                                        echo 'selected'; ?>>
                                        ระดับเชี่ยวชาญ</option>
                                    <option value="ระดับชำนาญการพิเศษ" <?php if ($vacation['vacation_level'] == 'ระดับชำนาญการพิเศษ')
                                        echo 'selected'; ?>>
                                        ระดับชำนาญการพิเศษ</option>
                                    <option value="ระดับชำนาญการ" <?php if ($vacation['vacation_level'] == 'ระดับชำนาญการ')
                                        echo 'selected'; ?>>
                                        ระดับชำนาญการ</option>
                                    <option value="ระดับปฏิบัติการ" <?php if ($vacation['vacation_level'] == 'ระดับปฏิบัติการ')
                                        echo 'selected'; ?>>
                                        ระดับปฏิบัติการ</option>
                                </select>
                            </div>


                            <div class="col-md-12">
                                <label for="vacation_formwork" class="form-label">ปฏิบัติการที่:</label>
                                <select class="form-select" id="vacation_formwork" name="vacation_formwork" required>
                                    <option value="">เลือกปฏิบัติการ</option>
                                    <?php
                                    $work_group_sql = "SELECT group_id, group_name FROM work_group";
                                    $work_group_result = $conn->query($work_group_sql);
                                    while ($row = $work_group_result->fetch_assoc()): ?>
                                        <option value="<?= htmlspecialchars($row['group_id']) ?>"
                                            <?= $vacation['vacation_formwork'] == $row['group_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($row['group_name']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success">บันทึกการแก้ไข</button>
                            <a href="Show_leave.php" class="btn btn-secondary">ยกเลิก</a>
                        </div>
                    </form>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        <script src="assets/static/js/components/dark.js"></script>
        <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="assets/compiled/js/app.js"></script>
        <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
        <script src="assets/static/js/pages/dashboard.js"></script>

</body>

</html>