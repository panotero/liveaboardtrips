var menuBtn = document.getElementById("menu-btn");
var mobileMenu = document.getElementById("mobile-menu");

// Toggle mobile menu visibility
menuBtn.addEventListener("click", function () {
  mobileMenu.classList.toggle("translate-x-full");
});

// Close mobile menu when clicking outside
document.addEventListener("click", function (event) {
  console.log(event.target);
  var isClickInside =
    mobileMenu.contains(event.target) || menuBtn.contains(event.target);
  console.log(isClickInside);

  if (!isClickInside && !mobileMenu.classList.contains("translate-x-full")) {
    // If the click is outside and the menu is open, close it
    mobileMenu.classList.add("translate-x-full");
  }
});
