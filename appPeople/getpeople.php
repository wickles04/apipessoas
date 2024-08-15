<?php

require('./../config.php');

$metodo=strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo==='GET') {

    $idpessoa=filter_input(INPUT_GET, 'idpessoa', FILTER_VALIDATE_INT);

    if($idpessoa){

        $sql=$pdo->prepare("SELECT * FROM pessoa WHERE idpessoa=:idpessoa");
        $sql->bindValue(":idpessoa", $idpessoa);
        $sql->execute();

        if($sql->rowCount() > 0){


            $array['result']=[
                'idpessoa'=> $dadoDaPessoa['idpessoa'],
                'nome'=> $dadoDaPessoa['nome'],
                'endereco'=> $dadoDaPessoa['endereco']
            ];
 
        }
        else{
            $array['error'] = 'Errro: Id Inexistente!';
        }
    }
    else{
        $array['error'] = 'Erro: Número de id inválido!';
    }

} else { 
    $array['error'] = 'Erro: Ação inválida método permitido apenas get';
}
require('./../return.php');


?>