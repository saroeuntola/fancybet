document.addEventListener("DOMContentLoaded", () => {
  const grid = document.getElementById("relatedGrid");
  const prevBtn = document.getElementById("relatedPrev");
  const nextBtn = document.getElementById("relatedNext");

  // Drag to scroll
  let isDown = false;
  let startX;
  let scrollLeft;

  grid.addEventListener("mousedown", (e) => {
    isDown = true;
    grid.classList.add("cursor-grabbing");
    startX = e.pageX - grid.offsetLeft;
    scrollLeft = grid.scrollLeft;
  });

  grid.addEventListener("mouseleave", () => {
    isDown = false;
    grid.classList.remove("cursor-grabbing");
  });

  grid.addEventListener("mouseup", () => {
    isDown = false;
    grid.classList.remove("cursor-grabbing");
  });

  grid.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - grid.offsetLeft;
    const walk = (x - startX) * 1.2;
    grid.scrollLeft = scrollLeft - walk;
  });

  // Arrow buttons scroll
  const scrollAmount = 320; // adjust per card width + gap
  nextBtn.addEventListener("click", () => {
    grid.scrollBy({
      left: scrollAmount,
      behavior: "smooth",
    });
  });
  prevBtn.addEventListener("click", () => {
    grid.scrollBy({
      left: -scrollAmount,
      behavior: "smooth",
    });
  });
});

function copyPostLink(link) {
  const button = document.getElementById("copyLinkBtn");
  const originalText = button.innerHTML;

  function setCopied() {
    button.innerHTML = '<i class="fas fa-check"></i> Copied!';
    setTimeout(() => {
      button.innerHTML = originalText;
    }, 2000);
  }

  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard
      .writeText(link)
      .then(setCopied)
      .catch(() => fallbackCopy(link, setCopied));
  } else {
    fallbackCopy(link, setCopied);
  }
}

function fallbackCopy(link, callback) {
  const tempInput = document.createElement("input");
  tempInput.value = link;
  document.body.appendChild(tempInput);
  tempInput.select();
  document.execCommand("copy");
  document.body.removeChild(tempInput);
  callback();
}
