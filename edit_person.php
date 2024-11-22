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
    if ($result && $result->num_rows > 0) {
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
    $formwork = isset($_POST['person_formwork']) ? $_POST['person_formwork'] : ''; // ตรวจสอบ key
    $level = $_POST['person_level'];
    $salary = $_POST['person_salary'];
    $nickname = $_POST['person_nickname'];

    // รวมค่าวันเดือนปีเกิด
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $born = ($year - 543) . "-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);

    // รวมค่าวันที่บรรจุ
    $accept_day = $_POST['accept_day'];
    $accept_month = $_POST['accept_month'];
    $accept_year = $_POST['accept_year'];
    $dateAccepting = ($accept_year - 543) . "-" . str_pad($accept_month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($accept_day, 2, '0', STR_PAD_LEFT);

    $typeHire = $_POST['person_typeHire'];
    $positionAllowance = $_POST['person_positionAllowance'];
    $phone = $_POST['person_phone'];
    $specialQualification = $_POST['person_specialQualification'];
    $blood = $_POST['person_blood'];
    $cardNum = $_POST['person_cardNum'];

    // รวมค่าของวันที่หมดอายุบัตรราชการ
    $Expired_day = $_POST['Expired_day'];
    $Expired_month = $_POST['Expired_month'];
    $Expired_year = $_POST['Expired_year'];
    $cardExpired = ($Expired_year - 543) . "-" . str_pad($Expired_month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($Expired_day, 2, '0', STR_PAD_LEFT);

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
                person_dateAccepting = '$dateAccepting', 
                person_typeHire = '$typeHire', 
                person_positionAllowance = '$positionAllowance', 
                person_phone = '$phone', 
                person_specialQualification = '$specialQualification', 
                person_blood = '$blood', 
                person_cardNum = '$cardNum', 
                person_CardExpired = '$cardExpired'
            WHERE person_id = $person_id";

    if ($conn->query($sql) === TRUE) {
        echo "แก้ไขข้อมูลสำเร็จ";
        header("Location: personnel.php");
        exit();
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
    <title>Ban Phai Hospital</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="photo/รพ.png" type="image/png">
    <link rel="icon" href="photo/รพ.png" type="image/png">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css">
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
                                    <a href="personnel_edit.php" class="submenu-link">เพิ่ม / ลบ / แก้ไข </a>

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
                                    <a href="vacation_leave.php" class="submenu-link">ลาพักผ่อน</a>

                                </li>

                                <li class="submenu-item  ">
                                    <a href="extra-component-divider.html" class="submenu-link">ลาป่วย</a>

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
            <script>
                document.addEventListener('DOMContentLoaded', function() {
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
                        const retirementAge = 60; // กำหนดอายุเกษียณราชการ
                        const currentDate = new Date(); // วันที่ปัจจุบัน

                        // รับค่าจากฟิลด์วันเดือนปีเกิด
                        const birthDay = parseInt(dayField.value) || 1; // ถ้าไม่มีค่าให้ใช้ค่าเริ่มต้น
                        const birthMonth = (parseInt(monthField.value) || 1) - 1; // เดือนใน JavaScript เริ่มต้นที่ 0
                        const birthYear = parseInt(yearField.value) || (new Date().getFullYear() + 543); // ใช้ปีปัจจุบันถ้าไม่มีค่า

                        // รับค่าจากฟิลด์วันที่บรรจุ
                        const acceptDay = parseInt(acceptDayField.value) || 1;
                        const acceptMonth = (parseInt(acceptMonthField.value) || 1) - 1;
                        const acceptYear = parseInt(acceptYearField.value) || (new Date().getFullYear() + 543);

                        // ตั้งค่าเริ่มต้นให้กับ select fields ถ้ายังไม่มีค่า
                        if (!dayField.value) dayField.value = '1';
                        if (!monthField.value) monthField.value = '1';
                        if (!yearField.value) yearField.value = (new Date().getFullYear() + 543).toString();
                        if (!acceptDayField.value) acceptDayField.value = '1';
                        if (!acceptMonthField.value) acceptMonthField.value = '1';
                        if (!acceptYearField.value) acceptYearField.value = (new Date().getFullYear() + 543).toString();

                        const birthDate = new Date(birthYear - 543, birthMonth, birthDay);
                        const acceptDate = new Date(acceptYear - 543, acceptMonth, acceptDay);
                        const retirementDate = new Date(birthYear - 543 + retirementAge, 9, 30); // เกษียณ 30 กันยายน

                        // คำนวณอายุปัจจุบัน
                        const age = calculateAge(birthDate, currentDate);

                        // คำนวณอายุราชการในวันเกษียณ
                        const serviceAtRetirement = calculateAge(acceptDate, retirementDate);

                        // คำนวณอายุราชการที่เหลือ
                        const serviceRemaining = calculateAge(currentDate, retirementDate);

                        // อัปเดตค่าลงในฟิลด์
                        if (ageField) ageField.value = `${age.years} ปี ${age.months} เดือน ${age.days} วัน`;
                        if (retirementDateField) retirementDateField.value = `${retirementDate.getDate()} ตุลาคม ${retirementDate.getFullYear() + 543}`;
                        if (serviceAtRetirementField) serviceAtRetirementField.value = `${serviceAtRetirement.years} ปี ${serviceAtRetirement.months} เดือน ${serviceAtRetirement.days} วัน`;
                        if (serviceRemainingField) serviceRemainingField.value = `${serviceRemaining.years} ปี ${serviceRemaining.months} เดือน ${serviceRemaining.days} วัน`;
                    }

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

                    // เรียกใช้ฟังก์ชันคำนวณทันทีที่โหลดหน้า
                    calculateDetails();

                    // เพิ่ม Event Listener สำหรับการเปลี่ยนแปลงค่า
                    dayField?.addEventListener('change', calculateDetails);
                    monthField?.addEventListener('change', calculateDetails);
                    yearField?.addEventListener('change', calculateDetails);
                    acceptDayField?.addEventListener('change', calculateDetails);
                    acceptMonthField?.addEventListener('change', calculateDetails);
                    acceptYearField?.addEventListener('change', calculateDetails);
                });
            </script>


            <body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="container my-5 d-flex justify-content-center">
                    <div style="max-width: 600px; width: 100%;">
                        <h2 class="text-center mb-4">แก้ไขข้อมูลบุคคล</h2>
                        <form action="edit_person.php" method="post">
                            <input type="hidden" name="person_id" value="<?php echo $row['person_id']; ?>">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="person_name" class="form-label">ชื่อ-สกุล</label>
                                    <input type="text" class="form-control" id="person_name" name="person_name"
                                        value="<?php echo $row['person_name']; ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"><span class="text-danger">*</span> เพศ:</label>
                                    <select name="person_gender" class="form-select" required>
                                        <option value="">เลือกเพศ</option>
                                        <option value="ชาย" <?php if ($row['person_gender'] == 'ชาย')
                                                                echo 'selected'; ?>>ชาย</option>
                                        <option value="หญิง" <?php if ($row['person_gender'] == 'หญิง')
                                                                    echo 'selected'; ?>>หญิง</option>
                                        <option value="อื่นๆ" <?php if ($row['person_gender'] == 'อื่นๆ')
                                                                    echo 'selected'; ?>>อื่นๆ</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="person_rank" class="form-label">ตำแหน่ง</label>
                                    <input type="text" class="form-control" id="person_rank" name="person_rank"
                                        value="<?php echo $row['person_rank']; ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">ประเภทการจ้าง:</label>
                                    <select name="person_typeHire" class="form-select" required>
                                        <option value="">เลือกประเภทการจ้าง</option>
                                        <option value="ข้าราชการ" <?php if ($row['person_typeHire'] == 'ข้าราชการ')
                                                                        echo 'selected'; ?>>ข้าราชการ</option>
                                        <option value="จ้างเหมาบริการ" <?php if ($row['person_typeHire'] == 'จ้างเหมาบริการ')
                                                                            echo 'selected'; ?>>
                                            จ้างเหมาบริการ</option>
                                        <option value="จ้างเหมาบุคคล" <?php if ($row['person_typeHire'] == 'จ้างเหมาบุคคล')
                                                                            echo 'selected'; ?>>
                                            จ้างเหมาบุคคล</option>
                                        <option value="พนักงานกระทรวง" <?php if ($row['person_typeHire'] == 'พนักงานกระทรวง')
                                                                            echo 'selected'; ?>>
                                            พนักงานกระทรวง</option>
                                        <option value="พนักงานราชการ" <?php if ($row['person_typeHire'] == 'พนักงานราชการ')
                                                                            echo 'selected'; ?>>
                                            พนักงานราชการ</option>
                                        <option value="ลูกจ้างชั่วคราว (รายเดือน)" <?php if ($row['person_typeHire'] == 'ลูกจ้างชั่วคราว (รายเดือน)')
                                                                                        echo 'selected'; ?>>ลูกจ้างชั่วคราว (รายเดือน)</option>
                                        <option value="ลูกจ้างชั่วคราวรายวัน" <?php if ($row['person_typeHire'] == 'ลูกจ้างชั่วคราวรายวัน')
                                                                                    echo 'selected'; ?>>
                                            ลูกจ้างชั่วคราวรายวัน</option>
                                        <option value="ลูกจ้างประจำ" <?php if ($row['person_typeHire'] == 'ลูกจ้างประจำ')
                                                                            echo 'selected'; ?>>
                                            ลูกจ้างประจำ</option>
                                        <option value="ลูกจ้างรายคาบ" <?php if ($row['person_typeHire'] == 'ลูกจ้างรายคาบ')
                                                                            echo 'selected'; ?>>
                                            ลูกจ้างรายคาบ</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">ระดับข้าราชการ:</label>
                                    <select name="person_level" class="form-select" required>
                                        <option value="">เลือกระดับ</option>
                                        <option value="ระดับทักษะพิเศษ" <?php if ($row['person_level'] == 'ระดับทักษะพิเศษ')
                                                                            echo 'selected'; ?>>
                                            ระดับทักษะพิเศษ</option>
                                        <option value="ระดับอาวุโส" <?php if ($row['person_level'] == 'ระดับอาวุโส')
                                                                        echo 'selected'; ?>>ระดับอาวุโส</option>
                                        <option value="ระดับชำนาญงาน" <?php if ($row['person_level'] == 'ระดับชำนาญงาน')
                                                                            echo 'selected'; ?>>
                                            ระดับชำนาญงาน</option>
                                        <option value="ระดับปฏิบัติงาน" <?php if ($row['person_level'] == 'ระดับปฏิบัติงาน')
                                                                            echo 'selected'; ?>>
                                            ระดับปฏิบัติงาน</option>
                                        <option value="พลเรือน (ประเภทวิชาการ)" <?php if ($row['person_level'] == 'พลเรือน (ประเภทวิชาการ)')
                                                                                    echo 'selected'; ?>>
                                            พลเรือน (ประเภทวิชาการ)</option>
                                        <option value="ระดับเชี่ยวชาญ" <?php if ($row['person_level'] == 'ระดับเชี่ยวชาญ')
                                                                            echo 'selected'; ?>>
                                            ระดับเชี่ยวชาญ</option>
                                        <option value="ระดับชำนาญการพิเศษ" <?php if ($row['person_level'] == 'ระดับชำนาญการพิเศษ')
                                                                                echo 'selected'; ?>>
                                            ระดับชำนาญการพิเศษ</option>
                                        <option value="ระดับชำนาญการ" <?php if ($row['person_level'] == 'ระดับชำนาญการ')
                                                                            echo 'selected'; ?>>
                                            ระดับชำนาญการ</option>
                                        <option value="ระดับปฏิบัติการ" <?php if ($row['person_level'] == 'ระดับปฏิบัติการ')
                                                                            echo 'selected'; ?>>
                                            ระดับปฏิบัติการ</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="person_DocNumber" class="form-label">เลขจ.18</label>
                                    <input type="number" class="form-control" id="person_DocNumber"
                                        name="person_DocNumber" value="<?php echo $row['person_DocNumber']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="person_SuppNumber" class="form-label">เลขที่ประกอบ:</label>
                                    <input type="number" class="form-control" id="person_SuppNumber"
                                        name="person_SuppNumber" value="<?php echo $row['person_SuppNumber']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="person_POSVNumber" class="form-label">หมายเลข พอ.ส.ว.::</label>
                                    <input type="number" class="form-control" id="person_POSVNumber"
                                        name="person_POSVNumber" value="<?php echo $row['person_POSVNumber']; ?>">
                                </div>


                                <div class="col-md-6">
                                    <label for="person_salary" class="form-label">เงินเดือน</label>
                                    <input type="number" class="form-control" id="person_salary" name="person_salary"
                                        value="<?php echo $row['person_salary']; ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="person_nickname" class="form-label">ชื่อเล่น</label>
                                    <input type="text" class="form-control" id="person_nickname" name="person_nickname"
                                        value="<?php echo $row['person_nickname']; ?>">
                                </div>
                                <!-- วันเกิด -->
                                <div class="col-md-6">
                                    <label class="form-label">วันเดือนปีเกิด:</label>
                                    <div class="d-flex gap-2">
                                        <select name="day" class="form-select" required>
                                            <option value="">วัน</option>
                                            <?php for ($i = 1; $i <= 31; $i++): ?>
                                                <option value="<?= $i ?>" <?= $i == date('j', strtotime($row['person_born'])) ? 'selected' : '' ?>>
                                                    <?= $i ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                        <select name="month" class="form-select" required>
                                            <option value="">เดือน</option>
                                            <?php
                                            $months = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
                                            foreach ($months as $key => $month): ?>
                                                <option value="<?= $key + 1 ?>" <?= $key + 1 == date('n', strtotime($row['person_born'])) ? 'selected' : '' ?>>
                                                    <?= $month ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <select name="year" class="form-select" required>
                                            <option value="">ปี</option>
                                            <?php for ($i = date("Y") + 543; $i >= 2500; $i--): ?>
                                                <option value="<?= $i ?>" <?= $i == date('Y', strtotime($row['person_born'])) + 543 ? 'selected' : '' ?>>
                                                    <?= $i ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">อายุราชการที่เหลือคือ:</label>
                                    <input type="text" name="service_remaining" class="form-control" maxlength="255"
                                        readonly>
                                </div>
                                <!-- วันที่บรรจุ -->
                                <div class="col-md-6">
                                    <label class="form-label">วันที่บรรจุ:</label>
                                    <div class="d-flex gap-2">
                                        <select name="accept_day" class="form-select" required>
                                            <option value="">วัน</option>
                                            <?php for ($i = 1; $i <= 31; $i++): ?>
                                                <option value="<?= $i ?>" <?= $i == date('j', strtotime($row['person_dateAccepting'])) ? 'selected' : '' ?>>
                                                    <?= $i ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                        <select name="accept_month" class="form-select" required>
                                            <option value="">เดือน</option>
                                            <?php foreach ($months as $key => $month): ?>
                                                <option value="<?= $key + 1 ?>" <?= $key + 1 == date('n', strtotime($row['person_dateAccepting'])) ? 'selected' : '' ?>>
                                                    <?= $month ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <select name="accept_year" class="form-select" required>
                                            <option value="">ปี</option>
                                            <?php for ($i = date("Y") + 543; $i >= 2500; $i--): ?>
                                                <option value="<?= $i ?>" <?= $i == date('Y', strtotime($row['person_dateAccepting'])) + 543 ? 'selected' : '' ?>>
                                                    <?= $i ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">อายุของคุณคือ:</label>
                                    <input type="text" name="age" class="form-control" maxlength="255" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">วันที่คุณเกษียณอายุราชการคือ:</label>
                                    <input type="text" name="retirement_date" class="form-control" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">อายุราชการในวันเกษียณของคุณคือ:</label>
                                    <input type="text" name="service_at_retirement" class="form-control" maxlength="255"
                                        readonly>
                                </div>



                                <div class="col-md-6">
                                    <label class="form-label">ประเภทการจ้าง:</label>
                                    <select name="person_typeHire" class="form-select" required>
                                        <option value="">เลือกประเภทการจ้าง</option>
                                        <option value="ข้าราชการ" <?php if ($row['person_typeHire'] == 'ข้าราชการ')
                                                                        echo 'selected'; ?>>ข้าราชการ</option>
                                        <option value="จ้างเหมาบริการ" <?php if ($row['person_typeHire'] == 'จ้างเหมาบริการ')
                                                                            echo 'selected'; ?>>
                                            จ้างเหมาบริการ</option>
                                        <option value="จ้างเหมาบุคคล" <?php if ($row['person_typeHire'] == 'จ้างเหมาบุคคล')
                                                                            echo 'selected'; ?>>
                                            จ้างเหมาบุคคล</option>
                                        <option value="พนักงานกระทรวง" <?php if ($row['person_typeHire'] == 'พนักงานกระทรวง')
                                                                            echo 'selected'; ?>>
                                            พนักงานกระทรวง</option>
                                        <option value="พนักงานราชการ" <?php if ($row['person_typeHire'] == 'พนักงานราชการ')
                                                                            echo 'selected'; ?>>
                                            พนักงานราชการ</option>
                                        <option value="ลูกจ้างชั่วคราว (รายเดือน)" <?php if ($row['person_typeHire'] == 'ลูกจ้างชั่วคราว (รายเดือน)')
                                                                                        echo 'selected'; ?>>ลูกจ้างชั่วคราว (รายเดือน)</option>
                                        <option value="ลูกจ้างชั่วคราวรายวัน" <?php if ($row['person_typeHire'] == 'ลูกจ้างชั่วคราวรายวัน')
                                                                                    echo 'selected'; ?>>
                                            ลูกจ้างชั่วคราวรายวัน</option>
                                        <option value="ลูกจ้างประจำ" <?php if ($row['person_typeHire'] == 'ลูกจ้างประจำ')
                                                                            echo 'selected'; ?>>
                                            ลูกจ้างประจำ</option>
                                        <option value="ลูกจ้างรายคาบ" <?php if ($row['person_typeHire'] == 'ลูกจ้างรายคาบ')
                                                                            echo 'selected'; ?>>
                                            ลูกจ้างรายคาบ</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="person_positionAllowance" class="form-label">เงินประจำตำแหน่ง</label>
                                    <input type="number" class="form-control" id="person_positionAllowance"
                                        name="person_positionAllowance"
                                        value="<?php echo $row['person_positionAllowance']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="person_phone" class="form-label">เบอร์โทรศัพท์</label>
                                    <input type="text" class="form-control" id="person_phone" name="person_phone"
                                        value="<?php echo $row['person_phone']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="person_specialQualification" class="form-label">วุฒิเฉพาะทาง</label>
                                    <input type="text" class="form-control" id="person_specialQualification"
                                        name="person_specialQualification"
                                        value="<?php echo $row['person_specialQualification']; ?>">
                                </div>


                                <div class="col-md-6">
                                    <label class="form-label">กรุ๊ปเลือด:</label>
                                    <select name="person_blood" class="form-select">
                                        <option value="">เลือกกรุ๊ปเลือด</option>
                                        <option value="A" <?php if ($row['person_blood'] == 'A')
                                                                echo 'selected'; ?>>A
                                        </option>
                                        <option value="B" <?php if ($row['person_blood'] == 'B')
                                                                echo 'selected'; ?>>B
                                        </option>
                                        <option value="AB" <?php if ($row['person_blood'] == 'AB')
                                                                echo 'selected'; ?>>AB</option>
                                        <option value="O" <?php if ($row['person_blood'] == 'O')
                                                                echo 'selected'; ?>>O
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="person_cardNum" class="form-label">เลขบัตรข้าราชการ</label>
                                    <input type="text" class="form-control" id="person_cardNum" name="person_cardNum"
                                        value="<?php echo $row['person_cardNum']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">วันหมดอายุบัตรข้าราชการ:</label>
                                    <div class="d-flex gap-2">
                                        <!-- ช่องเลือกวัน -->
                                        <select name="Expired_day" class="form-select" required>
                                            <option value="">วัน</option>
                                            <?php
                                            $expired_date = isset($row['person_CardExpired']) ? explode('-', $row['person_CardExpired']) : null;
                                            $expired_day = $expired_date ? (int) $expired_date[2] : null; // แยกค่าของวัน
                                            for ($i = 1; $i <= 31; $i++): ?>
                                                <option value="<?= $i ?>" <?= $i == $expired_day ? 'selected' : '' ?>>
                                                    <?= $i ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>

                                        <!-- ช่องเลือกเดือน -->
                                        <select name="Expired_month" class="form-select" required>
                                            <option value="">เดือน</option>
                                            <?php
                                            $expired_month = $expired_date ? (int) $expired_date[1] : null; // แยกค่าของเดือน
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
                                                <option value="<?= $key + 1 ?>" <?= ($key + 1) == $expired_month ? 'selected' : '' ?>>
                                                    <?= $month ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <!-- ช่องเลือกปี -->
                                        <select name="Expired_year" class="form-select" required>
                                            <option value="">ปี</option>
                                            <?php
                                            $expired_year = $expired_date ? (int) $expired_date[0] + 543 : null; // แปลงปี ค.ศ. เป็น พ.ศ.
                                            for ($i = date("Y") + 543; $i >= 2500; $i--): ?>
                                                <option value="<?= $i ?>" <?= $i == $expired_year ? 'selected' : '' ?>>
                                                    <?= $i ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>




                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-success">บันทึกการแก้ไข</button>
                                    <a href="personnel.php" class="btn btn-secondary">ยกเลิก</a>
                                </div>
                        </form>
                    </div>
                </div>
        </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/static/js/components/dark.js"></script>
<script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/compiled/js/app.js"></script>
</body>

</html>