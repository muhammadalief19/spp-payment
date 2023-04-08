<?php 
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

require_once "../../../Controller/AdminController.php";
require_once "../../../Controller/db-kompetensi/TableKomptensi.php";
require_once "../../../Controller/db-kelas/TableKelas.php";

$AdminController = new AdminController;
$TableKompetensi = new TableKompetensi;
$TableKelas = new TableKelas;
$kompetensi = $TableKompetensi->kompetensiAll();
$kelas = $TableKelas->findKelas($_GET["id"]);

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

// validasi untuk mengecek apakah proses created success atau belum
$error = false;
$success = false;
$message = '';

if(isset($_POST["update"])) {
    $updated = $TableKelas->updateKelas($_POST, $_GET["id"]);
    if($updated > 0) {
        $success = true;
    } else {
        $error = true;
        $message = $TableKelas->getError();
        var_dump($_POST);
        var_dump($_GET["id"]);
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
    <title>Kelas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../../dist/output.css">
</head>
<body class="w-full overflow-x-hidden relative">
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
                <p>Kelas berhasil diupdate</p>
            </div>
            <div class="text-right">
                <a href="kelas.php" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">
                Alhamdulillah
                </a>
            </div>
            </div>
        </div>
        </div>
    </div>
    <?php elseif($error) : ?>
            <div class="w-full h-screen overflow-hidden flex justify-center items-center fixed bg-slate-200 bg-opacity-60 backdrop-blur-md z-50" id="myModal">
        <!-- Modal -->
        <div class="w-full z-10 inset-0 overflow-y-auto">
        <div class="w-full flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-1/4 rounded-lg shadow-lg p-6">
            <div class="mb-4">
                <h2 class="text-xl font-bold">Error</h2>
            </div>
            <div class="mb-4">
                <p><?= (isset($message["data"])) ? $message["data"] : "Kelas gagal diupdate" ?></p>
            </div>
            <div class="text-right">
                <button onclick="closeModal()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Subhanallah
                </button>
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
                <a href="" class="">Petugas</a>
            </li>
            <li class="">
                <a href="../siswa/siswa.php" class="">Siswa</a>
            </li>
            <li class="">
                <a href="kelas.php" class="">Kelas</a>
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
    <section class="w-full h-screen flex flex-col justify-center items-center gap-5">
        <div class="w-1/2 flex flex-col gap-6 items-center">
            <p class="text-xl font-bold text-blue-900">Tambah Kelas</p>
            <form class="w-3/5 bg-white p-8 border-t-8 border-blue-900 rounded-lg shadow-lg" action="" method="post">
            <div class="mb-4 flex flex-col gap-2">
                    <label class="block text-gray-700 font-bold mb-2" for="nama_kelas">
                    Kelas
                    </label>
                    <div class="relative">
                    <select class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama_kelas" name="nama_kelas">
                        <option value="X" <?= ($kelas["nama_kelas"] === "X") ? "selected" : "" ?> >X</option>
                        <option value="XI" <?= ($kelas["nama_kelas"] === "XI") ? "selected" : "" ?> >XI</option>
                        <option value="XII" <?= ($kelas["nama_kelas"] === "XII") ? "selected" : "" ?> >XII</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 12l-6-6h12z"/></svg>
                    </div>
                    </div>
                    <?php if(isset($message["nama_kelas"])) : ?>
                    <p class="text-xs italic text-red-700"><?= $message["nama_kelas"] ?></p>
                    <?php endif?>
                </div>
                <div class="mb-4 flex flex-col gap-2">
                    <label class="block text-gray-700 font-bold mb-2" for="id_kompetensi">
                    Kompetensi Keahlian
                    </label>
                    <div class="relative">
                    <select class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="id_kompetensi" name="id_kompetensi">
                        <option value="0">-- Pilih Kompetensi Keahlian --</option>
                        <?php foreach($kompetensi as $item) : ?>
                        <option value="<?= $item["id_kompetensi"] ?>" <?= ($item["id_kompetensi"] == $kelas["id_kompetensi"]) ? "selected" : "" ?> ><?= $item["nama"] ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 12l-6-6h12z"/></svg>
                    </div>
                    </div>
                    <?php if(isset($message["kompetensi"])) : ?>
                    <p class="text-xs italic text-red-700"><?= $message["kompetensi"] ?></p>
                    <?php endif ?>
                </div>
                <div class="w-full flex items-center justify-end">
                    <button class="bg-blue-800 hover:bg-blue-700 text-white font-bold p-2 rounded-full focus:outline-none focus:shadow-outline" type="submit" name="update">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    </button>
                </div>
            </form>

        </div>
    </section>
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
    <!-- section main -->
    <script src="../../../public/js/script.js"></script>
</body>
</html>