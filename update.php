<?php 
require_once __DIR__ . '/../conexao.php';

if (!isset($_POST['id'], $_POST['name'], $_POST['username'])) {
    echo "Dados incompletos.";
    exit;
}

$id = $_POST['id'];
$novoNome = $_POST['name'];
$novoUsername = $_POST['username'];
$novaSenha = $_POST['password'] ?? '';

if (!empty($novaSenha)) {
    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
    $sql = 'UPDATE usuarios SET name = :name, username = :username, password = :password WHERE id = :id';
} else {
    $sql = 'UPDATE usuarios SET name = :name, username = :username WHERE id = :id';
}

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':name', $novoNome);
$stmt->bindParam(':username', $novoUsername);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if (!empty($novaSenha)) {
    $stmt->bindParam(':password', $senhaHash);
}

$queryExecute = $stmt->execute();

if ($queryExecute) {
    header('Location: index.php');
    exit;
} else {
    echo "Erro ao atualizar.";
}
