<?php 
    // model
    include_once '../model/Usuario.class.php';    
    // dao
    include_once '../dao/UsuarioDao.class.php';
    // global config
    include_once '../config/GlobalConfig.php';

    try {
            $usuarioController = new UsuarioController();
            $usuarioController->handleRequest();
    } catch (Exception $ex) {
            echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar realizar a requisição.<br> Mensagem: '.$ex->getMessage(), 'status_code' => 0));
    }

    // declaração da classe controller do produto
    class UsuarioController {

        // atributo que armazena a instância do dao do produto
        private $daoUsuario;

        // construtor da classe
        public function __construct() {
            $this->daoUsuario = new UsuarioDao();
        }

        // metodo para tratamento de requisicoes
        public function handleRequest() {          

            //identificando o tipo de requisicao recebida            
            switch ($_SERVER['REQUEST_METHOD']) 
            {
                // caso seja uma requisicao do tipo POST redefine o metodo para POST
                case 'POST':                    
                    if (isset($_POST['_acao'])) {
                        $this->handlePostRequest($_POST['_acao']);                        
                    } else {
                        echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Ação não informada', 'status_code' => 0));     
                    }                     
                break;
                // caso nao seja uma requisicao acima
                default:
                    echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Requisição desconhecida', 'status_code' => 0)); 
            }
        }

        // metodo para tratamento de requisicoes do tipo POST
        private function handlePostRequest($_acao) {
            switch($_acao) {
                // caso a acao seja cadastrar
                case 'cadastrar':
                    $this->cadastrar();
                break;
                // caso a acao seja logar
                case 'logar':
                    $this->logar();
                break;
                // poderiam existir outras ações a serem executadas com POST
                // caso a acao nao seja nenhuma das acima
                default:
                    echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Ação desconhecida', 'status_code' => 0)); 
            }            
        }

        // metodo para cadastrar um usuario
        public function cadastrar() {
            // tratamento de excecoes
            try {
                // recebendo os dados do formulario
                extract($_POST);    
                
                // verfica se o usuario nao existe
                if (!$this->daoUsuario->usuarioExiste('login', $login)) {

                    // realizando o upload da foto
                    $retUploadFoto = $this->uploadFoto($_FILES['foto'], $login);
                    
                    // caso o upload tenha sido realizado com sucesso
                    if(!(empty($retUploadFoto))){
                        
                        // criando o objeto usuario
                        $usuario = new Usuario(0, [], $nome, $login, $senha, $retUploadFoto);

                        // realizando o cadastro do usuario
                        if($this->daoUsuario->cadastrarUsuario($usuario)) {

                            // caso o cadastro tenha sido realizado com sucesso
                            echo json_encode(array('message' => 'Cadastro realizado com sucesso!', 'status_code' => 1));

                        // caso o cadastro nao tenha sido realizado com sucesso
                        } else {
                            echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar o cadastro.', 'status_code' => 0));
                        }

                    // caso o upload nao tenha sido realizado com sucesso
                    } else{
                        echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar o upload da foto.', 'status_code' => 0));
                    }

                // caso o usuario ja exista
                } else {
                    echo json_encode(array('message' => 'Usuário já cadastro.<br>Escolha outro login.', 'status_code' => 0));
                }                
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar realizar o cadastro.<br> Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }

        // metodo para logar um usuario
        public function logar() {
            // tratamento de excecoes
            try {
                // recebendo os dados do formulario
                extract($_POST);

                // criando o objeto usuario
                $usuario = new Usuario(0, [], "", $login, $senha, "");

                // realizando a busca do usuario
                $usuarioDb = $this->daoUsuario->buscarUsuarioLogin($usuario->get('login'), $usuario->get('senha'));

                // caso o usuario tenha sido encontrado
                if ($usuarioDb) {
                    echo json_encode($usuarioDb);          

                // caso o usuario nao tenha sido encontrado
                } else {
                    echo json_encode(array('message' => 'Login e/ou senha estão incorretos.', 'status_code' => 0));
                }                
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar buscar o usuário.<br> Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }

        // metodo para realizar o upload da foto
        public function uploadFoto($foto, $login){
            // tratamento de excecoes
            try{
                // atributos
                $target_dir = GlobalConfig::$DEFAULT_UPLOAD_DIR_USUARIO;
                $target_file = $target_dir . $login . "-" . basename($foto["name"]);
                $retorno = "";
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                // verificando se o arquivo enviado e uma imagem
                if(isset($_POST["submit"])) {
                    $check = getimagesize($foto["tmp_name"]);
                    if($check !== false) {
                        $uploadOk = 1;
                    } else {
                        $uploadOk = 0;
                    }
                }
                
                // verificando se o arquivo ja existe
                if (file_exists($target_file)) {
                    $uploadOk = 0;
                }
                
                // verificando o tamanho do arquivo
                if ($foto["size"] > 500000) {
                    $uploadOk = 0;
                }
                
                // verificando o tipo de arquivo
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    $uploadOk = 0;
                }
                
                // verificando se nao teve erro nas validacoes acima
                if ($uploadOk == 0) {
                    $retorno = "";

                // caso nao tenha ocorrido erro, tenta fazer o upload
                } else {

                    // realizando o upload
                    if (move_uploaded_file($foto["tmp_name"], $target_file)) {
                        $retorno = $target_file;

                    // caso ocorra erro no upload
                    } else {
                        $retorno = "";
                    }
                }
            } catch(Exception $ex){
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar fazer o processamento da foto.<br> Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
            return $retorno;
        }
    }



?>