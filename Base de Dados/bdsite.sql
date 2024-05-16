-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Maio-2024 às 13:41
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bdsite`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin_cred`
--

CREATE TABLE `admin_cred` (
  `sr_no` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `admin_cred`
--

INSERT INTO `admin_cred` (`sr_no`, `admin_name`, `admin_pass`) VALUES
(1, 'lucas', '12345');

-- --------------------------------------------------------

--
-- Estrutura da tabela `entradas`
--

CREATE TABLE `entradas` (
  `id` int(11) NOT NULL,
  `CodInt` int(11) NOT NULL,
  `Fact` int(11) NOT NULL,
  `Fornecedor` varchar(200) NOT NULL,
  `Data` timestamp NOT NULL DEFAULT current_timestamp(),
  `Qnt_Ent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `entradas`
--

INSERT INTO `entradas` (`id`, `CodInt`, `Fact`, `Fornecedor`, `Data`, `Qnt_Ent`) VALUES
(7, 21474, 9, 'Lambecas', '2024-03-20 13:41:14', 50),
(9, 21474, 83, 'Padaria', '2024-03-20 13:47:49', 2),
(12, 5329, 432, 'Ilha Ferragens', '2024-03-20 14:48:18', 20),
(13, 5329, 665, 'Governo', '2024-03-20 14:50:29', 200),
(14, 5329, 203, 'Galp', '2024-03-20 15:16:31', 400);

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens`
--

CREATE TABLE `itens` (
  `id` int(11) NOT NULL,
  `CodInt` int(11) NOT NULL,
  `Nome` varchar(150) NOT NULL,
  `TipoUN` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `itens`
--

INSERT INTO `itens` (`id`, `CodInt`, `Nome`, `TipoUN`) VALUES
(3, 654, 'Tinta', 'UN'),
(4, 6534, 'Fita Métrica', 'M'),
(5, 7032, 'Água', 'L'),
(14, 21474, 'Gelados', 'UN'),
(15, 52222, 'Farinha', 'KG'),
(16, 5329, 'Pregos', 'UN');

-- --------------------------------------------------------

--
-- Estrutura da tabela `saidas`
--

CREATE TABLE `saidas` (
  `id` int(11) NOT NULL,
  `CodInt` int(11) NOT NULL,
  `nREQ` int(11) NOT NULL,
  `Requisitante` varchar(200) NOT NULL,
  `Data` timestamp NOT NULL DEFAULT current_timestamp(),
  `Qnt_Sai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `saidas`
--

INSERT INTO `saidas` (`id`, `CodInt`, `nREQ`, `Requisitante`, `Data`, `Qnt_Sai`) VALUES
(2, 5329, 4, 'Museu', '2024-03-21 15:24:31', 1),
(6, 5329, 54, 'Farrobo', '2024-03-21 16:08:41', 350);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`sr_no`);

--
-- Índices para tabela `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Qnt_Ent` (`Qnt_Ent`),
  ADD KEY `Item_Entradas` (`CodInt`);

--
-- Índices para tabela `itens`
--
ALTER TABLE `itens`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `CodInt` (`CodInt`);

--
-- Índices para tabela `saidas`
--
ALTER TABLE `saidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Item_Saidas` (`CodInt`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `itens`
--
ALTER TABLE `itens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `saidas`
--
ALTER TABLE `saidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `Item_Entradas` FOREIGN KEY (`CodInt`) REFERENCES `itens` (`CodInt`) ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `saidas`
--
ALTER TABLE `saidas`
  ADD CONSTRAINT `Item_Saidas` FOREIGN KEY (`CodInt`) REFERENCES `itens` (`CodInt`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
