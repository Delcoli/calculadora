<?php

namespace Util;


class Config
{
    public static function config($configuracao = null) {
        $config = include './config/config.php';
        if ($configuracao == null) {
            return $config;
        }
        return $config[$configuracao];
    }
}