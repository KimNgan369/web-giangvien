document.addEventListener('DOMContentLoaded', function() {
    // Lấy các phần tử DOM
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteDocumentName = document.getElementById('deleteDocumentName');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    
    // Xử lý sự kiện click cho tất cả nút xóa
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Lấy data attributes từ nút được click
            const documentId = this.getAttribute('data-id');
            const documentName = this.getAttribute('data-name');
            
            // Cập nhật nội dung modal
            deleteDocumentName.textContent = documentName;
            confirmDeleteBtn.href = `documents.php?action=delete&id=${documentId}`;
            
            // Hiển thị modal
            deleteModal.show();
        });
    });
    
    // Tự động ẩn thông báo sau 5 giây
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 150);
        });
    }, 5000);
});