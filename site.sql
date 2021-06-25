--
-- Estrutura da tabela `conf`
--

CREATE TABLE `conf` (
  `Nome` varchar(535) NOT NULL,
  `Descrição` text NOT NULL,
  `Política` text NOT NULL,
  `Sobre` text NOT NULL,
  `Botões` text NOT NULL,
  `Logo` varchar(535) NOT NULL,
  `head` text NOT NULL,
  `manutencao` tinyint(1) NOT NULL,
  `ad` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `conf`
--

INSERT INTO `conf` (`Nome`, `Descrição`, `Política`, `Sobre`, `Botões`, `Logo`, `head`, `manutencao`, `ad`) VALUES
('Nome do site', 'Descrição do site', 'POlitica de privacidade', 'Sobre o site', 'termo de pesquisa1,termo de pesquisa2,termo de pesquisa3', '', '', 0, 'Código propaganda');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contact`
--

CREATE TABLE `contact` (
  `info` longtext NOT NULL,
  `contact` longtext NOT NULL,
  `data` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `id` int(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `texto` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `imgbg` varchar(255) NOT NULL,
  `cor1` varchar(255) NOT NULL,
  `cor2` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`id`, `titulo`, `texto`, `img`, `imgbg`, `cor1`, `cor2`) VALUES
(0, 'Tistulo da postagem', 'Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto Texto ', '', '', '#ffffff', '#00ff00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `user`, `password`) VALUES
(1, 'admin', '$2y$12$TZoTDezHgELHmm9gz/vN5OPK1YhOF9pyztWkTgky2e9LW5wrTrCq6');

-- --------------------------------------------------------

--
-- Estrutura da tabela `visualizacoes`
--

CREATE TABLE `visualizacoes` (
  `id_mensagem` int(255) DEFAULT NULL,
  `ip` varchar(40) NOT NULL,
  `data` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `visualizacoes`
--
ALTER TABLE `visualizacoes`
  ADD KEY `id_mensagem_fk` (`id_mensagem`);

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;
