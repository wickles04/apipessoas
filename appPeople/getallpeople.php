<?php

require('./../config.php');

$metodo=strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo==='GET') {

    $sql=$pdo->query("SELECT * FROM pessoa");

    if ($sql->rowCount()>0) {

        $array['result']=$sql->fetchAll(PDO::FETCH_ASSOC);
    }
    else{ 
        $array['error'] = 'Erro: Não há pessoas cadastradas';
    }
} else { 
    $array['error'] = 'Erro: Ação inválida método permitido apenas GET';
}
require('./../return.php');