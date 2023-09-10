<?php

$select = function($pageL, $totalArticlesByPageO) use ($link, $user, $password, $cerrarConexiones) {
    try {
        $pdo = new PDO($link, $user, $password);

        $pageL = is_string($pageL) ? intval($pageL) : $pageL;
        $totalArticlesByPageO = $totalArticlesByPageO;
    
        // ---------------- Query para paginación
        $sql = "SELECT * FROM articulos LIMIT $totalArticlesByPageO OFFSET $pageL";
    
        $stm = $pdo->prepare($sql);
        $stm->execute();
    
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        // ---------------- Query para total de artículos
        $sql = "SELECT count(*) as totalArticles FROM articulos";
        $stm = $pdo->prepare($sql);
        $stm->execute();

        $totalArticles = $stm->fetchAll(PDO::FETCH_ASSOC);
    } 
    catch (PDOException $e) {
        $result = $e->getMessage();
    }
    finally {
        $cerrarConexiones($pdo, $stm);
    }

    return compact('result', 'totalArticles');
};

