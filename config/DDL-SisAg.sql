-- -----------------------------------------------------
-- Database user
-- -----------------------------------------------------
CREATE USER 'usersisag'@'localhost' IDENTIFIED BY '#user-sisag';

CREATE DATABASE sisag;

USE sisag;

-- -----------------------------------------------------
-- Table sisag.usuario
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS sisag.usuario (
  idUsuario INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(200) NOT NULL,
  login VARCHAR(200) NULL,
  senha VARCHAR(255) NULL,
  foto VARCHAR(500) NULL,
  PRIMARY KEY (idUsuario))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table sisag.contato
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS sisag.contato (
  idContato INT NOT NULL AUTO_INCREMENT,
  idUsuario INT NOT NULL,
  nome VARCHAR(200) NOT NULL,
  telefone VARCHAR(20) NOT NULL,
  email VARCHAR(200) NOT NULL,
  foto VARCHAR(500) NOT NULL,
  PRIMARY KEY (idContato, idUsuario),  
  CONSTRAINT fk_contato_usuario
    FOREIGN KEY (idUsuario)
    REFERENCES sisag.usuario (idUsuario)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


GRANT ALL PRIVILEGES ON sisag.* TO 'usersisag'@'localhost';
FLUSH PRIVILEGES;