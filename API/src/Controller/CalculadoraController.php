<?php

namespace Controller;


class CalculadoraController
{
    private $operadores;

    public function __construct($operadores)
    {
        $this->operadores = $operadores;
    }

    public function prepararExpressao($expressao)
    {
        foreach ($this->operadores as $operador) {
            $expressao = str_replace($operador, '#' . $operador . '#', $expressao);
        }

        $expressao = str_replace('##', '#', $expressao);

        if (substr($expressao, 0, 1) == "#") {
            $expressao = substr($expressao, 1, strlen($expressao));
        }

        if (substr($expressao, strlen($expressao) - 1, strlen($expressao)) == "#") {
            $expressao = substr($expressao, 0, strlen($expressao) - 1);
        }

        $retorno = explode('#', $expressao);
        return $retorno;
    }

    public function removerParenteses($expressao)
    {
        $parentAberto = array_search('(', $expressao);
        $parentFechado = array_search(')', $expressao);

        if ($parentAberto === false && $parentFechado === false) {
            return $expressao;
        }

        $retorno = [];
        $calcular = [];
        $parentAberto = false;
        $parentFechado = false;

        foreach ($expressao as $chave => $valor) {
            $retorno[$chave] = $valor;

            if ($valor == "(") {
                $parentAberto = $chave;
            } elseif ($valor == ")") {
                $parentFechado = $chave;
            }

            if ($parentAberto !== false && $parentFechado !== false) {
                while ($parentAberto <= $parentFechado) {
                    if (isset($retorno[$parentAberto])) {
                        $calcular[] = $retorno[$parentAberto];
                        unset($retorno[$parentAberto]);
                    }
                    $parentAberto++;
                }

                array_shift($calcular);
                array_pop($calcular);

                $retorno[$parentFechado] = $this->resultado($calcular);

                $parentAberto = false;
                $parentFechado = false;
                $calcular = [];
            }
        }

        return $this->removerParenteses($retorno);
    }

    public function executa($valor1, $valor2, $operador)
    {
        if ($operador == '+') {
            return $valor1 + $valor2;
        } elseif ($operador == '-') {
            return $valor1 - $valor2;
        } elseif ($operador == '*') {
            return $valor1 * $valor2;
        } elseif ($operador == '/') {
            if ($valor2 == 0) {
                throw new \Exception('Divisão por zero', 403);
            }
            return $valor1 / $valor2;
        } else {
            throw new \Exception('Operação não definida', 403);
        }
    }

    public function calcular($expressao, $operador)
    {
        $primeiroElemento = array_shift($expressao);
        if (is_numeric($primeiroElemento)) {
            array_unshift($expressao, $primeiroElemento);
        } elseif ($primeiroElemento == '-' || $primeiroElemento == '+') {
            array_unshift($expressao, '0', $primeiroElemento);
        } else {
            throw new \Exception('Expressão incorreta');
        }

        $operac = null;
        $valor1 = null;
        $valor2 = null;

        $chaveOperac = null;
        $chaveValor1 = null;
        $chaveValor2 = null;

        $calculado = false;

        $retorno = [];

        foreach ($expressao as $chave => $valor) {

            if (!$calculado) {
                if (is_numeric($valor) && $valor1 === null) {
                    $valor1 = $valor;
                    $chaveValor1 = $chave;
                } elseif (is_numeric($valor) && $valor2 === null) {
                    $valor2 = $valor;
                    $chaveValor2 = $chave;
                } elseif ($valor == $operador) {
                    $operac = $valor;
                    $chaveOperac = $chave;
                } else {
                    $operac = null;
                    $valor1 = null;
                    $valor2 = null;
                }
            }

            $retorno[$chave] = $valor;

            if ($valor1 !== null && $valor2 !== null && $operac !== null) {
                unset($retorno[$chaveValor1]);
                unset($retorno[$chaveValor2]);
                unset($retorno[$chaveOperac]);

                $calculado = true;

                $retorno[$chave] = $this->executa($valor1, $valor2, $operac);
                $operac = null;
                $valor1 = null;
                $valor2 = null;

            }
        }

        if ($calculado) {
            return $this->calcular($retorno, $operador);
        }
        return $retorno;
    }

    public function valorRaiz($valor)
    {
        $retorno = 1;
        while ($retorno << 2 < $valor) {
            $retorno++;
        }

        for ($i = 0, $t = 14; $retorno != $valor && $i < $t; ++$i) {
            $retorno = 0.5 * ($retorno + $valor / $retorno);
        }

        return $retorno;
    }

    public function calcularRaizQuadrada($expressao)
    {
        $valor1 = null;
        $operac = null;
        $chaveValor1 = null;
        $chaveOperac = null;
        $retorno = [];

        foreach ($expressao as $chave => $valor) {
            if (is_numeric($valor)) {
                $valor1 = $valor;
                $chaveValor1 = $chave;
            } elseif ($valor == '@') {
                $operac = $valor;
                $chaveOperac = $chave;
                $valor1 = null;
                $chaveValor1 = null;
            }

            $retorno[$chave] = $valor;

            if ($valor1 !== null && $operac !== null) {
                unset($retorno[$chaveValor1]);
                unset($retorno[$chaveOperac]);

                $resultado = $this->valorRaiz($valor1);

                $retorno[$chave] = $resultado;
                $operac = null;
                $valor1 = null;

            }
        }

        return $retorno;
    }

    public function calcularPercentual($expressao)
    {
        $possuiPercentual = false;
        $posPercentual = null;
        $expressaoPercentual = [];
        $simPerc = null;
        $porcentagem = null;
        $operador = null;
        $base = null;

        foreach ($expressao as $chave => $valor) {
            $expressaoPercentual[$chave] = $valor;
            if ($valor == '%') {
                $expressao[$chave] = 'resultado';
                $possuiPercentual = true;
                break;
            }
        }
        $expressaoPercentual = array_reverse($expressaoPercentual, true);

        if (!$possuiPercentual) {
            return $expressao;
        }

        $count = 0;
        foreach ($expressaoPercentual as $chave => $valor) {
            $count++;
            if ($count == 1) {
                $simPerc = $valor;
            } elseif ($count == 2) {
                $porcentagem = $valor;
            } elseif ($count == 3) {
                $operador = $valor;
            } elseif ($count == 4) {
                $base = $valor;
            } else {
                break;
            }

            if ($count > 1) {
                unset($expressao[$chave]);
            }
        }

        if ($simPerc == null || $porcentagem == null || $operador == null || $base == null) {
            throw new \Exception('Expressão incorreta', 403);
        }

        $resultado = $base / 100 * $porcentagem;
        $resultado = $this->executa($base, $resultado, $operador);
        $chave = array_search('resultado', $expressao);
        $expressao[$chave] = $resultado;

        return $this->calcularPercentual($expressao);
    }

    public function resultado($expressao)
    {
        $expressao = $this->calcularRaizQuadrada($expressao);
        $expressao = $this->calcularPercentual($expressao);
        $expressao = $this->calcular($expressao, '/');
        $expressao = $this->calcular($expressao, '*');
        $expressao = $this->calcular($expressao, '-');
        $expressao = $this->calcular($expressao, '+');

        if (count($expressao) > 1) {
            throw new \Exception('Expressão incorreta', 403);
        }
        return isset($expressao[0]) ? $expressao[0] : 'Erro ao calcular';
    }

    public function resultadoExpressao($expressao)
    {
        $expressaoPreparada = $this->prepararExpressao($expressao);
        $expressaoPreparada = $this->removerParenteses($expressaoPreparada);
        $resultado = $this->resultado($expressaoPreparada);

        return $resultado;
    }

}