<?php

require('./../config.php');

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo === 'GET') {
    $sqlP = $pdo->query("SELECT * FROM pessoa");

    if ($sqlP->rowCount() > 0) {

        $sql = $pdo->query("SELECT pessoa.idpessoa, nome, endereco, idtelefone, ddi, ddd, telefone FROM pessoa LEFT JOIN telefone ON pessoa.idpessoa = telefone.idpessoa where idtelefone is not null ORDER BY pessoa.idpessoa ");


        $dados = $sql->fetchAll(PDO::FETCH_ASSOC);

        $arrayP = [];
        $idAtual = null;

        foreach ($dados as $linha) {

            if ($idAtual !== $linha['idpessoa']) {
                
                $idAtual = $linha['idpessoa'];

                $arrayP[] = [
                    'idpessoa' => $linha['idpessoa'],
                    'nome' => $linha['nome'],
                    'endereco' => $linha['endereco'],
                    'telefones' => []
                ];
            }

            if ($linha['idtelefone']) { 
                $arrayP[count($arrayP) - 1]['telefones'][] = [
                    'idtelefone' => $linha['idtelefone'],
                    'ddi' => $linha['ddi'],
                    'ddd' => $linha['ddd'],
                    'telefone' => $linha['telefone']
                ];
            }
        }

        $array['result'] = $arrayP;

    } else {
        $array['error'] = 'Erro: Não há pessoas cadastradas';
    }
} else {
    $array['error'] = 'Erro: Ação inválida, método permitido apenas GET';
}

require('./../return.php');
