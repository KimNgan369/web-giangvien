document.addEventListener('DOMContentLoaded', function() {
    console.log('Trang hồ sơ người dùng đã sẵn sàng!');
    
    // Toggle hiển thị mật khẩu
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
    
    // Xử lý form thông tin cá nhân
    const profileForm = document.querySelector('#profile form');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thông tin cá nhân đã được cập nhật!');
            // Có thể thêm code AJAX để gửi dữ liệu lên server ở đây
        });
    }
    
    // Xử lý form đổi mật khẩu
    const passwordForm = document.querySelector('#password form');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Kiểm tra mật khẩu mới
            if (newPassword !== confirmPassword) {
                alert('Mật khẩu mới không khớp!');
                return;
            }
            
            // Kiểm tra độ mạnh mật khẩu (đơn giản)
            if (newPassword.length < 8) {
                alert('Mật khẩu phải có ít nhất 8 ký tự!');
                return;
            }
            
            alert('Mật khẩu đã được thay đổi thành công!');
            // Có thể thêm code AJAX để gửi dữ liệu lên server ở đây
        });
    }
    
    // Hiệu ứng khi di chuột qua nút
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });
});