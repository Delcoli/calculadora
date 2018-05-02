<?php

namespace Controller;

use Model\Classe\Usuario;
use Model\Dao\UsuarioDao;

class UsuarioController
{
    /**
     * @var UsuarioDao;
     */
    private $usuarioDao;
    private $post;
    private $metodo;
    private $requisicao;


    /**
     * UsuarioController constructor.
     * @param UsuarioDao $usuarioDao
     */
    public function __construct(UsuarioDao $usuarioDao)
    {
        $this->usuarioDao = $usuarioDao;
    }

    public function processar($requisicao, $post, $metodo)
    {
        $this->post = $post;
        $this->metodo = $metodo;
        $this->requisicao = $requisicao;

        if ($requisicao[3] == 'logar' && $metodo == 'post' && isset($post['email']) && isset($post['senha'])) {
            return $this->logar($post['email'], $post['senha']);
        } elseif ($requisicao[3] == 'salvar' && $metodo == 'post' && isset($post['email']) && isset($post['senha'])) {

            $usuario = $this->usuarioDao->retornaUsuarioEmail($post['email']);
            if ($usuario !== false) {
                throw new \Exception('Já existe um email cadastrado', 403);
            }

            if (isset($post['nome'])) {
                $nome = $post['nome'];
            } else {
                $nome = $post['email'];
            }
            $usuario = new Usuario();

            $usuario->setNome($nome);
            $usuario->setEmail($post['email']);
            $usuario->setSenha(md5($post['senha']));

            return $this->salvar($usuario);
        } elseif ($requisicao[3] == 'logado') {
            return $this->logado();
        } elseif ($requisicao[3] == 'logout') {
            return $this->logout();
        } else {
            throw new \Exception('Não encontrado', 404);
        }

        return $this;
    }

    public function salvar(Usuario $usuario)
    {
        $this->usuarioDao->gravar($usuario);
        return $this;
    }

    public function logar($email, $senha)
    {
        if (isset($_SESSION['usuario'])) {
            unset($_SESSION['usuario']);
        }

        $senha = md5($senha);
        $usuario = $this->usuarioDao->retornaUsuarioLogin($email, $senha);

        if ($usuario === false) {
            throw new \Exception('Email ou senha está incorreto ou usuário não está cadastrado', 403);
        }

        return $usuario;
    }

    public function logout()
    {
        if (isset($_SESSION['usuario'])) {
            unset($_SESSION['usuario']);
        }

        return $this;
    }

    public function logado()
    {
        if (!isset($_SESSION['usuario'])) {
            throw new \Exception('Usuário não está logado', 403);
        }

        return true;
    }
}