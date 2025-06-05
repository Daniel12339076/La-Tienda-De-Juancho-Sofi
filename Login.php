<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #000;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-box {
      border: 3px solid;
      border-image: linear-gradient(to right, #ff69b4, #ffff00) 1;
      padding: 2rem;
      border-radius: 1rem;
      background-color: #111;
      width: 100%;
      max-width: 400px;
    }
    .logo-space {
      height: 100px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 1rem;
    }
    .logo-space img {
      max-height: 80px;
    }
    label, .form-control, .btn {
      color: white;
    }
    .form-control {
      background-color: #222;
      border: 1px solid #555;
    }
  </style>
</head>
<body>
  <div class="login-box text-white">
    <div class="logo-space">
      <!-- Aquí puedes colocar el logo -->
      <img src="Image/Logo juancho.png" alt="Logo de la tienda" width="110" height="110">
    </div>
    <h3 class="text-center mb-4">Iniciar Sesión</h3>
    <form>
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de usuario</label>
        <input type="text" class="form-control" id="nombre" placeholder="Tu nombre">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" placeholder="Contraseña">
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-warning">Ingresar</button>
      </div>
    </form>
  </div>
</body>
</html>