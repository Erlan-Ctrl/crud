<?php

require_once __DIR__ . '/../conexao.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$sql = 'INSERT INTO usuarios (name, username, password) VALUES (:name, :username, :password)';

$stmt = $pdo->prepare($sql);

$_name = $_POST[ 'name'] ?? '';
$_username = $_POST[ 'username'] ?? ''; 
$_password = $_POST[ 'password'] ?? '';

$stmt->bindParam(':name', $_name);
$stmt->bindParam(':username', $_username);
$stmt->bindParam(':password', $_password);

$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo "Usuário inserido com sucesso!";
} else {
    echo "Nenhum usuário inserido (provavelmente já existe).";
}

}

?>