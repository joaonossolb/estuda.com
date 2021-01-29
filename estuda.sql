-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 29-Jan-2021 às 10:16
-- Versão do servidor: 5.7.25
-- versão do PHP: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estuda`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `visivel` varchar(100) NOT NULL,
  `id` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `data_nascimento` varchar(100) NOT NULL,
  `genero` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`visivel`, `id`, `nome`, `telefone`, `email`, `data_nascimento`, `genero`) VALUES
('1', '1', 'Pedro', '99999', 'pedro@gmail.com', '2021-01-04', '1'),
('0', '2', 'joao', '55544444', 'joao@gmail.com', '2021-01-08', '1'),
('1', '3', 'Alex', '9988877', 'alex@gmaol.com', '2021-01-09', '1'),
('1', '4', 'aaa', '99999', 'joao@gmail.com', '', ''),
('1', '5', 'joao', '', 'joao@gmail.com', '', ''),
('1', '6', 'joao', '', 'joao@gmail.com', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos_de_turmas`
--

CREATE TABLE `alunos_de_turmas` (
  `pk_id` int(11) NOT NULL,
  `visivel` varchar(100) NOT NULL,
  `fk_id_aluno` varchar(100) NOT NULL,
  `fk_id_turma` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `alunos_de_turmas`
--

INSERT INTO `alunos_de_turmas` (`pk_id`, `visivel`, `fk_id_aluno`, `fk_id_turma`) VALUES
(20, '1', '2', '6'),
(22, '1', '2', '2'),
(23, '1', '1', '6'),
(24, '1', '1', '2'),
(25, '1', '1', '6'),
(26, '1', '2', '6'),
(27, '1', '3', '2'),
(28, '1', '3', '2'),
(29, '1', '6', '2'),
(30, '1', '6', '2'),
(31, '1', '6', '6');

-- --------------------------------------------------------

--
-- Estrutura da tabela `escolas`
--

CREATE TABLE `escolas` (
  `visivel` varchar(100) NOT NULL,
  `id` varchar(100) NOT NULL,
  `nome_escola` varchar(100) NOT NULL,
  `endereco_cep` varchar(100) NOT NULL,
  `situacao` varchar(100) NOT NULL,
  `data` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `escolas`
--

INSERT INTO `escolas` (`visivel`, `id`, `nome_escola`, `endereco_cep`, `situacao`, `data`) VALUES
('1', '11', 'Escola do joao', '55555', '0', '2021-01-01'),
('1', '3', '', '', '1', '2021-01-01'),
('1', '54', 'ESTUDA', '333', '1', '2021-01-08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `turmas`
--

CREATE TABLE `turmas` (
  `pk_id` int(11) NOT NULL,
  `visivel` varchar(100) NOT NULL,
  `fk_id_escola` varchar(100) NOT NULL,
  `ano` varchar(100) NOT NULL,
  `nivel_ensino` varchar(100) NOT NULL,
  `serie` varchar(100) NOT NULL,
  `turno` varchar(100) NOT NULL,
  `nome_turma` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `turmas`
--

INSERT INTO `turmas` (`pk_id`, `visivel`, `fk_id_escola`, `ano`, `nivel_ensino`, `serie`, `turno`, `nome_turma`) VALUES
(2, '1', '11', '2020', '1', '2', '2', 'turma do jacaré'),
(4, '0', '11', '', '0', '', '1', ''),
(6, '1', '11', '89', '0', '9', '1', 'turmaaa'),
(7, '1', '3', '', '0', '', '1', 'TURMA 3'),
(8, '1', '11', '2019', '1', '', '0', 'TURMA 4'),
(9, '1', '54', '23332', '0', '', '0', 'RRRR');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alunos_de_turmas`
--
ALTER TABLE `alunos_de_turmas`
  ADD PRIMARY KEY (`pk_id`);

--
-- Indexes for table `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`pk_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alunos_de_turmas`
--
ALTER TABLE `alunos_de_turmas`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `turmas`
--
ALTER TABLE `turmas`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
