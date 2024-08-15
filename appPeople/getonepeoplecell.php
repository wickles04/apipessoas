<?php

require('./../config.php');

$metodo = strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo === 'GET') {
    $idpessoa = filter_input(INPUT_GET, 'idpessoa', FILTER_VALIDATE_INT);

    if ($idpessoa) {

        $sql = $pdo->prepare("SELECT * FROM pessoa 
                              LEFT JOIN telefone ON pessoa.idpessoa = telefone.idpessoa
                              WHERE pessoa.idpessoa = :idpessoa");
        $sql->bindValue(":idpessoa", $idpessoa);
        $sql->execute();

        if ($sql->rowCount() > 0) {

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
            $array['error'] = 'Erro: Id Inexistente!';
        }
    } else {
        $array['error'] = 'Erro: Número de id inválido!';
    }

} else { 
    $array['error'] = 'Erro: Ação inválida, método permitido apenas GET';
}

require('./../return.php');

?>
