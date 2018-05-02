<?php

namespace Util;

class BancoDados
{
    private static $conexao = null;

    /**
     * @return null
     */
    public static function getConexao()
    {
        if (self::$conexao == null) {
            $config = Config::config('bancoDados');
            $dadosConexao = $config['driver'] . ':' . 'host='.$config['host'] . ';dbname=' . $config['dbname'];
            $charset = [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $config['charset']];

            self::$conexao = new \PDO($dadosConexao, $config['user'], $config['password'], $charset);
            self::$conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$conexao->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_EMPTY_STRING);
        }

        return self::$conexao;
    }

    public static function deletarConexao()
    {
        if (self::$conexao != null) {
            unset(self::$conexao);
        }
    }
}