<?php
// ---------------- Destruir las conexiones abiertas, los parámetros se deben pasar por referencia
$cerrarConexiones = function(&$pdo, &$stm) {
    $stm = null;
    $pdo = null;
};