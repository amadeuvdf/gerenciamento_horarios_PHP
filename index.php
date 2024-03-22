<?php?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Gerenciamento</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 20px 40px;
            margin: 20px;
            font-size: 18px;
            text-transform: uppercase;
            background-color: #0089e1;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tela de Gerenciamento</h1>
        <div class="buttons">
            <a href="./lista_agendamento.php" class="btn">Lista de Agendamentos</a>
            <a href="./controle.php" class="btn">Página de Controle</a>
            <a href="./form_envio.php" class="btn">Formulário para Agendamento</a>
        </div>
    </div>


</body>
</html>

