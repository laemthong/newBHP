<?php
session_start();
include 'connect/connection.php';
$userName = $_SESSION['user_name'] ?? 'Guest'; // ให้ชื่อผู้ใช้แสดงใน navbar

$success_message = $_SESSION['success'] ?? null;
$error_message = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']); // ล้างข้อความหลังแสดงแล้ว

$sql = "SELECT group_id, group_name FROM work_group";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ban Phai Hospital</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="photo/รพ.png" type="image/png">
    <link rel="icon" href="photo/รพ.png" type="image/png">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        .sidebar-item.activee {
            background-color: transparent;
            /* ลบสีพื้นหลัง */
            color: inherit;
            /* ใช้สีของข้อความตามสีพื้นฐาน */
            box-shadow: none;
            /* ลบเงาของปุ่ม */
        }

        .sidebar-item.activee a {
            color: inherit;
            /* ใช้สีของข้อความตามสีพื้นฐาน */
        }

        /* ปรับรูปแบบของการอัปโหลดไฟล์ */
        .form-group {
            margin-bottom: 20px;
            /* เพิ่มระยะห่างจากด้านล่าง */
        }

        .form-group label {
            font-weight: bold;
            /* ทำให้ข้อความของ label หนา */
            margin-bottom: 10px;
            /* เพิ่มระยะห่างด้านล่าง */
            display: block;
            /* ทำให้ label อยู่ในบรรทัดใหม่ */
            font-size: 16px;
            color: #333;
        }

        .form-group input[type="file"] {
            display: block;
            /* ทำให้ input อยู่ในบรรทัดใหม่ */
            width: 100%;
            /* ขยายปุ่มให้เต็มความกว้างของ container */
            padding: 10px;
            font-size: 14px;
            color: #555;
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
        }

        /* เพิ่มสไตล์เมื่อ hover หรือมีการเลือกไฟล์ */
        .form-group input[type="file"]:hover {
            background-color: #f1f1f1;
        }

        .form-group input[type="file"]:focus {
            outline: none;
            border-color: #007bff;
            /* สีของขอบเมื่อโฟกัส */
        }

        /* สำหรับการแสดงปุ่มที่เลือกไฟล์ */
        .form-group .custom-file-label {
            padding: 10px;
            font-size: 14px;
            color: #555;
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

            <body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="container mt-4" style="max-width: 800px;">
                    <h2 class="text-center .text-secondary mb-4">ระบบบันทึกข้อมูลบุคลากร</h2>
                    <form id="personnelForm" action="save_personnel.php" method="POST" enctype="multipart/form-data"
                        onsubmit="return validateForm()">


                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label"><span class="text-danger">*</span> ชื่อ - สกุล:</label>
                                <input type="text" name="person_name" class="form-control" maxlength="255"
                                    placeholder="กรอกชื่อ - สกุล" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><span class="text-danger">*</span> หมายเลขบัตรประชาชน 13
                                    หลัก:</label>
                                <input type="number" name="person_id" class="form-control" placeholder="กรอกหมายเลขบัตรประชาชน 13
                                    หลัก" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">ตำแหน่ง:</label>
                                <input type="text" name="person_rank" class="form-control" maxlength="255"
                                    placeholder="กรอกตำแหน่ง" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">ระดับ:</label>
                                <select name="person_level" class="form-select" required>
                                    <option value="">เลือกระดับ</option>
                                    <option value="ระดับทักษะพิเศษ">ระดับทักษะพิเศษ</option>
                                    <option value="ระดับอาวุโส">ระดับอาวุโส</option>
                                    <option value="ระดับชำนาญงาน">ระดับชำนาญงาน</option>
                                    <option value="ระดับปฏิบัติงาน">ระดับปฏิบัติงาน</option>
                                    <option value="พลเรือน (ประเภทวิชาการ)">พลเรือน (ประเภทวิชาการ)</option>
                                    <option value="ระดับเชี่ยวชาญ">ระดับเชี่ยวชาญ</option>
                                    <option value="ระดับชำนาญการพิเศษ">ระดับชำนาญการพิเศษ</option>
                                    <option value="ระดับชำนาญการ">ระดับชำนาญการ</option>
                                    <option value="ระดับปฏิบัติการ">ระดับปฏิบัติการ</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><span class="text-danger">*</span> เลข จ.18:</label>
                                <input type="text" name="person_DocNumber" class="form-control" maxlength="255"
                                    placeholder="กรอกเลขจ.18" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">ปฎิบัติงานจริง:</label>
                                <select name="person_formwork" class="form-select" required>
                                    <option value="">เลือกกลุ่มงานที่ปฏิบัติงาน</option>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        // วนลูปเพื่อสร้าง option
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row["group_id"] . '">' . $row["group_name"] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">ไม่มีข้อมูล</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">ประเภทการจ้าง:</label>
                                <select name="person_typeHire" class="form-select" required>
                                    <option value="">เลือกประเภทการจ้าง</option>
                                    <option value="ข้าราชการ">ข้าราชการ</option>
                                    <option value="จ้างเหมาบริการ">จ้างเหมาบริการ</option>
                                    <option value="จ้างเหมาบุคคล">จ้างเหมาบุคคล</option>
                                    <option value="พนักงานกระทรวง">พนักงานกระทรวง</option>
                                    <option value="พนักงานราชการ">พนักงานราชการ</option>
                                    <option value="ลูกจ้างชั่วคราว (รายเดือน)">ลูกจ้างชั่วคราว (รายเดือน)</option>
                                    <option value="ลูกจ้างชั่วคราวรายวัน">ลูกจ้างชั่วคราวรายวัน</option>
                                    <option value="ลูกจ้างประจำ">ลูกจ้างประจำ</option>
                                    <option value="ลูกจ้างรายคาบ">ลูกจ้างรายคาบ</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">เบอร์โทรศัพท์:</label>
                                <input type="tel" name="person_phone" class="form-control" pattern="[0-9]{10}"
                                    title="กรุณากรอกหมายเลขโทรศัพท์ 10 หลัก" placeholder="กรอกเบอร์โทรศัพท์" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><span class="text-danger">*</span>
                                    เลขที่ประกอบใบประกอบวิชาชีพ:</label>
                                <input type="text" name="person_SuppNumber" class="form-control" maxlength="255"
                                    placeholder="กรอกเลขที่ใบประกอบวิชาชีพ" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">วุฒิเฉพาะทาง:</label>
                                <input type="text" name="person_specialQualification" class="form-control"
                                    maxlength="255" placeholder="กรอกวุฒิพิเศษทางการ" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">วันที่บรรจุ:</label>
                                <div class="d-flex gap-2">
                                    <!-- ช่องเลือกวันที่ -->
                                    <select name="accept_day" class="form-select" required>
                                        <option value="">วัน</option>
                                        <?php for ($i = 1; $i <= 31; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>

                                    <!-- ช่องเลือกเดือน -->
                                    <select name="accept_month" class="form-select" required>
                                        <option value="">เดือน</option>
                                        <?php
                                        $months = [
                                            "มกราคม",
                                            "กุมภาพันธ์",
                                            "มีนาคม",
                                            "เมษายน",
                                            "พฤษภาคม",
                                            "มิถุนายน",
                                            "กรกฎาคม",
                                            "สิงหาคม",
                                            "กันยายน",
                                            "ตุลาคม",
                                            "พฤศจิกายน",
                                            "ธันวาคม"
                                        ];
                                        foreach ($months as $key => $month): ?>
                                            <option value="<?= $key + 1 ?>"><?= $month ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <!-- ช่องเลือกปี -->
                                    <select name="accept_year" class="form-select" required>
                                        <option value="">ปี</option>
                                        <?php for ($i = date("Y") + 543; $i >= 2500; $i--): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6"> <!-- แก้ไขเป็นอายุราชการระบบคำนวณด้วย -->
                                <label class="form-label">อายุราชการ:</label>
                                <input type="text" name="service_at_retirement" class="form-control" maxlength="255"
                                    placeholder="กรอกวัน/เดือน/ปีเกิด และ วันบรรรจุเพื่อมาคำนวณ" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">เงินเดือน:</label>
                                <input type="number" name="person_salary" class="form-control" step="0.01"
                                    placeholder="กรอกเงินเดือน" required>
                            </div>

                            <div class="col-md-6"> <!-- แก้ไขเป็นปีครบเกษียณระบบคำนวณด้วย -->
                                <label class="form-label">ปีครบเกษียณ:</label>
                                <input type="text" name="retirement_date" class="form-control"
                                    placeholder="กรอกวัน/เดือน/ปีเกิด และ วันบรรรจุเพื่อมาคำนวณ" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">เงินประจำตำแหน่ง:</label>
                                <input type="number" name="person_positionAllowance" class="form-control" step="0.01"
                                    placeholder="กรอกเงินประจำตำแหน่ง" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">เลขสมาชิก พอ.ส.ว. :</label>
                                <input type="text" name="person_POSVNumber" class="form-control" maxlength="255"
                                    placeholder="กรอกเลขสมาชิก พอ.ส.ว." required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">วันเดือนปีเกิด:</label>
                                <div class="d-flex gap-2">
                                    <!-- ช่องเลือกวันที่ -->
                                    <select name="day" class="form-select" " required>
                                        <option value="">วัน</option>
                                        <?php for ($i = 1; $i <= 31; $i++): ?>
                                                                                        <option value=" <?= $i ?>"><?= $i ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>

                                    <!-- ช่องเลือกเดือน -->
                                    <select name="month" class="form-select" required>
                                        <option value="">เดือน</option>
                                        <?php
                                        $months = [
                                            "มกราคม",
                                            "กุมภาพันธ์",
                                            "มีนาคม",
                                            "เมษายน",
                                            "พฤษภาคม",
                                            "มิถุนายน",
                                            "กรกฎาคม",
                                            "สิงหาคม",
                                            "กันยายน",
                                            "ตุลาคม",
                                            "พฤศจิกายน",
                                            "ธันวาคม"
                                        ];
                                        foreach ($months as $key => $month): ?>
                                            <option value="<?= $key + 1 ?>"><?= $month ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <!-- ช่องเลือกปี -->
                                    <select name="year" class="form-select" required>
                                        <option value="">ปี</option>
                                        <?php for ($i = date("Y") + 543; $i >= 2500; $i--): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">อายุ:</label>
                                <input type="text" name="age" class="form-control" maxlength="255"
                                    placeholder="กรอกวัน/เดือน/ปีเกิด และ วันบรรรจุเพื่อมาคำนวณ" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><span class="text-danger">*</span> เพศ:</label>
                                <select name="person_gender" class="form-select" required>
                                    <option value="">เลือกเพศ</option>
                                    <option value="ชาย">ชาย</option>
                                    <option value="หญิง">หญิง</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">ชื่อเล่น:</label>
                                <input type="text" name="person_nickname" class="form-control" maxlength="255"
                                    placeholder="กรอกชื่อเล่น" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">เลขที่บัตรข้าราชการ:</label>
                                <input type="text" name="person_cardNum" class="form-control" maxlength="255"
                                    placeholder="กรอกเลขที่บัตรข้าราชการ">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">วันที่หมดอายุบัตรราชการ:</label>
                                <div class="d-flex gap-2">
                                    <!-- ช่องเลือกวันที่ -->
                                    <select name="Expired_day" class="form-select" >
                                        <option value="">วัน</option>
                                        <?php for ($i = 1; $i <= 31; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>

                                    <!-- ช่องเลือกเดือน -->
                                    <select name="Expired_month" class="form-select" >
                                        <option value="">เดือน</option>
                                        <?php
                                        $months = [
                                            "มกราคม",
                                            "กุมภาพันธ์",
                                            "มีนาคม",
                                            "เมษายน",
                                            "พฤษภาคม",
                                            "มิถุนายน",
                                            "กรกฎาคม",
                                            "สิงหาคม",
                                            "กันยายน",
                                            "ตุลาคม",
                                            "พฤศจิกายน",
                                            "ธันวาคม"
                                        ];
                                        foreach ($months as $key => $month): ?>
                                            <option value="<?= $key + 1 ?>"><?= $month ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <select name="Expired_year" class="form-select" >
                                        <option value="">ปี</option>
                                        <?php
                                        $currentYear = date("Y") + 543; // ปีปัจจุบันในรูปแบบ พ.ศ.
                                        for ($i = $currentYear; $i <= $currentYear + 60; $i++): // เริ่มจากปีปัจจุบัน + 60 ปี
                                            ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">ประเภทการจ้าง:</label>
                                <select name="person_status" class="form-select" required>
                                    <option value="ปกติ">ปกติ</option>
                                    <option value="ออก">ออก</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">หมายเหตุ:</label>
                                <input type="text" name="person_note" class="form-control" maxlength="255"
                                    placeholder="กรุณาเพิ่มหมายเหตุ" required>
                            </div>

                            <button type="submit" class="btn btn-success mt-4 w-100">บันทึกข้อมูล</button>
                    </form>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                <script>
                    // ฟังก์ชันสำหรับตรวจสอบความถูกต้องของฟอร์ม
                    function validateForm() {
                        const form = document.getElementById('personnelForm');
                        let isValid = true;

                        // ตรวจสอบวันที่
                        const dateFields = ['person_born', 'person_dateAccepting', 'person_CardExpired'];
                        dateFields.forEach(fieldName => {
                            const field = form[fieldName];
                            if (field && field.value) {
                                const date = new Date(field.value);
                                if (isNaN(date.getTime())) {
                                    alert(`กรุณากรอก ${field.previousElementSibling.textContent.replace(':', '')} ให้ถูกต้อง`);
                                    isValid = false;
                                }
                            }
                        });

                        // ตรวจสอบเบอร์โทรศัพท์
                        const phone = form['person_phone'];
                        if (phone && phone.value && !/^\d{10}$/.test(phone.value)) {
                            alert('กรุณากรอกเบอร์โทรศัพท์ 10 หลัก');
                            isValid = false;
                        }

                        return isValid;
                    }

                  


                    document.addEventListener('DOMContentLoaded', function () {
                        const form = document.getElementById('personnelForm');

                        form.addEventListener('submit', function (event) {
                            event.preventDefault(); // หยุดการส่งฟอร์มแบบปกติ

                            if (!validateForm()) {
                                // หยุดการทำงานถ้าฟอร์มไม่ผ่านการตรวจสอบ
                                return;
                            }

                            Swal.fire({
                                title: 'คุณต้องการบันทึกข้อมูลหรือไม่?',
                                text: "กรุณาตรวจสอบข้อมูลก่อนยืนยัน",
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'ใช่, บันทึกเลย!',
                                cancelButtonText: 'ยกเลิก'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // หลังจากกด "ใช่, บันทึกเลย!" ให้แสดงข้อความสำเร็จ
                                    Swal.fire({
                                        title: 'บันทึกข้อมูลสำเร็จ',
                                        text: "ข้อมูลของคุณถูกบันทึกเรียบร้อยแล้ว",
                                        icon: 'success',
                                        confirmButtonText: 'ตกลง'
                                    }).then(() => {
                                        // หลังจากกด "ตกลง" ให้ทำการส่งฟอร์ม
                                        form.submit();
                                    });
                                } else {
                                    console.log('การบันทึกถูกยกเลิก');
                                }
                            });
                        });
                    });
                    document.addEventListener('DOMContentLoaded', function () {
                        // Flatpickr สำหรับวันเดือนปีเกิด
                        flatpickr("#dateBornPicker", {
                            altInput: true,
                            altFormat: "j F Y",
                            dateFormat: "Y-m-d",
                            locale: "th", // ใช้ภาษาไทย
                        });

                        // Flatpickr สำหรับวันที่บรรจุ
                        flatpickr("#dateAcceptingPicker", {
                            altInput: true,
                            altFormat: "j F Y",
                            dateFormat: "Y-m-d",
                            locale: "th", // ใช้ภาษาไทย
                        });
                    });
                    document.addEventListener('DOMContentLoaded', function () {
                        // อ้างอิงถึงฟิลด์
                        const dayField = document.querySelector('select[name="day"]');
                        const monthField = document.querySelector('select[name="month"]');
                        const yearField = document.querySelector('select[name="year"]');
                        const acceptDayField = document.querySelector('select[name="accept_day"]');
                        const acceptMonthField = document.querySelector('select[name="accept_month"]');
                        const acceptYearField = document.querySelector('select[name="accept_year"]');

                        const ageField = document.querySelector('input[name="age"]');
                        const retirementDateField = document.querySelector('input[name="retirement_date"]');
                        const serviceAtRetirementField = document.querySelector('input[name="service_at_retirement"]');
                        const serviceRemainingField = document.querySelector('input[name="service_remaining"]');

                        // คำนวณอายุ และอายุราชการที่เหลือ
                        function calculateDetails() {
                            const currentDate = new Date(); // วันที่ปัจจุบัน

                            // รับค่าจากฟิลด์วันเดือนปีเกิด
                            const birthDay = parseInt(dayField.value);
                            const birthMonth = parseInt(monthField.value) - 1; // เดือนใน JavaScript เริ่มต้นที่ 0
                            const birthYear = parseInt(yearField.value);

                            // รับค่าจากฟิลด์วันที่บรรจุ
                            const acceptDay = parseInt(acceptDayField.value);
                            const acceptMonth = parseInt(acceptMonthField.value) - 1; // เดือนใน JavaScript เริ่มต้นที่ 0
                            const acceptYear = parseInt(acceptYearField.value);

                            // ตรวจสอบค่าที่ได้จากฟิลด์
                            if (isNaN(birthDay) || isNaN(birthMonth) || isNaN(birthYear) ||
                                isNaN(acceptDay) || isNaN(acceptMonth) || isNaN(acceptYear)) {
                                console.error("ค่าที่รับมาไม่ถูกต้อง:", {
                                    birthDay,
                                    birthMonth,
                                    birthYear,
                                    acceptDay,
                                    acceptMonth,
                                    acceptYear
                                });
                                return;
                            }

                            const birthDate = new Date(birthYear - 543, birthMonth, birthDay);
                            const acceptDate = new Date(acceptYear - 543, acceptMonth, acceptDay);

                            // คำนวณอายุปัจจุบัน
                            const age = calculateAge(birthDate, currentDate);

                            // คำนวณอายุราชการจากวันที่บรรจุถึงวันนี้
                            const serviceAtRetirement = calculateAge(acceptDate, currentDate);  // เปลี่ยนให้คำนวณถึงวันนี้

                            // คำนวณปีเกษียณ
                            let retirementYear = (birthYear - 543) + 60; // ใช้ birthYear - 543 เพื่อลบออกและใช้ ค.ศ.
                            if (birthMonth >= 9) {  // ถ้าเกิดตั้งแต่ตุลาคมถึงธันวาคม
                                retirementYear += 1; // บวกเพิ่มอีก 1 ปี
                            }

                            const retirementDate = new Date(retirementYear, birthMonth, birthDay);

                            // อัปเดตค่าลงในฟิลด์
                            ageField.value = `${age.years} ปี ${age.months} เดือน ${age.days} วัน`;
                            retirementDateField.value = `${retirementDate.getFullYear() + 543}`; // แสดงปีเกษียณในรูปแบบ พ.ศ.

                            // แสดงแค่ปีที่บรรจุ
                            serviceAtRetirementField.value = formatServiceTime(serviceAtRetirement);
                        }

                        // ฟังก์ชันคำนวณอายุจากวันที่เกิดและวันที่เป้าหมาย
                        function calculateAge(birthDate, currentDate) {
                            let years = currentDate.getFullYear() - birthDate.getFullYear();
                            let months = currentDate.getMonth() - birthDate.getMonth();
                            let days = currentDate.getDate() - birthDate.getDate();

                            // ปรับเดือนและปี
                            if (months < 0) {
                                years--;
                                months += 12;
                            }
                            if (days < 0) {
                                months--;
                                days += new Date(currentDate.getFullYear(), currentDate.getMonth(), 0).getDate(); // หาจำนวนวันในเดือน
                            }

                            return { years, months, days };
                        }

                        // ฟังก์ชันจัดรูปแบบอายุราชการให้แสดงผลเป็น yy/mm/dd
                        function formatServiceTime(serviceTime) {
                            return `${serviceTime.years} ปี ${serviceTime.months} เดือน ${serviceTime.days} วัน`;
                        }

                        // เรียกใช้งานคำนวณเมื่อฟิลด์เปลี่ยนแปลง
                        dayField.addEventListener('change', calculateDetails);
                        monthField.addEventListener('change', calculateDetails);
                        yearField.addEventListener('change', calculateDetails);
                        acceptDayField.addEventListener('change', calculateDetails);
                        acceptMonthField.addEventListener('change', calculateDetails);
                        acceptYearField.addEventListener('change', calculateDetails);


                        // ฟังก์ชันคำนวณช่วงเวลา
                        function calculateAge(startDate, endDate) {
                            const years = endDate.getFullYear() - startDate.getFullYear();
                            const months = endDate.getMonth() - startDate.getMonth();
                            const days = endDate.getDate() - startDate.getDate();

                            let calculatedYears = years;
                            let calculatedMonths = months;
                            let calculatedDays = days;

                            if (calculatedDays < 0) {
                                calculatedMonths--;
                                calculatedDays += 31; // ประมาณจำนวนวันในเดือน
                            }
                            if (calculatedMonths < 0) {
                                calculatedYears--;
                                calculatedMonths += 12;
                            }

                            return {
                                years: calculatedYears,
                                months: calculatedMonths,
                                days: calculatedDays
                            };
                        }

                        // เพิ่ม Event Listener
                        dayField.addEventListener('change', calculateDetails);
                        monthField.addEventListener('change', calculateDetails);
                        yearField.addEventListener('change', calculateDetails);
                        acceptDayField.addEventListener('change', calculateDetails);
                        acceptMonthField.addEventListener('change', calculateDetails);
                        acceptYearField.addEventListener('change', calculateDetails);
                    });
                </script>



            </body>


            <script src="assets/static/js/components/dark.js"></script>
            <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>


            <script src="assets/compiled/js/app.js"></script>



</body>

</html>