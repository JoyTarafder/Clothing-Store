<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Log in';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Clothing App</title>
    <link rel="stylesheet" href="./output/tailwind.css" />
  </head>
  <body class="bg-white text-gray-900">
    <!-- Navbar on top of hero image -->
    <header class="absolute top-0 w-full z-20 bg-indigo-900 bg-opacity-90">
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center"
      >
        <!-- Logo -->
        <a href="#">
          <img src="./images/logo.png" class="w-30 h-20" alt="logo" />
        </a>

        <!-- Menu -->
        <nav class="space-x-6 hidden md:flex">
          <a href="./men.html" class="text-white hover:text-indigo-300 text-xl transition duration-300"
            >Men</a
          >
          <a
            href="./women.html"
            class="text-white hover:text-indigo-300 text-xl transition duration-300"
            >Women</a
          >
          <a href="./kids.html" class="text-white hover:text-indigo-300 text-xl transition duration-300"
            >Kids</a
          >
          <a
            href="./newArrival.html"
            class="text-white hover:text-indigo-300 text-xl transition duration-300"
            >NEW ARRIVAL</a
          >
          <a
            href="./sales.html"
            class="text-white hover:text-indigo-300 text-xl transition duration-300"
            >Sales</a
          >
        </nav>

        <!-- Search Box, Cart Icon, User Menu -->
        <div class="flex items-center space-x-4">
          <!-- Search Box -->
          <div class="relative">
            <input
              type="text"
              class="border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400 text-gray-900"
              placeholder="Search..."
            />
            <i class="fas fa-search absolute top-3 right-3 text-gray-400"></i>
          </div>
          <!-- Cart Icon -->
          <a href="#" class="hover:text-gray-200">
            <img src="./images/shopping-bag.png" class="w-10 h-10" alt="" />
          </a>
          <!-- User Menu -->
          <div class="relative">
            <button
              id="user-menu-button"
              class="text-white hover:text-gray-200 text-xl"
              onclick="toggleUserMenu()"
            >
              <span id="username-display"><?php echo htmlspecialchars($username); ?></span>
            </button>
            <div
              id="user-menu"
              class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1"
            >
              <a
                href="profile.php"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >Profile</a
              >
              <a
                href="logout.php"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >Logout</a
              >
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Hero Section with image -->
    <section
      class="relative h-screen bg-cover bg-center"
      style="background-image: url('./images/hero.png')"
    >
      <div class="absolute inset-0 bg-black opacity-25"></div>
      <!-- Dark overlay -->
      <div class="flex items-center justify-center h-full relative z-10">
        <div class="text-center mt-80 grid gap-4">
          <a
            href="./men.html"
            class="mt-20 inline-block px-6 py-3 bg-white/30 backdrop-blur-md text-black font-semibold rounded-lg hover:bg-white/40 transition"
            ><button class="flex gap-10">
              Shop For Men
              <img src="./images/right-arrow.png" class="w-6 h-6" alt="" />
            </button>
          </a>
          <a
            href="./women.html"
            class="inline-block px-6 py-3 bg-white/30 backdrop-blur-md text-black font-semibold rounded-lg hover:bg-white/40 transition"
            ><button class="flex gap-3">
              Shop For Women
              <img src="./images/right-arrow.png" class="w-6 h-6" alt="" />
            </button>
          </a>
        </div>
      </div>
    </section>

    <!-- Card Section -->

    <section class="py-12 bg-gray-100">
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8"
      >
        <!-- Women's Fashion Card -->
        <div
          class="relative bg-white shadow-2xl rounded-lg overflow-hidden h-80"
        >
          <div class="absolute inset-0 bg-gray-200 h-full">
            <img src="./images/WomenFashion.jpg" alt="" />
          </div>
          <!-- Placeholder for image -->
          <button
            class="absolute inset-x-0 top-60 mx-auto w-44 py-3 bg-white bg-opacity-20 backdrop-blur-lg text-gray-800 font-semibold border border-gray-300 rounded-lg shadow-lg hover:bg-opacity-30 transition duration-300 ease-in-out"
          >
            Women's Fashion
          </button>
        </div>

        <!-- Men's Styles Card -->
        <div
          class="relative bg-white shadow-2xl rounded-lg overflow-hidden h-80"
        >
          <div class="absolute inset-0 bg-gray-200 h-full">
            <img src="./images/Men-Fashion.webp" alt="" />
          </div>
          <!-- Placeholder for image -->
          <button
            class="absolute inset-x-0 top-60 mx-auto w-44 py-3 bg-white bg-opacity-20 backdrop-blur-lg text-gray-800 font-semibold border border-gray-300 rounded-lg shadow-lg hover:bg-opacity-30 transition duration-300 ease-in-out"
          >
            Men's Styles
          </button>
        </div>
      </div>
    </section>

    <!-- NEW ARRIVAL Section Start-->
    <section>
      <div class="bg-white text-gray-800 p-4 md:p-8">
        <!-- Section Title -->
        <div class="text-center mb-6 md:mb-8">
          <h2
            class="text-lg font-bold border border-gray-300 px-4 py-2 inline-block"
          >
            NEW ARRIVAL
          </h2>
        </div>

        <!-- Product Cards Wrapper -->
        <div class="flex items-center justify-between space-x-2 md:space-x-4">
          <!-- Left Arrow -->
          <button class="text-gray-500 hover:text-gray-700 hidden md:block">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              class="w-8 h-8"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 19l-7-7 7-7"
              />
            </svg>
          </button>

          <!-- Product Cards -->
          <div
            class="flex flex-col md:flex-row justify-between md:space-x-4 w-full"
          >
            <!-- Card 1 -->
            <div
              class="border border-gray-200 rounded-lg w-full md:w-1/3 p-4 text-center shadow-xl mb-4 md:mb-0"
            >
              <div
                class="flex flex-col items-center justify-center w-full max-w-xs mx-auto"
              >
                <div
                  class="w-full h-48 md:h-64 bg-gray-300 bg-center bg-cover rounded-lg shadow-md"
                  style="background-image: url(./images/items/na_item1.jpg)"
                ></div>

                <div
                  class="w-56 -mt-10 overflow-hidden bg-white rounded-lg shadow-lg md:w-64 dark:bg-gray-800"
                >
                  <h3
                    class="py-2 font-bold tracking-wide text-center text-gray-800 uppercase dark:text-white"
                  >
                    Vitorn Printed
                  </h3>
                  <div
                    class="flex items-center justify-between px-3 py-2 bg-gray-200 dark:bg-gray-700"
                  >
                    <span class="font-bold text-gray-800 dark:text-gray-200"
                      >৳ 129 BDT</span
                    >
                    <button
                      class="px-2 py-1 text-xs font-semibold text-white uppercase transition-colors duration-300 transform bg-gray-800 rounded hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 focus:outline-none"
                    >
                      Add to cart
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 2 -->
            <div
              class="border border-gray-200 rounded-lg w-full md:w-1/3 p-4 text-center shadow-xl mb-4 md:mb-0"
            >
              <div
                class="flex flex-col items-center justify-center w-full max-w-xs mx-auto"
              >
                <div
                  class="w-full h-48 md:h-64 bg-gray-300 bg-center bg-cover rounded-lg shadow-md"
                  style="background-image: url(./images/items/na_item2.webp)"
                ></div>

                <div
                  class="w-56 -mt-10 overflow-hidden bg-white rounded-lg shadow-lg md:w-64 dark:bg-gray-800"
                >
                  <h3
                    class="py-2 font-bold tracking-wide text-center text-gray-800 uppercase dark:text-white"
                  >
                    Contemporary
                  </h3>
                  <div
                    class="flex items-center justify-between px-3 py-2 bg-gray-200 dark:bg-gray-700"
                  >
                    <span class="font-bold text-gray-800 dark:text-gray-200"
                      >৳ 129 BDT</span
                    >
                    <button
                      class="px-2 py-1 text-xs font-semibold text-white uppercase transition-colors duration-300 transform bg-gray-800 rounded hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 focus:outline-none"
                    >
                      Add to cart
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 3 -->
            <div
              class="border border-gray-200 rounded-lg w-full md:w-1/3 p-4 text-center shadow-xl"
            >
              <div
                class="flex flex-col items-center justify-center w-full max-w-xs mx-auto"
              >
                <div
                  class="w-full h-48 md:h-64 bg-gray-300 bg-center bg-cover rounded-lg shadow-md"
                  style="background-image: url(./images/items/na_item3.webp)"
                ></div>

                <div
                  class="w-56 -mt-10 overflow-hidden bg-white rounded-lg shadow-lg md:w-64 dark:bg-gray-800"
                >
                  <h3
                    class="py-2 font-bold tracking-wide text-center text-gray-800 uppercase dark:text-white"
                  >
                    Ensemble Fashion
                  </h3>
                  <div
                    class="flex items-center justify-between px-3 py-2 bg-gray-200 dark:bg-gray-700"
                  >
                    <span class="font-bold text-gray-800 dark:text-gray-200"
                      >৳ 129 BDT</span
                    >
                    <button
                      class="px-2 py-1 text-xs font-semibold text-white uppercase transition-colors duration-300 transform bg-gray-800 rounded hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 focus:outline-none"
                    >
                      Add to cart
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Arrow -->
          <button class="text-gray-500 hover:text-gray-700 hidden md:block">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              class="w-8 h-8"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5l7 7-7 7"
              />
            </svg>
          </button>
        </div>
      </div>
    </section>

    <!-- NEW ARRIVAL Section End-->

    <!-- Men Section Start -->
    <section>
      <div class="bg-white text-gray-800 p-4 md:p-8">
        <!-- Section Title -->
        <div class="text-center mb-6 md:mb-8">
          <h2
            class="text-lg font-bold border border-gray-300 px-4 py-2 inline-block"
          >
            Men's Fashion
          </h2>
        </div>

        <!-- Cards Section -->
        <div
          class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
        >
          <!-- Card 1 -->
          <div
            class="relative flex flex-col bg-white shadow-lg border border-slate-200 rounded-lg transition-transform hover:-translate-y-1 group"
          >
            <div class="relative p-2 h-80 overflow-hidden rounded-t-lg">
              <img
                src="./images/items/mf-item-1.jpg"
                class="h-full w-full object-cover rounded-md transition-transform duration-300 transform group-hover:scale-110"
                alt="Fashion item 1"
              />
            </div>
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-lg font-semibold">
                  Madhabi Ajrakh
                </p>
                <p class="text-cyan-600 text-lg font-semibold">৳ 3095.00 BDT</p>
              </div>
              <p class="text-slate-600 text-sm leading-normal font-light">
                Stylish and versatile with voice-activated Siri access, plus
                wireless charging support.
              </p>
              <button
                class="rounded-md w-full mt-4 bg-cyan-600 py-2 text-sm text-white transition-all shadow-md hover:shadow-lg hover:bg-cyan-700 focus:outline-none"
              >
                Add to Cart
              </button>
            </div>
          </div>

          <!-- Card 2 -->
          <div
            class="relative flex flex-col bg-white shadow-lg border border-slate-200 rounded-lg transition-transform hover:-translate-y-1 group"
          >
            <div class="relative p-2 h-80 overflow-hidden rounded-t-lg">
              <img
                src="./images/items/mf-item-2.webp"
                class="h-full w-full object-cover rounded-md transition-transform duration-300 transform group-hover:scale-110"
                alt="Fashion item 2"
              />
            </div>
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-lg font-semibold">
                  Blue and White Zig Zag
                </p>
                <p class="text-cyan-600 text-lg font-semibold">৳ 2599.00 BDT</p>
              </div>
              <p class="text-slate-600 text-sm leading-normal font-light">
                Available in classic patterns with wireless charging and
                hands-free Siri support.
              </p>
              <button
                class="rounded-md w-full mt-4 bg-cyan-600 py-2 text-sm text-white transition-all shadow-md hover:shadow-lg hover:bg-cyan-700 focus:outline-none"
              >
                Add to Cart
              </button>
            </div>
          </div>

          <!-- Card 3 -->
          <div
            class="relative flex flex-col bg-white shadow-lg border border-slate-200 rounded-lg transition-transform hover:-translate-y-1 group"
          >
            <div class="relative p-2 h-80 overflow-hidden rounded-t-lg">
              <img
                src="./images/items/mf-item-3.webp"
                class="h-full w-full object-cover rounded-md transition-transform duration-300 transform group-hover:scale-110"
                alt="Fashion item 3"
              />
            </div>
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-lg font-semibold">
                  Yellow Gotapatti Net
                </p>
                <p class="text-cyan-600 text-lg font-semibold">৳ 1990.00 BDT</p>
              </div>
              <p class="text-slate-600 text-sm leading-normal font-light">
                Elegant design with voice-activated access and an optional
                wireless charging case.
              </p>
              <button
                class="rounded-md w-full mt-4 bg-cyan-600 py-2 text-sm text-white transition-all shadow-md hover:shadow-lg hover:bg-cyan-700 focus:outline-none"
              >
                Add to Cart
              </button>
            </div>
          </div>

          <!-- Card 4 -->
          <div
            class="relative flex flex-col bg-white shadow-lg border border-slate-200 rounded-lg transition-transform hover:-translate-y-1 group"
          >
            <div class="relative p-2 h-80 overflow-hidden rounded-t-lg">
              <img
                src="https://klubhaus.com.bd/cdn/shop/files/DSCF3622_1200x1200.jpg?v=1711342893"
                class="h-full w-full object-cover rounded-md transition-transform duration-300 transform group-hover:scale-110"
                alt="Fashion item 4"
              />
            </div>
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-lg font-semibold">Formal Shirt</p>
                <p class="text-cyan-600 text-lg font-semibold">৳ 2499.00 BDT</p>
              </div>
              <p class="text-slate-600 text-sm leading-normal font-light">
                Made of the highest quality materials with a softer fabric.
                Brand new classic designed women's ethnic top peach Comfortable
                fit with ...
              </p>
              <button
                class="rounded-md w-full mt-4 bg-cyan-600 py-2 text-sm text-white transition-all shadow-md hover:shadow-lg hover:bg-cyan-700 focus:outline-none"
              >
                Add to Cart
              </button>
            </div>
          </div>

          <!-- Add more cards as needed -->
        </div>

        <!-- See More Button -->
        <div class="flex justify-end mt-8">
          <a href="./men.html">
            <button
              class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800"
            >
              <span
                class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0"
              >
                See More
              </span>
            </button>
          </a>
        </div>
      </div>
    </section>

    <!-- Men Section end -->

    <!-- Women Section Start -->
    <section>
      <div class="bg-white text-gray-800 p-4 md:p-8">
        <!-- Section Title -->
        <div class="text-center mb-6 md:mb-8">
          <h2
            class="text-lg font-bold border border-gray-300 px-4 py-2 inline-block"
          >
            Women's Fashion
          </h2>
        </div>

        <!-- Cards Section -->
        <div
          class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
        >
          <!-- Card 1 -->
          <div
            class="relative flex flex-col bg-white shadow-lg border border-slate-200 rounded-lg transition-transform hover:-translate-y-1 group"
          >
            <div class="relative p-2 h-80 overflow-hidden rounded-t-lg">
              <img
                src="https://toptenmartltd.com/wp-content/uploads/2024/04/saree-13.jpg"
                class="h-full w-full object-cover rounded-md transition-transform duration-300 transform group-hover:scale-110"
                alt="Fashion item 1"
              />
            </div>
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-lg font-semibold">Bridal Saree</p>
                <p class="text-cyan-600 text-lg font-semibold">৳ 9099.00 BDT</p>
              </div>
              <p class="text-slate-600 text-sm leading-normal font-light">
                This pure silk saree, woven with intricate zari work, exudes
                timeless elegance. The soft, flowing fabric and delicate pallu
                make it a perfect choice for a traditional Indian wedding.
              </p>
              <button
                class="rounded-md w-full mt-4 bg-cyan-600 py-2 text-sm text-white transition-all shadow-md hover:shadow-lg hover:bg-cyan-700 focus:outline-none"
              >
                Add to Cart
              </button>
            </div>
          </div>

          <!-- Card 2 -->
          <div
            class="relative flex flex-col bg-white shadow-lg border border-slate-200 rounded-lg transition-transform hover:-translate-y-1 group"
          >
            <div class="relative p-2 h-80 overflow-hidden rounded-t-lg">
              <img
                src="https://static.wixstatic.com/media/4594f8_c69ecd10fa4a480fb87719cefa5aeb58~mv2.jpg/v1/fill/w_480,h_640,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/4594f8_c69ecd10fa4a480fb87719cefa5aeb58~mv2.jpg"
                class="h-full w-full object-cover rounded-md transition-transform duration-300 transform group-hover:scale-110"
                alt="Fashion item 2"
              />
            </div>
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-lg font-semibold">
                  Embroidered Party Wear
                </p>
                <p class="text-cyan-600 text-lg font-semibold">৳ 6599.00 BDT</p>
              </div>
              <p class="text-slate-600 text-sm leading-normal font-light">
                This vibrant Kanchipuram silk saree, with its bold colors and
                intricate weaves, is perfect for the confident bride. The rich,
                luxurious fabric and stunning design make it a showstopper.
              </p>
              <button
                class="rounded-md w-full mt-4 bg-cyan-600 py-2 text-sm text-white transition-all shadow-md hover:shadow-lg hover:bg-cyan-700 focus:outline-none"
              >
                Add to Cart
              </button>
            </div>
          </div>

          <!-- Card 3 -->
          <div
            class="relative flex flex-col bg-white shadow-lg border border-slate-200 rounded-lg transition-transform hover:-translate-y-1 group"
          >
            <div class="relative p-2 h-80 overflow-hidden rounded-t-lg">
              <img
                src="https://suvidhafashion.com/cdn/shop/products/1-A.jpg?v=1680852247&width=500"
                class="h-full w-full object-cover rounded-md transition-transform duration-300 transform group-hover:scale-110"
                alt="Fashion item 3"
              />
            </div>
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-lg font-semibold">
                  Wedding Saree
                </p>
                <p class="text-cyan-600 text-lg font-semibold">৳ 5990.00 BDT</p>
              </div>
              <p class="text-slate-600 text-sm leading-normal font-light">
                This stylish georgette saree, with its contemporary cut and
                trendy prints, is perfect for the modern bride. The lightweight,
                breathable fabric and chic design make it ideal for a
                destination wedding.
              </p>
              <button
                class="rounded-md w-full mt-4 bg-cyan-600 py-2 text-sm text-white transition-all shadow-md hover:shadow-lg hover:bg-cyan-700 focus:outline-none"
              >
                Add to Cart
              </button>
            </div>
          </div>

          <!-- Card 4 -->
          <div
            class="relative flex flex-col bg-white shadow-lg border border-slate-200 rounded-lg transition-transform hover:-translate-y-1 group"
          >
            <div class="relative p-2 h-80 overflow-hidden rounded-t-lg">
              <img
                src="https://images.othoba.com/images/thumbs/0630103_12-haat-printed-wetless-jorjet-saree-for-girls-and-women.webp"
                class="h-full w-full object-cover rounded-md transition-transform duration-300 transform group-hover:scale-110"
                alt="Fashion item 4"
              />
            </div>
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-lg font-semibold">Jorjet Saree</p>
                <p class="text-cyan-600 text-lg font-semibold">৳ 2499.00 BDT</p>
              </div>
              <p class="text-slate-600 text-sm leading-normal font-light">
                This dreamy chiffon saree, with its flowing silhouette and
                delicate embellishments, is perfect for a fairytale wedding. The
                sheer, lightweight fabric and ethereal design create a magical
                look.
              </p>
              <button
                class="rounded-md w-full mt-4 bg-cyan-600 py-2 text-sm text-white transition-all shadow-md hover:shadow-lg hover:bg-cyan-700 focus:outline-none"
              >
                Add to Cart
              </button>
            </div>
          </div>

          <!-- Add more cards as needed -->
        </div>

        <!-- See More Button -->
        <div class="flex justify-end mt-8">
          <a href="./women.html">
            <button
              class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800"
            >
              <span
                class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0"
              >
                See More
              </span>
            </button>
          </a>
        </div>
      </div>
    </section>
    <!-- Women Section end -->

    <!-- Kids Section Start -->
    <section>
      <div class="bg-white text-gray-800 p-4 md:p-8">
        <!-- Section Title -->
        <div class="text-center mb-6 md:mb-8">
          <h2
            class="text-lg font-bold border border-gray-300 px-4 py-2 inline-block"
          >
            Kid's Fashion
          </h2>
        </div>

        <!-- Cards Section -->
        <div
          class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
        >
          <!-- Card 1 -->
          <div
            class="relative flex flex-col bg-white shadow-lg border border-slate-200 rounded-lg transition-transform hover:-translate-y-1 group"
          >
            <div class="relative p-2 h-80 overflow-hidden rounded-t-lg">
              <img
                src="https://www.mumkins.in/cdn/shop/files/boys-kurta-pajama-bs10ish01-sky-blue-1.jpg?v=1725517681&width=1080"
                class="h-full w-full object-cover rounded-md transition-transform duration-300 transform group-hover:scale-110"
                alt="Fashion item 1"
              />
            </div>
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-lg font-semibold">
                  Kidswear for Boy
                </p>
                <p class="text-cyan-600 text-lg font-semibold">৳ 1095.00 BDT</p>
              </div>
              <p class="text-slate-600 text-sm leading-normal font-light">
                Dress to impress in our sharp, tailored shirts. Perfect for
                special occasions.
              </p>
              <button
                class="rounded-md w-full mt-4 bg-cyan-600 py-2 text-sm text-white transition-all shadow-md hover:shadow-lg hover:bg-cyan-700 focus:outline-none"
              >
                Add to Cart
              </button>
            </div>
          </div>

          <!-- Card 2 -->
          <div
            class="relative flex flex-col bg-white shadow-lg border border-slate-200 rounded-lg transition-transform hover:-translate-y-1 group"
          >
            <div class="relative p-2 h-80 overflow-hidden rounded-t-lg">
              <img
                src="https://img.faballey.com/images/Product/IGS00052Z/d3.jpg"
                class="h-full w-full object-cover rounded-md transition-transform duration-300 transform group-hover:scale-110"
                alt="Fashion item 2"
              />
            </div>
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-lg font-semibold">
                  Girls Clothing
                </p>
                <p class="text-cyan-600 text-lg font-semibold">৳ 599.00 BDT</p>
              </div>
              <p class="text-slate-600 text-sm leading-normal font-light">
                A perfect pair for any occasion. Our tailored trousers are both
                stylish and comfortable.
              </p>
              <button
                class="rounded-md w-full mt-4 bg-cyan-600 py-2 text-sm text-white transition-all shadow-md hover:shadow-lg hover:bg-cyan-700 focus:outline-none"
              >
                Add to Cart
              </button>
            </div>
          </div>

          <!-- Card 3 -->
          <div
            class="relative flex flex-col bg-white shadow-lg border border-slate-200 rounded-lg transition-transform hover:-translate-y-1 group"
          >
            <div class="relative p-2 h-80 overflow-hidden rounded-t-lg">
              <img
                src="https://4.imimg.com/data4/VN/JF/MY-34076214/boy-party-wear-dress.jpg"
                class="h-full w-full object-cover rounded-md transition-transform duration-300 transform group-hover:scale-110"
                alt="Fashion item 3"
              />
            </div>
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-lg font-semibold">
                  Boy Kids Party Wear Dress
                </p>
                <p class="text-cyan-600 text-lg font-semibold">৳ 990.00 BDT</p>
              </div>
              <p class="text-slate-600 text-sm leading-normal font-light">
                Elegant design with voice-activated access and an optional
                wireless charging case.
              </p>
              <button
                class="rounded-md w-full mt-4 bg-cyan-600 py-2 text-sm text-white transition-all shadow-md hover:shadow-lg hover:bg-cyan-700 focus:outline-none"
              >
                Add to Cart
              </button>
            </div>
          </div>

          <!-- Card 4 -->
          <div
            class="relative flex flex-col bg-white shadow-lg border border-slate-200 rounded-lg transition-transform hover:-translate-y-1 group"
          >
            <div class="relative p-2 h-80 overflow-hidden rounded-t-lg">
              <img
                src="https://i.pinimg.com/236x/b6/ea/ff/b6eaffd5ce04f88dab928c56cc8451bf.jpg"
                class="h-full w-full object-cover rounded-md transition-transform duration-300 transform group-hover:scale-110"
                alt="Fashion item 4"
              />
            </div>
            <div class="p-4">
              <div class="mb-2 flex items-center justify-between">
                <p class="text-slate-800 text-lg font-semibold">Kids dress</p>
                <p class="text-cyan-600 text-lg font-semibold">৳ 1499.00 BDT</p>
              </div>
              <p class="text-slate-600 text-sm leading-normal font-light">
                Beautiful embroidery with voice-activated access and wireless
                charging options.
              </p>
              <button
                class="rounded-md w-full mt-4 bg-cyan-600 py-2 text-sm text-white transition-all shadow-md hover:shadow-lg hover:bg-cyan-700 focus:outline-none"
              >
                Add to Cart
              </button>
            </div>
          </div>

          <!-- Add more cards as needed -->
        </div>

        <!-- See More Button -->
        <div class="flex justify-end mt-8">
          <a href="./kids.html">
            <button
              class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800"
            >
              <span
                class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0"
              >
                See More
              </span>
            </button>
          </a>
        </div>
      </div>
    </section>
    <!-- Kids Section end -->

    <!-- Feature Section -->
    <section class="bg-gray-100 py-12">
      <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-6">
        <!-- Feature 1 -->
        <div class="flex flex-col items-center">
          <img
            src="./images/premium-quality.png"
            alt="Quality"
            class="w-16 h-16 mb-4"
          />
          <h3 class="text-2xl font-semibold text-gray-800 mb-2">
            Premium Quality
          </h3>
          <p class="text-gray-600 text-center">
            Our products are made from the finest materials to ensure comfort
            and durability.
          </p>
        </div>

        <!-- Feature 2 -->
        <div class="flex flex-col items-center">
          <img
            src="./images/free-shipping.png"
            alt="Free Shipping"
            class="w-16 h-16 mb-4"
          />
          <h3 class="text-2xl font-semibold text-gray-800 mb-2">
            Free Shipping
          </h3>
          <p class="text-gray-600 text-center">
            Enjoy free shipping on all orders with fast and reliable delivery
            services.
          </p>
        </div>

        <!-- Feature 3 -->
        <div class="flex flex-col items-center">
          <img
            src="./images/customer-service.png"
            alt="Support"
            class="w-16 h-16 mb-4"
          />
          <h3 class="text-2xl font-semibold text-gray-800 mb-2">
            24/7 Support
          </h3>
          <p class="text-gray-600 text-center">
            Our support team is available around the clock to assist you with
            any inquiries.
          </p>
        </div>
      </div>
    </section>

    <!-- footer component -->
    <footer class="bg-indigo-950 border-t border-gray-200 py-8">
      <div class="container mx-auto px-6 md:px-12 lg:px-24">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <!-- Logo and Social Links -->
          <div>
            <h2 class="text-2xl font-semibold text-white">
              <img src="./images/Logo/logo.png" class="w-40 h-40" alt="" />
            </h2>
            <h3 class="text-sm font-medium text-white mt-4">FOLLOW US</h3>
            <div class="flex space-x-4 mt-4">
              <a
                href="#"
                aria-label="Facebook"
                class="text-gray-600 hover:text-black"
              >
                <i class="fab fa-facebook-f">
                  <img src="./images/facebook.png" class="w-6 h-6" alt="" />
                </i>
              </a>
              <a
                href="#"
                aria-label="Instagram"
                class="text-gray-600 hover:text-black"
              >
                <i class="fab fa-instagram">
                  <img src="./images/instagram.png" class="w-6 h-6" alt="" />
                </i>
              </a>
              <a
                href="#"
                aria-label="LinkedIn"
                class="text-gray-600 hover:text-black"
              >
                <i class="fab fa-linkedin-in">
                  <img src="./images/linkedin.png" class="w-6 h-6" alt="" />
                </i>
              </a>
              <a
                href="#"
                aria-label="YouTube"
                class="text-gray-600 hover:text-black"
              >
                <i class="fab fa-youtube"></i>
              </a>
            </div>
          </div>

          <!-- Help Section -->
          <div>
            <h3 class="text-lg font-medium text-white">HELP</h3>
            <ul class="mt-4 space-y-2 text-sm text-white">
              <li><a href="#" class="hover:text-zinc-300">FAQs</a></li>
              <li><a href="#" class="hover:text-zinc-300">Return Policy</a></li>
              <li>
                <a href="#" class="hover:text-zinc-300">Privacy Policy</a>
              </li>
              <li>
                <a href="#" class="hover:text-zinc-300">Delivery Policy</a>
              </li>
              <li>
                <a href="#" class="hover:text-zinc-300">Store Locations</a>
              </li>
              <li>
                <a href="#" class="hover:text-zinc-300">Terms & Conditions</a>
              </li>
            </ul>
          </div>

          <!-- About Section -->
          <div>
            <h3 class="text-lg font-medium text-white">ABOUT</h3>
            <ul class="mt-4 space-y-2 text-sm text-white">
              <li>
                <a href="./aboutUs.html" class="hover:text-zinc-300"
                  >About Us</a
                >
              </li>
              <li><a href="#" class="hover:text-zinc-300">Career</a></li>
            </ul>
            <h3 class="text-lg font-medium text-white mt-6">Donate Now</h3>
            <ul class="mt-4 space-y-2 text-sm text-white">
              <li><a href="#" class="hover:text-zinc-300">Login</a></li>
              <li>
                <a
                  href="./adminpanel/adminPanelLogInPage.html"
                  class="hover:text-zinc-300"
                  >Admin Panel</a
                >
              </li>
            </ul>
          </div>

          <!-- Contact Section -->
          <div>
            <h3 class="text-lg font-medium text-white">CONTACT</h3>
            <div class="text-sm text-white mt-4">
              <ul class="mt-4 space-y-2 text-sm text-white mb-5">
                <li><a href="#" class="hover:text-zinc-300">Contact Us</a></li>
              </ul>
              <p>
                <strong>Corporate Office</strong><br />
                Saimon Centre, Level-3<br />
                House No-4A, Road No-22,<br />
                Gulshan-01, Dhaka-1212<br />
                Phone: +8801904000258<br />
                (10 AM - 8 PM)<br />
                <em>Except Weekend/Govt. Holidays</em><br />
                Email: support@clothstore.com
              </p>
            </div>
          </div>
        </div>

        <!-- Subscription Form -->
        <div class="mt-8 text-center">
          <p class="text-sm text-white">
            Be the first to know about special offers and new products
          </p>
          <div class="mt-4 flex justify-center">
            <input
              type="email"
              placeholder="Enter your email..."
              class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none"
            />
            <button class="px-4 py-2 bg-black text-white rounded-r-md">
              SUBSCRIBE
            </button>
          </div>
        </div>

        <!-- Payment Methods -->
        <div class="mt-8 flex justify-center space-x-4">
          <!-- Example payment icons (use relevant payment icons if available) -->
          <!-- <img src="./images/visa.png" alt="Visa" class="h-10 w-10" />
          <img src="./images/master.png" alt="MasterCard" class="h-10 w-10" />
          <img src="./images/bkash.webp" alt="bKash" class="h-10 w-10" />
          <img src="/images/nagad.png" alt="Nagad" class="h-10 w-10" /> -->
          <img src="./images/SSLCommerz-Pay.png" alt="Visa" class="h-28" />
          <!-- Add more payment logos as necessary -->
        </div>

        <!-- Copyright -->
        <div class="mt-4 text-center text-white text-base">
          © 2024 - All Rights Reserved by Joy Tarafder
        </div>
      </div>
    </footer>
    <!-- footer component end -->
    <script>
      function toggleUserMenu() {
        const userMenu = document.getElementById("user-menu");
        userMenu.classList.toggle("hidden");
      }

      function logout() {
        // Clear session storage and redirect to login page
        sessionStorage.removeItem("username");
        window.location.href = "login.html";
      }

      // Check if the user is logged in
      const username = sessionStorage.getItem("username");
      if (username) {
        document.getElementById("username-display").textContent = username;
      } else {
        document.getElementById("username-display").textContent = "Log in";
      }
    </script>
    <!-- Joy Tarafder -->
  </body>
</html>
