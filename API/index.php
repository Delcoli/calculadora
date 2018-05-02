<?php
require_once("vendor/autoload.php");

$requisicao = $_SERVER['REQUEST_URI'];
$metodo = $_SERVER['REQUEST_METHOD'];

$requisicao = strtolower($requisicao);
$metodo = strtolower($metodo);

$requisicao = explode("/", $requisicao);

if (!isset($requisicao[2]) || !isset($requisicao[3])) {
    header("HTTP/1.0 404");
    echo 'Não encontrado';
    return false;
}

try {
    if ($requisicao[2] == 'usuario') {
        $usuarioController = \Util\ClasseFactory::getUsuarioController();
        $usuarioController->processar($requisicao, $_POST, $metodo);
    } elseif ($requisicao[2] == 'calculadora' && $requisicao[3] == 'calcular' && isset($_POST['expressao']) && isset($_POST['email'])) {
        $usuarioDao = \Util\ClasseFactory::getUsuarioDao();
        $usuario = $usuarioDao->retornaUsuarioEmail($_POST['email']);

        if ($usuario == false) {
            header("HTTP/1.0 403");
            echo 'Usuário sem permissão';
            return false;
        }

        $calculadora = \Util\ClasseFactory::getCalculadora();
        $resultado = $calculadora->resultadoExpressao($_POST['expressao']);

        $operacao = new \Model\Classe\Operacao();
        $operacao->setData(date('Y/m/d'));
        $operacao->setOperacao($_POST['expressao']);
        $operacao->setResultado($resultado);
        $operacao->setUsuario($usuario);

        $operacaoController = \Util\ClasseFactory::getOperacaoController();
        $operacaoController->gravar($operacao);

        echo $resultado;
    } elseif ($requisicao[2] == 'relatorio' && $requisicao[3] == 'lista') {
        $operacaoController = \Util\ClasseFactory::getOperacaoController();
        echo $operacaoController->relatorio($_POST);
    } else {
        header("HTTP/1.0 404");
        echo 'Não encontrado';
    }

} catch
(\Exception $e) {
    $codigo = $e->getCode();
    header("HTTP/1.0 $codigo");
    echo $e->getMessage();
}

