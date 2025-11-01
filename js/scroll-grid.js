document.addEventListener("DOMContentLoaded", () => {
  // Get all scroll sections
  const scrollSections = document.querySelectorAll(".scroll-section");

  scrollSections.forEach((section) => {
    const postGrid = section.querySelector(".scroll-grid");
    const scrollLeftBtn = section.querySelector(".scroll-left");
    const scrollRightBtn = section.querySelector(".scroll-right");

    if (!postGrid) return;

    let isDown = false;
    let startX, scrollLeft;

    // --- Drag Scroll ---
    postGrid.addEventListener("mousedown", (e) => {
      isDown = true;
      postGrid.classList.add("cursor-grabbing");
      startX = e.pageX - postGrid.offsetLeft;
      scrollLeft = postGrid.scrollLeft;
    });

    postGrid.addEventListener("mouseleave", () => {
      isDown = false;
      postGrid.classList.remove("cursor-grabbing");
    });

    postGrid.addEventListener("mouseup", () => {
      isDown = false;
      postGrid.classList.remove("cursor-grabbing");
    });

    postGrid.addEventListener("mousemove", (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - postGrid.offsetLeft;
      const walk = (x - startX) * 1.2;
      postGrid.scrollLeft = scrollLeft - walk;
    });

    // --- Arrow Buttons ---
    const scrollAmount = 350;

    if (scrollLeftBtn) {
      scrollLeftBtn.addEventListener("click", () => {
        postGrid.scrollBy({ left: -scrollAmount, behavior: "smooth" });
      });
    }

    if (scrollRightBtn) {
      scrollRightBtn.addEventListener("click", () => {
        postGrid.scrollBy({ left: scrollAmount, behavior: "smooth" });
      });
    }
  });
});
