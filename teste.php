<?php
require_once __DIR__ . '/../conexao.php';

if (!isset($_GET['id'])) {
    echo "ID não fornecido.";
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE id = :id');
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "Usuário não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
</head>
<body>
    <h1>Editar Usuário</h1>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">

        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($usuario['name']) ?>" required>

        <label for="username">Usuário:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($usuario['username']) ?>" required>

        <label for="password">Senha (deixe em branco para não alterar):</label>
        <input type="password" id="password" name="password">

        <button type="submit">Atualizar</button>
    </form>
    
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

    <br>
    <form action="index.php">
    <button type="submit">Voltar</button>  

    </form>
</body>
</html>
