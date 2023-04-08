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
<body class="w-full overflow-x-hidden text-gray-700">
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
                <a href="../petugas/petugas.php" class="">Petugas</a>
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
        <p class="text-3xl font-bold">SISWA</p>
        <div class="w-[85%]">
            <a href="add-siswa.php" class="py-3 bg-sky-800 px-7 rounded text-gray-100 font-semibold">
                Tambah Siswa
            </a>
        </div>
        <div class="w-[85%] flex flex-col gap-4">
            <div class="w-full grid grid-cols-3 gap-5">
                <!-- card profile -->
                <div class="w-full grid grid-rows-3 bg-white shadow-lg rounded-lg overflow-hidden">
                <div class=" px-6 py-4 row-span-2 gap-3 flex h-auto items-center">
                    <img class="block mx-auto sm:mx-0 sm:flex-shrink-0 h-24 rounded-full" src="https://via.placeholder.com/150" alt="Profile Picture">
                    <div class="flex flex-col gap-[2px]">
                    <h3 class="text-xl font-semibold text-gray-900">John Doe</h3>
                    <p class="text-base font-medium text-gray-600">312124124</p>
                    <p class="text-sm  text-gray-600">XII RPL 2</p>
                    <div class="w-full flex gap-3">
                        <div class="">
                            <a href="#" class="inline-block px-3 py-1 text-sm font-semibold text-gray-100 leading-none bg-red-600 rounded-full">Delete</a>
                        </div>
                        <div class="">
                            <a href="#" class="inline-block px-3 py-1 text-sm font-semibold text-gray-100 leading-none bg-green-700 rounded-full">Update</a>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="bg-gray-200 px-6 py-3">
                    <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-900">Email</span>
                    <span class="text-sm text-gray-600">johndoe@example.com</span>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                    <span class="text-sm font-medium text-gray-900">Phone</span>
                    <span class="text-sm text-gray-600">+1 555-555-1234</span>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                    <span class="text-sm font-medium text-gray-900">Address</span>
                    <span class="text-sm text-gray-600">Pajagalan</span>
                    </div>
                </div>
                </div>
                <!-- card profile -->
            </div>
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