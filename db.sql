
CREATE DATABASE dbEventos

CREATE TABLE rol(
   idRol       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY key,
   nombre VARCHAR(60) NOT NULL UNIQUE KEY,
   flag        INT DEFAULT 1
)ENGINE = InnoDB;

CREATE TABLE tipoDocumento(
  idTipoDoc   INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  abreviatura VARCHAR(50) NOT NULL UNIQUE KEY,
  descripcion VARCHAR(100) NOT NULL,
  flag        INT DEFAULT 1,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE = InnoDB;

CREATE TABLE evento(
   idEvento    INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY key,
   nombre VARCHAR(60) NOT NULL UNIQUE KEY,
   idUsuario   INT NULL,
   flag        INT DEFAULT 1,
   created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   updated_at   TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE = InnoDB;

CREATE TABLE premio(
   idPremio    INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY key,
   nombre      VARCHAR(120) NOT NULL UNIQUE KEY,
   flag        INT DEFAULT 1, 
   idUsuario   INT NULL,
   created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   updated_at   TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE = InnoDB;

CREATE TABLE juego(
   idJuego     INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY key,
   nombre      VARCHAR(60)  NOT NULL UNIQUE KEY,
   descripcion VARCHAR(250) NOT NULL,
   flag       INT DEFAULT 1, 
   created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   updated_at   TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE = InnoDB;

CREATE TABLE usuarios(
  idUsuario     INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  idTipoDoc     INT          NOT NULL,
  dni           CHAR(8)      NOT NULL UNIQUE KEY,
  aPaterno      VARCHAR(60)  NOT NULL,
  aMaterno      VARCHAR(60)  NOT NULL,
  nombres       VARCHAR(60)  NOT NULL,
  direccion     VARCHAR(250) NOT NULL,
  correo        VARCHAR(80)  NULL,
  usuario       VARCHAR(80)  NOT NULL UNIQUE KEY,
  password      VARCHAR(200) NOT NULL,
  idRol         INT NOT NULL,
  flag          INT DEFAULT 1,
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE = InnoDB;

CREATE TABLE detalleJuego(
    idDetalleJ  INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idEvento    INT NOT NULL,
    idJuego     INT NOT NULL,
    fechIni     DATE NOT NULL,
    fechFin     DATE NOT NULL,
    flag        INT DEFAULT 1,
    idUsuario   INT NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE = InnoDB;

CREATE TABLE participante(
    idParticipante INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    codigo        VARCHAR(10) NOT NULL,
    idTipoDoc     INT           NULL,
    nroDocumento  VARCHAR(20)   NULL,
    aPaterno      VARCHAR(100)  NULL,
    aMaterno      VARCHAR(100)  NULL,
    nombres       VARCHAR(100)  NULL,
    rsocial       VARCHAR(250)  NULL,
    direccion     VARCHAR(500)  NULL,
    celular       VARCHAR(80)   NULL,
    correo        VARCHAR(100)  NULL,
    estado        INT DEFAULT 0,
    flag          INT DEFAULT 1,
    idUsuario     INT NOT NULL,
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE = InnoDB;


CREATE TABLE detalleParticipante(
    idDetalleP       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idParticipante   INT NOT NULL,
    idDetalleJ       INT NOT NULL,
    idEvento         INT NOT NULL,
    idJuego          INT NOT NULL,
    flag             INT DEFAULT 1,
    idUsuario        INT NOT NULL,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at       TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE = InnoDB;

CREATE TABLE ganador(
    idGanador        INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    codigo           VARCHAR(10) NULL,
    idDetalleP       INT NOT NULL,
    idPremio         INT NOT NULL,
    fechaEntrega     DATE NULL,
    estadoEntrega    INT DEFAULT 0, 
    comentario       VARCHAR(200)  NULL,
    idUsuario        INT NOT NULL,
    flag             INT DEFAULT 1,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at       TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
)ENGINE = InnoDB;


INSERT INTO rol(nombre)values('ADMINISTRADOR'),('OPERADOR');

INSERT INTO tipoDocumento(abreviatura,descripcion)VALUES
                         ('DNI', 'DOCUMENTO NACIONAL DE IDENTIDAD'),
                         ('PASAPORTE', 'PASAPORTE'),
                         ('CARNET EXT.', 'CARNET DE EXTRANGERIA'),
                         ('RUC', 'REGISTRO ÚNICO DE CONTRIBUYENTES')

INSERT INTO usuarios(idTipoDoc,dni, aPaterno, aMaterno, nombres, direccion, correo, usuario, password, idRol)
            values(1,'47719515','MUÑOZ','RUIZ','PEDRO ', 'HORACIO ZEVALLOS GAMES ATE','RONI290690@GMAIL.COM','ADMIN','25d55ad283aa400af464c76d713c07ad',1)

