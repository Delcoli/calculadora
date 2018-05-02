<?php

use Controller\CalculadoraController;
use PHPUnit\Framework\TestCase;

class CalculadoraControllerTest extends TestCase
{

    private $calculadoraController;

    public function setUp()
    {
        $this->calculadoraController = \Util\ClasseFactory::getCalculadora();
    }

    public function testRaizQuadrada()
    {
        $this->assertEquals(sqrt(2), $this->calculadoraController->valorRaiz(2));
        $this->assertEquals(sqrt(3), $this->calculadoraController->valorRaiz(3));
        $this->assertEquals(sqrt(30), $this->calculadoraController->valorRaiz(30));
    }

    public function testPrepararExpressao()
    {
        $this->assertEquals(true, is_array($this->calculadoraController->prepararExpressao('1+1+1')));
        $this->assertEquals(true, is_array($this->calculadoraController->prepararExpressao('1+1+1+20+(20-10)')));
        $this->assertEquals(true, is_array($this->calculadoraController->prepararExpressao('30*30+10%')));
    }

    public function testRemoverParenteses()
    {

        $expressao1 = $this->calculadoraController->prepararExpressao('1+1+1');
        $expressao2 = $this->calculadoraController->prepararExpressao('1+1+1+20+(20-10)');
        $expressao3 = $this->calculadoraController->prepararExpressao('30*30+10%+(10+(20+10))');

        $this->assertEquals(true, is_array($this->calculadoraController->removerParenteses($expressao1)));
        $this->assertEquals(true, is_array($this->calculadoraController->removerParenteses($expressao2)));
        $this->assertEquals(true, is_array($this->calculadoraController->removerParenteses($expressao3)));
    }

    public function testExecuta() {
        $this->assertEquals(10, $this->calculadoraController->executa('5','5','+'));
        $this->assertEquals(30, $this->calculadoraController->executa('50','20','-'));
        $this->assertEquals(100, $this->calculadoraController->executa('10','10','*'));
        $this->assertEquals(35, $this->calculadoraController->executa('70','2','/'));
    }

    public function testResultadoExpressao() {
        $this->assertEquals(90.0125, $this->calculadoraController->resultadoExpressao("(10+10)+10+(60+15/(100*(2+10)))"));
        $this->assertEquals(105.00041666666667, $this->calculadoraController->resultadoExpressao("(10+10)+10+(60+15+(10/20)/(100*(2+10)))"));
        $this->assertEquals( 105.00041666666667, $this->calculadoraController->resultadoExpressao("(10+10)+10+(60+15+(10/20)/(100*(2+10)))"));
        $this->assertEquals(0.05, $this->calculadoraController->resultadoExpressao('10/200'));
    }
}
