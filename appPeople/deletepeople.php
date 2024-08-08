<?php

require('./../config.php');

$metodo=strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo ==='DELETE'){

    parse_str(file_get_contents("php://input"),$delete);

    $idpessoa = $delete['idpessoa'] ?? null;

    $idpessoa = filter_var($idpessoa,FILTER_VALIDATE_INT);

    if ($idpessoa){
        $sql = $pdo->prepare("SELECT * FROM pessoa WHERE idpessoa=:idpessoa");
        $sql->bindValue(":idpessoa", $idpessoa);
        $sql->execute();

        if ($sql->rowCount()>0) { 
            $sql = $pdo->prepare("DELETE FROM telefone WHERE idpessoa = :idpessoa");
            $sql->bindValue(":idpessoa", $idpessoa);
            $sql->execute();

            $sql = $pdo->prepare("DELETE FROM pessoa WHERE idpessoa = :idpessoa");
            $sql->bindValue(":idpessoa", $idpessoa);
            $sql->execute();


            $array['result']='Item excluído com sucesso!';

        }else { 
            $array['error']='Erro: Id Inexistente!';
        } 

    }else { 
            $array['error']='Erro: Id nulo ou inválido!';
        
        }
    
}else{
    $array['error'] = 'Erro: Ação invalida - Método permitido apenas DELETE';
}   

require('./../return.php');


?>