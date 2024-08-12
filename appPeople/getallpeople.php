<?php

require('./../config.php');

$metodo=strtoupper($_SERVER['REQUEST_METHOD']);

if ($metodo==='GET') {
    //selecionar tudo da tabela lembrete
    $sql=$pdo->query("SELECT * FROM pessoa");

    // se o número de linhas do sql for maior que 0, vai executar
    if ($sql->rowCount()>0) {

        // pegando tudo do sql e colocando na variável dados
        //fetch_assoc: ler o array de forma associativa (CHAVE=VALOR)
        $dados=$sql->fetchAll(PDO::FETCH_ASSOC);

        var_dump($dados);

    }
    //se o número de linhas não for maior que zero, mostrar mensagem de erro
    else{ 
        $array['error'] = 'Erro: Não há pessoas cadastradas';
    }
} else { 
    $array['error'] = 'Erro: Ação inválida método permitido apenas GET';
}
require('./../return.php');