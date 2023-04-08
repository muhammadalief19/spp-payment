<?php 
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

require_once "../../../Controller/AdminController.php";
require_once "../../../Controller/db-spp/TableSpp.php";

$AdminController = new AdminController;
$TableSpp = new TableSpp;

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

    $success = false;
    $error = false;
    $msg = '';
    if(isset($_POST["create"])) {
        $created = $TableSpp->createSpp($_POST);
        if($created > 0) {
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
    <title>SPP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../../dist/output.css">
</head>
<body class="w-full relative overflow-x-hidden">
<?php if($success) : ?>
    <div class="w-full h-screen overflow-hidden flex justify-center items-center fixed bg-slate-200 bg-opacity-60 backdrop-blur-md z-50" id="myModal">
        <!-- Modal -->
        <div class="w-full z-10 inset-0 overflow-y-auto">
        <div class="w-full flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-1/4 rounded-lg shadow-lg p-6">
            <div class="mb-4">
                <h2 class="text-xl font-bold">SUCCESS</h2>
            </div>
            <div class="mb-4">
                <p>SPP berhasil ditambah</p>
            </div>
            <div class="text-right">
                <a href="spp.php" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">
                Alhamdulillah
                </a>
            </div>
            </div>
        </div>
        </div>
    </div>
    <?php endif ?>
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
                <a href="../kompetensi/kompetensi.php" class="">Komptensi Keahlian</a>
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
    <!-- section main -->
    <section class="w-full h-screen flex flex-col gap-5 justify-center items-center">
    <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-xl shadow-lg">
        <div class="md:flex">
            <div class="md:flex-shrink-0">
            <img class="w-full object-cover md:w-48 h-full" src="https://source.unsplash.com/random" alt="Input Form Illustration">
            </div>
            <div class="p-8">
            <div class="uppercase tracking-wide text-2xl text-gray-800 font-bold">Tambah SPP</div>
            <form class="mt-6" action="" method="post">
                <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="full-name">
                    Nominal
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="full-name" name="nominal" type="text" placeholder="Nominal (RP)">
                </div>
                <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="create">
                    Create
                </button>
                </div>
            </form>
            </div>
        </div>
        </div>

    </section>
    <!-- section main -->
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