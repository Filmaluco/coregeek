CREATE DATABASE `CoreGeek_DevDB` CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- ######################################################
-- ################     TYPE TABLES      ################
-- ######################################################

CREATE TABLE `CoreGeek_DevDB`.`Repair_Types` ( 
    `Type_ID`      INT(11) UNSIGNED     NOT NULL  AUTO_INCREMENT  COMMENT 'PK Type of reparation ID' ,
    `Name`         VARCHAR(32)          NOT NULL                  COMMENT 'Designation of the reparation',
    
    PRIMARY KEY (`Type_ID`)
) ENGINE = InnoDB COMMENT = 'Type of the reparation';

CREATE TABLE `CoreGeek_DevDB`.`Repair_State` ( 
    `State_ID`      INT(11) UNSIGNED     NOT NULL  AUTO_INCREMENT  COMMENT 'PK State of reparation ID' ,
    `Name`         VARCHAR(32)          NOT NULL                  COMMENT 'Designation of the state',
    
    PRIMARY KEY (`State_ID`)
) ENGINE = InnoDB COMMENT = 'State of the reparation';

-- ######################################################
-- ################     CORE TABLES      ################
-- ######################################################
--
-- ##################### STORES TABLE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`Stores` ( 
    `Store_ID`      INT(11) UNSIGNED     NOT NULL  AUTO_INCREMENT  COMMENT 'PK Store Identification' ,
    `Name`          VARCHAR(32)          NOT NULL                  COMMENT 'Name of the store',
    `Manager`       VARCHAR(32)          NOT NULL                  COMMENT 'Name of the person in charge',
    `Email`         VARCHAR(32)          NULL                      COMMENT 'Email of the store',
    `Phone`         INT(12) UNSIGNED     NULL                      COMMENT 'Store contact',
    `Location`      TEXT                                           COMMENT 'Store location',
    
    PRIMARY KEY (`Store_ID`)
) ENGINE = InnoDB COMMENT = 'Stores related data';
ALTER TABLE `CoreGeek_DevDB`.`Stores` AUTO_INCREMENT=1;

--
-- ##################### USERS TABLE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`Users` ( 
    `User_ID`       INT(11) UNSIGNED      NOT NULL   AUTO_INCREMENT  COMMENT 'PK User Identification' , 
    `Store_ID`      INT(11) UNSIGNED      NULL       DEFAULT NULL    COMMENT 'FK -> Store Identification' , 
    `Username`      VARCHAR(32)           NOT NULL                   COMMENT 'Username' , 
    `Password`      VARCHAR(255)          NOT NULL                   COMMENT 'Password' , 
    
    PRIMARY KEY (`User_ID`),
    FOREIGN KEY (`Store_ID`) REFERENCES `CoreGeek_DevDB`.`Stores`(`Store_ID`)
) ENGINE = InnoDB COMMENT = 'Main information about the Users';
ALTER TABLE `CoreGeek_DevDB`.`Users` AUTO_INCREMENT=1;

--
-- ##################### USER TOKENS TABLE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`UserTokens`(
    `Token_Key`      VARCHAR(255)           NOT NULL                   COMMENT 'PK AcessToken',
    `User_ID`       int(11) UNSIGNED       NOT NULL                   COMMENT 'Token belongs to User',
    `Name`          VARCHAR(32)             NULL                      COMMENT 'Token info',
    `Creation_Date`  DATETIME               NOT NULL  DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation of the token',
    `Status`        TINYINT(1)             NOT NULL  DEFAULT 1        COMMENT 'Token valid',

    PRIMARY KEY (`Token_Key`),
    FOREIGN KEY (`User_ID`) REFERENCES `CoreGeek_DevDB`.`Users`(`User_ID`)
) ENGINE = InnoDB COMMENT = 'Acess tokens data';


