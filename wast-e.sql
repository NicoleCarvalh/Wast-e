-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 16/11/2022 às 03:37
-- Versão do servidor: 10.4.21-MariaDB
-- Versão do PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `wast-e`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `collections`
--

CREATE TABLE `collections` (
  `collection_id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `stage` int(11) NOT NULL DEFAULT 1,
  `classification` varchar(50) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `collection_date` varchar(50) NOT NULL,
  `period` varchar(50) NOT NULL,
  `additional_information` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estrutura para tabela `institution_users`
--

CREATE TABLE `institution_users` (
  `user_id` int(11) NOT NULL,
  `collections_id` varchar(255) DEFAULT NULL,
  `collections_id_confirmed` varchar(255) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `fantasyName` varchar(100) NOT NULL,
  `socialReason` varchar(100) NOT NULL,
  `cnpj` varchar(15) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `cep` varchar(15) NOT NULL,
  `street` varchar(150) NOT NULL,
  `numberBuilding` int(6) NOT NULL,
  `complementBuilding` varchar(100) DEFAULT NULL,
  `neighborhood` varchar(50) NOT NULL,
  `city` varchar(100) NOT NULL,
  `federativeUnit` varchar(2) NOT NULL,
  `about` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `concludedCollections` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Despejando dados para a tabela `institution_users`
--

INSERT INTO `institution_users` (`user_id`, `collections_id`, `collections_id_confirmed`, `email`, `password`, `fantasyName`, `socialReason`, `cnpj`, `telephone`, `cep`, `street`, `numberBuilding`, `complementBuilding`, `neighborhood`, `city`, `federativeUnit`, `about`, `photo_path`) VALUES
(1, NULL, NULL, 'empresa@gmail.com', '123456', 'Empresa Exemplo LTDA', 'Exemplo LTDA', '54354354354323', '1134343434', '30100438', 'Rua Angelica', 1700, NULL, 'Mario Quintana', 'Carapicuíba', 'SP', NULL, NULL);


--
-- Estrutura para tabela `person_users`
--

CREATE TABLE `person_users` (
  `user_id` int(11) NOT NULL,
  `collection_id` int(11) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `birth` varchar(10) NOT NULL,
  `cep` varchar(15) NOT NULL,
  `street` varchar(150) NOT NULL,
  `numberHouse` int(6) NOT NULL,
  `complementHouse` varchar(100) DEFAULT NULL,
  `neighborhood` varchar(50) NOT NULL,
  `city` varchar(100) NOT NULL,
  `federativeUnit` varchar(2) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `person_users`
--

INSERT INTO `person_users` (`user_id`, `collection_id`, `email`, `password`, `name`, `surname`, `telephone`, `birth`, `cep`, `street`, `numberHouse`, `complementHouse`, `neighborhood`, `city`, `federativeUnit`, `photo_path`) VALUES
(4, NULL, 'emailTeste@gmail.com', '12345', 'Teste', 'Wast-e', '11947800000', '1981-01-04', '06340-100', 'Av. Meu Pai Amado', 3, NULL, 'Vila Mariana', 'Gertrudes', 'SP', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`collection_id`);

--
-- Índices de tabela `institution_users`
--
ALTER TABLE `institution_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Índices de tabela `person_users`
--
ALTER TABLE `person_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `collections`
--
ALTER TABLE `collections`
  MODIFY `collection_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de tabela `institution_users`
--
ALTER TABLE `institution_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT de tabela `person_users`
--
ALTER TABLE `person_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
