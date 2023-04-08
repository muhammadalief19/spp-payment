<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

require_once "../../../Controller/AdminController.php";
require_once "../../../Controller/db-siswa/TableSiswa.php";

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
    $AdminController->logout("../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../../dist/output.css">
</head>
<body class="w-full overflow-x-hidden text-gray-700 relative">
     <!-- navbar -->
     <navbar class="w-full flex gap-16 px-10 h-24 items-center fixed" id="navbar">
        <div class="flex gap-5 h-auto items-center">
            <img src="../../../public/assets/icon-web.svg" alt="" class="">
            <p class="font-bold text-xl">
                SPP Center
            </p>
        </div>
        <ul class="flex gap-7">
            <li class="">
                <a href="../index.php" class="">Dashboard</a>
            </li>
            <li class="">
                <a href="" class="">Transaksi</a>
            </li>
            <li class="">
                <a href="" class="">Petugas</a>
            </li>
            <li class="">
                <a href="siswa.php" class="">Siswa</a>
            </li>
            <li class="">
                <a href="../kelas/kelas.php" class="">Kelas</a>
            </li>
            <li class="">
                <a href="../komptensi/kompetensi.php" class="">Komptensi Keahlian</a>
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
    <!-- main -->
    <section class="w-full h-screen flex flex-col justify-center items-center pt-24 gap-7">
    <div class="flex flex-col justify-center items-center w-full h-full">
        <p class="text-2xl font-bold">Tambah Siswa</p>
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-md">
            <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="nama">
                Nama Lengkap
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama" type="text" placeholder="Masukkan nama lengkap">
            </div>
            <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="nisn">
                NISN
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nisn" type="text" placeholder="Masukkan NISN">
            </div>
            <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="kelas">
                Kelas
            </label>
            <div class="relative">
                <select class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option>Pilih kelas</option>
                <option>X</option>
                <option>XI</option>
                <option>XII</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M14.293 5.293a1 1 0 0 0-1.414 0L10 8.586 6.707 5.293a1 1 0 0 0-1.414 1.414l3.586 3.586a1 1 0 0 0 1.414 0l3.586-3.586a1 1 0 0 0 0-1.414z"/>
                </svg>
                </div>
            </div>
            </div>
            <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="alamat">
                Alamat
            </label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="alamat" placeholder="Masukkan alamat"></textarea>
            </div>
            <div class="mb-4">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                Simpan
            </button>
            </div>
        </form>
        </div>

    </section>
    <!-- main -->
        <!-- footer -->
        <footer class="bg-gray-900 text-white p-4 mt-8">
            <div class="max-w-7xl mx-auto flex justify-between h-auto items-center">
                <div class="flex items-center">
                <img src="../../../public/assets/icon-web.svg" alt="Logo" class="w-12 h-12 mr-2">
                <h1 class="text-xl font-bold">Admin Pembayaran SPP</h1>
                </div>
                <p class="text-sm">&copy; 2023 SMKN 1 Kreal</p>
            </div>
        </footer>
        <!-- footer -->
    <script src="../../../public/js/script.js"></script>
</body>
</html>