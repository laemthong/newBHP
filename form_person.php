<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบบันทึกข้อมูลบุคลากร</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="container bg-white p-4 rounded shadow" style="max-width: 800px;">
        <h2 class="text-center text-success mb-4">ระบบบันทึกข้อมูลบุคลากร</h2>
        <form id="personnelForm" action="save_personnel.php" method="POST" onsubmit="return validateForm()">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label"><span class="text-danger">*</span> ลำดับที่:</label>
                    <input type="number" name="person_id" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><span class="text-danger">*</span> ชื่อ - สกุล:</label>
                    <input type="text" name="person_name" class="form-control" maxlength="255" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><span class="text-danger">*</span> เพศ:</label>
                    <select name="person_gender" class="form-select" required>
                        <option value="">เลือกเพศ</option>
                        <option value="ชาย">ชาย</option>
                        <option value="หญิง">หญิง</option>
                        <option value="อื่นๆ">อื่นๆ</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">ตำแหน่ง:</label>
                    <input type="text" name="person_rank" class="form-control" maxlength="255">
                </div>

                <div class="col-md-6">
                    <label class="form-label">ปฏิบัติการที่:</label>
                    <select name="person_formwork" class="form-select" required>
                        <option value="">เลือกปฏิบัติการ</option>
                        <option value="องค์กรแพทย์">องค์กรแพทย์</option>
                        <option value="กลุ่มงานบริหารทั่วไป">กลุ่มงานบริหารทั่วไป</option>
                        <option value="เภสัชกรรมและคุ้มครองผู้บริโภค">เภสัชกรรมและคุ้มครองผู้บริโภค</option>
                        <option value="โภชนศาสตร์">โภชนศาสตร์</option>
                        <option value="แพทย์แผนไทยและแพทย์ทางเลือก">แพทย์แผนไทยและแพทย์ทางเลือก</option>
                        <option value="เวชศาสตร์ฟื้นฟู">เวชศาสตร์ฟื้นฟู</option>
                        <option value="ประกันสุขภาพ ยุทธศาสตร์ และสารสนเทศทางการแพทย์">ประกันสุขภาพ ยุทธศาสตร์
                            และสารสนเทศทางการแพทย์</option>
                        <option value="เทคนิคการแพทย์">เทคนิคการแพทย์</option>
                        <option value="บริการด้านปฐมภูมิและองค์รวม">บริการด้านปฐมภูมิและองค์รวม</option>
                        <option value="ทันตกรรม">ทันตกรรม</option>
                        <option value="รังสีวิทยา">รังสีวิทยา</option>
                        <option value="จิตเวชและยาเสพติด">จิตเวชและยาเสพติด</option>
                        <option value="การพยาบาล">การพยาบาล</option>
                    </select>
                </div>



                <div class="col-md-6">
                    <label class="form-label">ระดับ:</label>
                    <input type="text" name="person_level" class="form-control" maxlength="255">
                </div>

                <div class="col-md-6">
                    <label class="form-label">เงินเดือน:</label>
                    <input type="number" name="person_salary" class="form-control" step="0.01">
                </div>

                <div class="col-md-6">
                    <label class="form-label">ชื่อเล่น:</label>
                    <input type="text" name="person_nickname" class="form-control" maxlength="255">
                </div>

                <div class="col-md-6">
                    <label class="form-label">วันเดือนปีเกิด:</label>
                    <input type="date" name="person_born" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">เลขที่ตำแหน่ง:</label>
                    <input type="number" name="person_positionNum" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">วันที่บรรจุ:</label>
                    <input type="date" name="person_dateAccepting" class="form-control">
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
                    <label class="form-label">เงินประจำตำแหน่ง:</label>
                    <input type="number" name="person_positionAllowance" class="form-control" step="0.01">
                </div>

                <div class="col-md-6">
                    <label class="form-label">เบอร์โทรศัพท์:</label>
                    <input type="tel" name="person_phone" class="form-control" pattern="[0-9]{10}"
                        title="กรุณากรอกหมายเลขโทรศัพท์ 10 หลัก">
                </div>

                <div class="col-md-6">
                    <label class="form-label">วุฒิพิเศษทางการ:</label>
                    <input type="text" name="person_specialQualification" class="form-control" maxlength="255">
                </div>

                <div class="col-md-6">
                    <label class="form-label">กรุ๊ปเลือด:</label>
                    <select name="person_blood" class="form-select">
                        <option value="">เลือกกรุ๊ปเลือด</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">เลขที่บัตรข้าราชการ:</label>
                    <input type="text" name="person_cardNum" class="form-control" maxlength="13" pattern="[0-9]{13}"
                        title="กรุณากรอกเลขบัตร 13 หลัก">
                </div>

                <div class="col-md-6">
                    <label class="form-label">วันหมดอายุบัตรข้าราชการ:</label>
                    <input type="date" name="person_CardExpired" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-4 w-100">บันทึกข้อมูล</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            const form = document.getElementById('personnelForm');
            let isValid = true;

            // ตรวจสอบวันที่
            const dateFields = ['person_born', 'person_dateAccepting', 'person_CardExpired'];
            dateFields.forEach(fieldName => {
                const field = form[fieldName];
                if (field.value) {
                    const date = new Date(field.value);
                    if (isNaN(date.getTime())) {
                        alert(`กรุณากรอก${field.previousElementSibling.textContent.replace(':', '')}ให้ถูกต้อง`);
                        isValid = false;
                    }
                }
            });

            // ตรวจสอบเบอร์โทรศัพท์
            const phone = form['person_phone'];
            if (phone.value && !/^\d{10}$/.test(phone.value)) {
                alert('กรุณากรอกเบอร์โทรศัพท์ 10 หลัก');
                isValid = false;
            }

            // ตรวจสอบเลขบัตร
            const cardNum = form['person_cardNum'];
            if (cardNum.value && !/^\d{13}$/.test(cardNum.value)) {
                alert('กรุณากรอกเลขบัตร 13 หลัก');
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>

</html>