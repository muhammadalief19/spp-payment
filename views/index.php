<?php
// session_start();
// if(!isset($_SESSION["login"])) {
//     header("Location:login.php");
// }
?>
<!-- template struktur dasar html  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPP Center</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../dist/output.css">
</head>
<body class="overflow-x-hidden w-full bg-gradient-to-br from-green-800 via-green-500 to-white">
    <nav class="w-full h-20 flex items-center justify-between px-10 fixed" id="navbar">
        <div class="">
            <p class="font-semibold text-gray-50 text-xl">
                SPP PAYMENT
            </p>
        </div>
        <div class="">
            <a href="login.php" class="font-semibold text-sm text-white">Login</a>
        </div>
    </nav>
    <!-- section landing page -->
    <section class="container mx-auto h-screen grid grid-cols-2 gap-7 py-24 px-10">
        <div class="w-full h-auto flex justify-center items-center">
            <img src="../public/assets/3d-illustration-1.png" alt="" class="w-4/5">
        </div>
        <div class="w-full h-auto flex flex-col justify-center gap-5">
            <p class="text-4xl font-bold text-white w-1/2">Jangan lupa bayar SPP 👍</p>
            <div class="w-4/5 bg-gradient-to-tr from-green-800 via-green-500 to-white bg-clip-text">
            <p class="text-lg font-medium text-white">"Bayar SPP menjadi lebih mudah dan efisien dengan layanan kami. Nikmati kemudahan pembayaran dengan beberapa metode yang tersedia, mulai dari transfer bank hingga pembayaran melalui aplikasi digital. Bergabunglah dengan para siswa yang merasakan kemudahan dalam membayar SPP."</p>
            </div>
            <a href="home.php" class="text-white bg-gradient-to-bl from- via-green-500 to-white py-3 w-1/2 font-bold rounded-3xl transition-all duration-300 ease-in-out hover:drop-shadow-xl shadow-gray-400 text-center">
                YUK BAYAR
            </a>
        </div>
    </section>
    <!-- section landing page -->

    <!-- section pelayanan -->
    <section class="container mx-auto flex flex-col gap-7 items-center py-10 px-10">
        <p class="text-4xl font-bold text-gray-100">Pelayanan</p>
        <div class="w-full grid grid-cols-3 gap-10">
            <div class="w-full aspect-square flex flex-col justify-center items-center">
                <img src="../public/assets/illustration-1.svg" alt="" class="w-3/4">
                <p class="text-white text-xl font-bold -mt-2">Melayani dengan senyuman</p>
            </div>
            <div class="w-full aspect-square flex flex-col justify-center items-center gap-16">
                <img src="../public/assets/3d-illustration-2.webp" alt="" class="w-full">
                <p class="text-white text-xl font-bold">Pembayaran menjadi lebih mudah</p>
            </div>
            <div class="w-full aspect-square flex flex-col justify-center items-center">
                <img src="../public/assets/3d-illustration-3.webp" alt="" class="w-3/4">
                <p class="text-white text-xl font-bold">Pelayanan SatSet</p>
            </div>
        </div>
    </section>
    <!-- section pelayanan -->

    
<!-- FOOTER -->
<footer class="bg-green-900 py-8">
  <div class="container mx-auto px-4">
    <div class="flex flex-wrap justify-center">
      <div class="w-full lg:w-6/12 px-4">
        <h4 class="text-3xl font-semibold text-white">Kontak</h4>
        <h5 class="text-lg mt-0 mb-2 text-white">Silahkan hubungi kami jika ada pertanyaan atau kendala:</h5>
        <div class="mt-6">
          <div class="flex">
            <span class="font-semibold text-white mr-4">Alamat:</span>
            <span class="text-white">Jalan Raya Bujuk Lalang No.99, Sumenep</span>
          </div>
          <div class="flex mt-4">
            <span class="font-semibold text-white mr-4">Telepon:</span>
            <span class="text-white">+62 123456789</span>
          </div>
          <div class="flex mt-4">
            <span class="font-semibold text-white mr-4">Email:</span>
            <span class="text-white">smkkreal@sppPayment.com</span>
          </div>
        </div>
      </div>
    </div>
    <hr class="my-6 border-green-700"/>
    <div class="flex flex-wrap items-center md:justify-between justify-center">
      <div class="w-full md:w-4/12 px-4">
        <div class="text-sm text-white font-semibold py-1">
          &copy; 2023 SPP Payment SMK Kreal
        </div>
      </div>
    </div>
  </div>
</footer>
<script src="../public/js/script.js"></script>
</body>
</html>