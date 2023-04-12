<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

require_once "../../../Controller/AdminController.php";
require_once "../../../Controller/db-siswa/TableSiswa.php";

$AdminController = new AdminController;
$TableSiswa = new TableSiswa;
$kelas = $TableSiswa->kelasAll();
$siswa = $TableSiswa->findSiswa($_GET["nisn"]);
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

if(isset($_POST["update"])) {
    $result = $TableSiswa->updateSiswa($_POST, $_GET["nisn"]);
    if($result) {
        $success = true;
    } else {
        $error = true;
        $message = $TableSiswa->getError();
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
<body class="w-full overflow-x-hidden text-gray-700 relative">
      <!-- modal update -->
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
                    <p>Siswa berhasil di update</p>
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
                    <p>Siswa gagal di update</p>
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
    <!-- modal update -->
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
    <section class="w-full flex flex-col justify-center items-center py-28 gap-7">
    <div class="flex flex-col gap-7 justify-center items-center w-full h-full">
        <p class="text-2xl font-bold">Update Siswa</p>
        <form action="" method="post" class="w-1/4" enctype="multipart/form-data">
        <div class="flex flex-col space-y-4">
            <div class="flex flex-col space-y-1">
                <label for="nama" class="text-lg font-semibold">Nama</label>
                <input autocomplete="off" type="text" id="nama" name="nama" class="border-b-2 border-gray-400 focus:outline-none focus:border-green-500 transition duration-500" value="<?= $siswa["nama_siswa"] ?>">
                <?php if(isset($message["nama"])) : ?>
                    <p class="px-1 text-xs italic text-red-700"><?= $message["nama"] ?></p>
                <?php endif ?>
            </div>

            <div class="flex flex-col space-y-1">
                <label for="alamat" class="text-lg font-semibold">Alamat</label>
                <input autocomplete="off" type="text" id="alamat" name="alamat" class="border-b-2 border-gray-400 focus:outline-none focus:border-green-500 transition duration-500" value="<?= $siswa["alamat"] ?>">
                <?php if(isset($message["alamat"])) : ?>
                    <p class="px-1 text-xs italic text-red-700"><?= $message["alamat"] ?></p>
                <?php endif ?>
            </div>

            <div class="flex flex-col space-y-1">
                <label for="no_telp" class="text-lg font-semibold">No. Telp</label>
                <input autocomplete="off" type="text" id="no_telp" name="no_telp" class="border-b-2 border-gray-400 focus:outline-none focus:border-green-500 transition duration-500" value="<?= $siswa["no_telp"] ?>">
                <?php if(isset($message["no_telp"])) : ?>
                    <p class="px-1 text-xs italic text-red-700"><?= $message["no_telp"] ?></p>
                <?php endif ?>
            </div>

            <div class="flex flex-col space-y-1">
				<label for="id_kelas" class="block text-gray-700 font-bold mb-2">Kelas</label>
				<div class="relative">
					<select name="id_kelas" id="id_kelas" class="border rounded-md py-2 px-3 w-full appearance-none">
						<option value="" selected>Pilih kelas</option>
                        <?php foreach($kelas as $item) : ?>
						<option value="<?= $item["id_kelas"] ?>" <?= ($siswa["id_kelas"] === $item["id_kelas"]) ? "selected" : "" ?> > <?= "{$item["nama_kelas"]} {$item["nama_kompetensi"]}" ?> </option>
                        <?php endforeach ?>
					</select>
					<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
						<svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M14.707 6.293a1 1 0 011.414 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 111.414-1.414L10 10.586l4.293-4.293a1 1 0 011.414 0z"/></svg>
					</div>
				</div>
                <?php if(isset($message["kelas"])) : ?>
                    <p class="px-1 text-xs italic text-red-700"><?= $message["kelas"] ?></p>
                <?php endif ?>
            </div>

            <input type="hidden" name="foto_lama" value="<?= $siswa["foto_profile_siswa"] ?>">

            <div class="flex flex-col space-y-1">
                <p class="block text-gray-700 font-bold mb-2">Foto Profile</p>
                <label class="block">
                <span class="sr-only">Choose File</span>
                <input autocomplete="off" type="file" name="foto_profile" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"/>
                </label>
                <?php if(isset($message["foto_profile"])) : ?>
                    <p class="px-1 text-xs italic text-red-700"><?= $message["foto_profile"] ?></p>
                <?php endif ?>
            </div>

            <div class="flex justify-center">
                <button type="submit" name="update" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-full transition duration-500">Submit</button>
            </div>
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