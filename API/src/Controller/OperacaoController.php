<?php

namespace Controller;

use Model\Classe\Operacao;
use Model\Dao\OperacaoDao;

class OperacaoController
{
    /**
     * @var OperacaoDao;
     */
    private $operacaoDao;

    /**
     * OperacaoController constructor.
     * @param OperacaoDao $operacaoDao
     */
    public function __construct(OperacaoDao $operacaoDao)
    {
        $this->operacaoDao = $operacaoDao;
    }

    public function gravar(Operacao $operacao)
    {
        $this->operacaoDao->gravar($operacao);
        return $this;
    }

    public function relatorio($post) {
        $dataInicial = $post['dataInicial'] ?? null;
        $dataFinal = $post['dataFinal'] ?? null;

        $dados = $this->operacaoDao->retornaListaOperacao($dataInicial,$dataFinal);
        $dados = json_encode($dados);
        return $dados;
    }

}