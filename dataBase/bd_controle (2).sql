-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/03/2026 às 18:38
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_controle`
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
(1, '2026-03-04', 100.00, 1, 'Deposito 1', 1),
(2, '2026-03-02', 24.00, 1, 'Deposito 2', 1),
(6, '2026-03-04', 124.00, 1, 'testes', 1),
(7, '2026-03-04', 33.50, 1, 'teste 2', 1),
(8, '2026-03-04', 49.90, 1, 'teste 3', 1),
(9, '2026-03-04', 44.50, 1, 'testes', 1),
(10, '2026-03-06', 100.00, 3, 'Primeiro depósito', 1),
(11, '2026-03-09', 50.00, 1, 'testes 22', 1),
(12, '2026-03-09', 100.00, 1, 'teste dep', 1);

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
(3, 'Caixa', '11953193480', 3, 1),
(4, 'Santander', 'judite@gmail.com', 4, 1),
(5, 'Will', '123456777', 5, 1);

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
  `idUsuario` int(11) NOT NULL,
  `stAtivo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `despesas`
--

INSERT INTO `despesas` (`idDespesa`, `dataDespesa`, `idPrioridade`, `idCategoria`, `dsDespesa`, `valorDespesa`, `idUsuario`, `stAtivo`) VALUES
(1, '2026-03-02', 1, 1, 'Teste despesa moradia', 251.00, 1, 1),
(4, '2026-03-13', 1, 2, 'Salgado e Guaraná e bala', 19.00, 1, 1),
(5, '2026-03-11', 2, 4, 'doce e cafe', 998.00, 1, 1),
(6, '2026-03-02', 1, 8, 'Unhas de gel na Raissa', 130.00, 3, 1),
(7, '2026-03-10', 2, 5, 'Compra de 1 Livro', 35.00, 1, 1),
(8, '2026-03-04', 1, 2, 'Coxinha e Café', 12.30, 1, 1),
(9, '2026-03-06', 2, 8, 'Progressiva na Lívia em Franco', 260.00, 3, 1),
(10, '2026-03-06', 1, 2, 'Salgadinho', 9.20, 1, 1),
(11, '2026-03-09', 1, 6, 'Cinema com a gata', 100.00, 1, 1),
(12, '2026-03-09', 2, 3, 'testes', 100.00, 1, 1);

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
(1, 'André Lima', 'admin', '$2y$10$9PPwPiZegp8T/f8G9Gr2M.XsO5k.sAd/WJtV4SwF8Aho3Rl9ZF5xy', 'andre525luis@gmail.com', 1, 1, 1),
(3, 'Laura Campos', 'laura', '$2y$10$CesVY1RNk2VRCCdAestMse5fuFUGkxEqVLAr9s8W6WSCNsMylCABu', 'lauraangra13@gmail.com', 2, 1, 1),
(4, 'Judite Feitoza', 'judite', '$2y$10$rO0Gqja37lqtJoiuoHx4w.EYmtb2B/Nprp50ISkNTDxnBRfG3SJ9u', '', 2, 1, 1),
(5, 'Joaquim', 'joaquim12', '$2y$10$T3lxVuN5V7PgPDq5P8Z6N.0BiBX7/HSoGwbnyUojcT07SOafrWFe6', '', 2, 0, 0),
(6, 'Juliana', 'julima', '$2y$10$e6S.w9bUpPabL99vTQ.Mq.QXU721Sm32mM/Qn.LR4paJzXdBqxH0i', '', 2, 1, 1),
(7, 'Maria das Graças', 'maria211', '$2y$10$l5cmscagwcLjgZWJGs/y6.eJ5fHak8i5oQeW7xhcqwrZR7L9n6L0K', '', 2, 1, 0);

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
  MODIFY `idDeposito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `idDespesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
