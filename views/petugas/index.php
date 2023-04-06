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
      <div class="p-4 flex flex-col gap-7">
        <div class="flex gap-5 h-auto items-center">
            <img src="../../public/assets/icon-web.svg" alt="" class="w-1/4">
            <h1 class="text-xl font-bold mb-4">SPP Management</h1>
        </div>
        <ul class="w-full flex flex-col gap-4">
          <li class="mb-4"><a href="#" class="hover:text-gray-300">Dashboard</a></li>
          <li class="mb-4"><a href="#" class="hover:text-gray-300">Siswa</a></li>
          <li class="mb-4"><a href="#" class="hover:text-gray-300">Pembayaran</a></li>
          <li class="mb-4"><a href="#" class="hover:text-gray-300">Laporan</a></li>
        </ul>
      </div>
    </div>

    <!-- Main Content -->
    <div class="pl-64 w-full flex-col">
    <div class="p-4 w-full h-screen">
      <h1 class="text-2xl font-bold mb-4">Selamat datang di halaman admin</h1>
      <p>Silakan pilih menu di sebelah kiri untuk mengakses fitur-fitur admin lainnya.</p>
    </div>
    <div class="p-4 w-full h-screen">
      <h1 class="text-2xl font-bold mb-4">Selamat datang di halaman admin</h1>
      <p>Silakan pilih menu di sebelah kiri untuk mengakses fitur-fitur admin lainnya.</p>
    </div>
    <div class="p-4 w-full h-screen">
      <h1 class="text-2xl font-bold mb-4">Selamat datang di halaman admin</h1>
      <p>Silakan pilih menu di sebelah kiri untuk mengakses fitur-fitur admin lainnya.</p>
    </div>
    <div class="p-4 w-full h-screen">
      <h1 class="text-2xl font-bold mb-4">Selamat datang di halaman admin</h1>
      <p>Silakan pilih menu di sebelah kiri untuk mengakses fitur-fitur admin lainnya.</p>
    </div>
    <div class="p-4 w-full h-screen">
      <h1 class="text-2xl font-bold mb-4">Selamat datang di halaman admin</h1>
      <p>Silakan pilih menu di sebelah kiri untuk mengakses fitur-fitur admin lainnya.</p>
    </div>
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
