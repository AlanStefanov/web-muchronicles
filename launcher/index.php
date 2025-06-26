<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>MU Chronicles</title>
  <style>
    html, body {
      margin: 0;
      height: 100%;
      background-color: #0b0b0b;
    }
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #ddd;
      font-size: 12px;
    }

    .container {
      display: flex;
      width: 800px;
      height: 90%;
      gap: 20px;
    }

    /* Columna izquierda */
    .left {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 60px 5px 5px;  /* padding-top para bajar el logo */
    }
    .left img {
      width: 80%;
      max-width: 180px;
      border: 1px solid #222;
      box-shadow: 0 0 10px #ff9900;
      border-radius: 3px;
    }
    /* Empuja Suscripciones abajo */
    .left .box {
      margin-top: auto;
    }

    /* Columna derecha */
    .right {
      flex: 1;
      display: flex;
      flex-direction: column;
      padding: 5px;
      justify-content: flex-start;
    }

    .menu {
      display: flex;
      justify-content: flex-end;
      gap: 6px;
      margin-bottom: 10px;
    }
    .menu a {
      background: linear-gradient(to bottom, #5e2e2e, #3d1d1d);
      border: 1px solid #800;
      padding: 5px 10px;
      color: #fff;
      font-weight: bold;
      font-size: 11px;
      text-decoration: none;
      border-radius: 4px;
      transition: background .3s, transform .2s;
    }
    .menu a:hover {
      background: #800;
      transform: scale(1.05);
    }

    .box {
      background: #111;
      padding: 10px;
      border: 1px solid #333;
      border-radius: 4px;
      width: 100%;
      box-sizing: border-box;
      margin-bottom: 10px;
    }
    .box h3 {
      margin: 0 0 6px;
      padding-bottom: 4px;
      border-bottom: 1px solid #800;
      font-size: 14px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .mas-link {
      background: #800;
      color: #fff;
      padding: 1px 4px;
      border-radius: 3px;
      font-size: 10px;
      text-decoration: none;
    }
    .box p {
      margin: 6px 0;
      line-height: 1.4;
    }
    .box ul {
      padding-left: 16px;
      margin: 6px 0;
    }
    .box ul li {
      margin: 2px 0;
    }
    .box a {
      color: #69f;
      text-decoration: none;
      margin: 4px 0;
      display: block;
    }
    .box a:hover {
      text-decoration: underline;
    }

    /* Asegura que Descargas quede alineado con Suscripciones */
    .right .box:last-child {
      margin-top: auto;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="left">
      <img src="https://muchronicles.ddns.net/templates/Atlans/img/logo.png" alt="MU Chronicles">

      <div class="box">
        <h3>Suscripciones</h3>
        <p>Comprar VIP dentro del juego:</p>
        <p><strong>Bronce:</strong> +10% EXP / DROP<br>
           <strong>Plata:</strong> +20% EXP / DROP<br>
           <strong>Oro:</strong> +30% EXP / DROP</p>
        <p>Duración: 30 días. Válido para todos los personajes.</p>
      </div>
    </div>

    <div class="right">
      <div class="menu">
        <a href="https://muchronicles.ddns.net/"    target="_blank">Inicio</a>
        <a href="https://muchronicles.ddns.net/donation" target="_blank">Donaciones</a>
        <a href="https://chat.whatsapp.com/EcjMiLMM24oEKL5Gog5Zgk" target="_blank">WhatsApp</a>
      </div>

      <div class="box">
        <h3>Sistema de Resets</h3>
        <p>Se borran todos los stats luego de cada reset.</p>
        <p>Las cuentas normales: <strong>2000</strong> puntos.</p>
        <p><strong>Bronce:</strong> 2500<br>
           <strong>Plata:</strong> 3000<br>
           <strong>Oro:</strong> 3500</p>
        <p>Repartir puntos:</p>
        <ul>
          <li>/f + puntos → Fuerza</li>
          <li>/a + puntos → Agilidad</li>
          <li>/v + puntos → Vitalidad</li>
          <li>/e + puntos → Energía</li>
        </ul>
        <p>Resetear: <strong>/reset</strong></p>
      </div>

      <div class="box">
        <h3>Descargas <a class="mas-link" href="https://muchronicles.ddns.net/downloads" target="_blank">Más</a></h3>
        <p>Las actualizaciones se mantienen automatizadas a través del launcher.</p>
      </div>
    </div>
  </div>

</body>
</html>
