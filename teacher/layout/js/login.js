document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const loginForm = document.querySelector('form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            
            let isValid = true;
            
            if (!email.value.trim()) {
                highlightInvalid(email);
                isValid = false;
            } else {
                highlightValid(email);
            }
            
            if (!password.value.trim()) {
                highlightInvalid(password);
                isValid = false;
            } else {
                highlightValid(password);
            }
            
            if (isValid) {
                // Simulate successful login with a small delay
                const loginButton = document.querySelector('button[type="submit"]');
                const originalText = loginButton.innerHTML;
                loginButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging in...';
                loginButton.disabled = true;
                
                setTimeout(() => {
                    loginButton.innerHTML = originalText;
                    loginButton.disabled = false;
                    // In a real app, you would redirect to the dashboard or home page
                    // For demo purposes, we'll just show an alert
                    console.log('Login successful!');
                    // You could redirect here: window.location.href = 'dashboard.html';
                }, 1500);
            }
        });
    }
    
    // Helper functions for form validation
    function highlightInvalid(element) {
        element.classList.add('is-invalid');
        element.classList.remove('is-valid');
    }
    
    function highlightValid(element) {
        element.classList.remove('is-invalid');
        element.classList.add('is-valid');
    }
    
    // Password visibility toggle
    const passwordField = document.getElementById('password');
    const passwordLabel = passwordField?.closest('div')?.querySelector('label');
    
    if (passwordField && passwordLabel) {
        // Create a toggle button for the password field
        const toggleBtn = document.createElement('button');
        toggleBtn.type = 'button';
        toggleBtn.className = 'btn btn-sm position-absolute end-0 top-50 translate-middle-y me-2';
        toggleBtn.innerHTML = '<i class="bi bi-eye"></i>';
        toggleBtn.style.background = 'none';
        toggleBtn.style.border = 'none';
        toggleBtn.style.padding = '0';
        toggleBtn.style.color = '#6c757d';
        
        toggleBtn.addEventListener('click', function() {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                passwordField.type = 'password';
                this.innerHTML = '<i class="bi bi-eye"></i>';
            }
        });
        
        // Add the toggle button to the password field's parent
        passwordField.parentElement.style.position = 'relative';
        passwordField.parentElement.appendChild(toggleBtn);
    }
    
    // Add subtle hover effects to all buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        if (!button.classList.contains('btn-sm')) { // Exclude small buttons like password toggle
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.transition = 'transform 0.2s ease';
                this.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
            });
        }
    });
});