document.addEventListener("DOMContentLoaded", function () {
  const slider = document.getElementById("mainSlider");
  const slides = slider.querySelectorAll("a");
  const dots = document.querySelectorAll("#sliderDots .dot");
  const prev = document.getElementById("prevSlide");
  const next = document.getElementById("nextSlide");
  let current = 0;
  let interval;

  function showSlide(index) {
    const offset = -index * 100;
    slider.style.transform = `translateX(${offset}%)`;
    dots.forEach((dot, i) => {
      dot.classList.toggle("bg-red-600", i === index);
      dot.classList.toggle("bg-gray-400", i !== index);
    });
    current = index;
  }

  function nextSlide() {
    showSlide((current + 1) % slides.length);
  }

  function prevSlideFunc() {
    showSlide((current - 1 + slides.length) % slides.length);
  }

  function startAutoSlide() {
    interval = setInterval(nextSlide, 4000);
  }

  function stopAutoSlide() {
    clearInterval(interval);
  }

  dots.forEach((dot, i) => {
    dot.addEventListener("click", () => {
      stopAutoSlide();
      showSlide(i);
      startAutoSlide();
    });
  });

  next.addEventListener("click", () => {
    stopAutoSlide();
    nextSlide();
    startAutoSlide();
  });

  prev.addEventListener("click", () => {
    stopAutoSlide();
    prevSlideFunc();
    startAutoSlide();
  });

  startAutoSlide();
});
