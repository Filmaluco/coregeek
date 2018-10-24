-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 21-Out-2018 às 23:13
-- Versão do servidor: 5.6.37
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Dashboard`
--
CREATE DATABASE IF NOT EXISTS `Dashboard` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `Dashboard`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Clients`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `Clients` (
  `Client_ID` int(11) unsigned NOT NULL COMMENT 'PK Clients',
  `Name` varchar(32) NOT NULL COMMENT 'Client Name',
  `Phone` int(12) unsigned DEFAULT NULL COMMENT 'Client cellphone number',
  `Email` varchar(32) NOT NULL COMMENT 'Email for contract',
  `Obs` text COMMENT 'Client observations'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Clients table';

--
-- Extraindo dados da tabela `Clients`
--

INSERT INTO `Clients` (`Client_ID`, `Name`, `Phone`, `Email`, `Obs`) VALUES
(1, 'John Doe', NULL, 'johndoe@dummy.com', 'Dummy Client');

-- --------------------------------------------------------

--
-- Estrutura da tabela `GroupPermissions`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `GroupPermissions` (
  `Permission_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Permissions',
  `Group_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Groups'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Groups and Permissions relationship table';

--
-- Extraindo dados da tabela `GroupPermissions`
--

INSERT INTO `GroupPermissions` (`Permission_ID`, `Group_ID`) VALUES
(1, 1),
(3, 1),
(4, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Groups`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `Groups` (
  `Group_ID` int(11) unsigned NOT NULL COMMENT 'PK Group ID',
  `Name` varchar(32) NOT NULL COMMENT 'Group name'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Groups Table';

--
-- Extraindo dados da tabela `Groups`
--

INSERT INTO `Groups` (`Group_ID`, `Name`) VALUES
(1, 'Admin'),
(2, 'Funcionario');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Notifications`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `Notifications` (
  `Notification_ID` int(11) unsigned NOT NULL COMMENT 'PK Identification',
  `Message` text NOT NULL COMMENT 'Content of the Notification',
  `Creation_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation of the notification',
  `Expiration_Date` datetime DEFAULT NULL COMMENT 'Create a time limit for the notification'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Notifications table';

--
-- Extraindo dados da tabela `Notifications`
--

INSERT INTO `Notifications` (`Notification_ID`, `Message`, `Creation_Date`, `Expiration_Date`) VALUES
(1, 'Welcome to CoreGeek.pt', '2018-10-10 22:11:53', NULL),
(8, 'Notification System Updated', '2018-10-21 17:57:27', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ORs`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `ORs` (
  `OR_ID` int(11) unsigned NOT NULL COMMENT 'PK EvaluationID',
  `Client_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Clientes',
  `Type_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Repair_Types',
  `Invoice_Number` int(11) unsigned DEFAULT '0' COMMENT 'Nr do orçamento',
  `Conditions_Read` tinyint(1) unsigned DEFAULT '0' COMMENT 'Terms and Conditions',
  `Read_on_Date` datetime DEFAULT NULL COMMENT 'Date the Client clicked Accept'
) ENGINE=InnoDB AUTO_INCREMENT=3001 DEFAULT CHARSET=latin1 COMMENT='ORs Table';

--
-- Extraindo dados da tabela `ORs`
--

INSERT INTO `ORs` (`OR_ID`, `Client_ID`, `Type_ID`, `Conditions_Read`, `Read_on_Date`) VALUES
(3000, 1, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `OR_State`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `OR_State` (
  `OR_ID` int(11) unsigned NOT NULL COMMENT 'FK -> ORs',
  `State_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Repair_State',
  `User_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Users',
  `Creation_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Alteration done in'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Keeping track of the or state';

--
-- Extraindo dados da tabela `OR_State`
--

INSERT INTO `OR_State` (`OR_ID`, `State_ID`, `User_ID`, `Creation_Date`) VALUES
(3000, 2, 1, '2018-10-10 22:11:53'),
(3000, 3, 1, '2018-10-10 22:11:53');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Rents`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `Rents` (
  `Rent_ID` int(11) unsigned NOT NULL COMMENT 'PK Rents',
  `OR_ID` int(11) unsigned NOT NULL COMMENT 'FK -> ORs',
  `State_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Rent_State',
  `Desc` text COMMENT 'Description of the device rented',
  `Acessories` varchar(64) DEFAULT 'S/ Acessorios' COMMENT 'Acessories rented with phone'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Rents Table';

--
-- Extraindo dados da tabela `Rents`
--

INSERT INTO `Rents` (`Rent_ID`,`OR_ID`, `State_ID`, `Desc`) VALUES
(1, 3001, 1, 'Noki7 (Android)');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Rent_State`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `Rent_State` (
  `State_ID` int(11) unsigned NOT NULL COMMENT 'PK State of Rent ID',
  `Name` varchar(32) NOT NULL COMMENT 'Designation of the state'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='State of the rent';

--
-- Extraindo dados da tabela `OR_State`
--

INSERT INTO `Rent_State` (`State_ID`, `Name`) VALUES
(1, 'Emprestado'),
(2, 'Entrege');


-- --------------------------------------------------------

--
-- Estrutura da tabela `Override_UserPermissions`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `Override_UserPermissions` (
  `User_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Users',
  `Permission_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Permissions',
  `Status` tinyint(1) NOT NULL COMMENT '1 - Granted / 0 - Denied'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Overriding permissions table';

-- --------------------------------------------------------

--
-- Estrutura da tabela `Permissions`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `Permissions` (
  `Permission_ID` int(11) unsigned NOT NULL COMMENT 'PK PermissionID',
  `Name` varchar(32) NOT NULL COMMENT 'Permission Designation'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='Permissions Table';

--
-- Extraindo dados da tabela `Permissions`
--

INSERT INTO `Permissions` (`Permission_ID`, `Name`) VALUES
(1, '*'),
(2, 'View'),
(3, 'Add'),
(4, 'Edit');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Repair_Info`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `Repair_Info` (
  `Repair_ID` int(11) unsigned NOT NULL COMMENT 'PK Clients',
  `OR_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Evaluation',
  `User_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Users',
  `Creation_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation of the info',
  `Schedule_To_Date` datetime DEFAULT NULL COMMENT 'Promised delivered date',
  `Device` varchar(32) NOT NULL COMMENT 'Type of device (phone,etc...)',
  `Brand` varchar(32) NOT NULL COMMENT 'Brand of the device',
  `Model` varchar(32) NOT NULL COMMENT 'Model of device',
  `Color` varchar(32) NOT NULL COMMENT 'Color of the device',
  `Unlock_Code` varchar(32) DEFAULT NULL COMMENT 'Unlock code if it has one',
  `Acessories` varchar(64) DEFAULT 'S/ Acessorios' COMMENT 'Acessories brought with phone',
  `Desc` text COMMENT 'Description of the device',
  `Obs` text COMMENT 'Obs about the repair',
  `Price` float unsigned DEFAULT '0' COMMENT 'Price given to the client'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Repairs (Versions) table';

--
-- Extraindo dados da tabela `Repair_Info`
--

INSERT INTO `Repair_Info` (`Repair_ID`, `OR_ID`, `User_ID`, `Creation_Date`, `Schedule_To_Date`, `Device`, `Brand`, `Model`, `Color`, `Unlock_Code`, `Acessories`, `Desc`, `Obs`, `Price`) VALUES
(1, 3000, 1, '2018-10-10 22:11:53', NULL, 'Phone', 'Xiaomi', 'x4', 'Black', NULL, 'S/ Acessorios', 'original Repair Desc', 'original Repair Obs', 69.99),
(2, 3000, 1, '2018-10-10 22:11:53', NULL, 'Phone', 'Xiaomi', 'x4', 'White', NULL, 'S/ Acessorios', 'alteration Repair Desc', 'alteration Repair Obs', 49.99);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Repair_State`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `Repair_State` (
  `State_ID` int(11) unsigned NOT NULL COMMENT 'PK State of reparation ID',
  `Name` varchar(32) NOT NULL COMMENT 'Designation of the state'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COMMENT='State of the reparation';

--
-- Extraindo dados da tabela `Repair_State`
--

INSERT INTO `Repair_State` (`State_ID`, `Name`) VALUES
(1, 'Agendado'),
(2, 'Recebido na Loja '),
(3, 'Aguarda Confirmação (Termos e Co'),
(4, 'Recebido em Laboratorio'),
(5, 'Aguarda Orçamento'),
(6, 'Aguarda Confirmação (Preço)'),
(7, 'OR Recusado'),
(8, 'Aguarda Stock'),
(9, 'Em Reparação'),
(10, 'Reparado '),
(11, 'S/ Reparação'),
(12, 'Reparado (Cliente Comunicado)'),
(13, 'S/ Reparação (Cliente Comunicado'),
(14, 'Aguardar Levantamento'),
(15, 'Entregue (Reparado)'),
(16, 'Entregue (S/ Reparação)'),
(17, 'Cancelado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Repair_Types`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `Repair_Types` (
  `Type_ID` int(11) unsigned NOT NULL COMMENT 'PK Type of reparation ID',
  `Name` varchar(32) NOT NULL COMMENT 'Designation of the reparation'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Type of the reparation';

--
-- Extraindo dados da tabela `Repair_Types`
--

INSERT INTO `Repair_Types` (`Type_ID`, `Name`) VALUES
(1, 'Orçamentar'),
(2, 'Orçamentado'),
(3, 'Garantia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Stores`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `Stores` (
  `Store_ID` int(11) unsigned NOT NULL COMMENT 'PK Store Identification',
  `Name` varchar(32) NOT NULL COMMENT 'Name of the store',
  `Manager` varchar(32) NOT NULL COMMENT 'Name of the person in charge',
  `Email` varchar(32) DEFAULT NULL COMMENT 'Email of the store',
  `Phone` int(12) unsigned DEFAULT NULL COMMENT 'Store contact',
  `Location` text COMMENT 'Store location'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Stores related data';

--
-- Extraindo dados da tabela `Stores`
--

INSERT INTO `Stores` (`Store_ID`, `Name`, `Manager`, `Email`, `Phone`, `Location`) VALUES
(1, 'CoreGeek', 'AndrePaixao / DiogoFernandes', 'geral@coregeek.pt', 911599651, 'R DOM LUÍS DA CUNHA LOTE 27 1ºESQ., 3030-302, SANTO ANTONIO OLIVAIS COIMBRA, COIMBRA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `UserGroups`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `UserGroups` (
  `User_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Users',
  `Group_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Groups'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Users and Groups relationship table';

--
-- Extraindo dados da tabela `UserGroups`
--

INSERT INTO `UserGroups` (`User_ID`, `Group_ID`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `UserNotifications`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `UserNotifications` (
  `Notification_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Notifications ID',
  `User_ID` int(11) unsigned NOT NULL COMMENT 'FK -> Users ID',
  `Seen` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Was the notification seen'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Users and Notifications relationship table';

--
-- Extraindo dados da tabela `UserNotifications`
--

INSERT INTO `UserNotifications` (`Notification_ID`, `User_ID`, `Seen`) VALUES
(1, 1, 0),
(8, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Users`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `Users` (
  `User_ID` int(11) unsigned NOT NULL COMMENT 'PK User Identification',
  `Store_ID` int(11) unsigned DEFAULT NULL COMMENT 'FK -> Store Identification',
  `Username` varchar(32) NOT NULL COMMENT 'Username',
  `Password` varchar(255) NOT NULL COMMENT 'Password'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Main information about the Users';

--
-- Extraindo dados da tabela `Users`
--

INSERT INTO `Users` (`User_ID`, `Store_ID`, `Username`, `Password`) VALUES
(1, 1, 'CoreGeek', '$2y$10$SkQeU9BwZ.MkAf5UXqsuseycgWeRs3v6DAhh8fhpvGRjzVjy.YzMG');

-- --------------------------------------------------------

--
-- Estrutura da tabela `UserTokens`
--
-- Criação: 10-Out-2018 às 21:11
--

CREATE TABLE IF NOT EXISTS `UserTokens` (
  `Token_Key` varchar(255) NOT NULL COMMENT 'PK AcessToken',
  `User_ID` int(11) unsigned NOT NULL COMMENT 'Token belongs to User',
  `Name` varchar(32) DEFAULT NULL COMMENT 'Token info',
  `Creation_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation of the token',
  `Status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Token valid'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Acess tokens data';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Clients`
--
ALTER TABLE `Clients`
  ADD PRIMARY KEY (`Client_ID`);

--
-- Indexes for table `GroupPermissions`
--
ALTER TABLE `GroupPermissions`
  ADD KEY `Permission_ID` (`Permission_ID`),
  ADD KEY `Group_ID` (`Group_ID`);

--
-- Indexes for table `Groups`
--
ALTER TABLE `Groups`
  ADD PRIMARY KEY (`Group_ID`);

--
-- Indexes for table `Notifications`
--
ALTER TABLE `Notifications`
  ADD PRIMARY KEY (`Notification_ID`);

--
-- Indexes for table `ORs`
--
ALTER TABLE `ORs`
  ADD PRIMARY KEY (`OR_ID`),
  ADD KEY `Client_ID` (`Client_ID`),
  ADD KEY `Type_ID` (`Type_ID`);

--
-- Indexes for table `OR_State`
--
ALTER TABLE `OR_State`
  ADD KEY `OR_ID` (`OR_ID`),
  ADD KEY `State_ID` (`State_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `Rents`
--
ALTER TABLE `Rents`
  ADD PRIMARY KEY (`Rent_ID`),
  ADD KEY `State_ID` (`State_ID`);

  --
-- Indexes for table `Rent_State`
--
ALTER TABLE `Rent_State`
  ADD PRIMARY KEY (`State_ID`);

--
-- Indexes for table `Override_UserPermissions`
--
ALTER TABLE `Override_UserPermissions`
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Permission_ID` (`Permission_ID`);

--
-- Indexes for table `Permissions`
--
ALTER TABLE `Permissions`
  ADD PRIMARY KEY (`Permission_ID`);

--
-- Indexes for table `Repair_Info`
--
ALTER TABLE `Repair_Info`
  ADD PRIMARY KEY (`Repair_ID`),
  ADD KEY `OR_ID` (`OR_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `Repair_State`
--
ALTER TABLE `Repair_State`
  ADD PRIMARY KEY (`State_ID`);

--
-- Indexes for table `Repair_Types`
--
ALTER TABLE `Repair_Types`
  ADD PRIMARY KEY (`Type_ID`);

--
-- Indexes for table `Stores`
--
ALTER TABLE `Stores`
  ADD PRIMARY KEY (`Store_ID`);

--
-- Indexes for table `UserGroups`
--
ALTER TABLE `UserGroups`
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Group_ID` (`Group_ID`);

--
-- Indexes for table `UserNotifications`
--
ALTER TABLE `UserNotifications`
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Notification_ID` (`Notification_ID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`User_ID`),
  ADD KEY `Store_ID` (`Store_ID`);

--
-- Indexes for table `UserTokens`
--
ALTER TABLE `UserTokens`
  ADD PRIMARY KEY (`Token_Key`),
  ADD KEY `User_ID` (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Clients`
--
ALTER TABLE `Clients`
  MODIFY `Client_ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK Clients',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Groups`
--
ALTER TABLE `Groups`
  MODIFY `Group_ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK Group ID',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Notifications`
--
ALTER TABLE `Notifications`
  MODIFY `Notification_ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK Identification',AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `ORs`
--
ALTER TABLE `ORs`
  MODIFY `OR_ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK EvaluationID',AUTO_INCREMENT=3001;


--
-- AUTO_INCREMENT for table `Rents`
--
ALTER TABLE `Rents`
  MODIFY `Rent_ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK of the Rent ID',AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Permissions`
--
ALTER TABLE `Permissions`
  MODIFY `Permission_ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK PermissionID',AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Repair_Info`
--
ALTER TABLE `Repair_Info`
  MODIFY `Repair_ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK Clients',AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Repair_State`
--
ALTER TABLE `Repair_State`
  MODIFY `State_ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK State of reparation ID',AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `Repair_Types`
--
ALTER TABLE `Repair_Types`
  MODIFY `Type_ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK Type of reparation ID',AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Stores`
--
ALTER TABLE `Stores`
  MODIFY `Store_ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK Store Identification',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `User_ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK User Identification',AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `GroupPermissions`
--
ALTER TABLE `GroupPermissions`
  ADD CONSTRAINT `grouppermissions_ibfk_1` FOREIGN KEY (`Permission_ID`) REFERENCES `Permissions` (`Permission_ID`),
  ADD CONSTRAINT `grouppermissions_ibfk_2` FOREIGN KEY (`Group_ID`) REFERENCES `Groups` (`Group_ID`);

--
-- Limitadores para a tabela `ORs`
--
ALTER TABLE `ORs`
  ADD CONSTRAINT `ors_ibfk_1` FOREIGN KEY (`Client_ID`) REFERENCES `Clients` (`Client_ID`),
  ADD CONSTRAINT `ors_ibfk_2` FOREIGN KEY (`Type_ID`) REFERENCES `Repair_Types` (`Type_ID`);

--
-- Limitadores para a tabela `Rents`
--
ALTER TABLE `Rents`
  ADD CONSTRAINT `rents_ibfk_1` FOREIGN KEY (`State_ID`) REFERENCES `Rent_State` (`State_ID`);

--
-- Limitadores para a tabela `OR_State`
--
ALTER TABLE `OR_State`
  ADD CONSTRAINT `or_state_ibfk_1` FOREIGN KEY (`OR_ID`) REFERENCES `ORs` (`OR_ID`),
  ADD CONSTRAINT `or_state_ibfk_2` FOREIGN KEY (`State_ID`) REFERENCES `Repair_State` (`State_ID`),
  ADD CONSTRAINT `or_state_ibfk_3` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`User_ID`);

--
-- Limitadores para a tabela `Override_UserPermissions`
--
ALTER TABLE `Override_UserPermissions`
  ADD CONSTRAINT `override_userpermissions_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`User_ID`),
  ADD CONSTRAINT `override_userpermissions_ibfk_2` FOREIGN KEY (`Permission_ID`) REFERENCES `Permissions` (`Permission_ID`);

--
-- Limitadores para a tabela `Repair_Info`
--
ALTER TABLE `Repair_Info`
  ADD CONSTRAINT `repair_info_ibfk_1` FOREIGN KEY (`OR_ID`) REFERENCES `ORs` (`OR_ID`),
  ADD CONSTRAINT `repair_info_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`User_ID`);

--
-- Limitadores para a tabela `UserGroups`
--
ALTER TABLE `UserGroups`
  ADD CONSTRAINT `usergroups_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`User_ID`),
  ADD CONSTRAINT `usergroups_ibfk_2` FOREIGN KEY (`Group_ID`) REFERENCES `Groups` (`Group_ID`);

--
-- Limitadores para a tabela `UserNotifications`
--
ALTER TABLE `UserNotifications`
  ADD CONSTRAINT `usernotifications_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`User_ID`),
  ADD CONSTRAINT `usernotifications_ibfk_2` FOREIGN KEY (`Notification_ID`) REFERENCES `Notifications` (`Notification_ID`);

--
-- Limitadores para a tabela `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`Store_ID`) REFERENCES `Stores` (`Store_ID`);

--
-- Limitadores para a tabela `UserTokens`
--
ALTER TABLE `UserTokens`
  ADD CONSTRAINT `usertokens_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `Users` (`User_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
