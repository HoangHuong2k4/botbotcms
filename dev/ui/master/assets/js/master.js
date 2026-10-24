document.addEventListener('DOMContentLoaded', () => {
    const introCard = document.querySelector('.intro-card');
    
    if (introCard) {
        // Trigger reveal after a short delay for a smoother feel
        setTimeout(() => {
            introCard.classList.add('reveal');
        }, 100);
    }
    
    // Optional: Add a subtle parallax effect on mouse move
    if (window.innerWidth > 1024) {
        document.addEventListener('mousemove', (e) => {
            const { clientX, clientY } = e;
            const centerX = window.innerWidth / 2;
            const centerY = window.innerHeight / 2;
            
            const moveX = (clientX - centerX) / 50;
            const moveY = (clientY - centerY) / 50;
            
            if (introCard) {
                introCard.style.transform = `translate(${moveX}px, ${moveY}px)`;
            }
        });
    }
});
