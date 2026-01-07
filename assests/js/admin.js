document.addEventListener("DOMContentLoaded", function() {
    
    // Select Elements
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const closeBtn = document.getElementById('close-sidebar');
    const openBtn = document.getElementById('sidebarCollapse'); // The Hamburger in your main page

    // 1. Function to OPEN
    function openMenu() {
        sidebar.classList.add('active');
        overlay.classList.add('active');
    }

    // 2. Function to CLOSE
    function closeMenu() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    }

    // 3. Event Listeners
    if(openBtn) {
        openBtn.addEventListener('click', openMenu);
    }
    
    if(closeBtn) {
        closeBtn.addEventListener('click', closeMenu);
    }
    
    if(overlay) {
        overlay.addEventListener('click', closeMenu); // Click outside to close
    }

    // Optional: Close menu when a link is clicked (good for mobile)
    const links = document.querySelectorAll('.components li a');
    links.forEach(link => {
        link.addEventListener('click', closeMenu);
    });
});
document.addEventListener("DOMContentLoaded", function() {
    
    // --- SIDEBAR LOGIC ---
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const closeBtn = document.getElementById('close-sidebar');
    const openBtn = document.getElementById('sidebarCollapse');

    function toggleMenu(show) {
        if (show) {
            sidebar.classList.add('active');
            overlay.classList.add('active');
        } else {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        }
    }

    if(openBtn) openBtn.addEventListener('click', () => toggleMenu(true));
    if(closeBtn) closeBtn.addEventListener('click', () => toggleMenu(false));
    if(overlay) overlay.addEventListener('click', () => toggleMenu(false));

    // --- CATEGORY FILTER LOGIC ---
    const filterBtns = document.querySelectorAll('.category-btn');
    const bookCards = document.querySelectorAll('.book-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // 1. Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // 2. Add active class to clicked button
            btn.classList.add('active');

            const filterValue = btn.getAttribute('data-filter');

            // 3. Loop through books and hide/show based on category
            bookCards.forEach(card => {
                const category = card.getAttribute('data-category');

                if (filterValue === 'all' || filterValue === category) {
                    card.style.display = 'flex'; // Use flex to maintain layout
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});