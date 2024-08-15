<?php

require('./../config.php');

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo === 'PUT') {
    parse_str(file_get_contents("php://input"), $put);

    $idpessoa = filter_var($put['idpessoa'] ?? null, FILTER_VALIDATE_INT);
    $idtelefone = filter_var($put['idtelefone'] ?? null, FILTER_VALIDATE_INT);
    $ddi = filter_var($put['ddi'] ?? null, FILTER_SANITIZE_SPECIAL_CHARS);
    $ddd = filter_var($put['ddd'] ?? null, FILTER_SANITIZE_SPECIAL_CHARS);
    $telefone = filter_var($put['telefone'] ?? null, FILTER_SANITIZE_SPECIAL_CHARS);

    if ($idpessoa && $idtelefone && $ddi && $ddd && $telefone) {
        $sql = $pdo->prepare("SELECT * FROM telefone WHERE idpessoa = :idpessoa");
        $sql->bindValue(":idpessoa", $idpessoa);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $sql = $pdo->prepare("UPDATE telefone SET ddi = :ddi, ddd = :ddd, telefone = :telefone WHERE idpessoa = :idpessoa and idtelefone =:idtelefone");

            $sql->bindValue(':idpessoa', $idpessoa);
            $sql->bindValue(':idtelefone', $idtelefone);
            $sql->bindValue(':ddi', $ddi);
            $sql->bindValue(':ddd', $ddd);
            $sql->bindValue(':telefone', $telefone);
            $sql->execute();

            $array['result']= [
                "idpessoa" => $idpessoa,
                "idtelefone" => $idtelefone,
                "ddi" => $ddi,
                "ddd" => $ddd,
                "telefone"=>$telefone
            ];
           
        } else {
            $array['error'] = 'Erro: ID inexistente!';
        }
    } elseif ($idpessoa ) {
        
        $sql = $pdo->prepare("SELECT * FROM telefone WHERE idpessoa = :idpessoa");
        $sql->bindValue(":idpessoa", $idpessoa);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            if ($ddi && $ddd && $telefone) {
                $sql = $pdo->prepare("UPDATE telefone SET ddi = :ddi, ddd = :ddd, telefone = :telefone WHERE idpessoa = :idpessoa and idtelefone =:idtelefone");
                $sql->bindValue(':idpessoa', $idpessoa);
                $sql->bindValue(':idtelefone', $idtelefone);
                $sql->bindValue(':ddi', $ddi);
                $sql->bindValue(':ddd', $ddd);
                $sql->bindValue(':telefone', $telefone);
                $sql->execute();
                
                $array = [
                    "idpessoa" => $idpessoa,
                    "idtelefone" => $idtelefone,
                    "ddi" => $ddi,
                    "ddd" => $ddd,
                    "telefone"=>$telefone
                ];
    
                
            } elseif ($ddi) {
                $sql = $pdo->prepare("UPDATE telefone SET ddi = :ddi WHERE idpessoa = :idpessoa and idtelefone =:idtelefone");
                $sql->bindValue(':idpessoa', $idpessoa);
                $sql->bindValue(':idtelefone', $idtelefone);
                $sql->bindValue(':ddi', $ddi);
                $sql->execute();
                
                $array = [
                    "idpessoa" => $idpessoa,
                    "idtelefone" => $idtelefone,
                    "ddi" => $ddi
                ];
                
            } elseif ($ddd) {
                $sql = $pdo->prepare("UPDATE telefone SET ddd = :ddd WHERE idpessoa = :idpessoa and idtelefone =:idtelefone");
                $sql->bindValue(':idpessoa', $idpessoa);
                $sql->bindValue(':idtelefone', $idtelefone);
                $sql->bindValue(':ddd', $ddd);
                $sql->execute();
                
                $array = [
                    "idpessoa" => $idpessoa,
                    "idtelefone" => $idtelefone,
                    "ddd" => $ddd
                ];
            } elseif ($telefone) {
                $sql = $pdo->prepare("UPDATE telefone SET telefone = :telefone WHERE idpessoa = :idpessoa and idtelefone =:idtelefone");
                $sql->bindValue(':idpessoa', $idpessoa);
                $sql->bindValue(':idtelefone', $idtelefone);
                $sql->bindValue(':telefone', $telefone);
                $sql->execute();
                
                $array = [
                    "idpessoa" => $idpessoa,
                    "idtelefone" => $idtelefone,
                    "telefone" => $telefone
                ];
            } else {
                $array['error'] = 'Erro: Nenhum parâmetro passado para atualizar!';
            }
        } else {
            $array['error'] = 'Erro: ID inexistente!';
        }
    } else {
        $array['error'] = 'Erro: Parâmetros nulos ou inválidos!';
    }
} else {
    $array['error'] = 'Erro: Método inválido - Apenas PUT é permitido.';
}

require('./../return.php');

?>