<?php 
    // model
    include_once '../model/Contato.class.php';    
    // dao
    include_once '../dao/ContatoDao.class.php';
    // global config
    include_once '../config/GlobalConfig.php';

    try {
            $contatoController = new ContatoController();
            $contatoController->handleRequest();
    } catch (Exception $ex) {
            echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar realizar a requisição.<br> Mensagem: '.$ex->getMessage(), 'status_code' => 0));
    }

    // declaracao da classe controller do produto
    class ContatoController {
        // atributos
        private $daoContato;
        private $idUsuarioSession = NULL; // id do usuario logado, ou seja, o id do usuario que esta realizando acoes no contato

        // construtor da classe
        public function __construct() {
            $this->daoContato = new ContatoDao();
            session_start();
            $this->idUsuarioSession = $_SESSION['idUsuario'];
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
                // caso seja uma requisicao do tipo GET redefine o metodo para GET
                case 'GET':
                    if (isset($_GET['_acao'])) {
                        $this->handleGetRequest($_GET['_acao']);                        
                    } else {
                        echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Ação não informada', 'status_code' => 0));     
                    }                      
                break;
                // caso nao seja nenhuma das opcoes acima, retorna erro
                default:
                    echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Requisição desconhecida', 'status_code' => 0)); 
            }
        }

        // funcao para tratar as requisicoes do tipo POST
        private function handlePostRequest($_acao) {
            // identificando a acao a ser executada
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
                // caso nao seja nenhuma das opcoes acima, retorna erro
                default:
                    echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Ação desconhecida', 'status_code' => 0)); 
            }            
        }

        // funcao para tratar as requisicoes do tipo GET
        private function handleGetRequest($_acao) {
            // identificando a acao a ser executada
            switch($_acao) {
                case 'listar':
                    $this->buscarTodosContatoUsuario();
                break;
                // poderiam existir outras ações a serem executadas com GET
                // caso nao seja nenhuma das opcoes acima, retorna erro
                default:
                    echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar a operação.<br> Ação desconhecida', 'status_code' => 0)); 
            }
        }

        // funcao para cadastrar um novo contato
        public function cadastrar() {
            // tratando excecoes
            try {
                // recebendo os dados do formulario
                extract($_POST);           
                
                // verificando se o contato ja existe
                if(!$this->daoContato->contatoUsuarioExiste($this->idUsuarioSession, $nome, $telefone, $email)){

                    // realizando o upload da foto
                    $retUploadFoto = $this->uploadFoto($_FILES['foto'], $nome, $telefone, $email);

                    // caso o upload tenha sido realizado com sucesso
                    if(!(empty($retUploadFoto))){
                            
                        // criando um novo objeto contato
                        $contato = new Contato(0, $nome,  $telefone, $email, $retUploadFoto);

                        // realizando o cadastro do contato
                        if($this->daoContato->cadastrarContato($this->idUsuarioSession, $contato)) {

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

                // caso o contato ja exista
                } else {
                    echo json_encode(array('message' => 'Contato já cadastrado.', 'status_code' => 0));
                }
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar realizar o cadastro.<br> Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }

        // funcao de upload de foto
        public function uploadFoto($foto, $nome, $telefone, $email){
            // tratando excecoes
            try{
                // atributos
                $target_dir = GlobalConfig::$DEFAULT_UPLOAD_DIR_CONTATO;
                $target_file = $target_dir . $this->idUsuarioSession . "-" . $nome . "-" . $telefone . "-" . $email . "-" . basename($foto["name"]);
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
            // retornando o caminho da foto
            return $retorno;
        }

        // funcao para buscar todos os contatos do usuario
        public function buscarTodosContatoUsuario() {
            // atributos
            $contatos = [];
            // tratando excecoes
            try {
                // buscando todos os contatos do usuario
                $contatos = $this->daoContato->buscarTodosContatosPorUsuario($this->idUsuarioSession);
                echo json_encode($contatos);
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar buscar os contatos.<br>Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }

        // funcao para atualizar um contato
        public function atualizar() {
            // tratando excecoes
            try {
                // recebendo os dados do formulario
                extract($_POST);
                
                // recuperando e verificando se o contato ja existe
                $contatoRet = $this->daoContato->buscarContatoId($idContatoAtt);
                if($contatoRet){     

                    // verificando se nao foi enviado uma nova foto
                    $foto = "";
                    if(!(is_uploaded_file($_FILES['fotoAtt']['tmp_name']))){
                        $foto = $contatoRet[0]['foto'];

                    // caso tenha sido enviado uma nova foto
                    } else {
                        $fotoUpload = $this->uploadFoto($_FILES['fotoAtt'], $nomeAtt, $telefoneAtt, $emailAtt);
                        if(!(empty($fotoUpload))){
                            unlink($contatoRet[0]['foto']);
                            $foto = $fotoUpload;
                        }
                    }

                    // verifica se nao ocorreu erro no upload da foto
                    if(!(empty($foto))){

                        // criando um novo objeto contato
                        $contato = new Contato($idContatoAtt, $nomeAtt, $telefoneAtt, $emailAtt, $foto);

                        // realizando a atualizacao do contato
                        if($this->daoContato->atualizarContato($contato)) {

                            // caso a atualizacao tenha sido realizada com sucesso
                            echo json_encode(array('message' => 'Contato atualizado com sucesso!', 'status_code' => 1));

                        // caso a atualizacao nao tenha sido realizada com sucesso
                        } else {
                            echo json_encode(array('message' => 'Ocorreu um erro ao tentar atualizar o contato.', 'status_code' => 0));
                        }

                    // caso o upload nao tenha sido realizado com sucesso
                    }  else{
                        echo json_encode(array('message' => 'Ocorreu um erro ao tentar realizar o upload da foto.', 'status_code' => 0));
                    } 
                    
                // caso o contato nao exista
                } else {
                    echo json_encode(array('message' => 'Não é possível atualizar um contato inexistente.', 'status_code' => 0));
                }
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar atualizar o produto.<br>Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }  
        
        // funcao para deletar um contato
        public function deletar() {
            // tratando excecoes
            try {
                // recebendo os dados do formulario
                extract($_POST);

                // recuperando e verificando se o contato ja existe
                $contatoRet = $this->daoContato->buscarContatoId($idContato);
                if($contatoRet){     

                        // realizando a exclusao do contato
                        if($this->daoContato->deletarContato($idContato)) {

                            // removendo a foto do contato do diretorio do servidor
                            unlink($contatoRet[0]['foto']);
                            // caso a exclusao tenha sido realizada com sucesso
                            echo json_encode(array('message' => 'Contato excluído com sucesso', 'status_code' => 1));

                        // caso a exclusao nao tenha sido realizada com sucesso
                        } else {
                            echo json_encode(array('message' => 'Ocorreu um erro ao tentar excluir o contato.', 'status_code' => 0));
                        }

                // caso o contato nao exista
                } else {
                    echo json_encode(array('message' => 'Não é possível excluir um contato inexistente.', 'status_code' => 0));
                }
            } catch (Exception $ex) {
                echo json_encode(array('message' => 'Uma exceção ocorreu ao tentar excluir o contato.<br>Mensagem: '.$ex->getMessage(), 'status_code' => 0));
            }
        }
    }



?>