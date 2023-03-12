<?php
    class Usuario {
        private $idUsuario;
        private $contatos = array();
        private $nome;
        private $login;
        private $senha;
        private $foto;

        public function __construct($pIdUsuario, $pContatos, $pNome, $pLogin, $pSenha, $pFoto) {
            $this->idUsuario = $pIdUsuario;
            $this->contatos = $pContatos;
            $this->nome = $pNome;
            $this->login = $pLogin;
            $this->senha = $pSenha;
            $this->foto = $pFoto;
        }

        // getters
        public function get($atributo) {
            switch ($atributo) {
                case "idUsuario":
                    return $this->idUsuario;
                break;

                case "contatos":
                    return $this->contatos;
                break;

                case "nome":
                    return $this->nome;
                break;

                case "login":
                    return $this->login;
                break;

                case "senha":
                    return $this->senha;
                break;

                case "foto":
                    return $this->foto;
                break;

                default:
                    return "Atributo inválido";
            }
        }

        // setters
        public function set($atributo, $valor) {
            switch($atributo) {
                case "idUsuario":
                    return $this->idUsuario = $valor;
                break;

                case "contatos":
                    return $this->contatos = $valor;
                break;

                case "nome":
                    return $this->nome = $valor;
                break;

                case "login":
                    return $this->login = $valor;
                break;

                case "senha":
                    return $this->senha = $valor;
                break;

                case "foto":
                    return $this->foto = $valor;
                break;

                default:
                    return "Atributo inválido";
            }
        }

        public function __toString() {
            return "<b> Id: </b>". $this->idUsuario."<br>".
                    "<b> Nome: </b>". $this->nome."<br>".
                    "<b> Login: </b>". $this->login."<br>".
                    "<b> Senha: </b>". $this->senha."<br>".
                    "<b> Foto: </b>". $this->foto."<br>";
        }
    }
?>