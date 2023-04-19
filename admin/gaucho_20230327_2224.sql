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
INSERT INTO `adm_menus` VALUES (2,1,'Cadastro de Menus','Cadastro e manutenção dos Menus do Sistema','',1,0,'','','admin/adm_002.php'),(3,1,'Cadastro de Rotinas','Cadastra as rotinas do sistema, que serão os menus principais.','',1,0,'','','admin/adm_003.php'),(4,1,'Cadastro Usuários','Cadastrar os usuários/operadores e Administradores do Sistema','',1,0,'','','admin/adm_001.php'),(6,1,'Liberações do Usuário','Liberar menus para os usuários cadsatrados','',1,0,'','','admin/adm_004.php'),(11,1,'Consulta Logs','Ver Logs de Erros e Transaões','',0,0,'','','admin/acessa_logs.php'),(5,2,'Cadastro Entidades','Cadastro Básico de Entidades','',0,0,'','','cadastros/entidades.php'),(12,2,'Cadastro de Pessoas','Cadastrar Pessoas Associadas às Entidades','',0,0,'','','cadastros/pessoas.php'),(13,2,'Cadastro de Eventos','Eventos do Calendário','',0,0,'','','cadastros/eventos.php');
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
  PRIMARY KEY (`id_usuario`,`id_menu`),
  CONSTRAINT `adm_menus_usuario_FK` FOREIGN KEY (`id_usuario`) REFERENCES `adm_usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Ligação Menus do Usuário';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_menus_usuario`
--

LOCK TABLES `adm_menus_usuario` WRITE;
/*!40000 ALTER TABLE `adm_menus_usuario` DISABLE KEYS */;
INSERT INTO `adm_menus_usuario` VALUES (1,2,1,1,1),(1,3,1,1,1),(1,4,1,1,1),(1,5,1,1,1),(1,6,1,1,1),(1,11,0,1,1),(1,12,1,1,1),(1,13,1,1,1),(2,2,1,1,1),(2,3,1,1,1),(2,4,1,1,1),(2,5,1,1,1),(2,6,1,1,1),(2,11,1,1,1),(2,12,1,1,1),(2,13,1,1,1);
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
  `usuario_id` int(5) NOT NULL,
  `sess_id` varchar(40) NOT NULL,
  `data_sessao` datetime DEFAULT NULL,
  `unico` decimal(15,0) DEFAULT 0,
  PRIMARY KEY (`usuario_id`),
  KEY `sess_login_usuario_IDX` (`usuario_id`) USING BTREE,
  CONSTRAINT `adm_sess_login_FK` FOREIGN KEY (`usuario_id`) REFERENCES `adm_usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Logins da sessão';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_sess_login`
--

LOCK TABLES `adm_sess_login` WRITE;
/*!40000 ALTER TABLE `adm_sess_login` DISABLE KEYS */;
INSERT INTO `adm_sess_login` VALUES (1,'oslcq74i5024e9dpq1d67mtmsb','2023-03-22 14:59:00',729010327),(2,'0unq9e3ajjsn2j27q8e4opkfhg','2023-03-17 18:47:00',310474836);
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
-- Table structure for table `endereço`
--

