<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

require_once"../../Controller/petugas/PetugasController.php";

$PetugasController = new PetugasController;

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

// logout
if(isset($_POST["logout"])) {
  $PetugasController->logout("login.php");
}

$page = "index";
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

<body class="bg-gray-200 w-full">
  <div class="flex w-full box-border">
    <!-- Sidebar -->
    <div class="bg-gray-800 w-64 h-screen fixed left-0 top-0 text-gray-100">
      <div class="p-4 flex flex-col gap-7 h-full">
        <div class="flex gap-5 h-auto items-center">
            <img src="../../public/assets/icon-web.svg" alt="" class="w-1/4">
            <h1 class="text-xl font-bold mb-4">SPP Management</h1>
        </div>
        <ul class="w-full flex flex-col gap-4">
          <li class="mb-4">
            <a href="index.php" class="hover:text-gray-300 <?= ($page === "index" ? "border-b-2" : "hover:border-b-2 trensition-all duration-200 ease-in-out") ?>">Dashboard</a>
          </li>
          <li class="mb-4">
            <a href="pembayaran.php" class="hover:text-gray-300 <?= ($page === "payment" ? "border-b-2" : "hover:border-b-2 trensition-all duration-200 ease-in-out") ?>">Pembayaran</a>
          </li>
          <li class="mb-4">
            <a href="" class="hover:text-gray-300 <?= ($page === "report" ? "border-b-2" : "hover:border-b-2 trensition-all duration-200 ease-in-out") ?>">Laporan</a>
        </li>
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
    <div class="p-7 w-full h-screen">
        <div class="w-full grid grid-cols-3 gap-6 text-white">
          <div class="w-full rounded-xl bg-gray-800 aspect-square shadow-2xl hover:shadow-gray-500 transition-all duration-500 ease-in-out p-5 flex flex-col gap-3 relative overflow-x-hidden">
            <img src="../../public/assets/illustration-3.svg" alt="" class="absolute w-1/2 -top-12 z-0 -right-14">
            <p class="text-2xl font-semibold">Profile</p>
            <div class="w-full flex flex-col items-center gap-2 flex-1 justify-center ">
              <img src="../../public/assets/foto-profile/<?= $user["foto_profile"] ?>" alt="" class="w-1/2 rounded-full">
              <p class="text-2xl font-bold"><?= $user["nama"] ?></p>
              <p class="text-xl font-medium"><?= $user["role"] ?></p>
              <div class="w-full flex justify-end">
                <button class="px-7 py-2 bg-gray-200 text-gray-800 font-bold rounded">Get started</button>
              </div>
            </div>
          </div>
          <div class="col-span-2 rounded-xl shadow-2xl hover:shadow-gray-500 transition-all duration-500 ease-in-out flex relative overflow-hidden text-gray-800 px-5 items-center">
              <img src="../../public/assets/illustration-4.svg" alt="" class="w-1/2 -left-40 -bottom-40 absolute rotate-45">
            <div class="z-10 relative w-full flex">
                <div class="flex-1 flex flex-col items-center gap-7">
                      <p class="text-center text-xl font-bold">Diary</p>
                      <div class="w-full flex flex-1 gap-3 justify-between items-center">
                          <div class="flex flex-col gap-1">
                            <p class="text-lg font-bold">Pembayaran hari ini</p>
                            <p class="font-medium">
                              <?= "4" ?> Siswa
                            </p>
                          </div>
                          <div class="flex flex-col gap-1">
                            <p class="text-lg font-bold">Pembayaran bulan ini</p>
                            <p class="font-medium">
                              <?= "10" ?> Siswa
                            </p>
                          </div>
                          <div class="flex flex-col gap-3"></div>
                      </div>
                      <div class="w-full flex justify-end">
                      <button class="px-7 py-2 bg-gradient-to-br from-gray-800 via-gray-600 to-gray-400 text-white font-semibold rounded-md">
                        History
                      </button>
                      </div>
                </div>
                <div class="flex justify-end w-1/3">
                  <img src="../../public/assets/3d-illustration-10.png" alt="" class="w-full">
                </div>
            </div>
          </div>
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
</body>
</html>
