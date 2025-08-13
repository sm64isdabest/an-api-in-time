-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/08/2025 às 17:16
-- Versão do servidor: 11.3.0-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ahitapi`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `acts` int(11) NOT NULL,
  `time_rifts` int(11) DEFAULT NULL,
  `timepieces` int(11) NOT NULL,
  `boss_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chapters`
--

INSERT INTO `chapters` (`id`, `name`, `description`, `acts`, `time_rifts`, `timepieces`, `boss_name`, `created_at`) VALUES
(1, 'Mafia Town', 'A vibrante ilha controlada pela máfia, cheia de confusões e moedas brilhantes.', 5, 2, 7, 'Mafia Boss', '2025-08-13 11:48:07'),
(2, 'Battle of the Birds', 'Um set de filmagem caótico onde dois diretores brigam pela fama.', 6, 3, 8, 'The Conductor', '2025-08-13 11:48:55'),
(3, 'Subcon Forest', 'Uma floresta misteriosa com espíritos traiçoeiros e contratos perigosos.', 4, 2, 6, 'Snatcher', '2025-08-13 11:49:39'),
(4, 'Alpine Skyline', 'Montanhas altíssimas, ventos cortantes e mistérios escondidos nas nuvens.', 4, 2, 7, 'Nenhum', '2025-08-13 12:27:56'),
(5, 'Time\'s End', 'O confronto final contra a Mustache Girl. Derrote-a e restaure o fluxo do tempo, encerrando a aventura.', 1, 1, 2, 'Mustache Girl', '2025-08-13 12:32:27'),
(6, 'The Arctic Cruise', 'Um luxuoso cruzeiro no Ártico... até que tudo começa a dar errado.', 3, 2, 5, 'Nenhum', '2025-08-13 12:33:48'),
(7, 'Nyakuza Metro', 'Explore o metrô da Nyakuza City, cheio de gangues felinas e aventuras urbanas.', 4, 2, 5, 'The Empress', '2025-08-13 12:34:55');

-- --------------------------------------------------------

--
-- Estrutura para tabela `hats`
--

CREATE TABLE `hats` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `icon_url` text DEFAULT NULL,
  `ability` text DEFAULT NULL,
  `yarn_cost` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `current_hat_id` int(11) DEFAULT NULL,
  `unlocked_hats` text DEFAULT NULL,
  `completed_chapters` text DEFAULT NULL,
  `collected_timepieces` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `hats`
--
ALTER TABLE `hats`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `hats`
--
ALTER TABLE `hats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
