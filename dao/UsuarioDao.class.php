<?php 
    // PDO
    include_once 'ConexaoPDO.class.php';
        
    class UsuarioDao { 
        // atributo       
        private $conexao;

        // construtor da classe
        public function __construct() {
            $this->conexao = new ConexaoPDO();
        }

        /**
         * Summary:
         * Método que tem por objetivo cadastrar um novo usuario no banco de dados
         * @param $usuario: Objeto da classe Usuario a ser cadastrado
         * @param boolean: Retorna true se o usuario foi inserido com sucesso 
         * ou false caso contrário
         */
        public function cadastrarUsuario($usuario) {
            $retorno  = false;
            try {
                // query
                $query = "INSERT INTO usuario(nome, login, senha, foto) VALUES(:nome, :login, :senha, :foto)";
                // fields to bind
                $fields = array (
                 ':nome' => $usuario->get('nome'), 
                 ':login' => $usuario->get('login'), 
                 ':senha' => hash('sha256', $usuario->get('senha')),
                 ':foto' => $usuario->get('foto'));

                $this->conexao->connect();    
                $stmt = $this->conexao->prepareQuery($query, $fields);                
                $result = $this->conexao->executeQuery($stmt);
                if ($result > 0) {
                    $retorno  = true;
                }
                
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage());
            }
            return $retorno;
        }     
        
        /**
         * Summary: Método que tem por objetivo verificar se um determinado 
         * usuario existe com base no campo e valor passados por parâmetro
         * @param $field: campo
         * @param $value: valor
         * @return boolean: Retorna true se o objeto com o valor equivalente ao campo existe, false caso contrário
         */
        public function usuarioExiste($field, $value) {
            $arr = [];
            $retorno  = false;

            try {
                // query
                $query = "SELECT nome FROM usuario WHERE ".$field." = :".$field;
                // fields to bind
                $fields = array (':'.$field => $value);                

                $this->conexao->connect();    
                $stmt = $this->conexao->prepareQuery($query, $fields);                
                $arr = $this->conexao->executeQuerySelect($stmt);
                if (count($arr) > 0) {
                    $retorno  = true;
                }

            } catch (Exception $ex) {
                throw new Exception($ex->getMessage());
            }
            return $retorno;
        }        
        
        /**
         * Buscar um usuario por login e senha passados como parâmetro
         * @param $login: login a ser procurado
         * @param $senha: senha a ser procurado
         * @return array: Array Associativo contendo o usuario buscado ou uma array vazio caso contrário
         */
        public function buscarUsuarioLogin($login, $senha) {
            $query = "SELECT * FROM usuario WHERE login = :login AND senha = :senha";                       
            // fields to bind
            $fields = array(
                ':login' => $login, 
                ':senha' => hash('sha256', $senha)
            );
            // array return
            $arr = [];            
            try {
                $this->conexao->connect();                    
                $stmt = $this->conexao->prepareQuery($query, $fields);                                
                $arr = $this->conexao->executeQuerySelect($stmt);
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage());
            }
            return $arr;            
        }
    }

?>