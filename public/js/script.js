const modal = document.querySelector("#modal-preview");
// modal
function closeModal() {
  document.getElementById("myModal").classList.add("hidden");
}

// Open modal function
function openModalPayment() {
  modal.classList.add("flex");
  modal.classList.remove("hidden");
}

// Close modal function
function closeModalPayment() {
  modal.classList.add("hidden");
  modal.classList.remove("flex");
}

// Add event listener to close button
document.getElementById("modal-close").addEventListener("click", closeModal);

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
