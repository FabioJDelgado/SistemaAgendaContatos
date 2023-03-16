<?php 
    // model
    include_once '../model/Contato.class.php';    
    // dao
    include_once '../dao/ContatoDao.class.php';

    include_once '../config/GlobalConfig.php';

   try {
        $contatoController = new ContatoController();
        $contatoController->handleRequest();
   } catch (Exception $ex) {
        echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar realizar a requisição.<br> Mensagem: '.$ex->getMessage(), 'status_code' => 0));
   }

    // declaração da classe controller do produto
    class ContatoController {
        private $daoContato;
        private $idUsuarioSession = NULL;

        public function __construct() {
            $this->daoContato = new ContatoDao();
            session_start();
            $this->idUsuarioSession = $_SESSION['idUsuario'];
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

                case 'GET':
                    if (isset($_GET['_acao'])) {
                        $this->handleGetRequest($_GET['_acao']);                        
                    } else {
                        echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Ação não informada', 'status_code' => 0));     
                    }                      
                break;

                default:
                    echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Requisição desconhecida', 'status_code' => 0)); 
            }
        }

        private function handlePostRequest($_acao) {
            switch($_acao) {
                case 'cadastrar':
                    $this->cadastrar();
                break;
                case 'editar':
                    $this->atualizar();
                break;
                case 'deletar':
                    $this->deletar();
                break;
                // poderiam existir outras ações a serem executadas com POST
                default:
                    echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Ação desconhecida', 'status_code' => 0)); 
            }            
        }

        private function handleGetRequest($_acao) {
            switch($_acao) {
                case 'listar':
                    $this->buscarTodosContatoUsuario();
                break;
                // poderiam existir outras ações a serem executadas com GET
                default:
                    echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Ação desconhecida', 'status_code' => 0)); 
            }
        }

        public function cadastrar() {
            try {
                extract($_POST);                
                if(!$this->daoContato->contatoUsuarioExiste($this->idUsuarioSession, $nome, $telefone, $email)){

                    $retUploadFoto = $this->uploadFoto($_FILES['foto'], $nome, $telefone, $email);

                    if(!(empty($retUploadFoto))){
                            
                        $contato = new Contato(0, $nome,  $telefone, $email, $retUploadFoto);

                        if($this->daoContato->cadastrarContato($this->idUsuarioSession, $contato)) {
                            echo json_encode(array('message' => 'Cadastro realizado com sucesso!', 'status_code' => 1));
                        } else {
                            echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar o cadastro.', 'status_code' => 0));
                        }
                    } else{
                        echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar o upload da foto.', 'status_code' => 0));
                    }
                } else {
                    echo json_encode(array('message' => 'Contato já cadastrado.', 'status_code' => 0));
                }
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar realizar o cadastro.<br> Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }

        public function uploadFoto($foto, $nome, $telefone, $email){
            try{
                $target_dir = GlobalConfig::$DEFAULT_UPLOAD_DIR_CONTATO;
                $target_file = $target_dir . $this->idUsuarioSession . "-" . $nome . "-" . $telefone . "-" . $email . "-" . basename($foto["name"]);
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

        public function buscarTodosContatoUsuario() {
            $contatos = [];
            try {
                $contatos = $this->daoContato->buscarTodosContatosPorUsuario($this->idUsuarioSession);
                echo json_encode($contatos);
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar buscar os contatos.<br>Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }

        public function atualizar() {
            try {
                extract($_POST);
                $contatoRet = $this->daoContato->buscarContatoId($idContatoAtt);
                if($contatoRet){     
                    $foto = "";
                    if(!(is_uploaded_file($_FILES['fotoAtt']['tmp_name']))){
                        $foto = $contatoRet[0]['foto'];
                    } else {
                        $fotoUpload = $this->uploadFoto($_FILES['fotoAtt'], $nomeAtt, $telefoneAtt, $emailAtt);
                        if(!(empty($fotoUpload))){
                            unlink($contatoRet[0]['foto']);
                            $foto = $fotoUpload;
                        }
                    }
                    if(!(empty($foto))){
                        $contato = new Contato($idContatoAtt, $nomeAtt, $telefoneAtt, $emailAtt, $foto);
                        if($this->daoContato->atualizarContato($contato)) {
                            echo json_encode(array('message' => 'Contato atualizado com sucesso!', 'status_code' => 1));
                        } else {
                            echo json_encode(array('message' => 'Ocorreu um erro ao tentar atualizar o contato.', 'status_code' => 0));
                        }
                    }  else{
                        echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar o upload da foto.', 'status_code' => 0));
                    }                      
                } else {
                    echo json_encode(array('message' => 'Não é possível atualizar um contato inexistente.', 'status_code' => 0));
                }
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar atualizar o produto.<br>Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }  
        
        public function deletar() {
            try {
                extract($_POST);
                $contatoRet = $this->daoContato->buscarContatoId($idContato);
                if($contatoRet){     
                        if($this->daoContato->deletarContato($idContato)) {
                            unlink($contatoRet[0]['foto']);
                            echo json_encode(array('message' => 'Contato excluído com sucesso', 'status_code' => 1));
                        } else {
                            echo json_encode(array('message' => 'Ocorreu um erro ao tentar excluir o contato.', 'status_code' => 0));
                        }
                } else {
                    echo json_encode(array('message' => 'Não é possível excluir um contato inexistente.', 'status_code' => 0));
                }
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar excluir o contato.<br>Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }

        /*public function buscarPorId() {
            try {
                echo json_encode(array('message' => 'Produto encontrado', 'status_code' => 1));
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar recuperar o produto.<br>Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }*/



    }



?>