<?php
    class Contato {
        private $idContato;
        private $nome;
        private $telefone;
        private $email;
        private $foto;

        public function __construct($pIdContato, $pNome, $pTelefone, $pEmail, $pFoto) {
            $this->idContato = $pIdContato;
            $this->nome = $pNome;
            $this->telefone = $pTelefone;
            $this->email = $pEmail;
            $this->foto = $pFoto;
        }

        // getters
        public function get($atributo) {
            switch ($atributo) {
                case "idContato":
                    return $this->idContato;
                break;

                case "nome":
                    return $this->nome;
                break;

                case "telefone":
                    return $this->telefone;
                break;

                case "email":
                    return $this->email;
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
                case "idContato":
                    return $this->idContato = $valor;
                break;

                case "nome":
                    return $this->nome = $valor;
                break;

                case "telefone":
                    return $this->telefone = $valor;
                break;

                case "email":
                    return $this->email = $valor;
                break;

                case "foto":
                    return $this->foto = $valor;
                break;

                default:
                    return "Atributo inválido";
            }
        }

        public function __toString() {
            return "<b> Id: </b>". $this->idContato."<br>".
                    "<b> Nome: </b>". $this->nome."<br>".
                    "<b> Login: </b>". $this->telefone."<br>".
                    "<b> Senha: </b>". $this->email."<br>".
                    "<b> Foto: </b>". $this->foto."<br>";
        }
    }
?>