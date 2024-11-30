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


 // Get references to modal and buttons
    const modal = document.getElementById("categoryModal");
    const addCategoryBtn = document.getElementById("addCategoryBtn");
    const closeModal = document.getElementById("closeModal");
    const categoryForm = document.getElementById("categoryForm");
    const categoriesContainer = document.getElementById("categories");

    // Open modal
    addCategoryBtn.addEventListener("click", () => {
      modal.classList.remove("hidden");
    });

    // Close modal
    closeModal.addEventListener("click", () => {
      modal.classList.add("hidden");
    });

    // Handle form submission
    categoryForm.addEventListener("submit", (e) => {
      e.preventDefault();

      // Get form data
      const categoryName = document.getElementById("categoryName").value;
      const subCategories = document.getElementById("subCategories").value;
      const products = document.getElementById("products").value;
      const variants = document.getElementById("variants").value;

      // Create a new category card
      const categoryCard = document.createElement("div");
      categoryCard.classList.add("bg-white", "p-4", "rounded", "shadow", "cursor-pointer");
      categoryCard.innerHTML = `
        <h3 class="text-lg font-semibold">${categoryName}</h3>
        <p>Sub-Categories: ${subCategories}</p>
        <p>Products: ${products}</p>
        <p>Variants: ${variants}</p>
      `;

      // Add click event to open the new page
      categoryCard.addEventListener("click", () => {
        alert(`Opening ${categoryName} page`);
      });

      // Append to the categories container
      categoriesContainer.appendChild(categoryCard);

      // Reset form and close modal
      categoryForm.reset();
      modal.classList.add("hidden");
    });