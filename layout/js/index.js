document.addEventListener('DOMContentLoaded', function() {
    // Add some subtle animations when page loads
    setTimeout(() => {
        const heroText = document.querySelector('.display-4');
        const heroImage = document.querySelector('.student-image-container');
        const buttons = document.querySelectorAll('.hero-section .btn');
        
        if (heroText) heroText.style.opacity = '1';
        if (heroImage) heroImage.style.opacity = '1';
        
        buttons.forEach((btn, index) => {
            setTimeout(() => {
                btn.style.opacity = '1';
                btn.style.transform = 'translateY(0)';
            }, 100 * index);
        });
    }, 300);

    // Add hover effects for navigation elements
    const navLinks = document.querySelectorAll('.navbar .nav-link, .navbar .btn');
    navLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Add some parallax-like effect on mouse move for the hero section
    const heroSection = document.querySelector('.hero-section');
    const studentImage = document.querySelector('.student-image-container');
    const accentStar = document.querySelector('.accent-star');
    const accentSquare = document.querySelector('.accent-square');
    
    if (heroSection && studentImage && accentStar && accentSquare) {
        heroSection.addEventListener('mousemove', function(e) {
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            
            studentImage.style.transform = `rotate(-5deg) translate(${x * 10}px, ${y * 10}px)`;
            accentStar.style.transform = `translate(${x * -15}px, ${y * -15}px)`;
            accentSquare.style.transform = `rotate(15deg) translate(${x * 20}px, ${y * 20}px)`;
        });
        
        heroSection.addEventListener('mouseleave', function() {
            studentImage.style.transform = 'rotate(-5deg)';
            accentStar.style.transform = 'translate(0, 0)';
            accentSquare.style.transform = 'rotate(15deg)';
        });
    }
});