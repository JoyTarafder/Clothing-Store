 // JavaScript for mobile sidebar toggle
 const menuToggle = document.getElementById("menu-toggle");
 const sidebar = document.querySelector("aside");

 menuToggle.addEventListener("click", () => {
   sidebar.classList.toggle("hidden");
 });

 // JavaScript to set active state on menu click
 function setActive(element) {
   const sidebarLinks = document.querySelectorAll(".sidebar-link");
   sidebarLinks.forEach((link) =>
     link.classList.remove("bg-blue-800", "active")
   );
   element.classList.add("bg-blue-800", "active");
 }

 // Set the active link based on the current page
 document.addEventListener("DOMContentLoaded", function () {
   const currentPage = window.location.pathname.split("/").pop();
   const linkMap = {
     "dashboard.html": "dashboard-link",
     "orderManagement.html": "order-management-link",
     "inventory.html": "inventory-link",
     "categoryManagement.html": "category-management-link",
     "userManagement.html": "user-management-link",
     "vendorManagement.html": "vendor-management-link",
     "siteManagement.html": "site-management-link",
   };
   const activeLinkId = linkMap[currentPage];
   if (activeLinkId) {
     const activeLink = document.getElementById(activeLinkId);
     if (activeLink) {
       setActive(activeLink);
     }
   }
 });