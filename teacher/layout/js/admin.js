document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
    });

    // Initialize Charts
    if(document.getElementById('topDownloadsChart')) {
        // Top Downloads Chart (Bar)
        const topDownloadsCtx = document.getElementById('topDownloadsChart').getContext('2d');
        const topDownloadsChart = new Chart(topDownloadsCtx, {
            type: 'bar',
            data: {
                labels: ['Toán cao cấp', 'Lập trình C++', 'Cơ sở dữ liệu', 'Trí tuệ nhân tạo', 'Mạng máy tính'],
                datasets: [{
                    label: 'Lượt tải',
                    backgroundColor: '#8E44AD',
                    borderColor: '#7d3b9b',
                    borderWidth: 1,
                    data: [1250, 980, 870, 650, 420],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    if(document.getElementById('userRolesChart')) {
        // User Roles Chart (Pie)
        const userRolesCtx = document.getElementById('userRolesChart').getContext('2d');
        const userRolesChart = new Chart(userRolesCtx, {
            type: 'pie',
            data: {
                labels: ['Admin', 'Moderator', 'User'],
                datasets: [{
                    data: [5, 15, 1225],
                    backgroundColor: ['#8E44AD', '#FDCB6E', '#3498DB'],
                    hoverBackgroundColor: ['#7d3b9b', '#f8c14d', '#2980B9'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                },
            },
        });
    }

    // User Management - Edit Button
    document.querySelectorAll('#userTable .btn-accent').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.closest('tr').querySelector('td').textContent;
            alert(`Chỉnh sửa người dùng ID: ${userId}`);
            // Thêm logic chỉnh sửa người dùng ở đây
        });
    });

    // User Management - Delete Button
    document.querySelectorAll('#userTable .btn-danger').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const userName = row.querySelector('td:nth-child(2)').textContent;
            
            if(confirm(`Bạn có chắc muốn xóa người dùng "${userName}"?`)) {
                row.remove();
                alert(`Đã xóa người dùng "${userName}"`);
            }
        });
    });

    // Violated Documents - View Button
    document.querySelectorAll('#violatedDocsTable .btn-accent').forEach(btn => {
        btn.addEventListener('click', function() {
            const docName = this.closest('tr').querySelector('td:nth-child(2)').textContent;
            alert(`Xem chi tiết tài liệu: ${docName}`);
        });
    });

    // Violated Documents - Delete Button
    document.querySelectorAll('#violatedDocsTable .btn-danger').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const docName = row.querySelector('td:nth-child(2)').textContent;
            
            if(confirm(`Xóa tài liệu vi phạm "${docName}"?`)) {
                row.remove();
                alert(`Đã xóa tài liệu "${docName}"`);
            }
        });
    });

    // Violated Documents - Approve Button
    document.querySelectorAll('#violatedDocsTable .btn-success').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const docName = row.querySelector('td:nth-child(2)').textContent;
            
            if(confirm(`Duyệt tài liệu "${docName}"?`)) {
                row.remove();
                alert(`Đã duyệt tài liệu "${docName}"`);
            }
        });
    });
});