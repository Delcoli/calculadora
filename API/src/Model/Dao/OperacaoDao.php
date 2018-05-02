<?php

namespace Model\Dao;

use Model\Classe\Operacao;
Use PDO;
use Util\ClasseFactory;

class OperacaoDao
{
    /**
     * @var PDO
     */
    private $conexao;

    /**
     * OperacaoController constructor.
     * @param $conexao
     */
    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function gravar(Operacao $operacao)
    {
        if ($operacao->getIdOperacao() != null) {
            $sql = $this->conexao->prepare('UPDATE operacoes SET data = :data, operacao = :operacao, resultado = :resultado, idUsuario = :idUsuario WHERE idOperacao = :idOperacao');
            $sql->bindValue('idOperacao', $operacao->getIdOperacao());
        } else {
            $sql = $this->conexao->prepare('INSERT INTO operacoes (data,operacao,resultado,idUsuario) VALUES (:data,:operacao,:resultado,:idUsuario)');
        }

        $sql->bindValue('data', $operacao->getData());
        $sql->bindValue('operacao', $operacao->getOperacao());
        $sql->bindValue('resultado', $operacao->getResultado());
        $sql->bindValue('idUsuario', $operacao->getUsuario()->getIdUsuario());

        try {
            $sql->execute();
        } catch (\Exception $e) {
            throw new \Exception('Erro ao gravar dados do da operação', '403');
        }
    }

    public function retornaListaOperacao($dataInicial = null, $dataFinal = null)
    {
        $usuarioDao = ClasseFactory::getUsuarioDao();

        if ($dataInicial != null && $dataFinal != null) {
            $sql = $this->conexao->prepare('SELECT * FROM operacoes WHERE data >= :dataInicial AND data <= :dataFinal order by data desc');
            $sql->bindValue('dataInicial', $dataInicial);
            $sql->bindValue('dataFinal', $dataFinal);
        } else {
            $sql = $this->conexao->prepare('SELECT * FROM operacoes  order by data desc');
        }

        $sql->execute();

        $lista = [];
        while ($objeto = $sql->fetchObject(Operacao::class)) {
            $usuario = $usuarioDao->retornaUsuarioId($objeto->idUsuario);
            $objeto->setUsuario($usuario);
            $objeto->dataFormatada = date('d/m/Y', strtotime($objeto->getData()));
            $lista[] = $objeto;
        }

        return $lista;
    }
}