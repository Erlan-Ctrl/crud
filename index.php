<?php
require_once __DIR__ . '/../conexao.php';

$stmt = $pdo->prepare('SELECT * FROM usuarios');
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
</head>
<body>

<h1>Cadastro</h1>
<form action="create.php" method="POST">
    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" required>
    
    <label for="username">Usuário:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" required>
    
    <button type="submit">Enviar</button>
</form>

<hr>

<h1>Usuários</h1>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Usuário</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['id']) ?></td>
                <td><?= htmlspecialchars($usuario['name']) ?></td>
                <td><?= htmlspecialchars($usuario['username']) ?></td>
                <td>
                    <form action="teste.php" method="GET">
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                    <button type="submit">Editar</button>
                    <style> 

                        button {
                            background-color: #3e613fff; 
                            color: white;
                            padding: 10px 20px;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                            margin-top: 5px;
                            
                        }

                        button:hover {
                            background-color: #375238ff; 
                        }

                    </style>
                    </form>

                    <form action="delete.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                    <button type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
