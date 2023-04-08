<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

require_once "../../../Controller/AdminController.php";
require_once "../../../Controller/db-kompetensi/TableKomptensi.php";

$AdminController = new AdminController;
$TableKompetensi = new TableKompetensi;
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

// pagination
$limit = 3;
$page = (isset($_GET["page"])) ? $_GET["page"] : 1;
$pageStart = ($page > 1) ? ($page * $limit) - $limit : 0;

$previous = $page - 1;
$next = $page + 1;

$data = $TableKompetensi->KompetensiAll();
$sumData = count($data);
$sumPage = ceil($sumData / $limit);
$num = $pageStart + 1;


$kompetensi = $TableKompetensi->listKomptensi($pageStart,$limit);

$err = false;
$success = false;

if(isset($_POST["delete"])) {
    $result = $TableKompetensi->deleteKompetensi($_POST["id_kompetensi"]);
    if($result > 0) {
        $success = true;
    } else {
        $err = true;
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
    <title>Kompetensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../../dist/output.css">
</head>
<body class="w-full overflow-x-hidden text-gray-700 relative">
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
                    <p>Kompetensi berhasil di hapus</p>
                </div>
                <div class="text-right">
                    <a href="kompetensi.php" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">
                    Alhamdulillah
                    </a>
                </div>
                </div>
            </div>
            </div>
            </div>
            <?php elseif($err) : ?>  
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
                    <p>Kompetensi gagal di hapus</p>
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
                <a href="../petugas/petugas.php" class="">Petugas</a>
            </li>
            <li class="">
                <a href="../siswa/siswa.php" class="">Siswa</a>
            </li>
            <li class="">
                <a href="../kelas/kelas.php" class="">Kelas</a>
            </li>
            <li class="">
                <a href="kompetensi.php" class="">Komptensi Keahlian</a>
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
    <section class="w-full h-screen flex flex-col justify-center items-center py-24 gap-7">
        <p class="text-3xl font-bold">Kompetensi Keahlian</p>
        <div class="w-[85%]">
            <a href="add-kompetensi.php" class="py-3 bg-sky-800 px-7 rounded text-gray-100 font-semibold">
                Tambah Kompetensi
            </a>
        </div>
        <div class="w-[85%] flex flex-col gap-4">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                    <th class="py-3 px-6 text-left font-medium text-gray-600 uppercase border-b border-gray-300">No</th>
                    <th class="py-3 px-6 text-left font-medium text-gray-600 uppercase border-b border-gray-300">Nama Kompetensi</th>
                    <th class="py-3 px-6 text-left font-medium text-gray-600 uppercase border-b border-gray-300">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    <?php foreach($kompetensi as $item): ?>
                    <tr>
                        <td class="py-4 px-6 border-b border-gray-300"><?= $num++?></td>
                        <td class="py-4 px-6 border-b border-gray-300"><?= $item["nama"] ?></td>
 
                    <td class="py-4 px-6 text-center border-b border-gray-300 flex gap-7">
                        <a href="update-kompetensi.php?id=<?= $item["id_kompetensi"] ?>" class="p-3 aspect-square bg-blue-500 hover:bg-blue-600 text-white rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        </a>
                        <form action="" method="post">
                            <input type="hidden" name="id_kompetensi" value="<?= $item["id_kompetensi"] ?>">
                            <button type="submit" name="delete" class="p-3 aspect-square bg-red-500 hover:bg-red-600 text-white rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>
                    </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
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