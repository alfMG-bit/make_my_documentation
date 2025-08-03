<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - MMD</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
  @vite(["resources/css/app.css","resources/js/app.js"])
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800">
  <div class="flex flex-col h-screen overflow-hidden">

    <!-- Topbar -->
    <header class="flex items-center justify-between p-4 shadow-md bg-white">
      <button id="openDrawer" class="mr-4 cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <nav class="hidden md:flex gap-8 font-medium mx-auto">
        <a href="#" class="hover:underline">Home</a>
        <a href="#" class="hover:underline">About</a>
        <img src="{{ asset('images/icon.png') }}" alt="Logo" class="h-8">
        <a href="#" class="hover:underline">Documentation</a>
        <a href="#" class="hover:underline">FAQ</a>
      </nav>
    </header>

    <!-- HERE MUST BE COMPONENTS -->
    {{ $slot }}
</body>
</html>
