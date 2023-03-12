<?php 
    include_once 'ConexaoPDO.class.php';
        
    class UsuarioDao {        
        private $conexao;

        public function __construct() {
            $this->conexao = new ConexaoPDO();
        }

        /**
         * Summary:
         * Método que tem por objetivo cadastrar um novo produto no banco de dados
         * @param $produto: Objeto da classe Produto a ser cadastrado
         * @param boolean: Retorna true se o produto foi inserido com sucesso 
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
         * Método que tem por objetivo deletar um produto com o id passado por parâmetro
         * @param $idProduto: Id do produto a ser deletado
         * @return boolean: Retorna true se o produto foi excluído com sucesso or false caso contrário. 
         * Variável $result guarda o número de linhas afetadas pela consulta
         */
        /*public function deletarProduto($idProduto) {
            $retorno = false;
            $query = "DELETE FROM produto WHERE idProduto = :idProduto";
            
            // fields to bind
            $fields = array (':idProduto' => $idProduto);

            try {
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
        }  */  
        
        /**
         * Método que tem por objetivo realizar a atualização de um produto.
         * @param $idProduto: Id do produto a ser atualizado
         * @param $fields: Array associativo contendo os campos e os novos valores a serem atualizados
         * Ex.: array('nome' => 'novoNome', 'categoria' => novaCategoria);
         * @return boolean: Retorna true se o produto pôde ser atualizado com sucesso e false caso contrário
         */
        /*public function atualizarProduto($idProduto, $fields) {
            $retorno = false;
            $query = "UPDATE produto SET ";

            // construindo a query dinamicamente
            foreach($fields as $field => $newValue) {                     

                // single quotes for string types
                gettype($newValue) === 'string' ? $query .= $field." = '".$newValue."'" : $query .= $field." = ".$newValue;

                // Se não for o último campo, então coloca vírgula
                if ($field !== array_key_last($fields)) $query .= ", ";
            }            

            $query .= " WHERE idProduto = :idProduto";

            // fields to bind
            $fields = array (':idProduto' => $idProduto);

            try {
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
        }*/        
        
        /**
         * Summary: Método que tem por objetivo verificar se um determinado 
         * produto existe com base no campo e valor passados por parâmetro
         * @param $field: campo
         * @param $value: valor
         * @return boolean: Retorna true se o objeto com o valor equivalente ao campo existe, false caso contrário
         */
        public function usuarioExiste($field, $value) {
            $arr = [];
            $retorno  = false;

            try {
                // query
                $query = "SELECT nome FROM produto WHERE ".$field." = :".$field;
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
         * Summary:
         * Método que busca todos os produtos cadastrados na base de dados.
         * @param nenhum
         * @return array: Retorna uma array associativo do tipo arr(key -> value) com os 
         * dados do produto, ou um array vazio caso nenhum produto seja encontrado
         */
        /*public function buscarTodosProdutos() {
            $query = "SELECT * FROM produto ORDER BY categoria ASC";                       
            // fields to bind
            $fields = [];
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
        }*/ 
        
        /**
         * Buscar um produto por id passado como parâmetro
         * @param $idProduto: Id a ser procurado
         * @return array: Array Associativo contendo o produto buscado ou uma array vazio caso contrário
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