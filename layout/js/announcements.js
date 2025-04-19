document.addEventListener('DOMContentLoaded', function() {
    // Check if user is teacher (for demo purposes, we'll assume the user is a teacher if the create post button exists)
    const isTeacher = document.getElementById('createPostBtn') !== null;
    
    // Handle image upload preview
    const postImage = document.getElementById('postImage');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const removeImage = document.getElementById('removeImage');
    
    if (postImage) {
        postImage.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const url = URL.createObjectURL(file);
                previewImg.src = url;
                imagePreview.classList.remove('d-none');
            }
        });
    }
    
    if (removeImage) {
        removeImage.addEventListener('click', function() {
            postImage.value = '';
            imagePreview.classList.add('d-none');
            previewImg.src = '';
        });
    }
    
    // Handle form submission
    const postForm = document.getElementById('postForm');
    
    if (postForm) {
        postForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const content = document.getElementById('postContent').value;
            const course = document.getElementById('postCourse').value;
            const category = document.getElementById('postCategory').value;
            const imageFile = postImage.files[0];
            
            // Validate form
            if (!content || !course || !category) {
                alert('Vui lòng điền đầy đủ thông tin bài đăng');
                return;
            }
            
            // In a real application, you would send this data to your server
            // For demo purposes, we'll just create a new post element and add it to the DOM
            createNewPost(content, course, category, imageFile);
            
            // Close modal and reset form
            const modal = bootstrap.Modal.getInstance(document.getElementById('createPostModal'));
            modal.hide();
            postForm.reset();
            imagePreview.classList.add('d-none');
        });
    }
    
    // Function to create new post
    function createNewPost(content, course, category, imageFile) {
        
        // Create post element
        const post = document.createElement('div');
        post.className = 'card shadow-sm mb-4 post';
        
        // Set post HTML
        let postHTML = `
            <div class="card-header bg-white d-flex align-items-center p-3">
                <img src="../img/avatar-teacher.jpg" class="rounded-circle avatar me-3" alt="Avatar">
                <div>
                    <h6 class="mb-0 fw-bold">Giảng viên A</h6>
                    <small class="text-muted">Vừa xong • <i class="fas fa-globe-asia"></i></small>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text">${content}</p>
                <span class="badge bg-category mb-3">${categoryNames[category]}</span>
        `;
        
        // Add image if uploaded
        if (imageFile) {
            const imageUrl = URL.createObjectURL(imageFile);
            postHTML += `
                <div class="post-image mb-3">
                    <img src="${imageUrl}" class="img-fluid rounded" alt="Uploaded image">
                </div>
            `;
        }
        
        postHTML += `
            </div>
            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                <div class="post-stats">
                    <span><i class="fas fa-eye text-primary me-1"></i> 0 lượt xem</span>
                </div>
                <div class="post-course">
                    <span class="text-muted"><i class="fas fa-book me-1"></i> ${courseNames[course]}</span>
                </div>
            </div>
        `;
        
        post.innerHTML = postHTML;
        
        // Add to post list at the top
        const postList = document.querySelector('.post-list');
        postList.insertBefore(post, postList.firstChild);
        
        // Show success message
        alert('Đăng bài thành công!');
    }
    
    // Handle hiding/showing teacher-specific elements based on user role
    function setupUserInterface() {
        const teacherElements = document.querySelectorAll('.teacher-only');
        teacherElements.forEach(element => {
            if (!isTeacher) {
                element.classList.add('d-none');
            }
        });
    }
    
    setupUserInterface();
});