<?php

$select = function($iniciar, $totalArticlesByPage) use ($link, $user, $password, $cerrarConexiones) {
    try {
        $pdo = new PDO($link, $user, $password);
    
        // ---------------- Query para paginación
        // $sql = "SELECT * FROM articulos LIMIT :totalArticlesByPage OFFSET $iniciar";
        
        // LIMIT acepta 2 parámetros y se puede omitir OFFSET
        $sql = "SELECT * FROM articulos LIMIT :iniciar, :totalArticlesByPage";
    
        $stm = $pdo->prepare($sql);

        // El método bindParam se usa para vincular datos que no sean tipo string
        $stm->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);
        $stm->bindParam(':totalArticlesByPage', $totalArticlesByPage, PDO::PARAM_INT);
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

