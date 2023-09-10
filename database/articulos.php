<?php

$select = function($pageL, $totalArticlesByPageO) use ($link, $user, $password, $cerrarConexiones) {
    try {
        $pdo = new PDO($link, $user, $password);
    
        // ---------------- Query para paginación
        $sql = "SELECT * FROM articulos LIMIT $totalArticlesByPageO OFFSET $pageL";
        // LIMIT acepta 2 parámetros y se puede omitir OFFSET
        // $sql = "SELECT * FROM articulos LIMIT $pageL, $totalArticlesByPageO";
    
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

