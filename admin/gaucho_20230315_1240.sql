-- MariaDB dump 10.19  Distrib 10.5.18-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: gaucho
-- ------------------------------------------------------
-- Server version	10.5.18-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adm_menus`
--

DROP TABLE IF EXISTS `adm_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_menus` (
  `id` int(5) NOT NULL,
  `id_rotina` int(5) NOT NULL,
  `nome_menu` varchar(30) NOT NULL,
  `funcionalidade` varchar(2500) NOT NULL,
  `observacao` varchar(500) DEFAULT 'NULL',
  `classificacao` decimal(1,0) DEFAULT NULL,
  `indisponivel` decimal(1,0) DEFAULT NULL,
  `indisponivel_msg` varchar(100) DEFAULT 'NULL',
  `icone` varchar(40) DEFAULT 'NULL',
  `arquivo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_rotina`,`id`),
  KEY `menus_rotinas_FK` (`id_rotina`),
  CONSTRAINT `adm_menus_FK` FOREIGN KEY (`id_rotina`) REFERENCES `adm_rotinas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Cadastro Geral de Menus';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_menus`
--

LOCK TABLES `adm_menus` WRITE;
/*!40000 ALTER TABLE `adm_menus` DISABLE KEYS */;
INSERT INTO `adm_menus` VALUES (2,1,'Cadastro de Menus','Cadastro e manutenção dos Menus do Sistema','',1,0,'','','admin/adm_002.php'),(3,1,'Cadastro de Rotinas','Cadastra as rotinas do sistema, que serão os menus principais.','',1,0,'','','admin/adm_003.php'),(4,1,'Cadastro Usuários','Cadastrar os usuários/operadores e Administradores do Sistema','',1,0,'','','admin/adm_001.php'),(6,1,'Liberações do Usuário','Liberar menus para os usuários cadsatrados','',1,0,'','','admin/adm_004.php'),(11,1,'Consulta Logs','Ver Logs de Erros e Transaões','',0,0,'','','admin/acessa_logs.php'),(5,2,'Cadastro Entidades','Cadastro Básico de Entidades','',0,0,'','','cadastros/entidades.php');
/*!40000 ALTER TABLE `adm_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_menus_usuario`
--

DROP TABLE IF EXISTS `adm_menus_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_menus_usuario` (
  `id_usuario` int(5) NOT NULL,
  `id_menu` int(6) NOT NULL,
  `db_insert` tinyint(1) DEFAULT 0,
  `db_update` tinyint(1) DEFAULT 0,
  `db_delete` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_usuario`,`id_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Ligação Menus do Usuário';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_menus_usuario`
--

LOCK TABLES `adm_menus_usuario` WRITE;
/*!40000 ALTER TABLE `adm_menus_usuario` DISABLE KEYS */;
INSERT INTO `adm_menus_usuario` VALUES (1,2,1,1,1),(1,3,1,1,1),(1,4,1,1,1),(1,5,1,1,1),(1,6,1,1,1),(1,11,0,1,1),(2,2,1,1,1),(2,3,1,1,1),(2,4,1,1,1),(2,5,1,1,1),(2,6,1,1,1),(2,11,1,1,1);
/*!40000 ALTER TABLE `adm_menus_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_rotinas`
--

DROP TABLE IF EXISTS `adm_rotinas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_rotinas` (
  `id` int(5) NOT NULL COMMENT 'Id',
  `rotina` varchar(30) NOT NULL COMMENT 'Rotinas',
  `funcionalidade` varchar(500) NOT NULL,
  `caminho_http` varchar(40) DEFAULT 'NULL',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_rotina` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Cadastro de Rotinas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_rotinas`
--

LOCK TABLES `adm_rotinas` WRITE;
/*!40000 ALTER TABLE `adm_rotinas` DISABLE KEYS */;
INSERT INTO `adm_rotinas` VALUES (1,'ADMIN','Rotinas Administrativas',''),(2,'CADASTROS','Cadastros e Consultas de Dados','');
/*!40000 ALTER TABLE `adm_rotinas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_sess_login`
--

DROP TABLE IF EXISTS `adm_sess_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_sess_login` (
  `usuario` varchar(30) NOT NULL,
  `sess_id` varchar(40) NOT NULL,
  `data_sessao` datetime DEFAULT NULL,
  `unico` decimal(15,0) DEFAULT 0,
  PRIMARY KEY (`usuario`),
  KEY `sess_login_usuario_IDX` (`usuario`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Logins da sessão';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_sess_login`
--

LOCK TABLES `adm_sess_login` WRITE;
/*!40000 ALTER TABLE `adm_sess_login` DISABLE KEYS */;
INSERT INTO `adm_sess_login` VALUES ('jgoulart','75jc9l6o5ej41uu4d6g1d0t59v','2023-03-15 11:48:00',1608846731);
/*!40000 ALTER TABLE `adm_sess_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_usuario`
--

DROP TABLE IF EXISTS `adm_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_usuario` (
  `id` int(5) NOT NULL DEFAULT 1,
  `codigo` varchar(30) NOT NULL,
  `nome_usuario` varchar(50) NOT NULL,
  `email` varchar(40) DEFAULT 'NULL',
  `fone` varchar(50) DEFAULT 'NULL',
  `senha` varchar(40) NOT NULL,
  `nivel` tinyint(1) NOT NULL DEFAULT 9,
  `entidade` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_USUARIO_ID` (`id`),
  UNIQUE KEY `usuario_UN` (`codigo`),
  KEY `usuario_empresa_FK` (`entidade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Cadastro Usuários do Sistema';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_usuario`
--

LOCK TABLES `adm_usuario` WRITE;
/*!40000 ALTER TABLE `adm_usuario` DISABLE KEYS */;
INSERT INTO `adm_usuario` VALUES (1,'jgoulart','João Goulart','joao_goulart@jgoulart.eti.br','','bd091c9f2ee4ecff656af36264477e9daf755239',0,0),(2,'jean','Jean Carlo','jean.csoares@gmail.com','','35acc293869e776b72a4d1259b9d8f75fbbd0abb',0,0);
/*!40000 ALTER TABLE `adm_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_valida`
--

DROP TABLE IF EXISTS `adm_valida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_valida` (
  `tabela` varchar(20) NOT NULL COMMENT 'Tabela Origem ',
  `coluna` varchar(45) NOT NULL COMMENT 'Coluna da tabela',
  `valida` text DEFAULT NULL COMMENT 'Regra de Validação',
  `filtro` varchar(50) DEFAULT NULL COMMENT 'Parametro adicional\n',
  PRIMARY KEY (`tabela`,`coluna`),
  KEY `adm_valida_coluna_IDX` (`coluna`) USING BTREE,
  KEY `adm_valida_tabela_IDX` (`tabela`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Regras de Validação Colunas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_valida`
--

LOCK TABLES `adm_valida` WRITE;
/*!40000 ALTER TABLE `adm_valida` DISABLE KEYS */;
/*!40000 ALTER TABLE `adm_valida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereço`
--

DROP TABLE IF EXISTS `endereço`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `endereço` (
  `end_id` int(5) NOT NULL,
  `tipo_end` int(2) NOT NULL COMMENT 'Tipo Endereço',
  `logradouro` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Logradouro',
  `numero` int(10) DEFAULT NULL COMMENT 'Nro',
  `complemento` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Complemento',
  `bairro` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Bairro',
  `distrito` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Distrito',
  `cep` int(8) DEFAULT NULL COMMENT 'CEP',
  `uf` char(2) DEFAULT NULL COMMENT 'UF',
  `cidade` varchar(40) DEFAULT NULL COMMENT 'Cidade',
  PRIMARY KEY (`end_id`,`tipo_end`),
  KEY `endereço_FK` (`tipo_end`),
  KEY `endereço_uf_IDX` (`uf`) USING BTREE,
  CONSTRAINT `endereço_FK` FOREIGN KEY (`tipo_end`) REFERENCES `tipo_ender` (`tipo_id`),
  CONSTRAINT `endereço_FK_1` FOREIGN KEY (`end_id`) REFERENCES `entidade` (`entidade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Endereços de Pessoas e Entidades';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereço`
--

LOCK TABLES `endereço` WRITE;
/*!40000 ALTER TABLE `endereço` DISABLE KEYS */;
INSERT INTO `endereço` VALUES (1,1,'Rua José Arlindo Fadanelli',440,'','Esplanada','',95096151,'RS','Caxias do Sul');
/*!40000 ALTER TABLE `endereço` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entidade`
--

DROP TABLE IF EXISTS `entidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entidade` (
  `entidade_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária',
  `nome_entidade` varchar(100) NOT NULL COMMENT 'Nome Entidade',
  `cnpj` decimal(14,0) DEFAULT NULL COMMENT 'CNPJ',
  `resp1` varchar(100) NOT NULL COMMENT 'Nome Primeiro Responsável',
  `email_resp1` varchar(50) DEFAULT NULL COMMENT 'Email do Primeiro responsável',
  `telefone_resp1` varchar(50) DEFAULT NULL COMMENT 'Telefone do Primeiro responsável',
  `resp2` varchar(100) DEFAULT NULL COMMENT 'Nome Segundo Responsável',
  `email_resp2` varchar(50) DEFAULT NULL COMMENT 'Email do Segundo responsável',
  `telefone_resp2` varchar(50) DEFAULT NULL COMMENT 'Telefone do Segundo responsável',
  PRIMARY KEY (`entidade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Registro de Entidades Pessoas Juridicas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entidade`
--

LOCK TABLES `entidade` WRITE;
/*!40000 ALTER TABLE `entidade` DISABLE KEYS */;
INSERT INTO `entidade` VALUES (1,'CTG dos Goulart',0,'Jota','goulart.joao@gmail.com','(54)99947-5408','','','');
/*!40000 ALTER TABLE `entidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invernadas`
--

DROP TABLE IF EXISTS `invernadas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invernadas` (
  `entidade_id` int(5) NOT NULL,
  `tipo_invernada` int(3) NOT NULL,
  PRIMARY KEY (`entidade_id`,`tipo_invernada`),
  KEY `invernadas_FK` (`tipo_invernada`),
  KEY `invernadas_entidade_id_IDX` (`entidade_id`) USING BTREE,
  CONSTRAINT `invernadas_FK` FOREIGN KEY (`tipo_invernada`) REFERENCES `tipo_invernada` (`tipo`),
  CONSTRAINT `invernadas_FK_1` FOREIGN KEY (`entidade_id`) REFERENCES `entidade` (`entidade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Invernadas da Entidade';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invernadas`
--

LOCK TABLES `invernadas` WRITE;
/*!40000 ALTER TABLE `invernadas` DISABLE KEYS */;
INSERT INTO `invernadas` VALUES (1,2),(1,3),(1,4);
/*!40000 ALTER TABLE `invernadas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pessoas`
--

DROP TABLE IF EXISTS `pessoas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pessoas` (
  `pessoa_id` int(5) NOT NULL COMMENT 'Chave Primária',
  `nome` varchar(50) DEFAULT NULL COMMENT 'Nome Completo',
  `data_nascimento` date DEFAULT NULL COMMENT 'Data Nascimento',
  `sexo` enum('F','M') DEFAULT NULL COMMENT 'Sexo',
  `entidade` int(5) DEFAULT NULL COMMENT 'Entidade a que Pertence',
  `docto_mtg` varchar(30) DEFAULT NULL COMMENT 'Documento  MTG',
  `validade_docto_mtg` date DEFAULT NULL,
  PRIMARY KEY (`pessoa_id`),
  KEY `pessoas_FK` (`entidade`),
  CONSTRAINT `pessoas_FK` FOREIGN KEY (`entidade`) REFERENCES `entidade` (`entidade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoas`
--

LOCK TABLES `pessoas` WRITE;
/*!40000 ALTER TABLE `pessoas` DISABLE KEYS */;
/*!40000 ALTER TABLE `pessoas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tabela_uf`
--

DROP TABLE IF EXISTS `tabela_uf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tabela_uf` (
  `UF` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Sigla',
  `nome_estado` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Nome da UF',
  PRIMARY KEY (`UF`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tabela_uf`
--

LOCK TABLES `tabela_uf` WRITE;
/*!40000 ALTER TABLE `tabela_uf` DISABLE KEYS */;
INSERT INTO `tabela_uf` VALUES ('AC','Acre'),('AL','Alagoas'),('AM','Amazonas'),('AP','Amapá'),('BA','Bahia'),('CE','Ceará'),('DF','Distrito Federal'),('ES','Espírito Santo'),('EX','Exterior'),('GO','Goiás'),('MA','Maranhão'),('MG','Minas Gerais'),('MS','Mato Grosso do Sul'),('MT','Mato Grosso'),('PA','Pará'),('PB','Paraíba'),('PE','Pernambuco'),('PI','Piauí'),('PR','Paraná'),('RJ','Rio de Janeiro'),('RN','Rio Grande do Norte'),('RO','Rondônia'),('RR','Roraima'),('RS','Rio Grande do Sul'),('SC','Santa Catarina'),('SE','Sergipe'),('SP','São Paulo'),('TO','Tocantins');
/*!40000 ALTER TABLE `tabela_uf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_ender`
--

DROP TABLE IF EXISTS `tipo_ender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_ender` (
  `tipo_id` int(3) NOT NULL,
  `descri_tipo` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`tipo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Tipos Endereço';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_ender`
--

LOCK TABLES `tipo_ender` WRITE;
/*!40000 ALTER TABLE `tipo_ender` DISABLE KEYS */;
INSERT INTO `tipo_ender` VALUES (1,'Principal'),(2,'Galpão'),(3,'Correspondência');
/*!40000 ALTER TABLE `tipo_ender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_invernada`
--

DROP TABLE IF EXISTS `tipo_invernada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_invernada` (
  `tipo` int(3) NOT NULL,
  `titulo` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Tipos de Invernada';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_invernada`
--

LOCK TABLES `tipo_invernada` WRITE;
/*!40000 ALTER TABLE `tipo_invernada` DISABLE KEYS */;
INSERT INTO `tipo_invernada` VALUES (1,'Mirim'),(2,'Juvenil'),(3,'Adulto'),(4,'Veterano');
/*!40000 ALTER TABLE `tipo_invernada` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-15 12:40:41
