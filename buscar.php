<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permite que el frontend consulte

$host = 'sql5.freesqldatabase.com';
$db   = 'sql5819398';
$user = 'sql5819398';
$pass = 'L3I8u26r1E';
$port = '3306';

try {
    $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $query = isset($_GET['q']) ? $_GET['q'] : '';

    if ($query) {
        // Busca coincidencias en NRO_DE_PARTE o REFERENCIAS
        $stmt = $pdo->prepare("SELECT * FROM repuestos WHERE nro_parte LIKE ? OR referencias LIKE ? LIMIT 1");
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($result ? $result : ["error" => "No encontrado"]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
}
?>
