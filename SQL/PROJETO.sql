
--
-- Database: `projeto`
--

CREATE DATABASE projeto;

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrador`
--

CREATE TABLE `administrador` (
  `E_mail` varchar(40) NOT NULL,
  `Nome` varchar(40) DEFAULT NULL,
  `CPF` char(11) DEFAULT NULL,
  `RG` char(9) DEFAULT NULL,
  `Idade` varchar(2) DEFAULT NULL,
  `Genero` varchar(9) DEFAULT NULL,
  `Telefone` char(11) DEFAULT NULL,
  `Senha` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Estrutura da tabela `atividades`
--

CREATE TABLE `atividades` (
  `ID` int(100) NOT NULL,
  `Nome` varchar(40) NOT NULL,
  `Beneficios` varchar(80) NOT NULL,
  `Descricao` varchar(80) NOT NULL,
  `FK_Rotinas_ID` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cadastra_atividades_medico`
--

CREATE TABLE `cadastra_atividades_medico` (
  `FK_Atividades_ID` int(100) NOT NULL,
  `FK_Medico_E_mail` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `medico`
--

CREATE TABLE `medico` (
  `E_mail` varchar(40) NOT NULL,
  `Nome` varchar(40) DEFAULT NULL,
  `CPF` char(11) DEFAULT NULL,
  `RG` char(9) DEFAULT NULL,
  `CRM` char(255) DEFAULT NULL,
  `Telefone` char(11) DEFAULT NULL,
  `Idade` varchar(2) DEFAULT NULL,
  `Genero` varchar(9) DEFAULT NULL,
  `Endereco` varchar(255) DEFAULT NULL,
  `Senha` varchar(40) DEFAULT NULL,
  `Facebook` varchar(40) DEFAULT NULL,
  `Instagram` varchar(40) DEFAULT NULL,
  `FK_Rotinas_ID` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estrutura da tabela `paciente`
--

CREATE TABLE `paciente` (
  `E_mail` varchar(40) NOT NULL,
  `Nome` varchar(40) NOT NULL,
  `CPF` char(11) NOT NULL,
  `RG` char(9) NOT NULL,
  `Idade` varchar(2) NOT NULL,
  `Genero` varchar(9) NOT NULL,
  `Telefone` char(11) NOT NULL,
  `Senha` varchar(40) NOT NULL,
  `Facebook` varchar(40) DEFAULT NULL,
  `Instagram` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estrutura da tabela `realizacao_de_atividade_faz`
--

CREATE TABLE `realizacao_de_atividade_faz` (
  `Ja_Realizada` tinyint(1) NOT NULL,
  `FK_Atividades_ID` int(100) NOT NULL,
  `FK_Paciente_E_mail` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `repeticoes`
--

CREATE TABLE `repeticoes` (
  `ID` int(100) NOT NULL,
  `Dias_da_semana` char(1) DEFAULT NULL,
  `Frequencia` char(2) DEFAULT NULL,
  `Horarios` varchar(2) DEFAULT NULL,
  `FK_Paciente_E_mail` varchar(40) DEFAULT NULL,
  `FK_Rotinas_ID` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estrutura da tabela `rotinas`
--

CREATE TABLE `rotinas` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(45) NOT NULL,
  `Descricao` char(100) NOT NULL,
  `FK_Administrador_E_mail` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Indexes for table `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`E_mail`);

--
-- Indexes for table `atividades`
--
ALTER TABLE `atividades`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Rotina` (`FK_Rotinas_ID`);

--
-- Indexes for table `cadastra_atividades_medico`
--
ALTER TABLE `cadastra_atividades_medico`
  ADD PRIMARY KEY (`FK_Atividades_ID`,`FK_Medico_E_mail`),
  ADD KEY `E_mail_Medico_Cadastra` (`FK_Medico_E_mail`);

--
-- Indexes for table `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`E_mail`),
  ADD KEY `FK_Rotinas_ID` (`FK_Rotinas_ID`);

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`E_mail`);

--
-- Indexes for table `realizacao_de_atividade_faz`
--
ALTER TABLE `realizacao_de_atividade_faz`
  ADD PRIMARY KEY (`FK_Atividades_ID`,`FK_Paciente_E_mail`),
  ADD KEY `E_mail_Paciente_Realiza` (`FK_Paciente_E_mail`);

--
-- Indexes for table `repeticoes`
--
ALTER TABLE `repeticoes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `E_mail_Paciente_Repeticoes` (`FK_Paciente_E_mail`),
  ADD KEY `ID_Rotina_Repeticoes` (`FK_Rotinas_ID`);

--
-- Indexes for table `rotinas`
--
ALTER TABLE `rotinas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `E_mail_Administrador_Rotinas` (`FK_Administrador_E_mail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atividades`
--
ALTER TABLE `atividades`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repeticoes`
--
ALTER TABLE `repeticoes`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rotinas`
--
ALTER TABLE `rotinas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `atividades`
--
ALTER TABLE `atividades`
  ADD CONSTRAINT `ID_Rotina_Atividades` FOREIGN KEY (`FK_Rotinas_ID`) REFERENCES `rotinas` (`ID`);

--
-- Limitadores para a tabela `cadastra_atividades_medico`
--
ALTER TABLE `cadastra_atividades_medico`
  ADD CONSTRAINT `E_mail_Medico_Cadastra` FOREIGN KEY (`FK_Medico_E_mail`) REFERENCES `medico` (`E_mail`),
  ADD CONSTRAINT `ID_Atividades_Cadastra` FOREIGN KEY (`FK_Atividades_ID`) REFERENCES `atividades` (`ID`);

--
-- Limitadores para a tabela `medico`
--
ALTER TABLE `medico`
  ADD CONSTRAINT `FK_Rotinas_ID` FOREIGN KEY (`FK_Rotinas_ID`) REFERENCES `rotinas` (`ID`);

--
-- Limitadores para a tabela `realizacao_de_atividade_faz`
--
ALTER TABLE `realizacao_de_atividade_faz`
  ADD CONSTRAINT `E_mail_Paciente_Realiza` FOREIGN KEY (`FK_Paciente_E_mail`) REFERENCES `paciente` (`E_mail`),
  ADD CONSTRAINT `ID_Atividades_Realiza` FOREIGN KEY (`FK_Atividades_ID`) REFERENCES `atividades` (`ID`);

--
-- Limitadores para a tabela `repeticoes`
--
ALTER TABLE `repeticoes`
  ADD CONSTRAINT `E_mail_Paciente_Repeticoes` FOREIGN KEY (`FK_Paciente_E_mail`) REFERENCES `paciente` (`E_mail`),
  ADD CONSTRAINT `ID_Rotina_Repeticoes` FOREIGN KEY (`FK_Rotinas_ID`) REFERENCES `rotinas` (`ID`);

--
-- Limitadores para a tabela `rotinas`
--
ALTER TABLE `rotinas`
  ADD CONSTRAINT `E_mail_Administrador_Rotinas` FOREIGN KEY (`FK_Administrador_E_mail`) REFERENCES `administrador` (`E_mail`);
COMMIT;
