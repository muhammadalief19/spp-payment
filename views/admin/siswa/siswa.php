<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

require_once "../../../Controller/AdminController.php";
require_once "../../../Controller/db-siswa/TableSiswa.php";

$AdminController = new AdminController;
$TableSiswa = new TableSiswa;
// authentication
$user = $AdminController->authPetugas($_SESSION);
switch ($user["role"]) {
    case 'admin':
        # code...
        break;
    case 'petugas':
        header("Location: ../petugas/index.php");
        break;
        case 'siswa':
        header("Location: ../home.php");
        break;
            
        default:
            # code...
        break;
}
// authentication

// pagination
$limit = 3;
$page = (isset($_GET["page"])) ? $_GET["page"] : 1;
$pageStart = ($page > 1) ? ($page * $limit) - $limit : 0;

$previous = $page - 1;
$next = $page + 1;

$data = $TableSiswa->listSiswaAll();
$sumData = count($data);
$sumPage = ceil($sumData / $limit);
$num = $pageStart + 1;

$siswa = $TableSiswa->listSiswa($pageStart, $limit);

$error = false;
$success = false;

if(isset($_POST["delete"])) {
    $deleted = $TableSiswa->deleteSiswa($_POST["nisn"], $_POST["foto_profile"]);

    if($deleted > 0) {
        $success = true;
    } else {
        $error = true;
    }
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
      <!-- modal delete -->
      <?php if($success) : ?>
            <div class="w-full h-screen overflow-hidden flex justify-center items-center fixed bg-slate-200 bg-opacity-60 backdrop-blur-md z-50 <?= "block" ?>" id="myModal">
            <!-- Modal -->
            <div class="w-full z-10 inset-0 overflow-y-auto">
            <div class="w-full flex items-center justify-center min-h-screen p-4">
                <div class="bg-white w-1/4 rounded-lg shadow-lg p-6">
                <div class="mb-4">
                    <h2 class="text-xl font-bold">Success</h2>
                </div>
                <div class="mb-4">
                    <p>Siswa berhasil di hapus</p>
                </div>
                <div class="text-right">
                    <a href="siswa.php" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">
                    Alhamdulillah
                    </a>
                </div>
                </div>
            </div>
            </div>
            </div>
            <?php elseif($error) : ?>  
                <div class="w-full h-screen overflow-hidden flex justify-center items-center fixed bg-slate-200 bg-opacity-60 backdrop-blur-md z-50 
                <?= "block" ?>" id="myModal">
            <!-- Modal -->
            <div class="w-full z-10 inset-0 overflow-y-auto">
            <div class="w-full flex items-center justify-center min-h-screen p-4">
                <div class="bg-white w-1/4 rounded-lg shadow-lg p-6">
                <div class="mb-4">
                    <h2 class="text-xl font-bold">Error</h2>
                </div>
                <div class="mb-4">
                    <p>Siswa gagal di hapus</p>
                </div>
                <div class="text-right">
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="closeModal()">
                    Subhanallah
                    </button>
                </div>
                </div>
            </div>
            </div>
            </div>  
        <?php endif; ?>
    <!-- modal delete -->
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
                <a href="../transaksi/transaksi.php" class="">Transaksi</a>
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
                <?php foreach($siswa as $item) : ?>
                <!-- card profile -->
                <div class="w-full grid grid-rows-3 bg-white shadow-lg rounded-lg overflow-hidden">
                <div class=" px-6 py-4 row-span-2 gap-3 flex h-auto items-center">
                    <img class="block mx-auto sm:mx-0 sm:flex-shrink-0 h-24 rounded-full" src="../../../public/assets/foto-profile/<?= $item["foto_profile_siswa"] ?>" alt="Profile Picture">
                    <div class="flex flex-col gap-[2px]">
                    <h3 class="text-xl font-semibold text-gray-900"><?= $item["nama_siswa"] ?></h3>
                    <p class="text-base font-medium text-gray-600"><?= $item["nisn"] ?></p>
                    <p class="text-sm  text-gray-600"><?= "{$item["nama_kelas"]}" ?></p>
                    <div class="w-full flex gap-3">
                        <div class="">
                            <form action="" method="post">
                                <input type="hidden" name="nisn" value="<?= $item["nisn"] ?>">
                                <input type="hidden" name="foto_profile" value="<?= $item["foto_profile_siswa"] ?>">
                                <button type="submit" name="delete" class="inline-block px-3 py-1 text-sm font-semibold text-gray-100 leading-none bg-red-600 rounded-full">Delete</button>
                            </form>
                        </div>
                        <div class="">
                            <a href="update-siswa.php?nisn=<?= $item["nisn"] ?>" class="inline-block px-3 py-1 text-sm font-semibold text-gray-100 leading-none bg-green-700 rounded-full">Update</a>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="bg-gray-200 px-6 py-3">
                    <div class="flex items-center justify-between mt-2">
                    <span class="text-sm font-medium text-gray-900">Kompetensi Keahlian</span>
                    <span class="text-sm text-gray-600"><?= $item["nama_kompetensi"] ?></span>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                    <span class="text-sm font-medium text-gray-900">Phone</span>
                    <span class="text-sm text-gray-600"><?= $item["no_telp"] ?></span>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                    <span class="text-sm font-medium text-gray-900">Address</span>
                    <span class="text-sm text-gray-600"><?= $item["alamat"] ?></span>
                    </div>
                </div>
                </div>
                <!-- card profile -->
                <?php endforeach ?>
            </div>
            <div class="flex justify-center">
                <nav class="inline-flex">
                    <a href="?page=<?= $page-1 ?>" class="bg-gray-200 px-3 py-2 font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                    < Prev
                    </a>
                    <?php for($i = 1; $i <= $sumPage; $i++): ?>
                    <a href="?page=<?= $i ?>" class="<?= ($page == $i) ? "bg-gray-900 text-gray-200" : "bg-gray-200 text-gray-900" ?>  px-3 py-2 font-medium hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                    <?= $i ?>
                    </a>
                    <?php endfor ?>
                    <a href="?page=<?= $page+1 ?>" class="bg-gray-200 px-3 py-2 font-medium hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                    Next >
                    </a>
                </nav>
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