document.addEventListener("DOMContentLoaded", function () {
  var navs = document.querySelectorAll("header nav");
  navs.forEach(function (nav) {
    if (nav.querySelector(".nav-bar")) nav.classList.add("menu-nav");
  });

  var toggles = document.querySelectorAll(".menu-toggle");
  var closeButtons = document.querySelectorAll(".menu-close");

  function closeMenu() {
    document.body.classList.remove("nav-open");
    toggles.forEach(function (btn) { btn.setAttribute("aria-expanded", "false"); });
  }

  function openMenu() {
    document.body.classList.add("nav-open");
    toggles.forEach(function (btn) { btn.setAttribute("aria-expanded", "true"); });
  }

  toggles.forEach(function (btn) {
    btn.addEventListener("click", function () {
      if (document.body.classList.contains("nav-open")) closeMenu();
      else openMenu();
    });
  });

  closeButtons.forEach(function (btn) { btn.addEventListener("click", closeMenu); });

  document.addEventListener("click", function (e) {
    if (!document.body.classList.contains("nav-open")) return;
    var insideNav = e.target.closest(".menu-nav");
    var onToggle = e.target.closest(".menu-toggle");
    if (!insideNav && !onToggle) closeMenu();
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") closeMenu();
  });

  document.querySelectorAll(".menu-nav").forEach(function (nav) {
    nav.addEventListener("click", function (e) {
      if (e.target.closest("a")) closeMenu();
    });
  });
});