--
-- ##################### NOTIFICATIONs TABLE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`Notifications` ( 
    `Notification_ID`   INT(11) UNSIGNED    NOT NULL  AUTO_INCREMENT            COMMENT 'PK Identification',
    `Message`           TEXT                NOT NULL                            COMMENT 'Content of the Notification',
    `Creation_Date`     DATETIME            NOT NULL  DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation of the notification',
    `Expiration_Date`   DATETIME            NULL      DEFAULT NULL              COMMENT 'Create a time limit for the notification',
    
    PRIMARY KEY(`Notification_ID`)
) ENGINE = InnoDB COMMENT = 'Notifications table';
ALTER TABLE `CoreGeek_DevDB`.`Notifications` AUTO_INCREMENT=1;

--
-- ##################### CLIENTS TABLE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`Clients` ( 
    `Client_ID`   INT(11) UNSIGNED    NOT NULL  AUTO_INCREMENT  COMMENT 'PK Clients',
    `Name`        VARCHAR(32)         NOT NULL                  COMMENT 'Client Name',
    `Phone`       INT(12) UNSIGNED    NULL                      COMMENT 'Client cellphone number',
    `Email`       VARCHAR(32)         NOT NULL                  COMMENT 'Email for contract',
    `Obs`         TEXT                NULL                      COMMENT 'Client observations',

    PRIMARY KEY(`Client_ID`)
) ENGINE = InnoDB COMMENT = 'Clients table';
ALTER TABLE `CoreGeek_DevDB`.`Clients` AUTO_INCREMENT=1; 

--
-- ##################### EVALUATIONS TABLE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`ORs`(
    `OR_ID`             INT(11)     UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'PK EvaluationID',
    `Client_ID`         INT(11)     UNSIGNED NOT NULL                COMMENT 'FK -> Clientes',
    `Type_ID`           INT(11)     UNSIGNED NOT NULL                COMMENT 'FK -> Repair_Types',
    `Conditions_Read`   TINYINT(1)  UNSIGNED     NULL DEFAULT 0      COMMENT 'Terms and Conditions',
    `Read_on_Date`      DATETIME                 NULL DEFAULT NULL   COMMENT 'Date the Client clicked Accept',

    PRIMARY KEY(`OR_ID`),
    FOREIGN KEY(`Client_ID`) REFERENCES `CoreGeek_DevDB`.`Clients`(`Client_ID`),
    FOREIGN KEY(`Type_ID`) REFERENCES `CoreGeek_DevDB`.`Repair_Types`(`Type_ID`)
)ENGINE = InnoDB COMMENT = 'ORs Table';
ALTER TABLE  `CoreGeek_DevDB`.`ORs` AUTO_INCREMENT=3000;

--
-- ##################### REPAIRS TABLE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`Repair_Info` ( 
    `Repair_ID`   INT(11) UNSIGNED    NOT NULL  AUTO_INCREMENT              COMMENT 'PK Clients',
    `OR_ID`       INT(11) UNSIGNED    NOT NULL                              COMMENT 'FK -> Evaluation',
    `User_ID`     INT(11) UNSIGNED    NOT NULL                              COMMENT 'FK -> Users',
    `Creation_Date` DATETIME          NOT NULL  DEFAULT CURRENT_TIMESTAMP   COMMENT 'Creation of the info',
    `Schedule_To_Date` DATETIME       NULL      DEFAULT NULL                COMMENT 'Promised delivered date',
    `Device`     VARCHAR(32)          NOT NULL                              COMMENT 'Type of device (phone,etc...)',
    `Brand`      VARCHAR(32)          NOT NULL                              COMMENT 'Brand of the device',
    `Model`      VARCHAR(32)          NOT NULL                              COMMENT 'Model of device',
    `Color`      VARCHAR(32)          NOT NULL                              COMMENT 'Color of the device',
    `Unlock_Code`VARCHAR(32)          NULL      DEFAULT NULL                COMMENT 'Unlock code if it has one',
    `Acessories` VARCHAR(64)          NULL      DEFAULT 'S/ Acessorios'     COMMENT 'Acessories brought with phone',
    `Desc`       TEXT                 NULL                                  COMMENT 'Description of the device',
    `Obs`        TEXT                 NULL                                  COMMENT 'Obs about the repair',
    `Price`      FLOAT  UNSIGNED      NULL      DEFAULT '0'                 COMMENT 'Price given to the client',
 
    PRIMARY KEY(`Repair_ID`),
    FOREIGN KEY(`OR_ID`) REFERENCES `CoreGeek_DevDB`.`ORs`(`OR_ID`),
    FOREIGN KEY(`User_ID`) REFERENCES `CoreGeek_DevDB`.`Users`(`User_ID`)
) ENGINE = InnoDB COMMENT = 'Repairs (Versions) table';
ALTER TABLE  `CoreGeek_DevDB`.`Repair_Info` AUTO_INCREMENT=1; 

