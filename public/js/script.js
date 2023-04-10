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
$(function () {
  // define variables
  var sliderContainer = $(".slider-container"),
    sliderTrack = $(".slider-track"),
    sliderSlides = $(".slider-slide"),
    sliderNavItems = $(".slider-nav-item"),
    numSlides = sliderSlides.length,
    currentSlide = 0;

  // initialize slider
  sliderNavItems.eq(currentSlide).addClass("bg-white");
  sliderTrack.css("transform", "translateX(0)");

  // handle slider navigation
  sliderNavItems.on("click", function () {
    var navIndex = $(this).index();
    sliderNavItems.eq(currentSlide).removeClass("bg-white");
    $(this).addClass("bg-white");
    sliderTrack.css("transform", "translateX(" + -navIndex * 100 + "%)");
    currentSlide = navIndex;
  });

  // handle slider autoplay
  function autoplay() {
    setInterval(function () {
      var nextSlide = (currentSlide + 1) % numSlides;
      sliderNavItems.eq(currentSlide).removeClass("bg-white");
      sliderNavItems.eq(nextSlide).addClass("bg-white");
      sliderTrack.css("transform", "translateX(" + -nextSlide * 100 + "%)");
      currentSlide = nextSlide;
    }, 5000);
  }

  autoplay();
});
