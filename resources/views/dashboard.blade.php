<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Patentes</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: #f4f4f9;
    }
    .container {
      width: 90%;
      max-width: 1200px;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    input[type="text"] {
      width: 100%;
      padding: 10px;
      font-size: 18px;
      text-transform: uppercase;
      border: 2px solid #ccc;
      border-radius: 8px;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    th, td {
      padding: 12px;
      text-align: left;
    }
    th {
      background: #007bff;
      color: white;
    }
    td {
      border-bottom: 1px solid #ddd;
    }
    .tarifa {
      color: #888;
      font-size: 0.9em;
    }
    tr:hover {
      background: #f1f1f1;
    }
    @media (max-width: 600px) {
      th, td {
        display: block;
        width: 100%;
      }
      th {
        text-align: center;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Gestión de Patentes</h1>
    <input type="text" placeholder="Ingrese la patente (3 a 8 caracteres)" maxlength="8">
    <table>
      <thead>
        <tr>
          <th>Patente</th>
          <th>Ingreso</th>
          <th>Salida</th>
          <th>Tipo</th>
          <th>Tarifa</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>ABC1234</td>
          <td>08:00</td>
          <td>17:00</td>
          <td>Auto</td>
          <td class="tarifa">$100</td>
        </tr>
        <tr>
          <td>XYZ5678</td>
          <td>09:15</td>
          <td>18:30</td>
          <td>Camioneta</td>
          <td class="tarifa">$150</td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
