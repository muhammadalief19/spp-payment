<?php
session_start();

if(!isset($_SESSION["login"])) {
  header("Location:login.php");
}

require_once"../Controller/siswa/SiswaController.php";

$SiswaController = new SiswaController;
$userAuth = $SiswaController->userAuth();

switch ($userAuth["role"]) {
    case 'admin':
        # code...
        header("Location: admin/index.php");
        break;
    case 'petugas':
        header("Location: petugas/index.php");
    break;

    case 'siswa':
    break;
            
        default:
            # code...
        break;
}

// logout
if(isset($_POST["logout"])) {
    $SiswaController->logout("login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../dist/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
        extend: {
        keyframes: {
            float: {
            "0%, 100%": { transform: "translate(0)" },
            "50%": { transform: "translate(42px, 18px)" },
            },
        },
        animation: {
            floating: "float 2s ease-in-out infinite",
        },
    },
  },
    }
  </script>
</head>
<body class="w-full overflow-x-hidden text-white bg-gradient-to-tl from-sky-700 via-sky-500 to-sky-300">
<nav class="bg-transparent backdrop-blur-xl shadow-lg h-16 fixed top-0 left-0 right-0 z-10" id="navbar">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      <div class="flex-shrink-0 flex items-center">
        <a href="#" class="font-bold text-2xl text-sky-800">SPPku</a>
      </div>
        <ul class="flex h-auto gap-7 items-center">
            <li><a href="home.php" class="">Home</a></li>
            <li><a href="pembayaran.php" class="">Pembayaran</a></li>
            <li><a href="" class="">My Spp</a></li>
            <li>
            <div class="">
            <form action="" method="post">
              <button type="submit" name="logout" class="flex items-center gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
              </svg>
                Logout
              </button>
            </form>
        </div>
            </li>
        </ul>
      <div class="-mr-2 flex items-center sm:hidden">
        <button type="button" class="bg-gray-100 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <!-- Icon ketika navbar diklik pada mode mobile -->
          <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <!-- Icon ketika navbar tidak dalam mode mobile -->
          <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Dropdown menu ketika navbar dalam mode mobile -->
  <div class="sm:hidden" id="mobile-menu">
    <div class="px-2 pt-2 pb-3 space-y-1 flex">
      <a href="#" class="block px-3 py-2 text-base font-medium text-gray-800 hover:text-gray-900">Dashboard</a>
      <a href="#" class="block px-3 py-2 text-base font-medium text-gray-800 hover:text-gray-900">Transaksi</a>
      <a href="#" class="block px-3 py-2 text-base font-medium text-gray-800 hover:text-gray-900">Laporan</a>
      <a href="#" class="block px-3 py-2 text-base font-medium text-gray-800 hover:text-gray-900">Pengaturan</a>
    </div>
    </div>
    </nav>
    <!-- hero section -->
    <section class="w-full h-screen flex justify-center items-center py-20">
        <div class="w-4/5 grid grid-cols-2">
            <div class="w-full">
                <img src="../public/assets/3d-illustration-11 - Copy.png" alt="" class="animate-floating">
            </div>
            <div class="w-full flex flex-col h-auto justify-center gap-10">
                <p class="text-2xl font-bold">
                  Bayar SPP
                </p>
                <p class="text-lg font-light">
                Selamat datang di sistem pembayaran SPP kami! Nikmati kemudahan dan kecepatan dalam melakukan pembayaran SPP dengan platform kami.Waktu membayar SPP tidak perlu repot lagi, cukup dengan beberapa klik saja, SPP kamu sudah terbayar. Ayo mulai gunakan sistem pembayaran SPP kami untuk kepraktisan dalam urusan keuanganmu.
                </p>
                <div class="w-full flex justify-end">
                    <button class="px-7 py-2 bg-gradient-to-r from-sky-700 text-white font-semibold rounded-lg">
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!-- hero section -->

    <!-- section menu -->
    <section class="w-full h-screen flex flex-col gap-8 justify-center items-center py-10">
      <p class="text-4xl font-bold">Menu</p>
    <!-- Slider main container -->
  <div class="swiper w-1/5 aspect-square shadow-2xl">
  <!-- Additional required wrapper -->
  <div class="swiper-wrapper w-full h-full">
    <!-- Slides -->
    <div class="swiper-slide w-full h-full rounded shadow-inner flex justify-center items-center">
      <a href="pembayaran.php" class=" flex flex-col items-center justify-center gap-7">
      <img src="../public/assets/3d-illustration-12.png" alt="" class="w-2/3">
      <p class="text-2xl font-bold">Pembayaran</p>
      </a>
    </div>
    <div class="swiper-slide w-full h-full rounded shadow-inner flex flex-col items-center justify-center gap-7">
      <a href="" class=" flex flex-col items-center justify-center gap-7">
      <img src="../public/assets/3d-illustration-13.png" alt="" class="w-2/3">
      <p class="text-2xl font-bold">My SPP</p>
      </a>
    </div>
    <div class="swiper-slide w-full h-full rounded shadow-inner flex flex-col items-center justify-center gap-7">
      <a href="riwayat-transaksi.php" class=" flex flex-col items-center justify-center gap-7">
      <img src="../public/assets/3d-illustration-14.png" alt="" class="w-2/3">
      <p class="text-2xl font-bold">History Pembayaran</p>
      </a>
    </div>
  </div>
  <!-- If we need pagination -->
  <div class="swiper-pagination"></div>

</div>
</section>
    <!-- section menu -->

    <!-- footer -->
    <footer class="bg-gray-900 text-white py-8">
      <div class="max-w-6xl mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center justify-between">
          <div>
            <h2 class="text-2xl font-bold mb-4">SPPku</h2>
            <p class="text-gray-500">Bayar SPP jadi lebih mudah dan praktis dengan layanan pembayaran online kami. Nikmati kemudahan dan keamanan dalam membayar SPP.</p>
          </div>
          <div class="flex mt-6 md:mt-0">
            <a href="home.php" class="text-white hover:text-gray-500 px-3 py-2">Home</a>
            <a href="pembayaran.php" class="text-white hover:text-gray-500 px-3 py-2">Pembayaran</a>
            <a href="#" class="text-white hover:text-gray-500 px-3 py-2">MySPP</a>
          </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row items-center justify-between">
          <p class="text-gray-500">© <?= date('Y') ?> SPPku. SMKN 1 Kreal.</p>
          <div class="flex mt-4 md:mt-0">
            <a href="#" class="text-white hover:text-gray-500 px-3 py-2"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white hover:text-gray-500 px-3 py-2"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white hover:text-gray-500 px-3 py-2"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white hover:text-gray-500 px-3 py-2"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
      </div>
    </footer>

    <!-- footer -->
    <script src="../public/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
      const swiper = new Swiper('.swiper', {
        // Optional parameters
        direction: 'vertical',
        loop: false,

        // If we need pagination
        pagination: {
          el: '.swiper-pagination',
        },

        // Navigation arrows
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },

        // And if we need scrollbar
        scrollbar: {
          el: '.swiper-scrollbar',
        },
      });
    </script>
</body>
</html>