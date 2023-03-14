<?php 
    // model
    include_once '../model/Usuario.class.php';    
    // dao
    include_once '../dao/UsuarioDao.class.php';

    include_once '../config/GlobalConfig.php';

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
                if (!$this->daoUsuario->usuarioExiste('login', $login)) {

                    $retUploadFoto = $this->uploadFoto($_FILES['foto'], $login);
                    
                    if(!(empty($retUploadFoto))){
                        
                        $usuario = new Usuario(0, [], $nome, $login, $senha, $retUploadFoto);

                        if($this->daoUsuario->cadastrarUsuario($usuario)) {
                            echo json_encode(array('message' => 'Cadastro realizado com sucesso!', 'status_code' => 1));
                        } else {
                            echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar o cadastro.', 'status_code' => 0));
                        }
                    } else{
                        echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar o upload da foto.', 'status_code' => 0));
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
                    //$usuarioBanco = new Usuario($usuarioDb[0]['idUsuario'], [], $usuarioDb[0]['nome'], $usuarioDb[0]['login'], $usuarioDb[0]['senha'], $usuarioDb[0]['foto']);
                    echo json_encode($usuarioDb);          
                } else {
                    echo json_encode(array('message' => 'Login e/ou senha estão incorretos.', 'status_code' => 0));
                }                
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar buscar o usuário.<br> Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }

        public function uploadFoto($foto, $login){
            try{
                $target_dir = GlobalConfig::$DEFAULT_UPLOAD_DIR_USUARIO;
                $target_file = $target_dir . $login . "-" . basename($foto["name"]);
                $retorno = "";
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                    $check = getimagesize($foto["tmp_name"]);
                    if($check !== false) {
                        $uploadOk = 1;
                    } else {
                        $uploadOk = 0;
                    }
                }
                
                // Check if file already exists
                if (file_exists($target_file)) {
                    $uploadOk = 0;
                }
                
                // Check file size
                if ($foto["size"] > 500000) {
                    $uploadOk = 0;
                }
                
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    $uploadOk = 0;
                }
                
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $retorno = "";
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($foto["tmp_name"], $target_file)) {
                        $retorno = $target_file;
                    } else {
                        $retorno = "";
                    }
                }
            } catch(Exception $ex){
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar fazer o processamento da foto.<br> Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
            return $retorno;
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