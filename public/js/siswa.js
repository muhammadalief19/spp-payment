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

// modal
function closeModal() {
  document.getElementById("myModal").classList.add("hidden");
}
