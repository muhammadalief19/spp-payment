<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

require_once"../../Controller/petugas/PetugasController.php";
require_once"../../Controller/db-transaksi/TransaksiController.php";


$PetugasController = new PetugasController;
$TransaksiController = new TransaksiController;

// authentication
$user = $PetugasController->authPetugas($_SESSION);
switch ($user["role"]) {
    case 'admin':
        # code...
        header("Location: ../admin/index.php");
        break;
    case 'petugas':
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
$msg = '';

if(isset($_POST["bayar"])) {
    $result = $TransaksiController->createPembayaranPetugas($_POST, $user["id"]);

    if($result > 0) {
        $success = true;
    } else {
        $error = true;
        $msg = $TransaksiController->getError();
    }
}
// logout
if(isset($_POST["logout"])) {
  $PetugasController->logout("login.php");
}

$page = "payment";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SPP Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../dist/output.css">
</head>

<body class="bg-gray-200 w-full relative">
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
                <p>Transaksi pembayaran suksess</p>
            </div>
            <div class="text-right">
                <a href="index.php" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">
                Alhamdulillah
                </a>
            </div>
            </div>
        </div>
        </div>
    </div>
    <?php elseif(isset($msg["payment"])) : ?>  
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
                    <p><?= $msg["payment"] ?></p>
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
                    <p>Transaksi pembayaran gagal</p>
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
    <?php endif ?>
  <div class="flex w-full box-border">
    <!-- Sidebar -->
    <div class="bg-gray-800 w-64 h-screen fixed left-0 top-0 text-gray-100">
      <div class="p-4 flex flex-col gap-7 h-full">
        <div class="flex gap-5 h-auto items-center">
            <img src="../../public/assets/icon-web.svg" alt="" class="w-1/4">
            <h1 class="text-xl font-bold mb-4">SPP Management</h1>
        </div>
        <ul class="w-full flex flex-col gap-4">
          <li class="mb-4"><a href="index.php" class="hover:text-gray-300 <?= ($page === "index" ? "border-b-2" : "hover:border-b-2 trensition-all duration-200 ease-in-out") ?>">Dashboard</a></li>
          <li class="mb-4"><a href="pembayaran.php" class="hover:text-gray-300 <?= ($page === "payment" ? "border-b-2" : "hover:border-b-2 trensition-all duration-200 ease-in-out") ?>">Pembayaran</a></li>
          <li class="mb-4"><a href="payment-history.php" class="hover:text-gray-300 <?= ($page === "report" ? "border-b-2" : "hover:border-b-2 trensition-all duration-200 ease-in-out") ?>">Laporan</a></li>
        </ul>
        <div class="flex-wrap flex h-full items-end">
            <form action="" method="post">
              <button type="submit" name="logout" class="flex items-center gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
              </svg>
                Logout
              </button>
            </form>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="pl-64 w-full flex-col">
    <div class="p-7 w-full h-screen flex flex-col items-center justify-center gap-7">
        <p class="text-2xl font-bold text-gray-600 uppercase">Pembayaran</p>
        <div class="w-1/2">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col gap-4" action="" method="POST" enctype="multipart/form-data">
                <div class="flex flex-col gap-2">
                <label class="block text-gray-700 font-bold" for="nisn">
                    NISN siswa
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nisn" name="nisn" type="text" placeholder="Masukkan nama lengkap">
                <?php if(isset($msg["nisn"])) : ?>
                    <p class="px-1 text-xs italic text-red-700"><?= $msg["nisn"] ?></p>
                <?php endif ?>
                </div>

                <div class="flex flex-col gap-2">
                <label class="block text-gray-700 font-bold" for="jumlah_bayar">
                    Jumlah Pembayaran
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="jumlah_bayar" name="jumlah_bayar" type="text" placeholder="Masukkan jumlah pembayaran">
                <?php if(isset($msg["pembayaran"])) : ?>
                    <p class="px-1 text-xs italic text-red-700"><?= $msg["pembayaran"] ?></p>
                <?php endif ?>
                </div>

                <div class="flex flex-col gap-2">
                <p class="block text-gray-700 font-bold">
                    Bukti Pembayaran
                </p>
                <label class="block">
                    <span class="sr-only">Choose File</span>
                    <input type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" name="bukti_pembayaran"/>
                </label>
                <?php if(isset($msg["bukti_pembayaran"])) : ?>
                    <p class="px-1 text-xs italic text-red-700"><?= $msg["bukti_pembayaran"] ?></p>
                <?php endif ?>
                </div>
                <div class="flex items-center justify-between">
                <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="bayar">
                    Bayar
                </button>
                </div>
            </form>
            </div>

    </div>

    <!-- footer -->
    <footer class="bg-gray-900 text-white py-8 px-10">
        <div class="container mx-auto flex justify-between items-center">
            <div>
            <h2 class="font-bold text-lg mb-2">Contact Us</h2>
            <p class="text-sm">Jalan Bujuk Lalang</p>
            <p class="text-sm">Sumenep</p>
            <p class="text-sm">smkkreal@gmail.com</p>
            <p class="text-sm">+62 87 938 920 124</p>
            </div>
            <div>
            <h2 class="font-bold text-lg mb-2">Follow Us</h2>
            <div class="flex">
                <a href="#" class="mr-4 text-gray-400 hover:text-gray-100 transition duration-300">
                <i class="fab fa-facebook"></i>
                </a>
                <a href="#" class="mr-4 text-gray-400 hover:text-gray-100 transition duration-300">
                <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-100 transition duration-300">
                <i class="fab fa-instagram"></i>
                </a>
            </div>
            </div>
        </div>
        <div class="bg-gray-800 h-1"></div>
        <div class="container mx-auto mt-4">
            <p class="text-center text-sm">&copy; 2023 SMKN 1 Kreal. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- footer -->
  </div>
  </div>


  <!-- Load JavaScript -->
  <script>
    // Get the sidebar
    const sidebar = document.querySelector('.bg-gray-800');

    // Get the main content
    const mainContent = document.querySelector('.ml-64');

    // Get the current width of the sidebar
    const sidebarWidth = sidebar.offsetWidth;

    // Set the initial margin-left of main content to match the sidebar width
    mainContent.style.marginLeft = sidebarWidth + 'px';

    // When the window is resized, adjust the margin-left of main content to match the new sidebar width
    window.addEventListener('resize', () => {
      const newSidebarWidth = sidebar.offsetWidth;
      mainContent.style.marginLeft = newSidebarWidth + 'px';
    });
  </script>
  <script src="../../public/js/script.js"></script>
</body>
</html>
