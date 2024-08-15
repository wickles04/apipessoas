<?php

require('./../config.php');

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo ==='POST'){
    $idpessoa = filter_input(INPUT_POST, 'idpessoa');
    $ddi = filter_input(INPUT_POST, 'ddi');
    $ddd = filter_input(INPUT_POST,'ddd');
    $telefone = filter_input(INPUT_POST,'telefone');

    if($ddi && $ddd && $idpessoa && $telefone){
        $sql = $pdo->prepare("SELECT * FROM pessoa WHERE idpessoa=:idpessoa");
        $sql->bindValue(":idpessoa", $idpessoa);
        $sql->execute();

        if ($sql->rowCount()>0) { 
            $sql=$pdo->prepare("INSERT INTO telefone (idpessoa,ddi, ddd, telefone) VALUES (:idpessoa,:ddi,:ddd,:telefone)");
            $sql->bindValue(':idpessoa', $idpessoa);
            $sql->bindValue(':ddi', $ddi);
            $sql->bindValue(':ddd', $ddd);
            $sql->bindValue(':telefone', $telefone);
            $sql->execute();

            $array['result']=[
                "idpessoa" => $idpessoa,
                "ddi" => $ddi,
                "ddd" => $ddd,
                "telefone" => $telefone
            ];
        }else { 
            $array['error'] = 'Erro: Id Inexistente!';
        }
    }else{
        $array['error'] = 'Erro: Valores nulos ou inválidos!';
    }

}else{
    $array['error'] = 'Erro: Ação invalida - Método permitido apenas POST';
}
require('./../return.php');


