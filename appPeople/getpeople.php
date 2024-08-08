<?php

require('./../config.php');

$metodo=strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo==='GET') {

    //filtrando se o parametro passado é um número inteiro, caso não seja, o valor "false" vai ser guardado na variável
    $idpessoa=filter_input(INPUT_GET, 'idpessoa', FILTER_VALIDATE_INT);

    if($idpessoa){

        // select * from lembrete where idlembrete=?
        $sql=$pdo->prepare("SELECT * FROM pessoa WHERE idpessoa=:idpessoa");
        $sql->bindValue(":idpessoa", $idpessoa);
        $sql->execute();

        if($sql->rowCount() > 0){
            //existe o id

            // pegando tudo do sql e colocando na variável dados
            //fetch_assoc: ler o array de forma associativa (CHAVE=VALOR)
            $dadoDaPessoa=$sql->fetch(PDO::FETCH_ASSOC);

            $array['result']=[
                // entrando na coluna especificada e colocando em uma variável
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