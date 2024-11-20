<?php
session_start();
include 'connect/connection.php'; // ระบุเส้นทางไปยังไฟล์ที่เชื่อมต่อฐานข้อมูล
$userName = $_SESSION['user_name'] ?? 'Guest'; // ให้ชื่อผู้ใช้แสดงใน navbar
$sql = "SELECT * FROM vacation_leave WHERE vacation_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$vacation = $result->fetch_assoc();

if (!$vacation) {
    $vacation = []; // กำหนดค่าเริ่มต้นเป็นอาร์เรย์ว่าง
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ban Phai Hospital</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="photo/รพ.png" type="image/png">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css">


    <style>
        /* Custom Spacing for the Marked Section */
        .row.g-3.mt-4 {
            margin-top: 20px;
            /* ปรับระยะห่างระหว่างส่วนบน */
        }

        .replacement-fields {
            display: none;
            /* ซ่อนช่องปฏิบัติงานแทนเริ่มต้น */
        }

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

            <body class="d-flex align-items-start justify-content-center" style="min-height: 100vh;">
                <div class="container mt-4" style="max-width: 800px; margin-top: 20px;">
                    <h2 class="text-center .text-secondary mb-4">ระบบบันทึกข้อมูลการลา</h2>
                    <form id="vacationForm" action="save_vacation.php" method="POST"
                        onsubmit="return validateVacationForm()">
                        <div class="row g-3">
                            <!-- Row 1 -->
                            <div class="col-md-6">
                                <label class="form-label">วันที่ปัจจุบัน:</label>
                                <input type="date" id="vacation_date" name="vacation_date" class="form-control">
                            </div>


                            <div class="col-md-6">
                                <label for="typeVacation_id" class="form-label">ประเภทการลา:</label>
                                <select class="form-control" id="typeVacation_id" name="typeVacation_id" required>
                                    <option value="1" <?= isset($vacation['typeVacation_id']) && $vacation['typeVacation_id'] == 1 ? 'selected' : '' ?>>ลาพักผ่อน</option>
                                    <option value="2" <?= isset($vacation['typeVacation_id']) && $vacation['typeVacation_id'] == 2 ? 'selected' : '' ?>>ลาป่วย</option>
                                    <option value="3" <?= isset($vacation['typeVacation_id']) && $vacation['typeVacation_id'] == 3 ? 'selected' : '' ?>>ลาคลอดบุตร</option>
                                    <option value="4" <?= isset($vacation['typeVacation_id']) && $vacation['typeVacation_id'] == 4 ? 'selected' : '' ?>>ลากิจส่วนตัว</option>
<<<<<<< HEAD
                                    <option value="5" <?= isset($vacation['typeVacation_id']) && $vacation['typeVacation_id'] == 4 ? 'selected' : '' ?>>ยกเลิกการลา</option>
=======
                                    <option value="5" <?= isset($vacation['typeVacation_id']) && $vacation['typeVacation_id'] == 5 ? 'selected' : '' ?>>ลาไปช่วยเหลือภริยาที่คลอดบุตร</option>
                                    <option value="6" <?= isset($vacation['typeVacation_id']) && $vacation['typeVacation_id'] == 6? 'selected' : '' ?>>ขอยกเลิกวันลา</option>
>>>>>>> 0f6ed7ea49336a9a4039cd3a32b1ddc98bd2c9ca
                                </select>
                            </div>


                            <!-- Row 2 -->
                            <div class="col-md-6">
                                <label class="form-label"><span class="text-danger">*</span> ชื่อ - สกุล:</label>
                                <input type="text" name="vacation_name" class="form-control" maxlength="255" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">ตำแหน่ง:</label>
                                <input type="text" name="vacation_rank" class="form-control" maxlength="255">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">ระดับข้าราชการ:</label>
                                <select name="vacation_level" class="form-select" required>
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
                                <label class="form-label">ปฏิบัติการที่:</label>
                                <select name="vacation_formwork" class="form-select" required>
                                    <option value="">เลือกปฏิบัติการ</option>
                                    <?php
                                    $sql_work_groups = "SELECT group_id, group_name FROM work_group";
                                    $result_work_groups = $conn->query($sql_work_groups);

                                    if ($result_work_groups->num_rows > 0) {
                                        while ($row = $result_work_groups->fetch_assoc()) {
                                            $selected = isset($vacation['vacation_formwork']) && $vacation['vacation_formwork'] == $row['group_id'] ? 'selected' : '';
                                            echo "<option value=\"{$row['group_id']}\" $selected>{$row['group_name']}</option>";
                                        }
                                    } else {
                                        echo "<option value=''>ไม่มีข้อมูลกลุ่มงาน</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">วันพักผ่อนสะสม:</label>
                                <input type="number" name="vacation_accumulateDay" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><span class="text-danger">*</span> ตั้งแต่วันที่:</label>
                                <input type="text" id="vacation_since" name="vacation_since" class="form-control"
                                    placeholder="เลือกช่วงวันที่" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">กำหนดวัน:</label>
                                <input type="number" id="vacation_setDay" name="vacation_setDay" class="form-control"
                                    readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><span class="text-danger">*</span> เบอร์โทรศัพท์:</label>
                                <input type="tel" name="vacation_numPhone" class="form-control" pattern="[0-9]{10}"
                                    title="กรุณากรอกหมายเลขโทรศัพท์ 10 หลัก">
                            </div>

                            <div class="col-md-6 replacement-fields">
                                <label class="form-label">ชื่อผู้ปฏิบัติงานแทน:</label>
                                <input type="text" name="vacation_nameWorkinstead" class="form-control" maxlength="255">
                            </div>
                            <div class="col-md-6 replacement-fields">
                                <label class="form-label">ตำแหน่งผู้ปฏิบัติงานแทน:</label>
                                <input type="text" name="vacation_WorkinsteadRank" class="form-control" maxlength="255">
                            </div>
<<<<<<< HEAD
                            <div class="col-md-12 cancel-reason-field">
                                <label class="form-label">เหตุผลในการยกเลิก:</label>
                                <textarea name="vacation_cancel_reason" class="form-control" rows="4"></textarea>
=======
                            <div class="col-md-12 ">
                                <label class="form-label">เหตุผลในการยกเลิก:</label>
                                <textarea name="vacation_cancel_reason" class="form-control" rows="4"
                                    required></textarea>
>>>>>>> 0f6ed7ea49336a9a4039cd3a32b1ddc98bd2c9ca
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success mt-4 w-100">บันทึกข้อมูล</button>
                    </form>
                </div>




                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                <script>
                    function validateVacationForm() {
                        const form = document.getElementById('vacationForm');
                        let isValid = true;

                        // ตรวจสอบเบอร์โทรศัพท์
                        const phone = form['vacation_numPhone'];
                        if (phone.value && !/^\d{10}$/.test(phone.value)) {
                            alert('กรุณากรอกเบอร์โทรศัพท์ 10 หลัก');
                            isValid = false;
                        }

                        return isValid;
                    }

                    // ตั้งค่าการเชื่อมต่อ Google Calendar
                    const CONFIG = {
                        API_KEY: 'AIzaSyBMxClJ1BONjTrkf0YkktYJrAzuJ5rXRN8', // ใส่ API Key ของคุณ
                        CALENDAR_ID: 'th.th#holiday@group.v.calendar.google.com', // ปฏิทินวันหยุดไทย
                        BASE_URL: 'https://www.googleapis.com/calendar/v3/calendars'
                    };

                    // ฟังก์ชันดึงข้อมูลวันหยุด
                    async function getHolidays(startDate, endDate) {
                        try {
                            // สร้าง URL สำหรับเรียก API
                            const params = new URLSearchParams({
                                key: CONFIG.API_KEY,
                                timeMin: new Date(startDate).toISOString(),
                                timeMax: new Date(endDate).toISOString(),
                                singleEvents: true,
                                orderBy: 'startTime'
                            });

                            const url = `${CONFIG.BASE_URL}/${encodeURIComponent(CONFIG.CALENDAR_ID)}/events?${params}`;

                            // เรียกข้อมูลจาก API
                            const response = await fetch(url);
                            if (!response.ok) {
                                throw new Error('ไม่สามารถดึงข้อมูลวันหยุดได้');
                            }

                            // แปลงข้อมูลที่ได้เป็นรายการวันหยุด
                            const data = await response.json();
                            return data.items.map(event => event.start.date);

                        } catch (error) {
                            console.error('เกิดข้อผิดพลาด:', error);
                            return [];
                        }
                    }

                    // ฟังก์ชันคำนวณวันทำงาน
                    async function calculateWorkingDays(startDate, endDate) {
                        try {
                            // ดึงรายการวันหยุด
                            const holidays = await getHolidays(startDate, endDate);

                            let currentDate = new Date(startDate);
                            const endDateTime = new Date(endDate);
                            let workingDays = 0;

                            // วนลูปนับวันทำงาน
                            while (currentDate <= endDateTime) {
                                const dayOfWeek = currentDate.getDay();
                                const dateString = currentDate.toISOString().split('T')[0];

                                // นับเฉพาะวันทำงาน (ไม่รวมเสาร์-อาทิตย์และวันหยุด)
                                if (dayOfWeek !== 0 && dayOfWeek !== 6 && !holidays.includes(dateString)) {
                                    workingDays++;
                                }

                                currentDate.setDate(currentDate.getDate() + 1);
                            }

                            return workingDays;
                        } catch (error) {
                            console.error('เกิดข้อผิดพลาดในการคำนวณวันทำงาน:', error);
                            return 0;
                        }
                    }

                    // ตั้งค่า Date Picker
                    document.addEventListener('DOMContentLoaded', function() {
                        flatpickr("#vacation_since", {
                            mode: "range",
                            dateFormat: "d/m/Y",
                            locale: "th",
                            onChange: async function(selectedDates) {
                                if (selectedDates.length === 2) {
                                    const workingDays = await calculateWorkingDays(selectedDates[0], selectedDates[1]);
                                    document.getElementById('vacation_setDay').value = workingDays;
                                } else {
                                    document.getElementById('vacation_setDay').value = '';
                                }
                            }
                        });
                    });


                    document.addEventListener('DOMContentLoaded', function() {
                        const today = new Date().toISOString().split('T')[0]; // แปลงวันที่ปัจจุบันเป็นรูปแบบ YYYY-MM-DD
                        document.getElementById('vacation_date').value = today; // ตั้งค่า value ให้กับ input
                    });


                    document.addEventListener('DOMContentLoaded', function () {
                        const typeVacationDropdown = document.getElementById('typeVacation_id');
                        const replacementFields = document.querySelectorAll('.replacement-fields');
                        const cancelReasonField = document.querySelector('.cancel-reason-field');

                        // Function to manage field visibility based on selected leave type
                        function handleLeaveTypeChange() {
                            const selectedType = typeVacationDropdown.value;

                            // Reset all fields to default
                            replacementFields.forEach(field => {
                                field.style.display = 'none'; // Hide by default
                                field.querySelector('input').value = ''; // Clear value
                                field.querySelector('input').setAttribute('disabled', 'disabled'); // Disable input
                            });

                            cancelReasonField.style.display = 'none';
                            cancelReasonField.querySelector('textarea').value = '';
                            cancelReasonField.querySelector('textarea').setAttribute('disabled', 'disabled');

                            // Show specific fields based on leave type
                            if (selectedType === '1') { // Vacation Leave
                                replacementFields.forEach(field => {
                                    field.style.display = 'block'; // Show
                                    field.querySelector('input').removeAttribute('disabled'); // Enable input
                                });
                            } else if (selectedType === '5') { // Cancel Leave
                                cancelReasonField.style.display = 'block';
                                cancelReasonField.querySelector('textarea').removeAttribute('disabled');
                            }
                        }

                        // Attach event listener
                        typeVacationDropdown.addEventListener('change', handleLeaveTypeChange);

                        // Initialize fields on page load
                        handleLeaveTypeChange();
                    });

                    
                </script>

            </body>


            <!-- Flatpickr CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
            <!-- Flatpickr JS -->
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script src="assets/static/js/components/dark.js"></script>
            <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
            <script src="assets/compiled/js/app.js"></script>

</body>

</html>