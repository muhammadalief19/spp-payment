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

$success = false;
$error = false;
$message = '';

if(isset($_POST["create"])) {
    // var_dump($_POST);
    $result = $TablePetugas->createPetugas($_POST);
    if( $result > 0) {
        $success = true;
    } else {
        $error = true;
        $message = $TablePetugas->getError();
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
<body class="relative overflow-x-hidden">

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
                <p>Petugas berhasil ditambah</p>
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

    <!-- section main -->
    <section class="w-full py-28 flex flex-col gap-8 items-center">
    <div class="w-1/2 py-6">
        <div class="w-full mx-auto bg-slate-300 rounded-lg overflow-hidden">
            <div class="grid grid-cols-3">
            <div class="w-full px-4 py-5 bg-slate-300 sm:p-6 col-span-2">
                <h1 class="text-xl font-bold text-gray-900 mb-4">Tambah Petugas</h1>
                <form action="" enctype="multipart/form-data" method="POST" class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <label for="nama" class="block text-gray-700 font-bold">Nama</label>
                    <input autocomplete="off" type="text" id="nama" name="nama" placeholder="Masukkan nama Anda" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
                    <?php if(isset($message["nama"])) : ?>
                        <p class="px-1 text-xs italic text-red-700"><?= $message["nama"] ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="email" class="block text-gray-700 font-bold">Email</label>
                    <input autocomplete="off" type="email" id="email" name="email" placeholder="Masukkan email Anda" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
                    <?php if(isset($message["email"])) : ?>
                        <p class="px-1 text-xs italic text-red-700"><?= $message["email"] ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="password" class="block text-gray-700 font-bold">Password</label>
                    <input autocomplete="off" type="password" id="password" name="password" placeholder="Masukkan password Anda" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
                    <?php if(isset($message["password"])) : ?>
                        <p class="px-1 text-xs italic text-red-700"><?= $message["password"] ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="role" class="block text-gray-700 font-bold">Role</label>
                    <select name="role" id="role" class="bg-gray-200 border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
                        <option value="" selected>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                    </select>
                    <?php if(isset($message["role"])) : ?>
                        <p class="px-1 text-xs italic text-red-700"><?= $message["role"]; ?></p>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col gap-2">
                <p class="block text-gray-700 font-bold">Foto Profile</p>
                <label class="block">
                <span class="sr-only">Choose File</span>
                <input autocomplete="off" type="file" name="foto_profile" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100"/>
                </label>
                <?php if(isset($message["image"])) : ?>
                    <p class="px-1 text-xs italic text-red-700"><?= $message["image"]; ?></p>
                <?php endif; ?>
                </div>
                <div class="">
                    <button type="submit" name="create" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">Submit</button>
                </div>
                </form>
            </div>
            <div class="w-full h-auto">
                <img class="w-full h-full object-cover " src="../../../public/assets/images-2.jpeg" alt="Gambar Retro">
            </div>
            </div>
        </div>
        </div>

  </form>
    </section>
    <!-- section main -->
<script src="../../../public/js/script.js"></script>
</body>
</html>