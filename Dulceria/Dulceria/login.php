
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dulcería Del Ángel</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #ff7fe8;
    }

    header {
      background-color: #fff698;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      text-align: center;
      position: relative;
    }

    .logo {
      position: absolute;
      top: 0px;
      left: 10px;
      height: 120px;
    }

    header h1 {
      margin: 0;
      color: #333;
    }

    nav {
      text-align: center;
      margin-top: 20px;
    }

    nav a {
      margin: 0 15px;
      text-decoration: none;
      color: #333;
      font-weight: 600;
    }

    .login-form {
      background-color: #fff;
      padding: 30px;
      width: 300px;
      margin: 50px auto;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .login-form h2 {
      text-align: center;
      color: #333;
    }

    .login-form input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: 1px solid #ddd;
    }

    .login-form button {
      width: 100%;
      padding: 10px;
      background-color: #e74c3c;
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }

    .login-form button:hover {
      background-color: #c0392b;
    }

    .carousel-container {
      max-width: 90%;
      margin: 40px auto;
      position: relative;
      overflow: hidden;
    }

    .carousel-slide {
      display: flex;
      transition: transform 0.5s ease-in-out;
      gap: 20px;
    }

    .carousel-slide img {
      width: 300px;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      background: white;
    }

    .carousel-buttons {
      position: absolute;
      top: 50%;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
      padding: 0 20px;
      box-sizing: border-box;
    }

    .carousel-buttons button {
      background-color: rgba(255, 255, 255, 0.7);
      border: none;
      border-radius: 50%;
      padding: 10px 15px;
      cursor: pointer;
      font-size: 20px;
      transition: background-color 0.3s;
    }

    .carousel-buttons button:hover {
      background-color: rgba(255, 255, 255, 1);
    }

    footer {
      text-align: center;
      padding: 20px;
      background-color: #333;
      color: white;
    }
  </style>
</head>
<body>

<header>
  <img src="imagenes/dulceria.logo.png" alt="Logo" class="logo">
  <h1>Dulcería Del Ángel</h1>
  <nav>
      <a href="inicionormal.html">Inicio</a>
      <a href="contacto.html">Contacto</a>
      <a href="productosnormal.php">Productos</a>
      <a href="registro.php">Registrarse</a>
  </nav>
</header>

<!-- Formulario de login -->
<div class="login-form">
  <h2>Iniciar Sesión</h2>
  <form action="clogin.php" method="POST">
    <input type="text" name="username" placeholder="Nombre de usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Entrar</button>
  </form>
</div>

<!-- Carrusel en cuadros -->
<div class="carousel-container">
  <div class="carousel-slide" id="carousel-slide">
    <img src="imagenes/bianchi.png" alt="Producto 1">
    <img src="imagenes/posh.png" alt="Producto 2">
    <img src="imagenes/waffer.png" alt="Producto 3">
    <img src="imagenes/bianchi.png" alt="Producto 4">
    <img src="imagenes/posh.png" alt="Producto 5">
    <img src="imagenes/bianchi.png" alt="Producto 6">
    <img src="imagenes/posh.png" alt="Producto 7">
    <img src="imagenes/waffer.png" alt="Producto 8">
    <img src="imagenes/bianchi.png" alt="Producto 9">
    <img src="imagenes/posh.png" alt="Producto 10">
    <img src="imagenes/waffer.png" alt="Producto 11">
    <img src="imagenes/bianchi.png" alt="Producto 12">
    <img src="imagenes/posh.png" alt="Producto 13">
  </div>
  <div class="carousel-buttons">
    <button id="prev">&#10094;</button>
    <button id="next">&#10095;</button>
  </div>
</div>

<footer>
  <p>&copy; 2025 Dulcería Del Ángel. Todos los derechos reservados.</p>
</footer>

<script>
  const slide = document.getElementById('carousel-slide');
  const images = slide.querySelectorAll('img');
  const totalSlides = images.length;
  const visibleCount = 6;
  let index = 0;

  function showSlide(i) {
    slide.style.transform = `translateX(-${i * (100 / visibleCount)}%)`;
  }

  document.getElementById('next').addEventListener('click', () => {
    index = (index < totalSlides - visibleCount) ? index + 1 : 0;
    showSlide(index);
  });

  document.getElementById('prev').addEventListener('click', () => {
    index = (index > 0) ? index - 1 : totalSlides - visibleCount;
    showSlide(index);
  });

  setInterval(() => {
    index = (index < totalSlides - visibleCount) ? index + 1 : 0;
    showSlide(index);
  }, 3000);
</script>

</body>
</html>
