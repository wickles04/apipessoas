<?php

require('./../config.php');

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo ==='POST'){
    $nome = filter_input(INPUT_POST, 'nome');
    $endereco = filter_input(INPUT_POST,'endereco');

    if($nome && $endereco){
        $sql=$pdo->prepare("INSERT INTO pessoa (nome, endereco) VALUES (:nome,:endereco)");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':endereco', $endereco);
        $sql->execute();

    }else{
        $array['error'] = 'Erro: Valores nulos ou inválidos!';
    }

}else{
    $array['error'] = 'Erro: Ação invalida - Método permitido apenas POST';
}
require('./../return.php');








?>