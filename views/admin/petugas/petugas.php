<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

require_once "../../../Controller/AdminController.php";
require_once "../../../Controller/db-petugas/TablePetugas.php";

$AdminController = new AdminController;
$TablePetugas = new TablePetugas;
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

$data = $TablePetugas->listPetugasAll();
$sumData = count($data);
$sumPage = ceil($sumData / $limit);
$num = $pageStart + 1;

$petugas = $TablePetugas->listPetugas($pageStart, $limit);

$success = false;
$error = false;

if(isset($_POST["delete"], $_POST["foto_profile"])) {
    $result = $TablePetugas->deletePetugas($_POST["id_petugas"], $_POST["foto_profile"]);
    if($result > 0) {
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
                    <p>Petugas berhasil di hapus</p>
                </div>
                <div class="text-right">
                    <a href="petugas.php" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">
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
                    <p>Petugas gagal di hapus</p>
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
                <a href="" class="">Transaksi</a>
            </li>
            <li class="">
                <a href="petugas.php" class="">Petugas</a>
            </li>
            <li class="">
                <a href="../siswa/siswa.php" class="">Siswa</a>
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
    <section class="w-full h-screen flex flex-col justify-center items-center pt-28 gap-10">
        <p class="text-3xl font-bold">Petugas</p>
        <div class="w-[85%]">
            <a href="add-petugas.php" class="py-3 bg-sky-800 px-7 rounded text-gray-100 font-semibold">
                Tambah Petugas
            </a>
        </div>
        <div class="w-[85%] flex flex-col gap-4">
            <div class="w-full grid grid-cols-3 gap-10">
                <?php foreach($petugas as $data) : ?>
                <!-- card profile -->
                <div class="bg-white rounded-lg hover:shadow-neutral-700 transition-shadow duration-300 ease-in-out shadow-2xl p-8 w-full flex flex-col gap-3">
                    <img class="w-32 h-32 rounded-full mx-auto" src="../../../public/assets/foto-profile/<?= $data["foto_profile"] ?>">
                    <h1 class="text-2xl font-bold text-center"><?= $data["nama"] ?></h1>
                    <p class="text-center text-gray-500"><?= $data["email"] ?></p>
                    <p class="text-center font-semibold text-gray-500"><?= $data["role"] ?></p>
                    <hr class="">
                    <div class="flex justify-center">
                        <a href="update-petugas.php?id=<?= $data["id_petugas"] ?>" class="bg-blue-700 text-white px-4 py-2 rounded mr-2">Update</a>
                        <form action="" method="post">
                            <input type="hidden" name="id_petugas" value="<?= $data["id_petugas"] ?>">
                            <input type="hidden" name="foto_profile" value="<?= $data["foto_profile"] ?>">
                            <button type="submit" name="delete" class="bg-red-700 text-white px-4 py-2 rounded mr-2">Delete</button>
                        </form>
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