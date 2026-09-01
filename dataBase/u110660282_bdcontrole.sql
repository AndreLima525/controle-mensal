-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 01/09/2026 às 19:42
-- Versão do servidor: 11.8.8-MariaDB-log
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u110660282_bdcontrole`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `caixinhas`
--

CREATE TABLE `caixinhas` (
  `idDeposito` int(11) NOT NULL,
  `dataDeposito` date NOT NULL,
  `valorDeposito` decimal(10,2) NOT NULL,
  `idPix` int(11) NOT NULL,
  `dsDeposito` varchar(200) NOT NULL,
  `stAtivo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `caixinhas`
--

INSERT INTO `caixinhas` (`idDeposito`, `dataDeposito`, `valorDeposito`, `idPix`, `dsDeposito`, `stAtivo`) VALUES
(1, '2026-08-26', 1000.00, 1, 'Caixinha Nubank', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `dsCategoria` varchar(50) NOT NULL,
  `stAtivo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `dsCategoria`, `stAtivo`) VALUES
(1, 'Moradia ', 1),
(2, 'Alimentação', 1),
(3, 'Transporte', 1),
(4, 'Saúde', 1),
(5, 'Educação', 1),
(6, 'Lazer', 1),
(7, 'Financeiro', 1),
(8, 'Pessoal', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `dadospix`
--

CREATE TABLE `dadospix` (
  `idPix` int(11) NOT NULL,
  `dsBancoPix` varchar(200) NOT NULL,
  `dsPix` varchar(250) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `stAtivo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `dadospix`
--

INSERT INTO `dadospix` (`idPix`, `dsBancoPix`, `dsPix`, `idUsuario`, `stAtivo`) VALUES
(1, 'nubank', '11998492112', 1, 1),
(3, 'Nubank', '11953193480', 3, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `despesas`
--

CREATE TABLE `despesas` (
  `idDespesa` int(11) NOT NULL,
  `dataDespesa` date NOT NULL,
  `idPrioridade` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `dsDespesa` varchar(200) NOT NULL,
  `valorDespesa` decimal(10,2) NOT NULL,
  `IC_Paga` enum('S','N') NOT NULL DEFAULT 'N',
  `idUsuario` int(11) NOT NULL,
  `stAtivo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `despesas`
--

INSERT INTO `despesas` (`idDespesa`, `dataDespesa`, `idPrioridade`, `idCategoria`, `dsDespesa`, `valorDespesa`, `IC_Paga`, `idUsuario`, `stAtivo`) VALUES
(1, '2026-08-26', 1, 2, 'Doce Isabela Presente', 7.75, 'S', 1, 1),
(2, '2026-08-26', 1, 2, 'Bolo e café - Fatec', 9.00, 'S', 1, 1),
(3, '2026-08-27', 3, 4, 'Remédio Cystex', 31.12, 'S', 1, 1),
(4, '2026-08-27', 1, 2, 'Doces Isabela presentes', 7.00, 'S', 1, 1),
(5, '2026-08-27', 1, 2, 'Doce e suquinho Isabela ', 11.49, 'S', 1, 1),
(6, '2026-08-28', 1, 8, 'Blaze', 20.00, 'S', 1, 1),
(7, '2026-08-28', 1, 3, 'Uber volta pra casa', 18.00, 'S', 1, 1),
(8, '2026-08-28', 1, 3, 'Uber', 17.00, 'S', 1, 1),
(9, '2026-09-05', 2, 1, 'Parcela 03 de 05 - Fernando', 520.00, 'N', 1, 1),
(10, '2026-09-05', 2, 1, 'Conta de Luz ', 85.00, 'N', 1, 1),
(11, '2026-09-05', 2, 7, 'Parcela 2 de 4 - Empréstimo Bradesco', 227.00, 'N', 1, 1),
(12, '2026-09-01', 2, 7, 'Fatura Bradesco 09/2026 - Valor mínimo', 605.00, 'N', 1, 1),
(13, '2026-09-05', 1, 1, 'Fernando - Materiais que comprou à parte no apartamento', 160.00, 'N', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `nivelacesso`
--

CREATE TABLE `nivelacesso` (
  `idNivelAcesso` int(11) NOT NULL,
  `dsAcesso` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `nivelacesso`
--

INSERT INTO `nivelacesso` (`idNivelAcesso`, `dsAcesso`) VALUES
(1, 'Administrador'),
(2, 'Usuário');

-- --------------------------------------------------------

--
-- Estrutura para tabela `prioridadesdespesas`
--

CREATE TABLE `prioridadesdespesas` (
  `idPrioridade` int(11) NOT NULL,
  `dsPrioridade` varchar(50) NOT NULL,
  `stAtivo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `prioridadesdespesas`
--

INSERT INTO `prioridadesdespesas` (`idPrioridade`, `dsPrioridade`, `stAtivo`) VALUES
(1, 'Baixa', 1),
(2, 'Média', 1),
(3, 'Alta', 1),
(4, 'Emergêncial', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nomeUsuario` varchar(100) NOT NULL,
  `login` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `idNivelAcesso` int(11) NOT NULL,
  `stAtivo` tinyint(1) NOT NULL DEFAULT 1,
  `idPAcesso` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nomeUsuario`, `login`, `senha`, `email`, `idNivelAcesso`, `stAtivo`, `idPAcesso`) VALUES
(1, 'André Lima', 'admin', '$2y$10$P2NsBjivWmmYb6lz7jJ4tOE4biXpgW6gXYenTsmpOJYboXrx1RjCy', 'andre525luis@gmail.com', 1, 1, 1),
(3, 'Laura Campos', 'laura', '$2y$10$GNOnOJBHpqTi3QYx1Xh/XOM5ReWI8SKlaSmQ0vTetrO4d8rzOuzGy', 'lauraangra13@gmail.com', 2, 1, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `caixinhas`
--
ALTER TABLE `caixinhas`
  ADD PRIMARY KEY (`idDeposito`),
  ADD KEY `FK_idPix` (`idPix`);

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Índices de tabela `dadospix`
--
ALTER TABLE `dadospix`
  ADD PRIMARY KEY (`idPix`),
  ADD KEY `FK_idUsuario1` (`idUsuario`);

--
-- Índices de tabela `despesas`
--
ALTER TABLE `despesas`
  ADD PRIMARY KEY (`idDespesa`),
  ADD KEY `FK_idCategoria` (`idCategoria`),
  ADD KEY `FK_prioridadeDespesa` (`idPrioridade`),
  ADD KEY `FK_idUsuario` (`idUsuario`);

--
-- Índices de tabela `nivelacesso`
--
ALTER TABLE `nivelacesso`
  ADD PRIMARY KEY (`idNivelAcesso`),
  ADD UNIQUE KEY `dsAcesso` (`dsAcesso`);

--
-- Índices de tabela `prioridadesdespesas`
--
ALTER TABLE `prioridadesdespesas`
  ADD PRIMARY KEY (`idPrioridade`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `FK_idNivelAcesso` (`idNivelAcesso`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `caixinhas`
--
ALTER TABLE `caixinhas`
  MODIFY `idDeposito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `dadospix`
--
ALTER TABLE `dadospix`
  MODIFY `idPix` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `despesas`
--
ALTER TABLE `despesas`
  MODIFY `idDespesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `nivelacesso`
--
ALTER TABLE `nivelacesso`
  MODIFY `idNivelAcesso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `prioridadesdespesas`
--
ALTER TABLE `prioridadesdespesas`
  MODIFY `idPrioridade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `caixinhas`
--
ALTER TABLE `caixinhas`
  ADD CONSTRAINT `FK_idPix` FOREIGN KEY (`idPix`) REFERENCES `dadospix` (`idPix`);

--
-- Restrições para tabelas `dadospix`
--
ALTER TABLE `dadospix`
  ADD CONSTRAINT `FK_idUsuario1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);

--
-- Restrições para tabelas `despesas`
--
ALTER TABLE `despesas`
  ADD CONSTRAINT `FK_idCategoria` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`idCategoria`),
  ADD CONSTRAINT `FK_idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `FK_prioridadeDespesa` FOREIGN KEY (`idPrioridade`) REFERENCES `prioridadesdespesas` (`idPrioridade`);

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_idNivelAcesso` FOREIGN KEY (`idNivelAcesso`) REFERENCES `nivelacesso` (`idNivelAcesso`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
