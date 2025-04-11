// Populate years dropdown (current year - 100 to current year)
const yearSelect = document.getElementById('year');
const currentYear = new Date().getFullYear();

for (let year = currentYear; year >= currentYear - 100; year--) {
    const option = document.createElement('option');
    option.value = year;
    option.textContent = year;
    yearSelect.appendChild(option);
}

// Role selector functionality
const roleButtons = document.querySelectorAll('.role-selector .btn');
roleButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Remove active class from all buttons
        roleButtons.forEach(btn => {
            btn.classList.remove('active-role');
        });
        
        // Add active class to clicked button
        button.classList.add('active-role');
    });
});

// Form submission
document.getElementById('signup-form').addEventListener('submit', function(e) {
    e.preventDefault();
    // Get selected role
    const selectedRole = document.querySelector('.active-role').id.replace('role-', '');
    
    // Get form values
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    
    // In a real application, you would send this data to the server
    console.log('Sign up form submitted:', { 
        role: selectedRole,
        email: email,
        password: password,
        birthMonth: month,
        birthYear: year
    });
    
    // Show confirmation (in a real app, you'd redirect or show success message)
    alert('Thank you for signing up as a ' + selectedRole + '!');
});