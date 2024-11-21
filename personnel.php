<?php
// เชื่อมต่อฐานข้อมูล
include 'connect/connection.php';

// กำหนดจำนวนรายการที่จะแสดงต่อหน้า
$records_per_page = 10;

// ตรวจสอบหน้าปัจจุบันจาก URL
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// ตรวจสอบว่ามีคำค้นหาหรือไม่
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// สร้างคำสั่ง SQL สำหรับดึงข้อมูลพร้อมเงื่อนไขการค้นหา
if ($search_query) {
    // เพิ่มเงื่อนไขสำหรับค้นหา person_id
    $sql = "SELECT * FROM personnel WHERE person_id LIKE '%$search_query%' 
            OR person_name LIKE '%$search_query%' 
            OR person_gender LIKE '%$search_query%' 
            OR person_rank LIKE '%$search_query%' 
            OR person_formwork LIKE '%$search_query%' 
            OR person_level LIKE '%$search_query%' 
            OR person_salary LIKE '%$search_query%' 
            OR person_born LIKE '%$search_query%' 
            OR person_phone LIKE '%$search_query%' 
            LIMIT $offset, $records_per_page";
    $total_records_sql = "SELECT COUNT(*) FROM personnel WHERE person_id LIKE '%$search_query%' 
            OR person_name LIKE '%$search_query%' 
            OR person_gender LIKE '%$search_query%' 
            OR person_rank LIKE '%$search_query%' 
            OR person_formwork LIKE '%$search_query%' 
            OR person_level LIKE '%$search_query%' 
            OR person_salary LIKE '%$search_query%' 
            OR person_born LIKE '%$search_query%' 
            OR person_phone LIKE '%$search_query%'";
} else {
    $sql = "SELECT * FROM personnel LIMIT $offset, $records_per_page";
    $total_records_sql = "SELECT COUNT(*) FROM personnel";
}

$result = $conn->query($sql);
$total_records_result = $conn->query($total_records_sql);
$total_records = $total_records_result->fetch_row()[0];
$total_pages = ceil($total_records / $records_per_page);

