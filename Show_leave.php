<?php
// เชื่อมต่อฐานข้อมูล
include 'connect/connection.php';

// ตรวจสอบค่าค้นหาจากผู้ใช้
$search_query = $_GET['search'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10; // จำนวนรายการต่อหน้า
$offset = ($page - 1) * $items_per_page;

// คำสั่ง SQL ดึงข้อมูล
$sql = "SELECT * FROM vacation_leave WHERE vacation_name LIKE ? LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$search_like = "%" . $search_query . "%";
$stmt->bind_param("sii", $search_like, $offset, $items_per_page);
$stmt->execute();
$result = $stmt->get_result();

// นับจำนวนหน้าทั้งหมด
$count_sql = "SELECT COUNT(*) as total FROM vacation_leave WHERE vacation_name LIKE ?";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("s", $search_like);
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_items = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_items / $items_per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ban Phai Hospital</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="photo/รพ.png" type="image/png"><link rel="icon" href="photo/รพ.png" type="image/png">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css">

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
                            <a href="dashboard.php"><img src="photo/รพ.png" alt="Logo" style="width: 100px; height: 100px;"></a>
                        </div>

                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                role="img" class="iconify iconify--system-uicons" width="20" height="20"
                                preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 24 24">
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

                        <li
                            class="sidebar-item active ">
                            <a href="dashboard.php" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>หน้าหลัก</span>
                            </a>


                        </li>

                        <li
                            class="sidebar-item  has-sub">
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

                        <li
                            class="sidebar-item  has-sub">
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

                        <li
                            class="sidebar-item  has-sub">
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

                        <li
                            class="sidebar-item  has-sub">
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
                        <li
                            class="sidebar-item activee ">
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

            <body>
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <div class="d-flex justify-content-between align-items-center">
                <span class="custom-title">ข้อมูลการลา</span>
                    <div class="d-flex">
                        <input type="text" id="tableSearch" class="form-control" placeholder="ค้นหา..." 
                               value="<?php echo htmlspecialchars($search_query); ?>" 
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
                                <th>ลำดับที่</th>
                                <th>ชื่อ-สกุล</th>
                                <th>ตำแหน่ง</th>
                                <th>วันพักผ่อนสะสม</th>
                                <th>สิทธิวันพักผ่อนประจำปี</th>
                                <th>รวมเป็นกี่วัน</th>
                                <th>ตั้งแต่วันที่</th>
                                <th>หมายเลขโทรศัพท์</th>
                                <th>ชื่อผู้ปฏิบัติงานแทน</th>
                                
                                <th>เเอ็คชั่น</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php $count = $offset + 1; ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo htmlspecialchars($row['vacation_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['vacation_rank']); ?></td>
                                        <td><?php echo htmlspecialchars($row['vacation_accumulateDay']); ?></td>
                                        <td><?php echo htmlspecialchars($row['vacation_rightsDay']); ?></td>
                                        <td><?php echo htmlspecialchars($row['vacation_sumDay']); ?></td>
                                        <td><?php echo htmlspecialchars($row['vacation_since']); ?></td>
                                        <td><?php echo htmlspecialchars($row['vacation_numPhone']); ?></td>
                                        <td><?php echo htmlspecialchars($row['vacation_nameWorkinstead']); ?></td>
                                        
                                        <td>
                                            <a href="edit_vacation.php?vacation_id=<?php echo $row['vacation_id']; ?>" 
                                               class="btn btn-warning btn-sm">แก้ไข</a>
                                            <a href="delete_vacation.php?vacation_id=<?php echo $row['vacation_id']; ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')">ลบ</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11" class="text-center">ไม่มีข้อมูลที่ตรงกับการค้นหา</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0);" onclick="navigatePage(<?php echo $page - 1; ?>)">&laquo;</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                <a class="page-link" href="javascript:void(0);" onclick="navigatePage(<?php echo $i; ?>)"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0);" onclick="navigatePage(<?php echo $page + 1; ?>)">&raquo;</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
       async function searchTable(pageNumber = null) {
    const searchInput = document.getElementById("tableSearch").value.trim();
    const currentPage = pageNumber || 1;
    
    try {
        // สร้าง URL สำหรับการค้นหา
        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set('search', searchInput);
        searchParams.set('page', currentPage);
        
        // อัพเดท URL โดยไม่ต้องรีโหลดหน้า
        window.history.pushState({}, '', `?${searchParams.toString()}`);
        
        // ทำการเรียกข้อมูลใหม่
        const response = await fetch(`Show_leave.php?${searchParams.toString()}`);
        const data = await response.text();
        
        // สร้าง DOM parser เพื่อแยกวิเคราะห์ HTML ที่ได้รับกลับมา
        const parser = new DOMParser();
        const htmlDoc = parser.parseFromString(data, 'text/html');
        
        // อัพเดทเฉพาะส่วนของตารางและ pagination
        const newTable = htmlDoc.querySelector('.table-responsive');
        const newPagination = htmlDoc.querySelector('.pagination');
        
        if (newTable) {
            document.querySelector('.table-responsive').innerHTML = newTable.innerHTML;
        }
        
        if (newPagination) {
            document.querySelector('.pagination').innerHTML = newPagination.innerHTML;
        }
        
    } catch (error) {
        console.error('Error during search:', error);
        // แสดงข้อความแจ้งเตือนถ้าเกิดข้อผิดพลาด
        alert('เกิดข้อผิดพลาดในการค้นหา กรุณาลองใหม่อีกครั้ง');
    }
}

// ฟังก์ชันสำหรับนำทางไปยังหน้าต่างๆ
function navigatePage(page) {
    searchTable(page);
}

// เพิ่ม event listener สำหรับช่องค้นหา
document.getElementById("tableSearch").addEventListener('keyup', (e) => {
    // ถ้ากด Enter ให้ทำการค้นหาทันที
    if (e.key === 'Enter') {
        searchTable(1);
    }
    // ถ้าไม่ได้กด Enter ให้รอสักครู่ก่อนค้นหา (debounce)
    else {
        clearTimeout(window.searchTimeout);
        window.searchTimeout = setTimeout(() => {
            searchTable(1);
        }, 500);
    }
});

// ฟังก์ชันสำหรับอัพเดท URL parameters
function updateURLParameter(url, param, value) {
    const regex = new RegExp('([?&])' + param + '=.*?(&|$)', 'i');
    const separator = url.indexOf('?') !== -1 ? '&' : '?';
    
    if (url.match(regex)) {
        return url.replace(regex, '$1' + param + '=' + value + '$2');
    } else {
        return url + separator + param + '=' + value;
    }
}
    
</script>


                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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