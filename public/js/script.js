// modal
function closeModal() {
  document.getElementById("myModal").classList.add("hidden");
}

// navbar fixed
window.onscroll = function () {
  const navbar = document.querySelector("#navbar");
  const fixedNav = navbar.offsetTop;

  if (window.pageYOffset > fixedNav) {
    navbar.classList.add("navbar-fixed");
  } else {
    navbar.classList.remove("navbar-fixed");
  }
};

// menu slider
new Glide(".glide", {
  type: "carousel",
  perView: 3,
  gap: 30,
  peek: { before: 50, after: 50 },
  breakpoints: {
    768: {
      perView: 2,
    },
    480: {
      perView: 1,
    },
  },
}).mount();