--
-- ##################### PERMISSIONS TABLE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`Permissions` (
    `Permission_ID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'PK PermissionID',
    `Name`          VARCHAR(32) NOT NULL                     COMMENT 'Permission Designation',

    PRIMARY KEY(`Permission_ID`)
)ENGINE = InnoDB COMMENT = 'Permissions Table';
ALTER TABLE `CoreGeek_DevDB`.`Permissions` AUTO_INCREMENT = 1;

--
-- ##################### GROUPS TABLE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`Groups` (
    `Group_ID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'PK Group ID',
    `Name`          VARCHAR(32) NOT NULL                     COMMENT 'Group name',

    PRIMARY KEY(`Group_ID`)
)ENGINE = InnoDB COMMENT 'Groups Table';
ALTER TABLE `CoreGeek_DevDB`.`Groups` AUTO_INCREMENT = 1;


-- ######################################################
-- ################ RELATIONSHIPS TABLES ################
-- ######################################################

--
-- ##################### USER NOTIFICATIONs TABLE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`UserNotifications` (
    `Notification_ID` INT(11) UNSIGNED    NOT NULL              COMMENT 'FK -> Notifications ID',
    `User_ID`         INT(11) UNSIGNED    NOT NULL              COMMENT 'FK -> Users ID',
    `Seen`            TINYINT(1)          NOT NULL   DEFAULT 0  COMMENT 'Was the notification seen',
    
    FOREIGN KEY (`User_ID`) REFERENCES `CoreGeek_DevDB`.`Users`(`User_ID`),
    FOREIGN KEY (`Notification_ID`) REFERENCES `CoreGeek_DevDB`.`Notifications`(`Notification_ID`)
) ENGINE = InnoDB COMMENT = 'Users and Notifications relationship table';

--
-- ##################### USERS GROUPS TABLE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`UserGroups`(
    `User_ID` INT(11)  UNSIGNED     NOT NULL    COMMENT 'FK -> Users',
    `Group_ID` INT(11) UNSIGNED     NOT NULL    COMMENT 'FK -> Groups',

    FOREIGN KEY (`User_ID`) REFERENCES `CoreGeek_DevDB`.`Users`(`User_ID`),
    FOREIGN KEY (`Group_ID`) REFERENCES `CoreGeek_DevDB`.`Groups`(`Group_ID`)
) ENGINE = InnoDB COMMENT = 'Users and Groups relationship table';

--
-- ##################### GROUPS PERMISIONS TABLE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`GroupPermissions`(
    `Permission_ID` INT(11) UNSIGNED     NOT NULL    COMMENT 'FK -> Permissions',
    `Group_ID` INT(11) UNSIGNED          NOT NULL    COMMENT 'FK -> Groups',

    FOREIGN KEY (`Permission_ID`) REFERENCES `CoreGeek_DevDB`.`Permissions`(`Permission_ID`),
    FOREIGN KEY (`Group_ID`) REFERENCES `CoreGeek_DevDB`.`Groups`(`Group_ID`)
) ENGINE = InnoDB COMMENT = 'Groups and Permissions relationship table';


