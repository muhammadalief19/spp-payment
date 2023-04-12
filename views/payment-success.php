<?php
session_start();

if(!isset($_SESSION["login"])) {
  header("Location:login.php");
}

require_once"../Controller/siswa/SiswaController.php";

$SiswaController = new SiswaController;
$userAuth = $SiswaController->userAuth();

switch ($userAuth["role"]) {
    case 'admin':
        # code...
        header("Location: admin/index.php");
        break;
    case 'petugas':
        header("Location: petugas/index.php");
    break;

    case 'siswa':
    break;
            
        default:
            # code...
        break;
}

// logout
if(isset($_POST["logout"])) {
    $SiswaController->logout("login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUCCESS</title>
    <link rel="stylesheet" href="../dist/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
        extend: {
        keyframes: {
            float: {
            "0%, 100%": { transform: "translate(0)" },
            "50%": { transform: "translate(42px, 18px)" },
            },
        },
        animation: {
            floating: "float 2s ease-in-out infinite",
        },
    },
  },
    }
  </script>
</head>
<body class="w-full h-screen overflow-hidden flex justify-center items-center">
    <section class="w-full h-screen">
    <div class="min-h-screen bg-gray-100 flex justify-center items-center">
        <div class="max-w-2xl pt-20 px-4">
            <div class="bg-white rounded-lg shadow-lg p-4">
            <div class="text-center">
                <svg class="w-16 h-16 text-green-500 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M18.15,3.74a1,1,0,0,0-1.41,0L8.5,11.09,3.27,6.39a1,1,0,1,0-1.2,1.6l5,3.86a1,1,0,0,0,1.19,0L18.15,5.15A1,1,0,0,0,18.15,3.74Z"/>
                </svg>
                <h1 class="text-2xl font-bold text-gray-700 mb-2">Pembayaran Berhasil!</h1>
                <p class="text-gray-600 mb-4">Terima kasih telah melakukan pembayaran. Transaksi Anda telah berhasil diproses.</p>
                <div class="mt-4">
                <a href="home.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Lihat Detail Pembayaran</a>
                </div>
            </div>
            </div>
        </div>
        </div>

    </section>
</body>
</html>