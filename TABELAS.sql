CREATE TABLE IF NOT EXISTS `operacoes` (
  `idOperacao` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `operacao` varchar(1050) NOT NULL,
  `resultado` varchar(1050) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idOperacao`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `senha` varchar(250) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `email_unico` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