--
-- ##################### EVALUATION STATE TABLE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`ORState`(
  `OR_ID`           INT(11) UNSIGNED NOT NULL COMMENT 'FK -> ORs',
  `State_ID`        INT(11) UNSIGNED NOT NULL COMMENT 'FK -> Repair_State',
  `User_ID`         INT(11) UNSIGNED NOT NULL COMMENT 'FK -> Users',
  `Creation_Date`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Alteration done in',

  FOREIGN KEY(`OR_ID`) REFERENCES `CoreGeek_DevDB`.`ORs`(`OR_ID`),
  FOREIGN KEY(`State_ID`) REFERENCES `CoreGeek_DevDB`.`Repair_State`(`State_ID`),
  FOREIGN KEY(`User_ID`) REFERENCES `CoreGeek_DevDB`.`Users`(`User_ID`)  
)ENGINE = InnoDB COMMENT = 'Keeping track of the or state';

--
-- ##################### PERMISIONS OVERRIDE ###########################
--

CREATE TABLE `CoreGeek_DevDB`.`Override_UserPermissions`(
    `User_ID`       INT(11) UNSIGNED NOT NULL COMMENT 'FK -> Users',
    `Permission_ID` INT(11) UNSIGNED NOT NULL COMMENT 'FK -> Permissions',
    `Status`        TINYINT(1)       NOT NULL COMMENT '1 - Granted / 0 - Denied',

    FOREIGN KEY(`User_ID`) REFERENCES `CoreGeek_DevDB`.`Users`(`User_ID`),
    FOREIGN KEY(`Permission_ID`) REFERENCES `CoreGeek_DevDB`.`Permissions`(`Permission_ID`)
)ENGINE = InnoDB COMMENT = 'Overriding permissions table';

-- ###########################################################################################
-- DUMMY VALUES 
-- ###########################################################################################

-- Dummy Store
INSERT INTO `CoreGeek_DevDB`.`Stores` (
    `Store_ID`, 
    `Name`, 
    `Manager`, 
    `Email`, 
    `Phone`, 
    `Location`) VALUES (
        NULL, 
        'CoreGeek', 
        'AndrePaixao / DiogoFernandes', 
        'geral@coregeek.pt', 
        '911599651', 'R DOM LUÍS DA CUNHA LOTE 27 1ºESQ., 3030-302, SANTO ANTONIO OLIVAIS COIMBRA, COIMBRA');

-- Dummy User
INSERT INTO `CoreGeek_DevDB`.`Users` (
    `User_ID`, 
    `Store_ID`, 
    `Username`, 
    `Password`) VALUES (
        NULL, 
        '1', 
        'CoreGeek', 
        '$2y$10$oIMvNyETPTBb0b6Mb5fapex.vtcvY1pxD4fDSWfTatTdA5tpENLsW');

-- Dummy Group
INSERT INTO `CoreGeek_DevDB`.`Groups` (
    `Group_ID`, 
    `Name`) VALUES 
    (NULL, 'Admin'),
    (NULL, 'Funcionario');

-- Dummy User-Group
INSERT INTO `CoreGeek_DevDB`.`UserGroups` 
    (`User_ID`, 
    `Group_ID`) 
        VALUES ('1', '1');

-- Dummy Permissions
INSERT INTO `CoreGeek_DevDB`.`Permissions` (
    `Permission_ID`,
    `Name`) VALUES 
        (NULL, '*'), 
        (NULL, 'View'), 
        (NULL, 'Add'), 
        (NULL, 'Edit');

-- Give Dummy group ALL Permissions
INSERT INTO `CoreGeek_DevDB`.`GroupPermissions` (
    `Permission_ID`,
    `Group_ID`) VALUES
        ('1', '1'), 
        ('2', '1'), 
        ('3', '1'), 
        ('4', '1'),
        ('2', '2');
    
-- Override Dummy User permission to * (deny)
INSERT INTO `CoreGeek_DevDB`.`Override_UserPermissions` (
    `User_ID`, 
    `Permission_ID`, 
    `Status`) VALUES (
        '1', 
        '1', 
        '0');

-- Dummy Welcome Message
INSERT INTO `CoreGeek_DevDB`.`Notifications` (
    `Notification_ID`, 
    `Message`, 
    `Creation_Date`, 
    `Expiration_Date`) VALUES (
        NULL, 
        'Welcome to CoreGeek.pt', 
        CURRENT_TIMESTAMP, 
        NULL); 

