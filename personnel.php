<?php
// เชื่อมต่อฐานข้อมูล
include 'connect/connection.php';

// จำนวนข้อมูลต่อหน้า
$limit = 10;

// หน้าปัจจุบัน
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1);

// รับค่าการค้นหา
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// Query สำหรับนับจำนวนทั้งหมด (ใช้ในการคำนวณหน้าทั้งหมด)
$total_sql = "SELECT COUNT(*) AS total
              FROM personnel p
              LEFT JOIN work_group wg ON p.person_formwork = wg.group_id";
if (!empty($search)) {
    $total_sql .= " WHERE p.person_name LIKE '%$search%' 
                    OR p.person_rank LIKE '%$search%' 
                    OR p.person_level LIKE '%$search%' 
                    OR p.person_salary LIKE '%$search%' /* เพิ่มเงื่อนไขค้นหาในเงินเดือน */
                    OR p.person_phone LIKE '%$search%'
                    OR p.person_id LIKE '%$search%'
                    OR p.person_DocNumber LIKE '%$search%'
                    OR wg.group_name LIKE '%$search%'";
}
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// คำนวณตำแหน่งเริ่มต้น
$offset = ($page - 1) * $limit;

// Query สำหรับดึงข้อมูลตามหน้าปัจจุบัน
$sql = "SELECT p.person_id, p.person_name, p.person_rank, p.person_level, p.person_salary, 
               p.person_born, p.person_dateAccepting, p.person_phone, p.person_DocNumber, 
               wg.group_name
        FROM personnel p
        LEFT JOIN work_group wg ON p.person_formwork = wg.group_id";
if (!empty($search)) {
    $sql .= " WHERE p.person_name LIKE '%$search%' 
              OR p.person_rank LIKE '%$search%' 
              OR p.person_level LIKE '%$search%' 
              OR p.person_salary LIKE '%$search%' /* เพิ่มเงื่อนไขค้นหาในเงินเดือน */
              OR p.person_phone LIKE '%$search%'
              OR p.person_id LIKE '%$search%'
              OR p.person_DocNumber LIKE '%$search%'
              OR wg.group_name LIKE '%$search%'";
}
$sql .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);
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
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <div class="d-flex justify-content-between align-items-center">
                <span class="custom-title">ข้อมูลบุคลากร</span>
                <!-- ช่องค้นหา -->
                <input type="text" id="searchInput" class="form-control" placeholder="ค้นหา..." 
                       value="<?php echo htmlspecialchars($search); ?>" style="width: 200px;">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead class="table-primary">
    </br>
                        <tr>
                            <th>ลำดับที่</th>
                            <th>หมายเลขบัตรประชาชน</th>
                            <th>หมายเลข จ.18</th>
                            <th>ชื่อ-สกุล</th>
                            <th>ตำแหน่ง</th>
                            <th>ระดับ</th>
                            <th>กลุ่มงาน</th> <!-- เพิ่มคอลัมน์นี้ -->
                            <th>เงินเดือน</th>
                            <th>วันเกิด</th>
                            <th>วันที่บรรจุ</th>
                            <th>หมายเลขโทรศัพท์</th>
                            
                            
                            <th>แอ็คชั่น</th>
                        </tr>
                    </thead>
                    <tbody id="personnelTableBody">
                        <?php
                        $index = $offset + 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $person_born = !empty($row['person_born']) 
                                    ? date("d/m/", strtotime($row['person_born'])) . (date("Y", strtotime($row['person_born'])) + 543)
                                    : "-";
                                $person_dateAccepting = !empty($row['person_dateAccepting']) 
                                    ? date("d/m/", strtotime($row['person_dateAccepting'])) . (date("Y", strtotime($row['person_dateAccepting'])) + 543)
                                    : "-";
                                echo "<tr>";
                                echo "<td>" . $index++ . "</td>";
                                echo "<td>{$row['person_id']}</td>";
                                echo "<td>{$row['person_DocNumber']}</td>";
                                echo "<td>{$row['person_name']}</td>";
                                echo "<td>{$row['person_rank']}</td>";
                                echo "<td>{$row['person_level']}</td>";
                                echo "<td>{$row['group_name']}</td>"; // แสดงชื่อกลุ่มงาน
                                echo "<td>" . number_format($row['person_salary'], 2) . "</td>";
                                echo "<td>{$person_born}</td>";
                                echo "<td>{$person_dateAccepting}</td>";
                                echo "<td>{$row['person_phone']}</td>";
                               
                               
                                echo "<td>
                                        <a href='edit_person.php?id={$row['person_id']}' class='btn btn-warning btn-sm'>ดูรายละเอียด</a>
                                        <a href='#' onclick='confirmDelete({$row['person_id']})' class='btn btn-danger btn-sm'>ลบ</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='12' class='text-center'>ไม่มีข้อมูล</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
                    </br>
             <!-- Pagination -->
             <nav aria-label="Pagination">
                                    <ul class="pagination justify-content-center" id="paginationLinks">
                                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">«</a>
                                        </li>
                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">»</a>
                                        </li>
                                    </ul>
                                </nav>
        </div>
    </div>
</div>


                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

                    <script>
                        document.getElementById('searchInput').addEventListener('keyup', function() {
                            const search = this.value;
                            const page = 1; // รีเซ็ตหน้าเมื่อค้นหาใหม่

                            // ใช้ AJAX ดึงข้อมูลใหม่จากเซิร์ฟเวอร์
                            fetch(`?search=${encodeURIComponent(search)}&page=${page}`)
                                .then(response => response.text())
                                .then(html => {
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(html, 'text/html');

                                    // อัปเดตตารางและ Pagination
                                    const newTableBody = doc.querySelector('#personnelTableBody').innerHTML;
                                    const newPagination = doc.querySelector('#paginationLinks')?.innerHTML;

                                    document.querySelector('#personnelTableBody').innerHTML = newTableBody;
                                    if (newPagination) {
                                        document.querySelector('#paginationLinks').innerHTML = newPagination;
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        });



                        // ฟังก์ชันสำหรับค้นหาในตาราง
                        function searchTable() {
                            const input = document.getElementById("tableSearch");
                            const filter = input.value.toLowerCase();
                            const table = document.getElementById("personnelTable");
                            const rows = table.getElementsByTagName("tr");

                            for (let i = 1; i < rows.length; i++) {
                                let cells = rows[i].getElementsByTagName("td");
                                let match = false;

                                for (let j = 0; j < cells.length; j++) {
                                    if (cells[j]) {
                                        const cellText = cells[j].textContent || cells[j].innerText;
                                        if (cellText.toLowerCase().includes(filter)) {
                                            match = true;
                                            break;
                                        }
                                    }
                                }
                                rows[i].style.display = match ? "" : "none";
                            }
                        }
                        function confirmDelete(personId) {
    // ครั้งแรก: ยืนยันการลบข้อมูล
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
            // ถ้าผู้ใช้ยืนยัน ให้แสดง SweetAlert2 อีกครั้ง
            Swal.fire({
                title: 'ลบข้อมูลสำเร็จ!',
                text: 'ข้อมูลได้ถูกลบเรียบร้อยแล้ว',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ตกลง'
            }).then(() => {
                // เมื่อผู้ใช้กด "ตกลง" ใน SweetAlert2 ครั้งที่สอง ให้เปลี่ยนเส้นทางไปยังลิงก์ลบจริง ๆ
                window.location.href = 'delete_person.php?id=' + personId;
            });
        }
    });
}

                    </script>
                </body>
                <script src="assets/static/js/components/dark.js"></script>
                <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
                <script src="assets/compiled/js/app.js"></script>
</body>

</html>