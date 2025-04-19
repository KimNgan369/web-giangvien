document.addEventListener('DOMContentLoaded', function() {
    // Xác định vai trò người dùng (giảng viên/học sinh)
    const userRole = 'teacher'; // Thay đổi thành 'student' để xem giao diện học sinh
    
    // Ẩn nút đăng thông báo nếu là học sinh
    if (userRole === 'student') {
        document.querySelector('.btn-primary[data-bs-toggle="modal"]').style.display = 'none';
    }
    
    // Xử lý form đăng thông báo
    const announcementForm = document.getElementById('announcementForm');
    if (announcementForm) {
        announcementForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Lấy dữ liệu từ form
            const title = document.getElementById('announcementTitle').value;
            const course = document.getElementById('announcementCourse').value;
            const type = document.getElementById('announcementType').value;
            const content = document.getElementById('announcementContent').value;
            const isImportant = document.getElementById('announcementImportant').checked;
            
            // Tạo thông báo mới (trong thực tế sẽ gửi AJAX request đến server)
            console.log('Đăng thông báo:', {
                title,
                course,
                type,
                content,
                isImportant
            });
            
            // Hiển thị thông báo thành công
            alert('Đăng thông báo thành công!');
            
            // Đóng modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addAnnouncementModal'));
            modal.hide();
            
            // Reset form
            announcementForm.reset();
        });
    }
    
    // Xử lý lọc thông báo
    const filterForm = document.querySelector('.card-body form');
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const course = document.getElementById('courseFilter').value;
            const type = document.getElementById('typeFilter').value;
            const date = document.getElementById('dateFilter').value;
            
            console.log('Lọc thông báo theo:', {
                course,
                type,
                date
            });
            
            // Trong thực tế sẽ gửi AJAX request để lọc dữ liệu
            alert('Đã áp dụng bộ lọc: ' + [course, type, date].filter(Boolean).join(', '));
        });
    }
    
    // Xử lý lưu thông báo
    document.querySelectorAll('.btn-outline-primary:not([data-bs-toggle])').forEach(btn => {
        btn.addEventListener('click', function() {
            const announcementTitle = this.closest('.list-group-item').querySelector('h5').textContent;
            if (this.innerHTML.includes('bookmark')) {
                this.innerHTML = '<i class="fas fa-bookmark me-1"></i> Đã lưu';
                alert('Đã lưu thông báo: ' + announcementTitle);
            } else {
                this.innerHTML = '<i class="far fa-bookmark me-1"></i> Lưu';
                alert('Đã bỏ lưu thông báo: ' + announcementTitle);
            }
        });
    });
    
    // Xử lý tải file đính kèm
    document.querySelectorAll('a[href="#"]').forEach(link => {
        if (link.textContent.includes('File đính kèm')) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Đang tải file đính kèm...');
            });
        }
    });
    
    // Khởi tạo date picker (giả lập)
    document.getElementById('dateFilter').addEventListener('focus', function() {
        alert('Trong thực tế sẽ hiển thị date picker để chọn khoảng thời gian');
    });
});