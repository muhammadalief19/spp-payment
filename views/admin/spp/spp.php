<?php 
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}

require_once "../../../Controller/AdminController.php";
require_once "../../../Controller/db-spp/TableSpp.php";

$year = date('Y');
$AdminController = new AdminController;
$TableSpp = new TableSpp;
$SppNow = $TableSpp->findSppYear($year);

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
            # code...
            break;
            
            default:
            # code...
            break;
        }
        // authentication

    if(isset($_POST["delete"])) {
        $deleted = $TableSpp->deleteSpp($_POST["id_spp"]);
        if($deleted > 0) {
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
<body>
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
    <section class="w-full <?= (isset($SppNow)) ? "" : "h-screen" ?> py-32 flex flex-col items-center gap-4 justify-center">
    <p class="text-3xl font-bold">SPP</p>
    <?php if(!isset($SppNow)) : ?>
    <div class="w-1/2">
        <a href="add-spp.php" class="">
            <button class="bg-gradient-to-r from-gray-500 to-slate-600 hover:from-gray-700 hover:to-slate-800 text-white font-bold py-2 px-4 rounded-lg shadow-md transform hover:-translate-y-2 active:shadow-inner active:-translate-y-1 focus:outline-none duration-300 ease-in-out shadow-gray-500">
                Tambah SPP
            </button>
        </a>
    </div>
    <?php endif ?>
    <?php if(isset($SppNow)) : ?>
    <div class="bg-white shadow-2xl hover:shadow-yellow-300 transition-shadow duration-300 ease-in-out rounded-lg overflow-hidden w-80 md:w-96 mx-auto my-4 pb-6">
        <div class="bg-gradient-to-r from-amber-600 to-orange-300 h-48"></div>
        <div class="flex justify-center -mt-24">
            <img src="../../../public/assets/images-1.jpg" alt="Placeholder" class="rounded-full border-solid border-white border-4 -mt-3 w-[200px]">
        </div>
        <div class="px-4 py-2 flex flex-col gap-5">
            <h3 class="text-gray-700 font-bold text-xl text-center mb-2">SPP</h3>
            <p class="text-gray-600 text-xl font-semibold">Detail</p>
            <div class=" flex justify-between">
            <span class="text-gray-600 text-sm">Tahun :</span>
            <span class="text-gray-900 font-bold text-xl"><?= $SppNow["tahun"] ?></span>
            </div>
            <div class=" flex justify-between">
            <span class="text-gray-600 text-sm">Nominal :</span>
            <span class="text-gray-900 font-bold text-xl"><?= "RP. {$SppNow["nominal"]}" ?></span>
            </div>
            <div class=" flex gap-7 justify-center">
            <a href="update-spp.php?id=<?= $SppNow["id_spp"] ?>" class="p-3 aspect-square bg-blue-500 hover:bg-blue-600 text-white rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        </a>
                        <form action="" method="post">
                            <input type="hidden" name="id_spp" value="<?= $SppNow["id_spp"] ?>">
                            <button type="submit" name="delete" class="p-3 aspect-square bg-red-500 hover:bg-red-600 text-white rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
            </div>
        </div>
        </div>
        <?php else :?>
            <p class="">EMPTY</p>
        <?php endif ?>

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