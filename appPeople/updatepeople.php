<?php

require('./../config.php');

$metodo=strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo ==='PUT'){

    parse_str(file_get_contents("php://input"),$put);

    $idpessoa = $put['idpessoa'] ?? null;
    $nome = $put['nome'] ?? null;
    $endereco = $put['endereco'] ?? null;


    $idpessoa = filter_var($idpessoa,FILTER_VALIDATE_INT);
    $nome = filter_var($nome, FILTER_SANITIZE_SPECIAL_CHARS);
$endereco = filter_var($endereco, FILTER_SANITIZE_SPECIAL_CHARS);

    if ($idpessoa && $nome && $endereco){
        $sql = $pdo->prepare("SELECT * FROM pessoa WHERE idpessoa=:idpessoa");
        $sql->bindValue(":idpessoa", $idpessoa);
        $sql->execute();

        if ($sql->rowCount()>0) { 
            $sql = $pdo->prepare("UPDATE pessoa SET endereco = :endereco, nome = :nome WHERE idpessoa = :idpessoa");

            $sql->bindValue(':idpessoa', $idpessoa);
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':endereco', $endereco);
            $sql->execute();

            $array['result']=[
                "idpessoa" => $idpessoa,
                "nome" => $nome,
                "endereco" => $endereco
            ];
            //$array['result']='Item atualizado com sucesso!';

        }else { 
            $array['error'] = 'Erro: Id Inexistente!';
        }

    
    }else { 
        $array['error'] = 'Erro: parametro nulo ou inválido!';
    }  


}else{
    $array['error'] = 'Erro: Ação invalida - Método permitido apenas PUT';
}   

require('./../return.php');


?>