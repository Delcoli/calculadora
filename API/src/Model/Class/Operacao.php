<?php

namespace Model\Classe;

class Operacao
{
    public $idOperacao;
    public $data;
    public $operacao;
    public $resultado;
    public $usuario;

    /**
     * @return mixed
     */
    public function getIdOperacao()
    {
        return $this->idOperacao;
    }

    /**
     * @param mixed $idOperacao
     */
    public function setIdOperacao($idOperacao)
    {
        $this->idOperacao = $idOperacao;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getOperacao()
    {
        return $this->operacao;
    }

    /**
     * @param mixed $operacao
     */
    public function setOperacao($operacao)
    {
        $this->operacao = $operacao;
    }

    /**
     * @return mixed
     */
    public function getResultado()
    {
        return $this->resultado;
    }

    /**
     * @param mixed $resultado
     */
    public function setResultado($resultado)
    {
        $this->resultado = $resultado;
    }

    /**
     * @return \Model\Classe\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
}