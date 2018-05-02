<?php

namespace Model\Dao;

use Model\Classe\Usuario;
Use PDO;

class UsuarioDao
{
    /**
     * @var PDO
     */
    private $conexao;

    /**
     * UsuarioController constructor.
     * @param $conexao
     */
    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    public function gravar(Usuario $usuario) {
        if ($usuario->getIdUsuario() != null) {
            $sql = $this->conexao->prepare('UPDATE usuario SET nome = :nome, email = :email, senha = :senha WHERE idUsuario = :idUsuario');
            $sql->bindValue('idUsuario',$usuario->getIdUsuario());
        } else {
            $sql = $this->conexao->prepare('INSERT INTO usuario (nome,email,senha) VALUES (:nome,:email,:senha)');
        }

        $sql->bindValue('nome',$usuario->getNome());
        $sql->bindValue('email',$usuario->getEmail());
        $sql->bindValue('senha',$usuario->getSenha());

        try {
            $sql->execute();
        } catch (\Exception $e) {
           throw new \Exception('Erro ao gravar dados do usuário','403');
        }
    }

    public function retornaUsuarioLogin($email,$senha) {
        $sql = $this->conexao->prepare('SELECT * FROM usuario WHERE email = :email AND senha = :senha');
        $sql->bindValue('email',$email);
        $sql->bindValue('senha',$senha);

        $sql->execute();
        return $sql->fetchObject(Usuario::class);
    }

    public function retornaUsuarioEmail($email) {
        $sql = $this->conexao->prepare('SELECT * FROM usuario WHERE email = :email');
        $sql->bindValue('email',$email);

        $sql->execute();
        return $sql->fetchObject(Usuario::class);
    }

    public function retornaUsuarioId($id) {
        $sql = $this->conexao->prepare('SELECT * FROM usuario WHERE idUsuario = :id');
        $sql->bindValue('id',$id);

        $sql->execute();
        return $sql->fetchObject(Usuario::class);
    }
}