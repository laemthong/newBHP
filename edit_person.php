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
    <title>Ban Phai Hospital</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon"
        href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC"
        type="image/png">


    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css">

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
                                    <a href="form_person.php" class="submenu-link">เพิ่มบุคลากร</a>

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
                                    <a href="extra-component-avatar.html" class="submenu-link">ลากิจ</a>

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
                        <li <a href="logout.php" class='sidebar-link'>
                            <i class="fas fa-power-off "></i>
                            <span>ออกจากระบบ</span>
                            </a>


                        </li>


                        </li>



                    </ul>
                </div>
            </div>
        </div>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>แก้ไขข้อมูลบุคคล</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <style>
                .form-container {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 20px;
                    justify-content: center;
                    max-width: 1200px;
                    margin: auto;
                }

                .form-group {
                    flex: 1 1 45%;
                    min-width: 300px;
                }

                .header-container {
                    text-align: center;
                    margin-bottom: 40px;
                }
            </style>
        </head>

        <body>
            <div id="app">
                <div id="main">
                    <div class="container my-5">
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
                                    <label for="person_gender" class="form-label">เพศ</label>
                                    <input type="text" class="form-control" id="person_gender" name="person_gender"
                                        value="<?php echo $row['person_gender']; ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="person_rank" class="form-label">ตำแหน่ง</label>
                                    <input type="text" class="form-control" id="person_rank" name="person_rank"
                                        value="<?php echo $row['person_rank']; ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="person_formwork" class="form-label">ปฏิบัติการที่</label>
                                    <input type="text" class="form-control" id="person_formwork" name="person_formwork"
                                        value="<?php echo $row['person_formwork']; ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="person_level" class="form-label">ระดับ</label>
                                    <input type="text" class="form-control" id="person_level" name="person_level"
                                        value="<?php echo $row['person_level']; ?>" required>
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

                                <div class="col-md-6">
                                    <label for="person_born" class="form-label">วันเกิด</label>
                                    <input type="date" class="form-control" id="person_born" name="person_born"
                                        value="<?php echo $row['person_born']; ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="person_positionNum" class="form-label">เลขที่ตำแหน่ง</label>
                                    <input type="number" class="form-control" id="person_positionNum"
                                        name="person_positionNum" value="<?php echo $row['person_positionNum']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="person_dateAccepting" class="form-label">วันบรรจุ</label>
                                    <input type="date" class="form-control" id="person_dateAccepting"
                                        name="person_dateAccepting" value="<?php echo $row['person_dateAccepting']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="person_typeHire" class="form-label">ประเภทการจ้าง</label>
                                    <input type="text" class="form-control" id="person_typeHire" name="person_typeHire"
                                        value="<?php echo $row['person_typeHire']; ?>">
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
                                    <label for="person_specialQualification" class="form-label">วุฒิและพรสวรรค์</label>
                                    <input type="text" class="form-control" id="person_specialQualification"
                                        name="person_specialQualification"
                                        value="<?php echo $row['person_specialQualification']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="person_blood" class="form-label">กรุ๊ปเลือด</label>
                                    <input type="text" class="form-control" id="person_blood" name="person_blood"
                                        value="<?php echo $row['person_blood']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="person_cardNum" class="form-label">เลขบัตรข้าราชการ</label>
                                    <input type="text" class="form-control" id="person_cardNum" name="person_cardNum"
                                        value="<?php echo $row['person_cardNum']; ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="person_CardExpired" class="form-label">วันหมดอายุบัตรข้าราชการ</label>
                                    <input type="date" class="form-control" id="person_CardExpired"
                                        name="person_CardExpired" value="<?php echo $row['person_CardExpired']; ?>">
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="assets/static/js/components/dark.js"></script>
        <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="assets/compiled/js/app.js"></script>
</body>

</html>