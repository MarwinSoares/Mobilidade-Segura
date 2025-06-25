-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/05/2025 às 18:37
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mobilidade_segura`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `acoes_moderador`
--

CREATE TABLE `acoes_moderador` (
  `id_acoes` int(11) NOT NULL,
  `id_adm` int(11) NOT NULL,
  `acao` text NOT NULL,
  `data_acao` datetime DEFAULT current_timestamp(),
  `id_locais` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `acoes_moderador`
--

INSERT INTO `acoes_moderador` (`id_acoes`, `id_adm`, `acao`, `data_acao`, `id_locais`) VALUES
(15, 1, 'aprovar', '2025-05-26 21:58:46', 1),
(16, 1, 'aprovou o local ID 1', '2025-05-27 17:55:32', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `locais`
--

CREATE TABLE `locais` (
  `id_locais` int(11) NOT NULL,
  `nome_locais` varchar(150) NOT NULL,
  `link_maps` text NOT NULL,
  `acessibilidade` text NOT NULL,
  `categoria` varchar(150) NOT NULL,
  `data_adicionado` datetime DEFAULT current_timestamp(),
  `id_usuario` int(11) DEFAULT NULL,
  `status_locais` enum('Pendente','Aprovado','Rejeitado') DEFAULT 'Pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `locais`
--

INSERT INTO `locais` (`id_locais`, `nome_locais`, `link_maps`, `acessibilidade`, `categoria`, `data_adicionado`, `id_usuario`, `status_locais`) VALUES
(1, 'mequi donalds 971', 'https://www.google.com/maps/dir/-23.5215014,-46.4568041/McDonald\'s+-+Av.+Jacu-P%C3%AAssego,+931+-+Vila+Jacu%C3%AD,+S%C3%A3o+Paulo+-+SP,+08050-099/@-23.5236029,-46.4597385,17z/data=!3m1!4b1!4m9!4m8!1m1!4e1!1m5!1m1!1s0x94ce61897f2da1e7:0x43f8d3df752d763e!2m2!1d-46.4566561!2d-23.5241193?entry=ttu&g_ep=EgoyMDI1MDUyMS4wIKXMDSoASAFQAw%3D%3D', 'deficiencia_fisica,deficiencia_visual', 'restaurante', '2025-05-26 02:06:42', 2, 'Aprovado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `moderadores`
--

CREATE TABLE `moderadores` (
  `id_adm` int(11) NOT NULL,
  `nome_adm` varchar(100) NOT NULL,
  `email_adm` varchar(100) NOT NULL,
  `senha_adm` varchar(255) NOT NULL,
  `data_cadastro_adm` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `moderadores`
--

INSERT INTO `moderadores` (`id_adm`, `nome_adm`, `email_adm`, `senha_adm`, `data_cadastro_adm`) VALUES
(1, 'Marwin Barbosa', 'Marwinbarbosa1407@gmail.com', '$2y$10$86fnz6tiXUx1cMl2Q5ei2OI1.MWY9Ti05E84q5PR0mfEEZOhwakPO', '2025-05-26 16:36:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reportes`
--

CREATE TABLE `reportes` (
  `id_reporte` int(11) NOT NULL,
  `id_locais` int(11) DEFAULT NULL,
  `mensagem` text DEFAULT NULL,
  `data_reporte` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `reportes`
--

INSERT INTO `reportes` (`id_reporte`, `id_locais`, `mensagem`, `data_reporte`) VALUES
(3, 1, 'banheiro ruim da porra\r\n', '2025-05-27 00:35:21');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `status` enum('Ativo','Inativo') DEFAULT 'Ativo',
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `telefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha`, `status`, `data_cadastro`, `telefone`) VALUES
(1, 'Marwin Barbosa Silva Soares', 'Marwinsoares070@gmail.com', '$2y$10$xlBljU.Sl1s9DIerITTrWOq3Yb71HyIsGMoOFUcXlPmKETBiJSTFW', 'Ativo', '2025-05-25 21:30:57', '11959237933'),
(2, 'joaozinho pinheiro', 'joaozinho.pinheiro@gmail.com', '$2y$10$qb6Q/C.MnIj9pA2fM3FQV.HOwzt6jaYHbTNGjJ/.Nu8fCc/tdSz7u', 'Ativo', '2025-05-26 01:34:06', '11959237933');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `acoes_moderador`
--
ALTER TABLE `acoes_moderador`
  ADD PRIMARY KEY (`id_acoes`),
  ADD KEY `id_moderador` (`id_adm`),
  ADD KEY `fk_acoes_locais` (`id_locais`);

--
-- Índices de tabela `locais`
--
ALTER TABLE `locais`
  ADD PRIMARY KEY (`id_locais`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `moderadores`
--
ALTER TABLE `moderadores`
  ADD PRIMARY KEY (`id_adm`),
  ADD UNIQUE KEY `email` (`email_adm`);

--
-- Índices de tabela `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id_reporte`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acoes_moderador`
--
ALTER TABLE `acoes_moderador`
  MODIFY `id_acoes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `locais`
--
ALTER TABLE `locais`
  MODIFY `id_locais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `moderadores`
--
ALTER TABLE `moderadores`
  MODIFY `id_adm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `acoes_moderador`
--
ALTER TABLE `acoes_moderador`
  ADD CONSTRAINT `acoes_moderador_ibfk_1` FOREIGN KEY (`id_adm`) REFERENCES `moderadores` (`id_adm`),
  ADD CONSTRAINT `fk_acoes_locais` FOREIGN KEY (`id_locais`) REFERENCES `locais` (`id_locais`) ON DELETE SET NULL;

--
-- Restrições para tabelas `locais`
--
ALTER TABLE `locais`
  ADD CONSTRAINT `locais_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
