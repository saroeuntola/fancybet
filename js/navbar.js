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

const html = document.documentElement;
const themeButton = document.getElementById("theme-toggle");
let themeIcon = document.getElementById("theme-icon");

function setIcons(dark) {
  const sunImg = "/image/sun-24.ico";
  const moonIcon = `
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
  `;

  if (dark) {
    themeIcon.outerHTML = `
      <img id="theme-icon" src="${sunImg}" alt="Sun"
        class="transition-transform duration-300 cursor-pointer text-white">
    `;
  } else {
    themeIcon.outerHTML = `
      <svg id="theme-icon"
        class="h-6 w-6 text-white transition-transform duration-300 cursor-pointer"
        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        ${moonIcon}
      </svg>
    `;
  }

  themeIcon = document.getElementById("theme-icon");
}

function setTheme(dark) {
  if (dark) {
    html.classList.add("dark");
  } else {
    html.classList.remove("dark");
  }

  localStorage.setItem("theme", dark ? "dark" : "light");
  setIcons(dark);
}

function toggleTheme() {
  const isDark = html.classList.contains("dark");
  setTheme(!isDark);

  themeIcon.classList.add("rotate-180");
  setTimeout(() => themeIcon.classList.remove("rotate-180"), 300);
}

themeButton.addEventListener("click", toggleTheme);

// 🔹 DEFAULT: Light Theme
const saved = localStorage.getItem("theme");
const isDarkMode = saved === "dark" ? true : false; // default light
setTheme(isDarkMode);


  document.addEventListener("DOMContentLoaded", () => {
    const dropdowns = document.querySelectorAll(".dropdown");
    dropdowns.forEach((dropdown) => {
      const toggle = dropdown.querySelector(".dropdown-toggle");
      const submenu = dropdown.querySelector(".submenu");
      // Toggle submenu on click
      toggle.addEventListener("click", (e) => {
        e.stopPropagation();
        submenu.classList.toggle("hidden");
      });

      dropdown.addEventListener("mouseenter", () => {
        submenu.classList.remove("hidden");
      });
      // Close submenu when clicking outside
      document.addEventListener("click", (e) => {
        if (!dropdown.contains(e.target)) {
          submenu.classList.add("hidden");
        }
      });
    });
  });
   document.addEventListener("DOMContentLoaded", () => {
     const mobileDropdowns = document.querySelectorAll(".mobile-dropdown");
     mobileDropdowns.forEach((dropdown) => {
       const toggle = dropdown.querySelector(".mobile-dropdown-toggle");
       const submenu = dropdown.querySelector(".mobile-submenu");
       const icon = dropdown.querySelector("i");
       toggle.addEventListener("click", () => {
         submenu.classList.toggle("hidden");
         icon.classList.toggle("rotate-180");
         icon.classList.toggle("transition-transform");
       });
     });
   });

