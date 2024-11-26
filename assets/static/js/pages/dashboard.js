var optionsProfileVisit = {
  annotations: {
    position: "back",
  },
  dataLabels: {
    enabled: false,
  },
  chart: {
    type: "bar", // ชนิดของกราฟ
    height: 300,
    stacked: true, // กรณีต้องการรวม stack bar
    toolbar: {
      show: true,
    },
    horizontal: true, // ตั้งค่าให้กราฟเป็นแนวนอน
  },
  fill: {
    opacity: 1,
  },
  plotOptions: {
    bar: {
      horizontal: true, // กำหนดให้แกนเป็นแนวนอน
      barHeight: "70%", // ขนาดความสูงของแต่ละแถบ
    },
  },
  series: [
    {
      name: "จำนวนคน",
      data: [50, 60, 70, 80, 40, 90], // จำนวนคนตามตำแหน่ง
    },
  ],
  colors: ["#435ebe"], // สีของแถบกราฟ
  xaxis: {
    title: {
      text: "จำนวนคน", // ชื่อแกน X
    },
    categories: [
      "Admin", // ประเภทตำแหน่ง person_rank
      "Nurse",
      "Doctor",
      "Technician",
      "Cleaner",
      "Manager",
    ],
  },
  yaxis: {
    title: {
      text: "ตำแหน่งงาน (person_rank)", // ชื่อแกน Y
    },
  },
  legend: {
    position: "top", // กำหนดตำแหน่งของ legend
  },
}

var chartProfileVisit = new ApexCharts(
  document.querySelector("#chart-profile-visit"), // ตำแหน่งของกราฟใน HTML
  optionsProfileVisit
)

chartProfileVisit.render()
