<?php 
session_start();
if(isset($_SESSION["login"])) {
    header("Location: home.php");
}

require_once"../Controller/siswa/SiswaController.php";
$SiswaController = new SiswaController;

$msg = '';
if(isset($_POST["login"])) {
    $login = $SiswaController->loginSiswa($_POST);
    if($login > 0) {
        header("Location:home.php");
    } else {
        $msg = $SiswaController->getError();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../public/assets/icon-web.svg">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../dist/output.css">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="w-full bg-gray-50 relative">
    <?php if(isset($msg["login"])) : ?>
        <div class="w-full h-screen overflow-hidden flex justify-center items-center fixed bg-slate-200 bg-opacity-60 backdrop-blur-md z-50 <?= "block" ?>" id="myModal">
        <!-- Modal -->
        <div class="w-full z-10 inset-0 overflow-y-auto">
        <div class="w-full flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-1/4 rounded-lg shadow-lg p-6">
            <div class="mb-4">
                <h2 class="text-xl font-bold">Error</h2>
            </div>
            <div class="mb-4">
                <p><?= $msg["login"] ?></p>
            </div>
            <div class="text-right">
                <button class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded" onclick="closeModal()">
                Tutup Modal
                </button>
            </div>
            </div>
        </div>
        </div>
    </div>  
    <?php endif; ?>
    <div class="w-full h-screen flex justify-center items-center">
        <div class="lg:w-4/5 grid lg:grid-cols-2 grid-cols-1 grid-flow-row gap-10  rounded-[10px] overflow-x-hidden shadow-lg shadow-slate-400">
            <div class="w-full">
                <img src="../public/assets/illustration-login.svg" alt="" class="w-full">
            </div>
            <div class="w-full h-auto bg-gray-100 flex flex-col items-center justify-center gap-4">
                <p class="text-2xl text-green-500 font-bold uppercase">Login</p>
                <form action="" method="post" class="w-3/4 flex flex-col gap-10">
                <!-- input nisn -->
                <div class="relative w-full flex flex-col gap-2">
                    <input id="nisn" name="nisn" type="text"
                        class="w-full h-10 text-gray-900 placeholder-transparent border-b-4 border-gray-200 peer focus:outline-none focus:border-green-600 bg-transparent" placeholder="nisn" autocomplete="off"/>
                    <label for="nisn"
                        class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400               peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">NISN
                    </label>
                    <?php if(isset($msg["nisn"])) : ?>
                        <p class="text-xs italic text-red-700"><?= $msg["nisn"] ?></p>
                    <?php endif;?>
                </div>
                <!-- input password -->
                <div class="relative w-full flex flex-col gap-2">
                    <input id="password" name="password" type="password"
                        class="w-full h-10 text-gray-900 placeholder-transparent border-b-4 border-gray-200 peer focus:outline-none focus:border-green-600 bg-transparent" placeholder="password" autocomplete="off"/>
                    <label for="password"
                        class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400               peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password
                    </label>
                    <?php if(isset($msg["password"])) : ?>
                        <p class="text-xs italic text-red-700"><?= $msg["password"] ?></p>
                    <?php endif;?>
                </div>
                <button type="submit" name="login" class="w-full py-3 text-center bg-green-700 rounded-full text-white font-semibold">
                    Login
                </button>
                </form>
            </div>
        </div>
    </div>

    <script src="../public/js/siswa.js"></script>
</body>
</html>