// ถ้าเป็นการร้องขอผ่าน AJAX ให้ส่งข้อมูลในรูปแบบ JSON
if (isset($_GET['ajax']) && $_GET['ajax'] == 'true') {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(['data' => $data, 'total_pages' => $total_pages]);
    exit;
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
    <link rel="icon" href="photo/รพ.png" type="image/png">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css">
    <!-- เพิ่มที่ส่วน <head> ของ HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ปรับขอบโค้งให้กับการ์ดและตาราง */
        .card {
            border-radius: 10px;
        }

        .table th,
        .table td {
            text-align: center;
            /* จัดข้อความให้อยู่กึ่งกลาง */
            vertical-align: middle;
            /* จัดข้อความให้อยู่กลางแนวตั้ง */
            white-space: nowrap;
            /* ป้องกันคำขาดบรรทัด */
        }

        .table th {
            background-color: #0097e6;
            /* เปลี่ยนสีพื้นหลังหัวตาราง */
            color: #ffffff;
            /* สีข้อความหัวตาราง */
            font-size: 14px;
            /* ขนาดข้อความ */
        }

        .table-responsive {
            overflow-x: auto;
            /* เพิ่ม scroll bar เมื่อขนาดหน้าจอไม่พอ */
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .table th:first-child,
        .table td:first-child {
            border-top-left-radius: 10px;
            /* มุมซ้ายบน */
            border-bottom-left-radius: 10px;
            /* มุมซ้ายล่าง */
        }

        .table th:last-child,
        .table td:last-child {
            border-top-right-radius: 10px;
            /* มุมขวาบน */
            border-bottom-right-radius: 10px;
            /* มุมขวาล่าง */
        }

        .custom-title {
            font-size: 24px;
            /* ขนาดที่ต้องการ สามารถเปลี่ยนได้ */
            font-weight: bold;
            /* ทำให้ตัวหนา (ถ้าต้องการ) */
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

                <body>
                    <div class="container my-4">

                        <!-- การ์ดสำหรับตาราง -->
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white"
                                style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                <div class="d-flex justify-content-between align-items-center">

                                    <span class="custom-title">ข้อมูลบุคลากร</span>
                                    <div style="max-width: 300px;">
                                        <input type="text" id="tableSearch" class="form-control" placeholder="ค้นหา..."
                                            onkeyup="searchTable()">
                                    </div>
                                </div>
                            </div>
                            </br>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped" id="personnelTable">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>หมายเลขบัตรประชาชน</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th>เพศ</th>
                                                <th>ตำแหน่ง</th>
                                                <th>ปฏิบัติการที่</th>
                                                <th>ระดับ</th>
                                                <th>เงินเดือน</th>
                                                <th>วันเกิด</th>
                                                <th>วันที่บรรจุ</th>
                                                <th>อายุ (ปี)</th>
                                                <th>วันที่เกษียณ</th>
                                                <th>อายุราชการในวันเกษียณ</th>
                                                <th>อายุราชการคงเหลือ</th>
                                                <th>โทรศัพท์</th>
                                                <th>แอคชั่น</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $person_born = $row["person_born"];
                                                    $date_accepting = $row["person_dateAccepting"];

                                                    // กำหนดค่าตัวแปร
                                                    $retirement_date = $current_age = $service_remaining = $service_years_at_retirement = "";

                                                    if (!empty($person_born)) {
                                                        // แปลง พ.ศ. เป็น ค.ศ.
                                                        $person_born_converted = date('Y-m-d', strtotime($person_born . ' -543 years'));
                                                        $birth_date = new DateTime($person_born_converted);

                                                        // คำนวณวันที่เกษียณราชการ (1 ตุลาคม ในปีที่อายุครบ 60)
                                                        $retirement_date_obj = new DateTime();
                                                        $retirement_date_obj->setDate($birth_date->format('Y') + 60, 10, 1);
                                                        $retirement_date = $retirement_date_obj->format('d/m/') . ($retirement_date_obj->format('Y') + 543); // เพิ่ม 543 ให้ปี
                                            
                                                        // คำนวณอายุปัจจุบัน
                                                        $current_date = new DateTime();
                                                        $age_interval = $birth_date->diff($current_date);
                                                        $current_age = $age_interval->y . " ปี " . $age_interval->m . " เดือน " . $age_interval->d . " วัน";
                                                    }

                                                    if (!empty($date_accepting)) {
                                                        // แปลง พ.ศ. เป็น ค.ศ.
                                                        $date_accepting_converted = date('Y-m-d', strtotime($date_accepting . ' -543 years'));
                                                        $accept_date = new DateTime($date_accepting_converted);

                                                        // คำนวณอายุราชการคงเหลือ
                                                        if (!empty($retirement_date)) {
                                                            $service_remaining_interval = $current_date->diff($retirement_date_obj);
                                                            $service_remaining = $service_remaining_interval->y . " ปี " . $service_remaining_interval->m . " เดือน " . $service_remaining_interval->d . " วัน";
                                                        }

                                                        // คำนวณอายุราชการในวันเกษียณ
                                                        if (!empty($retirement_date)) {
                                                            $service_interval_retirement = $accept_date->diff($retirement_date_obj);
                                                            $service_years_at_retirement = $service_interval_retirement->y . " ปี " . $service_interval_retirement->m . " เดือน " . $service_interval_retirement->d . " วัน";
                                                        }
                                                    }

                                                    // แสดงข้อมูลในตาราง
                                                    echo "<tr>";
                                                    echo "<td>" . $row["person_id"] . "</td>";
                                                    echo "<td>" . $row["person_name"] . "</td>";
                                                    echo "<td>" . $row["person_gender"] . "</td>";
                                                    echo "<td>" . $row["person_rank"] . "</td>";
                                                    echo "<td>" . $row["person_formwork"] . "</td>";
                                                    echo "<td>" . $row["person_level"] . "</td>";
                                                    echo "<td>" . $row["person_salary"] . "</td>";
                                                    echo "<td>" . (!empty($person_born) ? date('d/m/Y', strtotime($person_born)) : '-') . "</td>";
                                                    echo "<td>" . (!empty($date_accepting) ? date('d/m/Y', strtotime($date_accepting)) : '-') . "</td>";
                                                    echo "<td>" . $current_age . "</td>";
                                                    echo "<td>" . $retirement_date . "</td>";
                                                    echo "<td>" . $service_years_at_retirement . "</td>";
                                                    echo "<td>" . $service_remaining . "</td>";
                                                    echo "<td>" . $row["person_phone"] . "</td>";
                                                    echo "<td>";
                                                    echo "<a href='edit_person.php?id=" . $row["person_id"] . "' class='btn btn-warning btn-sm'>แก้ไข</a>";
                                                    echo "<a href='#' onclick='confirmDelete(" . $row["person_id"] . ")' class='btn btn-danger btn-sm'>ลบ</a>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='15' class='text-center'>ไม่มีข้อมูล</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer"
                                style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="?search=<?php echo urlencode($search_query); ?>&page=<?php echo $page - 1; ?>"
                                                    aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li class="page-item <?php if ($i == $page)
                                                echo 'active'; ?>">
                                                <a class="page-link"
                                                    href="?search=<?php echo urlencode($search_query); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($page < $total_pages): ?>
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="?search=<?php echo urlencode($search_query); ?>&page=<?php echo $page + 1; ?>"
                                                    aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>


                    <script>
                        function searchTable(page = 1) {
                            var search = document.getElementById("tableSearch").value; // ดึงค่าค้นหา
                            var url = `personnel.php?search=${encodeURIComponent(search)}&page=${page}&ajax=true`;

                            fetch(url)
                                .then(response => response.json())
                                .then(data => {
                                    const tbody = document.querySelector("#personnelTable tbody");
                                    tbody.innerHTML = ""; // ล้างข้อมูลเดิมในตาราง

                                    // วนลูปเพื่อแสดงข้อมูลในตารางใหม่
                                    data.data.forEach((row, index) => {
                                        tbody.innerHTML += `
                    <tr>
                        <td>${row.person_id}</td>
                        <td>${row.person_name}</td>
                        <td>${row.person_gender}</td>
                        <td>${row.person_rank}</td>
                        <td>${row.person_formwork}</td>
                        <td>${row.person_level}</td>
                        <td>${row.person_salary}</td>
                        <td>${row.person_born}</td>
                        <td>${row.person_phone}</td>
                        <td>
                            <div class='d-flex'>
                                <a href='edit_person.php?id=${row.person_id}' class='btn btn-sm btn-warning me-1'>แก้ไข</a>
                                <a href='#' class='btn btn-sm btn-danger' onclick="confirmDelete(${row.person_id})">ลบ</a>
                            </div>
                        </td>
                    </tr>
                `;
                                    });

                                    // อัปเดต pagination พร้อมคำค้นหา
                                    updatePagination(data.total_pages, page, search);
                                })
                                .catch(error => console.error('Error:', error));
                        }


                        function updatePagination(totalPages, currentPage, search = "") {
                            const pagination = document.querySelector(".pagination");
                            pagination.innerHTML = ""; // ล้าง pagination เดิม

                            // ปุ่มไปหน้าก่อนหน้า
                            if (currentPage > 1) {
                                pagination.innerHTML += `
            <li class="page-item">
                <a class="page-link" href="#" onclick="searchTable(${currentPage - 1})">&laquo;</a>
            </li>
        `;
                            }

                            // สร้าง pagination
                            for (let i = 1; i <= totalPages; i++) {
                                pagination.innerHTML += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="searchTable(${i})">${i}</a>
            </li>
        `;
                            }

                            // ปุ่มไปหน้าถัดไป
                            if (currentPage < totalPages) {
                                pagination.innerHTML += `
            <li class="page-item">
                <a class="page-link" href="#" onclick="searchTable(${currentPage + 1})">&raquo;</a>
            </li>
        `;
                            }

                            // // // ปุ่ม ">>" ไปหน้าสุดท้าย
                            //  if (currentPage < totalPages) {
                            //      pagination.innerHTML += `
                            //          <li class="page-item">
                            //             <a class="page-link" href="#" onclick="searchTable(${totalPages})">&raquo;&raquo;</a>
                            //         </li>
                            //      `;
                            //  }
                        }


                        // เรียกใช้งานเมื่อมีการป้อนคำค้นหา
                        document.getElementById("tableSearch").addEventListener("input", () => searchTable(1));



                        function confirmDelete(personId) {
                            Swal.fire({
                                title: 'คุณต้องการลบข้อมูลนี้หรือไม่?',
                                text: "เมื่อทำการลบแล้วจะไม่สามารถกู้คืนได้",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'ใช่, ลบเลย!',
                                cancelButtonText: 'ยกเลิก'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // ถ้าผู้ใช้ยืนยันการลบ ให้เปลี่ยนเส้นทางไปยังลิงก์ลบจริง ๆ
                                    window.location.href = 'delete_person.php?id=' + personId;
                                }
                            });
                        }
                    </script>
                </body>


                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



                <script src="assets/static/js/components/dark.js"></script>
                <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>


                <script src="assets/compiled/js/app.js"></script>



</body>

</html>