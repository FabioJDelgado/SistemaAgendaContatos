<?php 
    // PDO
    include_once 'ConexaoPDO.class.php';
        
    class ContatoDao {        
        // atributo 
        private $conexao;
        
        // construtor da classe
        public function __construct() {
            $this->conexao = new ConexaoPDO();
        }

        /**
         * Summary:
         * Método que tem por objetivo cadastrar um novo contato no banco de dados
         * @param $idUsuario: Id do usuário que está cadastrando o contato
         * @param $contato: Objeto da classe contato a ser cadastrado
         * @param boolean: Retorna true se o contato foi inserido com sucesso 
         * ou false caso contrário
         */
        public function cadastrarContato($idUsuario, $contato) {
            $retorno  = false;
            try {
                // query
                $query = "INSERT INTO contato(idUsuario, nome, telefone, email, foto) VALUES(:idUsuario, :nome, :telefone, :email, :foto)";
                // fields to bind
                $fields = array (
                 ':idUsuario' => $idUsuario, 
                 ':nome' => $contato->get('nome'), 
                 ':telefone' => $contato->get('telefone'), 
                 ':email' => $contato->get('email'),
                 ':foto' => $contato->get('foto'));

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
         * Método que tem por objetivo deletar um contato com o id passado por parâmetro
         * @param $idContato: Id do contato a ser deletado
         * @return boolean: Retorna true se o contato foi excluído com sucesso or false caso contrário. 
         * Variável $result guarda o número de linhas afetadas pela consulta
         */
        public function deletarContato($idContato) {
            $retorno = false;
            $query = "DELETE FROM contato WHERE idContato = :idContato";
            
            // fields to bind
            $fields = array (':idContato' => $idContato);

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
        } 
        
        /**
         * Método que tem por objetivo realizar a atualização de um contato.
         * @param $contato: Objeto da classe contato a ser atualizado
         * @return boolean: Retorna true se o contato pôde ser atualizado com sucesso e false caso contrário
         */
        public function atualizarContato($contato) {
            $retorno = false;
            $query = "UPDATE contato SET nome = :nome, telefone = :telefone, email = :email, foto = :foto WHERE idContato = :idContato";

            // fields to bind
            $fields = array (
                ':nome' => $contato->get('nome'),
                ':telefone' => $contato->get('telefone'),
                ':email' => $contato->get('email'),
                ':foto' => $contato->get('foto'),
                ':idContato' => $contato->get('idContato')
            );

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
        }       
        
        /**
         * Summary: Método que tem por objetivo verificar se um determinado 
         * contato existe com base nos parâmetros passados
         * @param $idUsuario: usuário que está cadastrando o contato
         * @param $nome: nome do contato
         * @param $telefone: telefone do contato
         * @param $email: email do contato
         * @return boolean: Retorna true se o objeto com o valor equivalente ao campo existe, false caso contrário
         */
        public function contatoUsuarioExiste($idUsuario, $nome, $telefone, $email) {
            $arr = [];
            $retorno  = false;

            try {
                // query
                $query = "SELECT nome FROM contato WHERE idUsuario = :idUsuario AND nome = :nome AND telefone = :telefone AND email = :email";
                // fields to bind
                $fields = array (
                    ':idUsuario' => $idUsuario,
                    ':nome' => $nome,
                    ':telefone' => $telefone,
                    ':email' => $email
                );                

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
         * Método que busca todos os contato cadastrados na base de dados.
         * @param $idUsuario: Id do usuário que está cadastrando o contato
         * @return array: Retorna uma array associativo do tipo arr(key -> value) com os 
         * dados do contato, ou um array vazio caso nenhum contato seja encontrado
         */
        public function buscarTodosContatosPorUsuario($idUsuario) {
            $query = "SELECT * FROM contato WHERE idUsuario = :idUsuario ORDER BY nome ASC";                       
            // fields to bind
            $fields = array (':idUsuario' => $idUsuario);
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
        
        /**
         * Buscar um contato por id passado como parâmetro
         * @param $idContato: Id a ser procurado
         * @return array: Array Associativo contendo o contato buscado ou uma array vazio caso contrário
         */
        public function buscarContatoId($idContato) {
            $query = "SELECT * FROM contato WHERE idContato = :idContato";                       
            // fields to bind
            $fields = array(':idContato' => $idContato);
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