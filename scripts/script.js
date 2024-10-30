const appearElements = document.querySelectorAll(".appear");

const appearOnScroll = new IntersectionObserver(
  (entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("active");
        observer.unobserve(entry.target);
      }
    });
  },
  {
    threshold: 0.1,
  }
);

appearElements.forEach((element) => {
  appearOnScroll.observe(element);
});
