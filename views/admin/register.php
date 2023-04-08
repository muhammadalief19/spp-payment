<?php 
session_start();
if(isset($_SESSION["login"])) {
    header("Location:index.php");
}

include_once "../../Controller/AdminController.php";

$AdminController = new AdminController;

$on = false;
$off = false;
$message = '';
if(isset($_POST["register"])) {
    $result = $AdminController->registrasiAdmin($_POST);

    if($result > 0) {
     $on = true;
    } else {
     $off = true;
     $message = $AdminController->getError();
    }

 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../dist/output.css">
</head>
<body class="w-full bg-gray-50 relative overflow-x-hidden">
    <?php if($on) : ?>
    <div class="w-full h-screen overflow-hidden flex justify-center items-center fixed bg-slate-200 bg-opacity-60 backdrop-blur-md z-50" id="myModal">
        <!-- Modal -->
        <div class="w-full z-10 inset-0 overflow-y-auto">
        <div class="w-full flex items-center justify-center min-h-screen p-4">
            <div class="bg-white w-1/4 rounded-lg shadow-lg p-6">
            <div class="mb-4">
                <h2 class="text-xl font-bold">SUCCESS</h2>
            </div>
            <div class="mb-4">
                <p>Registrasi berhasil</p>
            </div>
            <div class="text-right">
                <a href="login.php" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">
                Tutup Modal
                </a>
            </div>
            </div>
        </div>
        </div>
    </div>
    <?php endif ?>
    <div class="w-full py-10 flex justify-center items-center">
        <div class="lg:w-4/5 grid lg:grid-cols-2 grid-cols-1 grid-flow-row gap-10  rounded-[10px] overflow-x-hidden shadow-lg shadow-slate-400">
            <div class="w-full flex h-auto items-center">
                <img src="../../public/assets/illustration-register.svg" alt="" class="w-full">
            </div>
            <div class="w-full h-auto bg-gray-100 flex flex-col items-center justify-center gap-4 py-10">
                <p class="text-2xl text-blue-500 font-bold uppercase">Register</p>
                <form action="" method="post" class="w-3/4 flex flex-col gap-10" enctype="multipart/form-data">
                <!-- input nama -->
                <div class="relative w-full flex flex-col gap-2">
                    <input id="nama" name="nama" type="text"
                        class="w-full h-10 text-gray-900 placeholder-transparent border-b-4 border-gray-200 peer focus:outline-none focus:border-blue-600 bg-transparent" placeholder="nama" autocomplete="off"/>
                    <label for="nama"
                        class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400               peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Nama
                    </label>
                    <?php if(isset($message["nama"])) : ?>
                    <p class="text-xs italic text-red-700"><?= $message["nama"] ?></p>
                    <?php endif ?>
                </div>
                <!-- input email -->
                <div class="relative w-full flex flex-col gap-2">
                    <input id="email" name="email" type="email"
                        class="w-full h-10 text-gray-900 placeholder-transparent border-b-4 border-gray-200 peer focus:outline-none focus:border-blue-600 bg-transparent" placeholder="email" autocomplete="off"/>
                    <label for="email"
                        class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400               peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Email
                    </label>
                    <?php if(isset($message["email"])) : ?>
                    <p class="text-xs italic text-red-700"><?= $message["email"] ?></p>
                    <?php endif ?>
                </div>
                <!-- input password -->
                <div class="relative w-full">
                    <input id="password" name="password" type="password"
                        class="w-full h-10 text-gray-900 placeholder-transparent border-b-4 border-gray-200 peer focus:outline-none focus:border-blue-600 bg-transparent" placeholder="password" autocomplete="off"/>
                    <label for="password"
                        class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400               peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password
                    </label>
                </div>
                
                <input type="hidden" name="role" value="admin">

                <!-- input foto profile -->
                <div class="flex justify-center w-full flex-col gap-2">
                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-lg cursor-pointer border-blue-600 hover:border-blue-700 ">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg aria-hidden="true" class="w-10 h-10 mb-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <p class="mb-2 text-sm text-blue-600"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-blue-600">JPEG, PNG, JPG or WEBP (MAX. 2MB)</p>
                </div>
                <input id="dropzone-file" type="file" class="hidden" name="foto_profile"/>
                </label>
                <?php if(isset($message["image"])) : ?>
                    <p class="text-xs italic text-red-700"><?= $message["image"] ?></p>
                    <?php endif ?>
                </div> 

                <div class="w-full relative">
                    <p class="text-sm font-medium text-blue-600">Sudah Punya Akun ? <a href="login.php" class="hover:font-semibold">Login</a></p>
                </div>

                <button type="submit" name="register" class="w-full py-3 text-center bg-blue-700 rounded-full text-white font-semibold">
                    Register
                </button>
                </form>
            </div>
        </div>
    </div>
    <script src="../../public/js/script.js"></script>
</body>
</html>