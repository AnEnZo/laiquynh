<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê doanh thu</title>
    <style>
        .btn-quaylai {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
            background-color: green;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-quaylai:hover {
            background-color: #0056b3;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Thống kê doanh thu</h1>
    <select id="statisticType">
        <option value="monthly">Theo tháng</option>
        <option value="yearly">Theo năm</option>
    </select>
    <input type="month" id="monthInput">
    <input type="number" id="yearInput" placeholder="Nhập năm" min="2000" max="2100" style="display:none;">
    <canvas id="myChart" width="400" height="200"></canvas>
    
    <script>
        // Lấy dữ liệu từ file PHP
        fetch('chitietdoanhthu.php')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('myChart').getContext('2d');
                let myChart;

                function updateChart() {
                    const type = document.getElementById('statisticType').value;
                    const month = document.getElementById('monthInput').value;
                    const year = document.getElementById('yearInput').value;

                    if (type === 'monthly') {
                        showMonthlyData(data, month);
                        document.getElementById('monthInput').style.display = 'inline';
                        document.getElementById('yearInput').style.display = 'none';
                    } else if (type === 'yearly') {
                        if (year) {
                            showYearlyData(data, year);
                        } else {
                            const today = new Date();
                            const currentYear = today.getFullYear();
                            showYearlyData(data, currentYear.toString());
                            document.getElementById('yearInput').value = currentYear;
                        }
                        document.getElementById('monthInput').style.display = 'none';
                        document.getElementById('yearInput').style.display = 'inline';
                    }
                }

                // Hàm hiển thị dữ liệu theo tháng
                function showMonthlyData(data, month) {
                   
                    const revenueByDay = {};
                    data.forEach(item => {
                        
                        if (item.ngay.startsWith(month)
                                ) {
                                   
                            const day = item.ngay;
                            if (!revenueByDay[day]) {
                                revenueByDay[day] = 0;
                            }
                            revenueByDay[day] += parseFloat(item.tongtienngay);
                        }
                    });

                    const labels = [];
                    const totalAmount = [];

                    // Lặp qua tất cả các ngày trong tháng để tạo nhãn và dữ liệu
                    const daysInMonth = new Date(parseInt(month.slice(0, 4)), parseInt(month.slice(5, 7)), 0).getDate();
                    for (let i = 1; i <= daysInMonth; i++) {
                        const dayKey = `${month}-${i < 10 ? '0' + i : i}`;
                        labels.push(dayKey);
                        totalAmount.push(revenueByDay[dayKey] || 0);
                    }

                    if (myChart) {
                        myChart.destroy();
                    }

                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Doanh thu',
                                data: totalAmount,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                                barThickness: 20
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                },
                                x: {
                                    max: labels.length
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                    document.getElementById('totalOrders').textContent = `Tổng số đơn hàng: ${totalOrders}`;
            
                }

                // Hàm hiển thị dữ liệu theo năm
                function showYearlyData(data, year) {
                    const revenueByMonth = {};
                    data.forEach(item => {
                        if (item.ngay.startsWith(year)) {
                            const month = item.ngay.slice(5, 7); // Lấy tháng từ chuỗi ngày
                            if (!revenueByMonth[month]) {
                                revenueByMonth[month] = 0;
                            }
                            revenueByMonth[month] += parseFloat(item.tongtienngay);
                        }
                    });

                    const labels = [];
                    const totalAmount = [];

                    for (let i = 1; i <= 12; i++) {
                        const monthKey = i < 10 ? `0${i}` : `${i}`;
                        labels.push(monthKey);
                        totalAmount.push(revenueByMonth[monthKey] || 0);
                    }

                    if (myChart) {
                        myChart.destroy();
                    }

                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Doanh thu',
                                data: totalAmount,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                                barThickness: 20
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                },
                                x: {
                                    max: labels.length
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                }

                // Sự kiện thay đổi của combobox và input date
                document.getElementById('statisticType').addEventListener('change', function () {
                    updateChart();
                });
                document.getElementById('monthInput').addEventListener('change', updateChart);
                document.getElementById('yearInput').addEventListener('change', updateChart);

                // Hiển thị mặc định theo tháng
                const today = new Date();
                const defaultMonth = today.toISOString().slice(0, 7); // Lấy tháng hiện tại
                document.getElementById('monthInput').value = defaultMonth;
                showMonthlyData(data, defaultMonth);
            });
    </script>
    <a href="/baiktracuoiky/dta/trangchu.php" class="btn-quaylai">Quay lại</a>
</body>
</html>
