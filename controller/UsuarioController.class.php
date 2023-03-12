<?php 
    // model
    include_once '../model/Usuario.class.php';    
    // dao
    include_once '../dao/UsuarioDao.class.php';

   try {
        $usuarioController = new UsuarioController();
        $usuarioController->handleRequest();
   } catch (Exception $ex) {
        echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar realizar a requisição.<br> Mensagem: '.$ex->getMessage(), 'status_code' => 0));
   }

    // declaração da classe controller do produto
    class UsuarioController {
        private $daoUsuario;

        public function __construct() {
            $this->daoUsuario = new UsuarioDao();
        }

        public function handleRequest() {            
            //identificando o tipo de requisicao recebida            
            switch ($_SERVER['REQUEST_METHOD']) 
            {
                case 'POST':                    
                    if (isset($_POST['_acao'])) {
                        $this->handlePostRequest($_POST['_acao']);                        
                    } else {
                        echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Ação não informada', 'status_code' => 0));     
                    }                     
                break;

                /*case 'GET':
                    if (isset($_GET['_acao'])) {
                        $this->handleGetRequest($_GET['_acao']);                        
                    } else {
                        echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Ação não informada', 'status_code' => 0));     
                    }                      
                break;*/

                default:
                    echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Requisição desconhecida', 'status_code' => 0)); 
            }
        }

        private function handlePostRequest($_acao) {
            switch($_acao) {
                case 'cadastrar':
                    $this->cadastrar();
                break;
                case 'logar':
                    $this->logar();
                break;
                // poderiam existir outras ações a serem executadas com POST
                default:
                    echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Ação desconhecida', 'status_code' => 0)); 
            }            
        }

        /*private function handleGetRequest($_acao) {
            switch($_acao) {
                case 'listar':
                    $this->buscarTodosProdutos();
                break;
                // poderiam existir outras ações a serem executadas com GET
                default:
                    echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Ação desconhecida', 'status_code' => 0)); 
            }
        }*/

        public function cadastrar() {
            try {
                extract($_POST);
                // variaveis $_acao, $nome, $categoria e $quantidade
                $usuario = new Usuario(0, [], $nome, $login, $senha, $foto);
                if (!$this->daoUsuario->usuarioExiste('login', $usuario->get('login'))) {

                    if($this->daoUsuario->cadastrarUsuario($usuario)) {
                        echo json_encode(array('message' => 'Cadastro realizado com sucesso!', 'status_code' => 1));
                    } else {
                        echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar o cadastro.', 'status_code' => 0));
                    }

                } else {
                    echo json_encode(array('message' => 'Usuário já cadastro.<br>Escolha outro login.', 'status_code' => 0));
                }                
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar realizar o cadastro.<br> Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }

        public function logar() {
            try {
                extract($_POST);
                // variaveis $_acao, $login, $senha
                $usuario = new Usuario(0, [], "", $login, $senha, "");
                $usuarioDb = $this->daoUsuario->buscarUsuarioLogin($usuario->get('login'), $usuario->get('senha'));
                if ($usuarioDb) {
                    echo json_encode($usuarioDb);            
                } else {
                    echo json_encode(array('message' => 'Login e/ou senha estão incorretos.', 'status_code' => 0));
                }                
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar buscar o usuário.<br> Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }

        /*public function buscarTodosProdutos() {
            $produtos = [];
            try {
                $produtos = $this->daoProduto->buscarTodosProdutos();
                echo json_encode($produtos);
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar buscar os produtos.<br>Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }*/

        /*public function atualizar() {
            try {
                echo json_encode(array('message' => 'Produto atualizado com sucesso', 'status_code' => 1));
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar atualizar o produto.<br>Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }   */ 
        
        /*public function deletar() {
            try {
                echo json_encode(array('message' => 'Produto excluído com sucesso', 'status_code' => 1));
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar excluir o produto.<br>Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }*/

        /*public function buscarPorId() {
            try {
                echo json_encode(array('message' => 'Produto encontrado', 'status_code' => 1));
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar recuperar o produto.<br>Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }*/



    }



?>