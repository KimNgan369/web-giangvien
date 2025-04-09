document.addEventListener('DOMContentLoaded', function() {
    console.log('Trang lớp học đã sẵn sàng!');
    
    // Hiệu ứng khi di chuột qua card môn học
    const subjectCards = document.querySelectorAll('.subject-card');
    subjectCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 15px rgba(0, 0, 0, 0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.05)';
        });
    });
    
    // Xử lý click vào nút "Vào lớp học"
    const joinButtons = document.querySelectorAll('.btn-accent');
    joinButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const subjectName = this.closest('.subject-card').querySelector('.card-title').textContent;
            alert(`Bạn đã chọn tham gia lớp: ${subjectName}`);
            // Có thể thêm code chuyển hướng đến lớp học thực tế ở đây
        });
    });
    
    // Xử lý nút "Thêm môn"
    const addSubjectBtn = document.querySelector('.subject-card:last-child .btn-outline-primary');
    if (addSubjectBtn) {
        addSubjectBtn.addEventListener('click', function() {
            alert('Tính năng thêm môn học mới sẽ được kích hoạt sau!');
        });
    }
});