-- Welcome Message for Dummy User
INSERT INTO `CoreGeek_DevDB`.`UserNotifications` (
    `Notification_ID`, 
    `User_ID`, 
    `Seen`) VALUES (
        '1', 
        '1', 
        '0');

-- Dummy Client

INSERT INTO `CoreGeek_DevDB`.`Clients` (
    `Client_ID`, 
    `Name`, 
    `Phone`, 
    `Email`, 
    `Obs`) VALUES (
        NULL, 
        'John Doe', 
        NULL, 
        'johndoe@dummy.com', 
        'Dummy Client'); 

-- Dummy Repair Types
INSERT INTO `CoreGeek_DevDB`.`Repair_Types` (
    `Type_ID`, 
    `Name`) VALUES 
        (NULL, 'Orçamentar'), 
        (NULL, 'Orçamentado'), 
        (NULL, 'Garantia'); 

-- Dummy Repair States
INSERT INTO `CoreGeek_DevDB`.`Repair_State` (
    `State_ID`,
    `Name` ) VALUES
        (NULL, 'Agendado'),
        (NULL, 'Recebido na Loja '),
        (NULL, 'Aguarda Confirmação (Termos e Condições)'),
        (NULL, 'Recebido em Laboratorio'),
        (NULL, 'Aguarda Orçamento'),
        (NULL, 'Aguarda Confirmação (Preço)'),
        (NULL, 'OR Recusado'),
        (NULL, 'Aguarda Stock'),
        (NULL, 'Em Reparação'),
        (NULL, 'Reparado '),
        (NULL, 'S/ Reparação'),
        (NULL, 'Reparado (Cliente Comunicado)'),
        (NULL, 'S/ Reparação (Cliente Comunicado)'),
        (NULL, 'Aguardar Levantamento'),
        (NULL, 'Entregue (Reparado)'),
        (NULL, 'Entregue (S/ Reparação)'),
        (NULL, 'Cancelado');

-- Dummy OR
INSERT INTO `CoreGeek_DevDB`.`ORs` (
    `OR_ID`, 
    `Client_ID`, 
    `Type_ID`) 
        VALUES 
            (NULL, '1', '1');

-- Dummy OR info1
INSERT INTO `CoreGeek_DevDB`.`Repair_Info` (
    `Repair_ID`, 
    `OR_ID`, 
    `User_ID`, 
    `Creation_Date`, 
    `Schedule_To_Date`, 
    `Device`, 
    `Brand`, 
    `Model`, 
    `Color`, 
    `Unlock_Code`, 
    `Acessories`, 
    `Desc`, 
    `Obs`, 
    `Price`) 
        VALUES 
            (NULL, '3000', '1', CURRENT_TIMESTAMP, NULL, 'Phone', 'Xiaomi', 'x4', 'Black', NULL, 'S/ Acessorios', 'original Repair Desc', 'original Repair Obs', '69.99'); 
        
-- Dummy OR states
INSERT INTO `CoreGeek_DevDB`.`ORState` (
    `OR_ID`, 
    `State_ID`, 
    `User_ID`, 
    `Creation_Date`) 
        VALUES 
            ('3000', '2', '1', CURRENT_TIMESTAMP), 
            ('3000', '3', '1', CURRENT_TIMESTAMP);

-- Dummy OR info2
INSERT INTO `CoreGeek_DevDB`.`Repair_Info` (
    `Repair_ID`, 
    `OR_ID`, 
    `User_ID`, 
    `Creation_Date`, 
    `Schedule_To_Date`, 
    `Device`, 
    `Brand`, 
    `Model`, 
    `Color`, 
    `Unlock_Code`, 
    `Acessories`, 
    `Desc`, 
    `Obs`, 
    `Price`) 
        VALUES 
            (NULL, '3000', '1', CURRENT_TIMESTAMP, NULL, 'Phone', 'Xiaomi', 'x4', 'White', NULL, 'S/ Acessorios', 'alteration Repair Desc', 'alteration Repair Obs', '49.99'); 