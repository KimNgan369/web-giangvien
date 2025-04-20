document.addEventListener('DOMContentLoaded', function() {
    // Enable tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Form edit functionality (simplified for demo)
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const field = this.dataset.field;
            const valueElement = document.getElementById(`value-${field}`);
            const currentValue = valueElement.textContent;
            
            // In a real app, this would show a modal or inline form for editing
            const newValue = prompt(`Chỉnh sửa ${this.dataset.label}`, currentValue);
            
            if (newValue !== null && newValue !== currentValue) {
                valueElement.textContent = newValue;
                // Here you would typically send an AJAX request to save the changes
                console.log(`Updated ${field} to: ${newValue}`);
            }
        });
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});