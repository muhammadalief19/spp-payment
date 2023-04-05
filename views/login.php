<?php 
session_start();
if(isset($_SESSION["login"])) {
    header("Location:home.php");
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
</head>
<body class="w-full bg-gray-50">
    <div class="w-full h-screen flex justify-center items-center">
        <div class="lg:w-4/5 grid lg:grid-cols-2 grid-cols-1 grid-flow-row gap-10  rounded-[10px] overflow-x-hidden shadow-lg shadow-slate-400">
            <div class="w-full">
                <img src="../public/assets/illustration-login.svg" alt="" class="w-full">
            </div>
            <div class="w-full h-auto bg-gray-100 flex flex-col items-center justify-center gap-4">
                <p class="text-2xl text-green-500 font-bold uppercase">Login</p>
                <form action="" method="post" class="w-3/4 flex flex-col gap-10">
                <!-- input nisn -->
                <div class="relative w-full">
                    <input id="nisn" name="nisn" type="text"
                        class="w-full h-10 text-gray-900 placeholder-transparent border-b-4 border-gray-200 peer focus:outline-none focus:border-green-600 bg-transparent" placeholder="nisn" autocomplete="off"/>
                    <label for="nisn"
                        class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400               peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">NISN
                    </label>
                </div>
                <!-- input password -->
                <div class="relative w-full">
                    <input id="password" name="password" type="password"
                        class="w-full h-10 text-gray-900 placeholder-transparent border-b-4 border-gray-200 peer focus:outline-none focus:border-green-600 bg-transparent" placeholder="password" autocomplete="off"/>
                    <label for="password"
                        class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400               peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password
                    </label>
                </div>
                <button type="submit" class="w-full py-3 text-center bg-green-700 rounded-full text-white font-semibold">
                    Login
                </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>