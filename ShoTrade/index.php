<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>C2C Marketplace</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
  function toggleModal(id) {
    const modal = document.getElementById(id);
    modal.classList.toggle('hidden');}
</script>
<link rel = "Stylesheets" src = "css/styles.css">
</head>

<body class = "min-h-screen bg-gray-50 text-gray-800 flex flex-col">
  <header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto p-4 flex justify-between items-center">
      <div>
          <img src = "/ShoTrade/assets/images/Sho'Trade Icon.png" class = "w-16 h-16 float-left">
          <span class="text-xl font-bold text-yellow-600 float-right">Sho'Trade</span>
    </div>
      <nav class="space-x-4">
        <a href="#features" class="hover:text-blue-600">Features</a>
        <button onclick="toggleModal('loginModal')" class="hover:text-blue-600">Login</button>
        <button onclick="toggleModal('registerModal')" class="hover:text-blue-600">Register</button>
      </nav>
    </div>
  </header>

  <section class="text-center py-20 bg-gradient-to-r from-blue-600 to-yellow-500 text-white">
    <h2 class="text-4xl font-bold mb-4">Buy, Sell, Deliver — Safely</h2>
    <p class="text-xl mb-8">A secure peer-to-peer marketplace with verified delivery by drivers</p>
    <a onclick="toggleModal('registerModal')" class="bg-white text-blue-600 px-6 py-2 rounded-full font-semibold">Get Started</a>
  </section>

  <section id="features" class="max-w-6xl mx-auto py-16 grid md:grid-cols-3 gap-10 text-center">
    <div>
      <h3 class="text-xl font-semibold">List Products</h3>
      <p>Post your items for sale easily with photos and details.</p>
    </div>
    <div>
      <h3 class="text-xl font-semibold">Hire Drivers</h3>
      <p>Let verified drivers deliver your goods and prevent scams.</p>
    </div>
    <div>
      <h3 class="text-xl font-semibold">Rate & Review</h3>
      <p>Leave feedback after transactions to build trust.</p>
    </div>
  </section>

  <footer class="bg-gray-100 text-center p-4">
    &copy; 2025 Sho'Trade © All rights reserved.
  </footer>


<div id="loginModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
  <div class="bg-white p-6 rounded-lg w-96 shadow-lg relative">
    <button onclick="toggleModal('loginModal')" class="absolute top-2 right-3 text-gray-400">&times;</button>
    <h2 class="text-xl font-bold mb-4">Login</h2>
  <form action = "login.php" method = "POST">
    <input type="email" name="email" placeholder="Email" class="w-full mb-3 p-2 border rounded" required>
    <input type="password" name="password" placeholder="Password" class="w-full mb-3 p-2 border rounded" required>
    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
  </form>
  </div>
</div>

<div id="registerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
  <div class="bg-white p-6 rounded-lg w-96 shadow-lg relative">
    <button onclick="toggleModal('registerModal')" class="absolute top-2 right-3 text-gray-400">&times;</button>
    <h2 class="text-xl font-bold mb-4">Register</h2>
  <form action = "register.php" method = "POST">
      <select name = "role" class="w-full mb-3 p-2 border rounded" required>
          <option value="">Select role</option>
          <option value="user">User</option>
          <option value="driver">Driver</option>
      </select>
        <input type="text" name="name" placeholder="Name" class="w-full mb-3 p-2 border rounded" required>
        <input type="text" name="surname" placeholder="Surname" class="w-full mb-3 p-2 border rounded" required>
        <input type="address" name="address" placeholder="Address" class="w-full mb-3 p-2 border rounded" required>
        <input type="email" name="email" placeholder="Email" class="w-full mb-3 p-2 border rounded" required>
        <input type="password" name="password" placeholder="Password" class="w-full mb-3 p-2 border rounded" required>
        <button type="submit" class="w-full bg-yellow-400 text-white py-2 rounded hover:bg-yellow-700">Register</button>
  </form>

  </div>
</div>

</body>
</html>
