<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

require_once "../../Controller/AdminController.php";

$AdminController = new AdminController;
$user = $AdminController->authPetugas($_SESSION);
switch ($user["role"]) {
    case 'admin':
        # code...
        break;
    case 'petugas':
        header("Location: ../petugas/index.php");
        break;
    case 'siswa':
        # code...
        break;
    
    default:
        # code...
        break;
}

if(isset($_POST["logout"])) {
    $AdminController->logout("login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../dist/output.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@^3.4.1/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@^3.4.1/dist/css/glide.theme.min.css">
</head>
<body class="w-full overflow-x-hidden relative text-gray-700">
    <!-- navbar -->
    <navbar class="w-full flex gap-16 px-10 h-24 items-center fixed" id="navbar">
        <div class="flex gap-5 h-auto items-center">
            <img src="../../public/assets/icon-web.svg" alt="" class="">
            <p class="font-bold text-xl">
                SPP Center
            </p>
        </div>
        <ul class="flex gap-7">
            <li class="">
                <a href="index.php" class="">Dashboard</a>
            </li>
            <li class="">
                <a href="" class="">Transaksi</a>
            </li>
            <li class="">
                <a href="petugas/petugas.php" class="">Petugas</a>
            </li>
            <li class="">
                <a href="siswa/siswa.php" class="">Siswa</a>
            </li>
            <li class="">
                <a href="kelas/kelas.php" class="">Kelas</a>
            </li>
            <li class="">
                <a href="komptensi/kompetensi.php" class="">Komptensi Keahlian</a>
            </li>
        </ul>
        <div class="flex-1 flex justify-end">
            <form action="" method="post">
                <button type="submit" name="logout">
                    Logout
                </button>
            </form>
        </div>
    </navbar>
    <!-- navbar -->

    <!-- section hero -->
    <section class="w-full flex justify-center py-28">
        <div class="w-3/4 grid grid-cols-2">
            <div class="w-full flex gap-10 h-auto items-center">
                <img src="../../public/assets/foto-profile/<?= $user["foto_profile"] ?>" alt="" class="w-1/2 rounded-full">
                <div class="flex-1 flex flex-col">
                    <P class="text-3xl font-bold">
                        Selamat Datang
                    </P>
                    <P class="">
                        <?= $user["nama"] ?>
                    </P>
                </div>
            </div>
            <div class="w-full flex justify-center">
                <img src="../../public/assets/3d-illustration-4.png" alt="" class="w-3/4">
            </div>
        </div>
    </section>
    <!-- section hero -->
    <!-- section menu -->
    <section class="w-full flex flex-col gap-10 items-center py-20">
        <p class="text-center text-4xl font-bold">MENU</p>
        <div class="w-1/2">
        <div class="glide" id="slider">
        <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
            <li class="glide__slide rounded-md shadow-md box-border p-6 flex-col gap-2 aspect-square border-[3px] flex justify-center items-center"> 
                <img src="../../public/assets/3d-illustration-6.png" alt="" class="">  
                <a href="siswa/siswa.php" class="text-lg font-semibold hover:text-gray-500">Siswa</a href="">
            </li>
            <li class="glide__slide rounded-md shadow-md box-border p-6 flex-col gap-2 aspect-square border-[3px] flex justify-center items-center"> 
                <img src="../../public/assets/3d-illustration-7.png" alt="" class="">  
                <a href="" class="text-lg font-semibold hover:text-gray-500">History transaksi</a href="">
            </li>
            <li class="glide__slide rounded-md shadow-md box-border p-6 flex-col gap-2 aspect-square border-[3px] flex justify-center items-center"> 
                <img src="../../public/assets/3d-illustration-8.png" alt="" class="">  
                <a href="petugas/petugas.php" class="text-lg font-semibold hover:text-gray-500">Petugas</a href="">
            </li>
            <li class="glide__slide rounded-md shadow-md box-border p-6 flex-col gap-2 aspect-square border-[3px] flex justify-center items-center"> 
                <img src="../../public/assets/3d-illustration-9.png" alt="" class="">  
                <a href="spp/spp.php" class="text-lg font-semibold hover:text-gray-500">SPP</a href="">
            </li>
            <li class="glide__slide rounded-md shadow-md box-border p-6 flex-col gap-2 aspect-square border-[3px] flex justify-center items-center"> 
                <img src="../../public/assets/illustration-2.svg" alt="" class="">  
                <a href="kelas/kelas.php" class="text-lg font-semibold hover:text-gray-500">Kelas</a href="">
            </li>
            </ul>
        </div>
        <div data-glide-el="controls" class="w-full flex justify-between">
            <button class="glide__arrow glide__arrow--left bg-gray-500 w-max aspect-square rounded-full" data-glide-dir="<">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
            </svg>
            </button>
            <button class="glide__arrow glide__arrow--right bg-gray-500 w-max aspect-square rounded-full" data-glide-dir=">">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
            </svg>
            </button>
        </div>
        </div>
        </div>
    </section>
    <!-- section menu -->

    <!-- footer -->
<footer class="bg-gray-900 text-white p-4 mt-8">
  <div class="max-w-7xl mx-auto flex justify-between h-auto items-center">
    <div class="flex items-center">
      <img src="../../public/assets/icon-web.svg" alt="Logo" class="w-12 h-12 mr-2">
      <h1 class="text-xl font-bold">Admin Pembayaran SPP</h1>
    </div>
    <p class="text-sm">&copy; 2023 SMKN 1 Kreal</p>
  </div>
</footer>

    <!-- footer -->
    <!-- script -->
    <script src="../../public/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
    <script>
    new Glide('#slider', {
        type: 'carousel',
        perView: 2.5,
        autoplay: 2000,
        gap: 30,
        peek: { before: 50, after: 50 },
        breakpoints: {
        768: {
            perView: 2
        },
        480: {
            perView: 1
        }
        }
    }).mount();
    </script>

</body>
</html>