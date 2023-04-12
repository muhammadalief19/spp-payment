<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

require_once"../Controller/siswa/SiswaController.php";

$SiswaController = new SiswaController;
$userAuth = $SiswaController->userAuth();
$siswa = $SiswaController->getSiswaAuth($userAuth["nisn"]);
$transaksi = $SiswaController->checkPembayaran($userAuth["nisn"]);
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

$msg = '';

if(isset($_POST["payment"])) {
    $pay = $SiswaController->sppPayment($_POST, $userAuth["nisn"]);

    if($pay > 0) {
      header("Location: payment-success.php");
    } else {
      $msg = $SiswaController->getError();
      echo"gagal";
      var_dump($_POST);
    }
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
    
    <section class="w-full h-screen py-20 flex items-center justify-center">
    <div class="w-1/3 mx-auto shadow-2xl p-7 bg-sky-200 text-gray-700 rounded-lg">
  <h1 class="text-2xl font-bold mb-4">Form Pembayaran</h1>
  <form action="#" method="post" class=" shadow-inner" enctype="multipart/form-data">
        <input type="hidden" name="id_spp" value="<?= $siswa["id_spp"] ?>">

        <div class="mb-4 flex flex-col gap-2">
        <label class="block text-gray-700 font-bold mb-2" for="jumlah_bayar">Jumlah Pembayaran</label>
        <input class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="jumlah_bayar" type="number" name="jumlah_bayar" placeholder="Masukkan jumlah pembayaran"">
        </div>
        <div class="mb-4">
        <label for="bukti_pembayaran" class="block text-gray-700 font-bold mb-2">Bukti Pembayaran</label>
        <label class="block">
            <span class="sr-only">Choose File</span>
            <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
            <?php if(isset($msg["bukti_pembayaran"])) : ?>
            <p class="px-1 text-xs italic text-red-700">
              <?= $msg["bukti_pembayaran"] ?>
            </p>
            <?php endif ?>
        </label>
        </div>
        <?php if($transaksi): ?>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="payment">Bayar</button>
        <?php else : ?>
        <span class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"name="payment">Sudah Bayar</span>
        <?php endif; ?>

    </form>
    </div>

    </section>

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
</body>
</html>