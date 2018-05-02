<?php
/**
 * Created by PhpStorm.
 * User: emers
 * Date: 01/05/2018
 * Time: 13:00
 */

namespace Util;


use Controller\OperacaoController;
use Controller\UsuarioController;
use Model\Dao\OperacaoDao;
use Model\Dao\UsuarioDao;

class ClasseFactory
{
    private static $usuarioDao = null;
    private static $operacaoDao = null;
    private static $usuarioController = null;
    private static $operacaoController = null;
    private static $calculadora = null;

    public static function getUsuarioDao()
    {
        if (self::$usuarioDao == null) {
            $conexao = BancoDados::getConexao();
            self::$usuarioDao = new UsuarioDao($conexao);
        }
        /**
         * returns UsuarioDao;
         */
        return self::$usuarioDao;
    }

    public static function getUsuarioController()
    {
        if (self::$usuarioController == null) {
            $usuarioDao = self::getUsuarioDao();
            self::$usuarioController = new UsuarioController($usuarioDao);
        }

        /**
         * returns UsuarioController;
         */
        return self::$usuarioController;
    }

    /**
     * @return \Controller\CalculadoraController|null
     */
    public static function getCalculadora()
    {
        if (self::$calculadora == null) {
            $operadores = [
                '+' => '+',
                '-' => '-',
                '*' => '*',
                '/' => '/',
                '(' => '(',
                ')' => ')',
                '%' => '%',
                '@' => '@'
            ];

            self::$calculadora = new \Controller\CalculadoraController($operadores);
        }

        /**
         * returns CalculadoraController;
         */
        return self::$calculadora;
    }

    public static function getOperacaoDao()
    {
        if (self::$operacaoDao == null) {
            $conexao = BancoDados::getConexao();
            self::$operacaoDao = new OperacaoDao($conexao);
        }
        /**
         * returns UsuarioDao;
         */
        return self::$operacaoDao;
    }

    public static function getOperacaoController()
    {
        if (self::$operacaoController == null) {
            $operacaoDao = self::getOperacaoDao();
            self::$operacaoController = new OperacaoController($operacaoDao);
        }

        /**
         * returns OperacaoController;
         */
        return self::$operacaoController;
    }

}