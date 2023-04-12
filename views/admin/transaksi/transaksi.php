<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

require_once "../../../Controller/AdminController.php";
require_once "../../../Controller/db-transaksi/TransaksiController.php";

$AdminController = new AdminController;
$TransaksiController = new TransaksiController;
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

$data = $TransaksiController->transactionAll();
$sumData = count($data);
$sumPage = ceil($sumData / $limit);
$num = $pageStart + 1;

$transactions = $TransaksiController->transactions($pageStart, $limit);

$error = false;
$success = false;

if(isset($_POST["delete"])) {
    // $deleted = $TransaksiController->deleteSiswa($_POST["nisn"], $_POST["foto_profile"]);

    if($deleted > 0) {
        $success = true;
    } else {
        $error = true;
    }
}

$setuju = false;
$tolak = false;

if(isset($_POST["terima"])) {
    $terima = $TransaksiController->terimaTransaksi($_POST["id_transaksi"]);
    if($terima > 0) {
        $setuju = true;
    }
}

if(isset($_POST["tolak"])) {
    $failed = $TransaksiController->tolakTransaksi($_POST["id_transaksi"]);
    if($failed > 0) {
        $tolak = true;
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
      <?php if($setuju) : ?>
            <div class="w-full h-screen overflow-hidden flex justify-center items-center fixed bg-slate-200 bg-opacity-60 backdrop-blur-md z-50 <?= "block" ?>" id="myModal">
            <!-- Modal -->
            <div class="w-full z-10 inset-0 overflow-y-auto">
            <div class="w-full flex items-center justify-center min-h-screen p-4">
                <div class="bg-white w-1/4 rounded-lg shadow-lg p-6">
                <div class="mb-4">
                    <h2 class="text-xl font-bold">Success</h2>
                </div>
                <div class="mb-4">
                    <p>Transaksi telah disetujui</p>
                </div>
                <div class="text-right">
                    <a href="transaksi.php" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">
                    Alhamdulillah
                    </a>
                </div>
                </div>
            </div>
            </div>
            </div>
            <?php elseif($tolak) : ?>  
                <div class="w-full h-screen overflow-hidden flex justify-center items-center fixed bg-slate-200 bg-opacity-60 backdrop-blur-md z-50 
                <?= "block" ?>" id="myModal">
            <!-- Modal -->
            <div class="w-full z-10 inset-0 overflow-y-auto">
            <div class="w-full flex items-center justify-center min-h-screen p-4">
                <div class="bg-white w-1/4 rounded-lg shadow-lg p-6">
                <div class="mb-4">
                    <h2 class="text-xl font-bold">Success</h2>
                </div>
                <div class="mb-4">
                    <p>Transaksi telah ditolak</p>
                </div>
                <div class="text-right">
                    <a href="transaksi.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Alhamdulillah
                    </a>
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
                <a href="transaksi.php" class="">Transaksi</a>
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
        <div class="w-[85%] flex flex-col gap-4">
        <div class="w-full mx-auto py-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Transaksi</h1>
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse">
            <thead>
                <tr>
                <th class="px-4 py-2 text-left font-medium bg-gray-100">ID Transaksi</th>
                <th class="px-4 py-2 text-left font-medium bg-gray-100">NISN</th>
                <th class="px-4 py-2 text-left font-medium bg-gray-100">Nama Siswa</th>
                <th class="px-4 py-2 text-left font-medium bg-gray-100">Petugas</th>
                <th class="px-4 py-2 text-left font-medium bg-gray-100">Tanggal</th>
                <th class="px-4 py-2 text-left font-medium bg-gray-100">Nominal</th>
                <th class="px-4 py-2 text-left font-medium bg-gray-100">Status</th>
                <th class="px-4 py-2 text-left font-medium bg-gray-100">Jenis Pembayaran</th>
                <th class="px-4 py-2 text-left font-medium bg-gray-100">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($transactions as $item) : ?>
                <tr class="py-10 border-b-2">
                    <td class="px-4 py-6 text-left"><?= $item["id_transaksi"] ?></td>
                    <td class="px-4 py-6 text-left"><?= $item["nisn"] ?></td>
                    <td class="px-4 py-6 text-left"><?= $item["nama_siswa"] ?></td>
                    <td class="px-4 py-6 text-left"><?= $item["nama"] ?></td>
                    <td class="px-4 py-6 text-left">
                    <?= $item["tgl_bayar"] ?>
                    </td>
                    <td class="px-4 py-6 text-left">
                    <?= $item["jumlah_bayar"] ?>
                    </td>
                    <td class="px-4 py-6 text-left"><span class="<?= ($item["status"] === "disetujui") ? "bg-green-500" : ( ($item["status"] === "pending") ? "bg-yellow-500" : (($item["status"] === "ditolak") ? "bg-red-500" :  "") )?> text-white font-medium py-1.5 px-4 rounded-full">
                    <?= ($item["status"] === "disetujui") ? "success" : ( ($item["status"] === "pending") ? "pending" : (($item["status"] === "ditolak") ? "failed" :  "") )?></span>
                    </td>
                    <td class="px-4 py-6 text-left flex justify-center">
                        <span class="bg-sky-700 text-white font-semibold px-5 py-0.5 cursor-pointer rounded-xl" onclick="openModalImage()">
                            LIHAT
                        </span>
                        <div class="w-full h-screen fixed z-[99999] bg-slate-300 backdrop-blur-xl top-0 left-0 bg-opacity-5 justify-center items-center hidden" id="modal-preview">
                            <div class="w-1/4 aspect-square bg-white relative overflow-hidden rounded-lg">
                                <span class="absolute top-5 text-white right-6 cursor-pointer" id="modal-close">
                                    X
                                </span>
                                <img src="../../../public/assets/bukti-pembayaran/<?= $TransaksiController->findBukti($item["id_transaksi"]) ?>" alt="<?= $TransaksiController->findBukti($item["id_transaksi"]) ?>" class="object-cover">
                            </div>
                        </div>
                    </td>
                    <td class="py-6">
                        <div class="flex gap-5">
                        <form action="" method="post" class="">
                            <input type="hidden" name="id_transaksi" value="<?= $item["id_transaksi"] ?>">
                            <button class="px-5 py-2 bg-green-500 rounded-md font-semibold text-white" type="submit" name="terima">
                                Terima
                            </button>
                        </form>
                        <form action="" method="post" class="">
                            <input type="hidden" name="id_transaksi" value="<?= $item["id_transaksi"] ?>">
                            <button class="px-5 py-2 bg-red-500 rounded-md font-semibold text-white" type="submit" name="tolak">
                                Tolak
                            </button>
                        </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
            </table>
        </div>
        </div>

            <div class="flex justify-center">
                <nav class="inline-flex">
                    <?php for($i = 1; $i <= $sumPage; $i++): ?>
                    <a href="?page=<?= $i ?>" class="<?= ($page == $i) ? "bg-gray-900 text-gray-200" : "bg-gray-200 text-gray-900" ?>  px-3 py-2 font-medium hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                    <?= $i ?>
                    </a>
                    <?php endfor ?>
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
    <script>
        // Open modal function
        function openModalImage() {
          document.getElementById("modal-preview").classList.add("flex");
          document.getElementById("modal-preview").classList.remove("hidden");
        }

        // Close modal function
        function closeModalImage() {
          document.getElementById("modal-preview").classList.add("hidden");
          document.getElementById("modal-preview").classList.remove("flex");
        }

        // Add event listener to close button
        document.getElementById("modal-close").addEventListener("click", closeModalImage);
    </script>
</body>
</html>