DROP TABLE IF EXISTS `endereço`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `endereço` (
  `end_id` int(5) NOT NULL,
  `tipo_end` int(2) NOT NULL COMMENT 'Tipo Endereço',
  `logradouro` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Logradouro',
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
  CONSTRAINT `endereço_FK_1` FOREIGN KEY (`end_id`) REFERENCES `entidade` (`entidade_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Endereços de Pessoas e Entidades';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereço`
--

LOCK TABLES `endereço` WRITE;
/*!40000 ALTER TABLE `endereço` DISABLE KEYS */;
INSERT INTO `endereço` VALUES (625,1,'Km 72, S/Nº ERS-122 , bairro Cidade Nova',NULL,NULL,NULL,NULL,95110310,'RS','Caxias do Sul'),(656,1,'Estrada Arroio das Marrecas, 3000, apartamento 3, Vila Seca',NULL,NULL,NULL,NULL,9514000,'RS','Caxias do Sul'),(668,1,'Rua Estrela, 490, apartamento 1, bairro Cruzeiro',NULL,NULL,NULL,NULL,95076570,'RS','Caxias do Sul'),(673,1,'Rua Francisco Camatti, 937, apartamento 205, bairro Madureira',NULL,NULL,NULL,NULL,95020220,'RS','Caxias do Sul'),(674,1,'Rua Inocente Comunello, 24, bairro Rio Branco',NULL,NULL,NULL,NULL,95097500,'RS','Farroupilha'),(685,1,'Linha Chapadão, 400, São Jorge da Mulada, Criuva',NULL,NULL,NULL,NULL,95143000,'RS','Caxias do Sul'),(688,1,'Rua Ana Catharina Canali, 512, bairro São Cristovão',NULL,NULL,NULL,NULL,95058030,'RS','Caxias do Sul'),(696,1,'Rua Carlos Mantovani, 535, bairro São Jose',NULL,NULL,NULL,NULL,95042630,'RS','Caxias do Sul'),(867,1,'Avenida Rio Branco, Ana Rech',NULL,NULL,NULL,NULL,95060145,'RS','Caxias do Sul'),(1059,1,'Rua Gilda Marcon Grazziotin Nora, 1130, bairro Petropolis',NULL,NULL,NULL,NULL,95070564,'RS','Caxias do Sul'),(1111,1,'Rua João Zanol, 761, bairro Ana Rech',NULL,NULL,NULL,NULL,95060360,'RS','Caxias do Sul'),(1273,1,'Rua Doutor Montaury, 652, centro',NULL,NULL,NULL,NULL,95270000,'RS','Flores da Cunha'),(1409,1,'Rua Cesare Cambruzzi, 1006, apartamento 101, bairro Santa Catarina',NULL,NULL,NULL,NULL,95032610,'RS','Caxias do Sul'),(1457,1,'Rua Arlindo Festugato, 20, bairro Charqueadas',NULL,NULL,NULL,NULL,95110350,'RS','Caxias do Sul'),(1467,1,'Rua Olinda Pontalti Peteffi, 1306, bairro Diamantino',NULL,NULL,NULL,NULL,95055618,'RS','Caxias do Sul'),(1476,1,'Rua Gregorio Panazollo, 330, bairro Centro',NULL,NULL,NULL,NULL,95260000,'RS','Nova Roma do Sul'),(1532,1,'Rua Jose Ramos, 1084, bairro Ana Rech',NULL,NULL,NULL,NULL,95060390,'RS','Caxias do Sul'),(1569,1,'Rua Veneto, 1855, Santa Rita',NULL,NULL,NULL,NULL,95176370,'RS','Farroupilha'),(1583,1,'Rua Rodrigues Alves, 2205, bairro Nossa Senhora de Lourdes',NULL,NULL,NULL,NULL,95076670,'RS','Caxias do Sul'),(1664,1,'Rua Centauro, 23, bairro Cruzeiro',NULL,NULL,NULL,NULL,95074150,'RS','Caxias do Sul'),(1684,1,'Rua Maria Zelina Rodrigues, 37 , bairro Desvio Rizzo',NULL,NULL,NULL,NULL,95110015,'RS','Caxias do Sul'),(1685,1,'Rua Padre Anchieta, 521, bairro Francisco Doncatto',NULL,NULL,NULL,NULL,95190000,'RS','São Marcos'),(1713,1,'Avenida Benjamin Custódio de Oliveira, 274, apartamento 01, bairro Charqueadas',NULL,NULL,NULL,NULL,95110760,'RS','Caxias do Sul'),(1788,1,'Rua Teixeira de Freitas, 1490, apartamento 901, bairro Sagrada Familia',NULL,NULL,NULL,NULL,95054510,'RS','Caxias do Sul'),(1789,1,'Rua Libres Gaviraghi, 584, Bairro Industrial',NULL,NULL,NULL,NULL,95178172,'RS','Farroupilha'),(1800,1,'Rua Victorio Jose Bisol, 178, bairro Diamantino',NULL,NULL,NULL,NULL,95055550,'RS','Caxias do Sul'),(1936,1,'Rua Ines Boff Mazotti, 1520, bairro Nossa Senhora do Rosário',NULL,NULL,NULL,NULL,95045291,'RS','Caxias do Sul'),(1990,1,'Rua Engenheiro Dario Granja Sant\'Ana, 272, apartamento 41, bairro Rio Branco',NULL,NULL,NULL,NULL,95099150,'RS','Caxias do Sul'),(1992,1,'Rua Victor Pellin, 1070, bairro Pedancino',NULL,NULL,NULL,NULL,95100000,'RS','Caxias do Sul'),(2010,1,'Rua Andrade Neves, 1452, apartamento 302, bairro Centro, Flores da Cunha',NULL,NULL,NULL,NULL,95270000,'RS','Caxias do Sul'),(2056,1,'Rua Virgolina Alves Carneiro, 71, bairro Cidade Nova',NULL,NULL,NULL,NULL,95112042,'RS','Caxias do Sul'),(2090,1,'RUA ALCIDES LAZZARI, 563',NULL,NULL,NULL,NULL,95115020,'RS','Caxias do Sul'),(2110,1,'Rua Emilio Ernesto Schmidt, 370, bairro Esplanada',NULL,NULL,NULL,NULL,95095205,'RS','Caxias do Sul'),(2238,1,'Rua Guido D\'Andrea, 284, bairro Marechal Floriano',NULL,NULL,NULL,NULL,95013170,'RS','Caxias do Sul'),(2341,1,'Rua Nelson Henz, 69, bairro Por do Sol',NULL,NULL,NULL,NULL,95042440,'RS','Caxias do Sul'),(2453,1,'Rua Waldemar Lazzarotto, 499, apartamento 402, bairro Interlagos',NULL,NULL,NULL,NULL,95052590,'RS','Caxias do Sul'),(2567,1,'Rua Elma Lazzari Belenzier, 49, bairro São Caetano',NULL,NULL,NULL,NULL,95095288,'RS','Caxias do Sul'),(2622,1,'Rua Garibaldino Borges Atti, 293, bairro Jardim Eldorado',NULL,NULL,NULL,NULL,95059230,'RS','Caxias do Sul'),(2644,1,'Rua Venancio Aires, 1436, bairro Centro, São Marcos',NULL,NULL,NULL,NULL,95143000,'RS','Caxias do Sul'),(2692,1,'Vila Meneguzzi, 1230, centro',NULL,NULL,NULL,NULL,95190000,'RS','São Marcos'),(2693,1,'Rua Tucano, 129, bairro Cruzeiro',NULL,NULL,NULL,NULL,95074380,'RS','Caxias do Sul'),(2705,1,'Rua Luiz Perico, 500, bairro Desvio Rizzo',NULL,NULL,NULL,NULL,95110505,'RS','Caxias do Sul'),(2707,1,'Rua Edmundo Hilgert, 55, apartamento 503 bloco B',NULL,NULL,NULL,NULL,95174300,'RS','Farroupilha'),(2735,1,'Rua Principal, 1061, Bairro São Pedro da Terceira Légua',NULL,NULL,NULL,NULL,95124000,'RS','Caxias do Sul'),(2833,1,'Estrada do Imigrante, 100. Nossa Senhora das Graças. ',NULL,NULL,NULL,NULL,95095232,'RS','Caxias do Sul');
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
  `sigla` varchar(3) DEFAULT NULL COMMENT 'Sigla da Entidade.',
  `nome_entidade` varchar(100) NOT NULL COMMENT 'Nome Entidade',
  `cnpj` decimal(14,0) DEFAULT NULL COMMENT 'CNPJ',
  `resp1` varchar(100) NOT NULL COMMENT 'Nome Primeiro Responsável  (Patrão)',
  `email_resp1` varchar(50) DEFAULT NULL COMMENT 'Email do Primeiro responsável',
  `telefone_resp1` varchar(50) DEFAULT NULL COMMENT 'Telefone do Primeiro responsável',
  `resp2` varchar(100) DEFAULT NULL COMMENT 'Nome Segundo Responsável',
  `email_resp2` varchar(50) DEFAULT NULL COMMENT 'Email do Segundo responsável',
  `telefone_resp2` varchar(50) DEFAULT NULL COMMENT 'Telefone do Segundo responsável',
  `data_fundação` date DEFAULT NULL COMMENT 'Data de Fundação da Entidade',
  `RT` varchar(3) DEFAULT NULL COMMENT 'Região Tradicionalista',
  `matricula` int(5) DEFAULT NULL COMMENT 'Matricula MTG',
  PRIMARY KEY (`entidade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2834 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Registro de Entidades Pessoas Juridicas';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entidade`
--

LOCK TABLES `entidade` WRITE;
/*!40000 ALTER TABLE `entidade` DISABLE KEYS */;
INSERT INTO `entidade` VALUES (1,NULL,'CTG dos Goulart',0,'Aldoir Lira de Barros','aldoirzorrinho@hotmail.com','(54) 991136716/999422491','','','','1971-07-12',NULL,NULL),(102,'CTG','PAIXÃO CORTES ',89280549000190,'Deloir Franciso Rodrigues Pereira','carbeal@terra.com.br','(54) 991946394',NULL,NULL,NULL,'1956-07-04','25',102),(111,'CTG','POUSADA DOS TROPEIROS ',92861871000118,'Fernando Antonio Giordani','juvacchi@yahoo.com.br','(54) 999660608',NULL,NULL,NULL,'1969-12-31','25',111),(119,'CTG','RINCÃO DA LEALDADE',15562117000136,'Valdemar Soares da Luz','valdemarsoares130@gmail.com','(54) 991025157',NULL,NULL,NULL,'1969-12-31','25',119),(256,'CTG','RODEIO MINUANO ',90732641000175,'Adão Gomes de Araújo Junior','adaoaraujojr@outlook.com','(54) 981337649',NULL,NULL,NULL,'1959-06-08','25',256),(430,'CTG','SINUELO DO PAMPA ',0,'Carlos Dalnei Rosa de Quadros',' qeqconstrutora@hotmail.com','(54) 999844176',NULL,NULL,NULL,'1969-12-31','25',430),(465,'CTG','RONDA CHARRUA ',89664551000163,'Rogerio Carlos Abreu da Silva','chasque2009@hotmail.com','(54) 999765155',NULL,NULL,NULL,'1969-12-31','25',465),(623,'CTG','NEGRINHO DO PASTOREIO ',89822712000108,'André Luis dos Santos Vieira','bgvisual@bgvisual.com.br','(54) 991614770',NULL,NULL,NULL,'1972-01-05','25',623),(624,'CTG','RAPOSO TAVARES',19056858000104,'Oscar Almeida Vieira','makellyfernanda@gmail.com','(54) 95098650',NULL,NULL,NULL,'1969-12-31','25',624),(625,'CTG','DOM MANUEL SANMARTIN',8595205000179,'Idival Castilhos Machado','idival.machado@grupo-sanmartin.com','(54) 999415833',NULL,NULL,NULL,'2006-12-12','25',625),(626,'CTG','PORTEIRA DA SERRA  ',92864156000139,'Roque Jocenir Castilhos','roberta_castilhos@hotmail.com','(54)999953880',NULL,NULL,NULL,'1969-12-31','25',626),(656,'CTG','CHIMARRÃO ',90770256000170,'Nestor Juarez dos Passos','edilainers90@gmail.com','(54) 996748645',NULL,NULL,NULL,'1969-12-31','25',656),(660,'PL','RODEIO TEATINO',21009580000158,'Lucas Vanaz','agrodrago@brsulnetrs.com.br','(54) 996795315',NULL,NULL,NULL,'1966-08-01','25',660),(661,'PL','PRESILHA DO RINCÃO',604987000153,'Claudio Adenir Varela dos Santos','varelarepresent@hotmail.com','(54) 999489172',NULL,NULL,NULL,'1969-12-31','25',661),(662,'PL','SESTIADA DE GAÚCHO',9359554000154,'Mario Gilberto Gonçalves','mariogilberto.goncalves@hotmail.com','(54)999960318',NULL,NULL,NULL,'1969-12-31','25',662),(663,'PL','RODEIO VELHO',0,'Darlan Adão Camelo de Araujo',' ggcastilhos@yahoo.com.br','(54) 98425-6559',NULL,NULL,NULL,'1963-08-11','25',663),(664,'PL','LAÇO FORTE',0,'Maicon Joenir Fortes','maiconjfortes@gmail.com','(54) 999149979',NULL,NULL,NULL,'1969-12-31','25',664),(665,'PL','VOVÔ SILVANO DANELUZ',0,'Volnei Pistore','volneipistore@gmail.com','(54) 99113-2425',NULL,NULL,NULL,'1977-11-05','25',665),(667,'CTG','PORTEIRA DA AMIZADE',10690521000171,'Elairton Zampieri Fochezatto','vanuzafochezatto@gmail.com','(54) 999748534',NULL,NULL,NULL,'1969-12-31','25',667),(668,'CTG','LAÇO DA AMIZADE',10511909000168,'Juares Perochin','gustavoperochin@yahoo.com.br','(54) 999322358',NULL,NULL,NULL,'1969-12-31','25',668),(670,'PL','VETERANOS',0,'Gilson Boff','gilsonboff@hotmail.com','(54) 999177381',NULL,NULL,NULL,'1969-01-01','25',670),(671,'PL','SINUELO DOS PAMPAS',0,'Carlos Cervelin',' sonia.bachic@hotmail.com','(54) 981150485',NULL,NULL,NULL,'1969-12-31','25',671),(673,'PL','LAÇADORES DA QUERÊNCIA',0,'Diego Palmeira Marques','diego-marques16@hotmail.com','(54) 991779313',NULL,NULL,NULL,'1969-12-31','25',673),(674,'CTG','CHILENAS DE PRATA',7970805000107,'Simara de Souza Barbosa','','(54) 98428-9099',NULL,NULL,NULL,'2005-12-02','25',674),(675,'PL','POTREIRO DA SERRA',90775693000187,'Airton Zacarias dos Santos','','(54)  999652620',NULL,NULL,NULL,'1977-06-07','25',675),(685,'PL','CHALEIRA PRETA',8390275000190,'Jose Mario Schmitt Machado','antonio_castilhos@hotmail.com','(54) 999082435',NULL,NULL,NULL,'1969-12-31','25',685),(688,'CTG','GALPÃO  PRAZER  DE GAÚCHO',808945000134,'Lilian Catarina Fabiane da Silva','lcfabiani@ucs.br','(54) 991868017',NULL,NULL,NULL,'1969-12-31','25',688),(696,'CTG','CARRO DE BOI',26662771000138,'Edson Dutra da Silva','edsondutradasilva209@gmail.com','(54) 991422041',NULL,NULL,NULL,'1981-04-12','25',696),(802,'PL','RODEIO LAGEADO',88373196000100,'Elton Antonio Capelani dos Santos','elton.capelani@gmail.com','(54) 997114122',NULL,NULL,NULL,'1983-01-08','25',802),(813,'PL','MINUANO DA CASCATA',0,'Raul Bento Gomes da Fonseca','fonseca.raul@terra.com.br','(54)999241640',NULL,NULL,NULL,'1964-08-03','25',813),(867,'CTG','IMIGRANTES E TRADIÇÃO',88708409000108,'Jorge Jacomelli','jjacomelli@uol.com.br','(54) 9 9923-3769',NULL,NULL,NULL,'1969-12-31','25',867),(1030,'CTG','RANCHO DE GAUDÉRIOS ',92861319000120,'Alexandre de Moura Destefani','alexandede@outlook.com','(54) 99613-9493',NULL,NULL,NULL,'1969-12-31','25',1030),(1050,'CTG','VELHA CARRETA ',87505442000178,'Cicero Adriano Perez Garcia',' c.adriano.tche@gmail.com','(54) 98446-0883',NULL,NULL,NULL,'1969-12-31','25',1050),(1057,'CTG','MARCO DA TRADIÇÃO ',91109421000100,'Gilberto Corsso','','(54) 981220332',NULL,NULL,NULL,'1969-12-31','25',1057),(1059,'CTG','CAMPO DOS BUGRES ',91106484000103,'Vanderlei Muller Franco',' vmfranco@terra.com.br ','(54) 99137-4666',NULL,NULL,NULL,'1986-10-09','25',1059),(1080,'CTG','TAPERA VELHA ',90481169000101,'Enio Roberto Schmitt Becker','bertoni@bertonibecker.com.br','(54)  99679-9802',NULL,NULL,NULL,'1984-10-11','25',1080),(1103,'CTG','QUERÊNCIA XUCRA ',91107854000127,'Paulo Roberto Souza Pereira',' paulorsp13@gmail.com','(54) 99932046',NULL,NULL,NULL,'1969-12-31','25',1103),(1111,'CTG','GINETES DA TRADIÇÃO ',88708508000190,'Alvaro Giacomet Barreto',' barretodag@yahoo.com.br','(54) 991832608',NULL,NULL,NULL,'1982-10-09','25',1111),(1125,'PIQ','TRONQUEIRA DE BUGRE',91108076000190,'Luciano Tomiello',' lucianotomiello@gmail.com','(54) 992168603',NULL,NULL,NULL,'1969-12-31','25',1125),(1184,'CTG','LAÇO ITALIANO',0,'Gustavo luiz Moterle','','(54) 999190354',NULL,NULL,NULL,'1969-12-31','25',1184),(1273,'CTG','GALPÃO SERRANO',91110007000111,'Allan Conz','allanconz@gmail.com','(54) 991143362',NULL,NULL,NULL,'1969-12-31','25',1273),(1293,'CTG','PORTEIRA DO IMIGRANTE ',92860584000193,'Roberdan Escobar Saraiva','roberdanescobar@hotmail.com','(54) 984480717',NULL,NULL,NULL,'1969-12-31','25',1293),(1401,'CTG','PAMPAS DO IMIGRANTE',0,'Leonel Machado da Silva',' construtoraorence@hotmail.com','(54) 99923-6264',NULL,NULL,NULL,'1969-12-31','25',1401),(1409,'CTG','HEROIS FARROUPILHAS',92863117000117,'Waldemar da Silva','secretariaherois@gmail.com','(54)  99774692',NULL,NULL,NULL,'1989-01-07','25',1409),(1457,'CTG','HERDEIROS DA TRADIÇÃO',92866813000187,'Anderson Theodoro de Lima','andersonlima88@bol.com.br','(54) 996029188',NULL,NULL,NULL,'1990-05-10','25',1457),(1458,'CTG','PAMPA DO RIO GRANDE',92866763000138,'Cassiano Ramos Moreira','moreira.cassiano@hotmail.com','(54)  984284855',NULL,NULL,NULL,'1990-08-07','25',1458),(1467,'CTG','ELO DO RIO GRANDE ',92867308000157,'Marcelo Alencar de Oliveira','marcelo.juiz@hotmail.com','(54) 99909-3908',NULL,NULL,NULL,'1990-09-08','25',1467),(1476,'CTG','ACONCHEGO GAÚCHO',92861491000183,'Maxuel Lodi Gabrielli','maxgabrielli@hotmail.com','(54) 999722696',NULL,NULL,NULL,'1988-12-01','25',1476),(1508,'CTG','SANGUE CRIOULO',92868280000172,'Itagir Jose Baggio','','(54)  999177241',NULL,NULL,NULL,'1991-12-01','25',1508),(1531,'CTG','OS CARRETEIROS',87505442000178,'Fernando Bonotto',' fer.bonoto@gmail.com','(54) 991226446',NULL,NULL,NULL,'1969-12-31','25',1531),(1532,'CTG','CABANHA BELIZÁRIO NUNES',92869460000179,'Jardel de Souza Pereira','jardelpereirajardel@gmail.com','(54) 99100-2759',NULL,NULL,NULL,'1969-12-31','25',1532),(1533,'CTG','VOVÔ FLORIAN ',92870666000119,'Luciano da Silva Moreira','hotelariamoreira@gmail.com','(54) 99968-4279',NULL,NULL,NULL,'1969-12-31','25',1533),(1553,'CTG','RANCHO VELHO',92871086000146,'Rodinei Forlin','rudi.cacique@hotmail.com','(54) 99945-9772',NULL,NULL,NULL,'1992-08-02','25',1553),(1569,'CTG','ALDEIA FARROUPILHA',92865732000162,'Ataide Tadeu Flores Pereira','atamaris2010@hotmail.com','(54) 99659-4804',NULL,NULL,NULL,'1969-12-31','25',1569),(1570,'CTG','RELIQUIAS DE GAÚCHO ',0,'Santo de Castilhos Homem',' shomem@camaracaxias.rs.gov.br','(54) 991643323',NULL,NULL,NULL,'1992-10-05','25',1570),(1583,'CTG','ANDANÇA SERRANA ',92892084000171,'Rovaldino de Assis Godinho',' godinho.rovaldino@gmail.com','(54) 997097407',NULL,NULL,NULL,'1969-12-31','25',1583),(1664,'CTG','ESPORA PRATEADA',86733961000120,'Manoel dos Passos de Souza','clebercosta850@gmail.com','(54) 984066044',NULL,NULL,NULL,'1992-12-09','25',1664),(1665,'CTG','TIO CARLO',188668000104,'Luiz Vanderlei Ferreira dos Reis','hwluisf@gmail.com','(54)981213882',NULL,NULL,NULL,'1994-06-04','25',1665),(1684,'CTG','CHEGANDO NO RANCHO ',135920000117,'Manoel  Adão Siqueira Borges','manoeladaob@gmail.com','(54) 99631-8334',NULL,NULL,NULL,'1969-12-31','25',1684),(1685,'CTG','AMIGOS DO LAÇO',23392307000180,'Maicon Zuanazzi','maanrepresentacoes@hotmail.com','(54) 991223812',NULL,NULL,NULL,'2006-06-10','25',1685),(1711,'CTG','RAÍZES DO RIO GRANDE',473146000154,'Marcos Antonio Ganzer','andreiacganzer@yahoo.com.br','(54)996034618',NULL,NULL,NULL,'1969-12-31','25',1711),(1713,'CTG','ANGELO FRANCISCO GUERRA',92870542000133,'Leandro Teles de Souza',' leandrotsouza0@gmail.com','(54) 981131934',NULL,NULL,NULL,'1995-01-07','25',1713),(1743,'CTG','RINCÃO SERRANO',10537079000148,'Alcir dos Santos','lbraconstrucoes@gmail.com','(54) 999964782',NULL,NULL,NULL,'1995-05-10','25',1743),(1788,'CTG','ESTÂNCIA ALEGRIA',1553355000170,'Jurandi Baldasso',' jbjin@terra.com.br','(54) 999712824',NULL,NULL,NULL,'1996-06-01','25',1788),(1789,'CTG','ALMA SERRANA',1309652000175,'Luis Deoclecio Teles Ferreira','','(54) 981374105',NULL,NULL,NULL,'1969-12-31','25',1789),(1790,'CTG','PARQUE DE RODEIOS VILA OLIVA',1309658000142,'Adilson Emerich Marques','adilsonemarques@hotmail.com','(54)  996993499',NULL,NULL,NULL,'1995-07-10','25',1790),(1791,'CTG','MARCA DA TERRA',7748263000122,'Ilso Buffon','oficinamecanicabuffon@hotmail.com','(54) 99978-1603',NULL,NULL,NULL,'1969-12-31','25',1791),(1800,'CTG','ENTREVERO DE AMIGOS',9088438000148,'Luis Carlos da Silva','','(54) 996056501',NULL,NULL,NULL,'1969-12-31','25',1800),(1837,'CTG','PONCHO SERRANO',1676715000121,'Jose Nereu da Silva','nereu.silva11@gmail.com','(54) 999981467',NULL,NULL,NULL,'1996-03-03','25',1837),(1880,'CTG','TAURAS DO LAÇO',2105545000198,'Crineu Lopes Pereira','neuzoautomoveis@bol.com.br','(54) 999712419',NULL,NULL,NULL,'1969-12-31','25',1880),(1899,'CTG','QUERÊNCIA DE SÃO PEDRO',2611456000113,'Alisson Fernandes Schmidt','alisson.schmidt01@gmail.com','(54) 99188-5539',NULL,NULL,NULL,'1969-12-31','25',1899),(1934,'CTG','VOVÔ JOÃO SCAIN',3384662000109,'Gabriel Machado Rodrigues','gabrielmachado.rodrigues@hotmail.com','(54) 99657-3603',NULL,NULL,NULL,'1969-12-31','25',1934),(1935,'CTG','QUERÊNCIA DA SERRA',3369517000140,'Clovis Danei Alves da Silva','clovisdasilva@metalurgicoscaxias.com.br','(54)991216274',NULL,NULL,NULL,'1999-03-07','25',1935),(1936,'CTG','CORAÇÃO SERRANO',3249811000119,'Neimar de Campos','','(54) 99989-4245',NULL,NULL,NULL,'1999-04-06','25',1936),(1954,'CTG','MARCA DA SERRA',3513917000188,'Leandro Alves Borba','','(54) 996749953',NULL,NULL,NULL,'1969-12-31','25',1954),(1978,'PL','UNIDOS PELA TRADIÇÃO ',4147209000133,'Jose Amilcar Wollmann','','(54) 996277650',NULL,NULL,NULL,'1969-12-31','25',1978),(1990,'CTG','CAPÃO DO VENTO',3430396000103,'Alison de Medeiros Friso',' alisonfriso@hotmail.com','(54) 999792876',NULL,NULL,NULL,'1969-12-31','25',1990),(1992,'CTG','HERANÇA GAUDÉRIA',8715747000138,'','','',NULL,NULL,NULL,'1999-03-12','25',1992),(1999,'CTG','VELHO MATEUS',4413327000146,'João Trindade','','(54) 999711786',NULL,NULL,NULL,'1969-12-31','25',1999),(2000,'CTG','OS AMIGOS DO RIO GRANDE',8618842000113,'Antonio dos Santos Paulino','','(54) 999235401',NULL,NULL,NULL,'1969-12-31','25',2000),(2006,'PL','OS TAURAS DA QUERÊNCIA',3726407000199,'Valdir Teles de Vargas ','ajnrepresentacoes@gmail.com','(54) 999726496',NULL,NULL,NULL,'1969-12-31','25',2006),(2010,'CTG','ARUÁ',22368999000169,'Jose Enor Andrade de Oliveira','joseenorao@hotmail.com','(54) 991733914',NULL,NULL,NULL,'1969-12-31','25',2010),(2056,'CTG','ESTANCIEIROS DO LAÇO',4741970000107,'Eloi de Fatima Lima Mattos','eloimattos03@gmail.com','(54) 996811834',NULL,NULL,NULL,'1969-12-31','25',2056),(2057,'CTG','TIO DANILO',4636679000160,'Carlos Alberto da Silva','esquadriasadani@gmail.com','(54)  98447-7522',NULL,NULL,NULL,'1969-12-31','25',2057),(2065,' ','QUERÊNCIA DA POESIA XUCRA',0,'Arno Moscato dos Santos','tchemoscato@hotmail.com','(54)999123237',NULL,NULL,NULL,'1969-12-31','25',2065),(2085,'CTG','VOVÔ LISBOA',5137129000160,'Ernesto Antonio de Almeida Lisboa','kamilagl@terra.com.br','(54) 999733499',NULL,NULL,NULL,'1969-12-31','25',2085),(2090,'CTG','HONEYDE BERTUSSI ',0,'FRANCISCO VILMAR RODRIGUES','','54-99735784',NULL,NULL,NULL,'2000-06-12','25',2090),(2091,'CTG','MANGRULHOS DA SERRA',5179407000141,'Jose Saul Radatz','jose-saul.radataz@gmail.com','(54) 996355244',NULL,NULL,NULL,'2002-05-07','25',2091),(2110,'CTG','AMIGOS DA TRADIÇÃO',5108318000104,'Manoel Luiz Almeida dos Santos','manoelbaraunanana@gmail.com','(54) 999885124',NULL,NULL,NULL,'2002-05-01','25',2110),(2111,'CTG','SINUELO',89281323000295,'Edilson Paulo Hoff','edilsonhoff2214@gmail.com','(54) 99156-4140',NULL,NULL,NULL,'1969-12-31','25',2111),(2238,'CTG','ILHAPA DO RIO GRANDE',8275585000164,'Paulo Renato Ferreira','pauloferreira339@gmail.com','(54) 984036320',NULL,NULL,NULL,'1969-12-31','25',2238),(2339,'PL','QUERÊNCIA FARROUPILHA',0,'ADILSO JOÃO MOLON','','54-99712700',NULL,NULL,NULL,'1969-12-31','25',2339),(2340,'CTG','RECANTO GAÚCHO',9129136000170,'Marcos Sonda','marcossonda@hotmail.com','(54) 98109-4767',NULL,NULL,NULL,'1969-12-31','25',2340),(2341,'PL','HERDEIROS DO PAMPA',9083042000108,'Assis Finger',' assisfinger2@gmail.com','(54) 999867121',NULL,NULL,NULL,'1969-12-31','25',2341),(2453,'PL','ESTÂNCIA DA AMIZADE',10524277000177,'Luiz Carlos Carneiro de Melo','kriativa.transportes@yahoo.com.br','(54) 991956301',NULL,NULL,NULL,'2008-02-07','25',2453),(2564,'PL','RINCÃO DOS LIRAS',11849863000154,'Sergio Adriano Lopes Dias','lopesadri50@gmail.com','(54) 99243-6541',NULL,NULL,NULL,'1969-12-31','25',2564),(2567,'PL','COXILHA SERRANA',11807440000171,'Joel Gomes Santos',' joeldoesplanada@hotmail.com','(54) 999702558',NULL,NULL,NULL,'1969-12-31','25',2567),(2572,'PL','PRESILHA DA AMIZADE',12340715000172,'Evaldo Blauth','evaldoblauth@yahoo.com.br','(54) 99652-3424',NULL,NULL,NULL,'1969-12-31','25',2572),(2576,'PL','MARCA GAÚCHA',19468000000149,'Flavio Lauri Becher Gil','flaviogil@gilecarneiro.com.br','(54) 999782639',NULL,NULL,NULL,'2011-10-05','25',2576),(2589,'CTG','RONCO DO BUGIO',14039284000134,'Claudeci Leite da Silva','','(54) 99933-2907',NULL,NULL,NULL,'2011-12-07','25',2589),(2622,'PL','HERANÇA DO MEU AVÔ',15274428000108,'Dinolva Almeida Dias',' douglas07dias@gmail.com','(54)  996887712',NULL,NULL,NULL,'1969-12-31','25',2622),(2644,'PL','ENCONTRO DE AMIGOS',17321322000135,'Antonio Fermiano Alves','eduaradadaros@gmail.com','(54) 999349515',NULL,NULL,NULL,'1969-12-31','25',2644),(2646,'CTG','VELHO TROPEIRO SERRANO',17139935000156,'Vanderlei Bresolin','luana-dartora@hotmail.com','(54) 9 9947-3410',NULL,NULL,NULL,'2012-05-05','25',2646),(2692,'PL','GAÚCHOS DA SERRA',19231436000110,'Igor Moreira Santos','nani19boeira@hotmail.com','(54) 996194615',NULL,NULL,NULL,'2013-10-09','25',2692),(2693,'PQT','CHEGANDO NA QUERÊNCIA',10607673000168,'Claudiomar Ribeiro de Andrade','claudiomarandrade01@gmail.com','(54) 98400-8297',NULL,NULL,NULL,'1969-12-31','25',2693),(2694,'PL','TROPILHA DA AMIZADE',19330974000161,'João Rodrigues Francisco dos Passos','','(54) 999773403',NULL,NULL,NULL,'1969-12-31','25',2694),(2705,'CTG','LAÇO EM FAMILIA',19757670000185,'Aldoir Lira de Barros','aldoirzorrinho@hotmail.com','(54) 991136716/999422491',NULL,NULL,NULL,'2014-12-02','25',2705),(2707,'PL','GARRÃO DE POTRO',20538411000142,'Max Leandro dos Santos Fernandes','max.fernandez777@gmail.com','(54) 999487702',NULL,NULL,NULL,'1969-12-31','25',2707),(2711,'PL','VOVÔ AGOSTINHO TONELLA',20814945000154,'Arnos Jose Tonella','tatikieling@hotmail.com','(54) 999941290',NULL,NULL,NULL,'1969-12-31','25',2711),(2735,'PL','20 DE SETEMBRO',20898092000186,'Jorge Valderez dos Passos','','(54) 996055148',NULL,NULL,NULL,'1969-12-31','25',2735),(2744,'PL','VOVÔ NATALÍCIO',20265395000161,'Antonio Ferreira de Andrade','','(54) 999686847',NULL,NULL,NULL,'1969-12-31','25',2744),(2747,'CTG','RANCHO DE ESPERANÇA',22033750000100,'Paulo dos Santos de Andrade','paulodossdandrade@gmail.com','(54) 99997-3576',NULL,NULL,NULL,'2015-07-02','25',2747),(2758,'PL','TROPEIROS DO PAMPA',23524693000117,'Paulo Cesar da Silva','','(54) 996504328',NULL,NULL,NULL,'1969-12-31','25',2758),(2833,'CTG','GALPÃO CRIOULO',35111085000160,'Valmor Pesini','deniseferreira625@gmail.com','(54) 999735782',NULL,NULL,NULL,'1999-12-10','25',2833);
/*!40000 ALTER TABLE `entidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evento` (
  `evento_id` int(5) NOT NULL COMMENT 'Chave Primária',
  `entidade_id` int(5) NOT NULL COMMENT 'Entidade Promotora',
  `titulo_evento` varchar(100) NOT NULL COMMENT 'Nome d0 Evento',
  `info_complementar` text DEFAULT NULL COMMENT 'Informações Complementares do Evento',
  `data_evento` date NOT NULL COMMENT 'Data Oficial do Evento',
  `data_inicio_inscri` datetime DEFAULT NULL COMMENT 'Data Inicial Inscrições',
  `data_final_inscri` datetime DEFAULT NULL COMMENT 'Data Final para Inscrições',
  `data_base_calculo_idade` date DEFAULT NULL COMMENT 'Data base para cálculo idade inscritos',
  PRIMARY KEY (`evento_id`),
  KEY `evento_FK` (`entidade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Cadastro de Eventos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `img_evento`
--

DROP TABLE IF EXISTS `img_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `img_evento` (
  `img_evento_id` int(5) NOT NULL,
  `img_seq` int(2) NOT NULL,
  `imagem` blob DEFAULT NULL,
  PRIMARY KEY (`img_evento_id`,`img_seq`),
  CONSTRAINT `img_evento_FK` FOREIGN KEY (`img_evento_id`) REFERENCES `evento` (`evento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Imagens Associadas ao Evento';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `img_evento`
--

LOCK TABLES `img_evento` WRITE;
/*!40000 ALTER TABLE `img_evento` DISABLE KEYS */;
/*!40000 ALTER TABLE `img_evento` ENABLE KEYS */;
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
  CONSTRAINT `invernadas_FK` FOREIGN KEY (`tipo_invernada`) REFERENCES `tipo_invernada` (`tipo`)
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
-- Table structure for table `modalidades`
--

DROP TABLE IF EXISTS `modalidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modalidades` (
  `mod_id` int(3) NOT NULL AUTO_INCREMENT,
  `descri` varchar(50) NOT NULL,
  `tipo` enum('I','G') NOT NULL,
  PRIMARY KEY (`mod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modalidades`
--

LOCK TABLES `modalidades` WRITE;
/*!40000 ALTER TABLE `modalidades` DISABLE KEYS */;
INSERT INTO `modalidades` VALUES (1,'Trova Mi Maior de Gavetão','I'),(2,'Trova de Martelo','I'),(3,'Declamação Prenda Mirim','I'),(4,'Declamação Peão Mirim','I'),(5,'Declamação Peão Juvenil','I'),(6,'Declamação Prenda Veterana','I'),(7,'Declamação Peão Veterano','I'),(8,'Declamação Prenda Adulta','I'),(9,'Declamação Peão Adulto','I'),(10,'Interprete Vocal Prenda Mirim','I'),(11,'Interprete Vocal Peão Mirim','I'),(12,'Interprete Vocal Prenda Juvenil','I'),(13,'Interprete Vocal  Peão Juvenil','I'),(14,'Interprete Vocal Prenda Adulta','I'),(15,'Interprete Vocal Peão Adulto','I'),(16,'Interprete Vocal Prenda Veterana','I'),(17,'Interprete Vocal Peão Veterano','I'),(18,'Gaita Ponto até 15 Anos','I'),(19,'Gaita Ponto Acima de 15 Anos','I'),(20,'Gaita Piano até 15 Anos','I'),(21,'Gaita Piano Acima de 15 Anos','I'),(22,'Chula Mirim','I'),(23,'Chula Juvenil','I'),(24,'Chula Veterano','I'),(25,'Chula Xirú','I'),(26,'Chula Adulto','I'),(27,'Danças Tradicionais Pré-Mirim','G'),(28,'Danças Tradicionais Mirim','G'),(29,'Danças Tradicionais Juvenil','G'),(30,'Danças Tradicionais Adulto','G'),(31,'Danças Tradicionais Veterano','G'),(32,'Danças Tradicionais Xirú','G'),(33,'Danças Biritas do Tropeirismo','G'),(34,'Chula Dupla','G'),(35,'Chula Trio','G'),(36,'Chula Quarteto','G');
/*!40000 ALTER TABLE `modalidades` ENABLE KEYS */;
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
  `cpf` decimal(11,0) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `id_altera` int(5) DEFAULT NULL,
  `data_altera` datetime DEFAULT NULL,
  PRIMARY KEY (`pessoa_id`),
  UNIQUE KEY `pessoas_UN` (`cpf`),
  KEY `pessoas_FK` (`entidade`),
  KEY `pessoas_FK_1` (`id_altera`),
  CONSTRAINT `pessoas_FK` FOREIGN KEY (`entidade`) REFERENCES `entidade` (`entidade_id`),
  CONSTRAINT `pessoas_FK_1` FOREIGN KEY (`id_altera`) REFERENCES `adm_usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoas`
--

LOCK TABLES `pessoas` WRITE;
/*!40000 ALTER TABLE `pessoas` DISABLE KEYS */;
INSERT INTO `pessoas` VALUES (1,'Joao Goulart','1956-12-28','M',1,'Pendente','2045-12-31',21577161904,'joao_goulart@jgoulart.eti.br',1,'2023-03-17 15:23:24'),(2,'Jose da Silva','1954-08-20','M',1,'','0000-00-00',0,'goulart.joao@gmail.com',1,'2023-03-17 15:40:37');
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
  `NULL` varchar(50) DEFAULT NULL,
  `Trova Gildo de Freitas` varchar(50) DEFAULT NULL,
  `I` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Tipos de Invernada';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_invernada`
--

LOCK TABLES `tipo_invernada` WRITE;
/*!40000 ALTER TABLE `tipo_invernada` DISABLE KEYS */;
INSERT INTO `tipo_invernada` VALUES (1,'Mirim',NULL,NULL,NULL),(2,'Juvenil',NULL,NULL,NULL),(3,'Adulto',NULL,NULL,NULL),(4,'Veterano',NULL,NULL,NULL);
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

-- Dump completed on 2023-03-27 22:24:40
