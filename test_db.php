<?php
// test_db.php - script de prueba para mostrar el error de conexión PDO
require __DIR__ . '/db.php';

try {
    $pdo = db();
    echo "Conexión OK. Versión de servidor: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
} catch (Exception $e) {
    // Mostrar error completo (útil para diagnóstico local)
    echo "ERROR: " . $e->getMessage();
}
