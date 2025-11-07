 const langBtn = document.getElementById("lang-btn");
    const langMenu = document.getElementById("lang-menu");
    const menuBtn = document.getElementById('menu-toggle');
    const closeBtn = document.getElementById('closeBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    langBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        langMenu.classList.toggle("hidden");
    });

    document.addEventListener("click", (e) => {
        if (!langBtn.contains(e.target)) langMenu.classList.add("hidden");
    });

    const openMenu = () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    };
    const closeMenu = () => {
        sidebar.classList.add('-translate-x-full');
        setTimeout(() => overlay.classList.add('hidden'), 300);
    };

    menuBtn.addEventListener('click', openMenu);
    closeBtn.addEventListener('click', closeMenu);
    overlay.addEventListener('click', closeMenu);


    const mobileSearchBtn = document.getElementById('mobile-search-btn');
    const mobileSearchDropdown = document.getElementById('mobile-search-dropdown');

    mobileSearchBtn.addEventListener('click', () => {
        mobileSearchDropdown.classList.toggle('hidden');
    });
    document.addEventListener('click', (e) => {
        if (!mobileSearchDropdown.contains(e.target) && !mobileSearchBtn.contains(e.target)) {
            mobileSearchDropdown.classList.add('hidden');
        }
    });
