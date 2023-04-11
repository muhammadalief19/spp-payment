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

// pagination
$limit = 3;
$page = (isset($_GET["page"])) ? $_GET["page"] : 1;
$pageStart = ($page > 1) ? ($page * $limit) - $limit : 0;

$previous = $page - 1;
$next = $page + 1;

$data = $PetugasController->transactionReportAll($user["id"]);
$sumData = count($data);
$sumPage = ceil($sumData / $limit);
$num = $pageStart + 1;

$transaksi = $PetugasController->transactionReport($user["id"],$pageStart,$limit);


$success = false;
$error = false;
$msg = '';

// logout
if(isset($_POST["logout"])) {
  $PetugasController->logout("login.php");
}

$page = "report";
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
    <div class="p-7 w-full h-[120vh] flex flex-col items-center justify-center gap-7">
        <p class="text-2xl font-bold text-gray-600 uppercase">Transaction History</p>
        <div class="w-full flex flex-col items-center gap-7">
        <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN siswa</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pembayaran</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Pembayaran</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
              <?php foreach($transaksi as $data) : ?>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  <?= $data["nisn"] ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <?= $data["tgl_bayar"] ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <?= $PetugasController->convertRupiah($data["jumlah_bayar"]) ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <span class="px-4 py-0.5 bg-green-300 text-green-600 font-semibold rounded-full">
                    <?= $data["status"] ?>
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <span class="px-4 py-0.5 bg-sky-300 text-sky-600 font-semibold rounded-full" onclick="openModalImage()">
                  <?= $data["bukti_pembayaran"] ?>
                  </span>
              <!-- Modal container -->
              <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="modal-preview">
                <div class="flex items-center justify-center min-h-screen px-4">
                  <!-- Background overlay -->
                  <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50 flex justify-center items-center">
                  <!-- Modal content -->
                  <div class="bg-white rounded-lg shadow-lg overflow-hidden w-1/3 relative aspect-square">
                    <!-- Image container -->
                    <div class="relative w-full">
                      <img src="../../public/assets/bukti-pembayaran/<?= $data["bukti_pembayaran"] ?>" alt="Preview Image" class="w-full object-cover">
                    </div>

                    <!-- Close button -->
                    <button class="absolute top-0 right-0 m-4 text-gray-500 hover:text-gray-700 focus:outline-none" id="modal-close">
                      <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 8.586l3.293-3.293a1 1 0 1 1 1.414 1.414L11.414 10l3.293 3.293a1 1 0 1 1-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 0 1-1.414-1.414L8.586 10 5.293 6.707a1 1 0 0 1 1.414-1.414L10 8.586z"/>
                      </svg>
                    </button>
                  </div>
                  </div>
                </div>
              </div>
                  </td>
                </tr>
            <?php endforeach; ?>
              </tbody>
            </table>
            <div class="w-3/4 flex justify-center">
            <?php for($i = 1; $i <= $sumPage; $i++): ?>
                    <a href="?page=<?= $i ?>" class="<?= ($page === $i) ? "bg-gray-900 text-gray-200" : "bg-gray-200 text-gray-900" ?>  px-3 py-2 font-medium hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                    <?= $i ?>
                    </a>
            <?php endfor ?>
            </div>
        </div>
    </div>
      <!-- footer -->
      <!-- footer -->
    <footer class="w-full bg-gray-900 text-white py-8 px-10">
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
    </div>
  


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
