<?php
    
require_once __DIR__ . '/../conexao.php';


$sql = 'SELECT * FROM usuarios';

$stmt = $pdo->prepare($sql);
$result = $stmt->execute();

if ($result) {
    $data = $stmt->fetchAll(PDO:: FETCH_ASSOC);

    echo '<h1> Registros encontrados: ' . $stmt->rowCount() . '</h1>';
    
    
    foreach ($data as $linha) {
    echo '<h1>' . $linha['username'] . '</h1>';  
    echo '<pre>';
    var_dump($linha);
    echo '</pre>';
    echo '<hr>';
    }
}

?>
