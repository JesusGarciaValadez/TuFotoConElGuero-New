-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-05-2014 a las 14:02:51
-- Versión del servidor: 5.5.31
-- Versión de PHP: 5.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `r6000017_chiapas_live`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ctg_tiposusuario`
--

CREATE TABLE IF NOT EXISTS `ctg_tiposusuario` (
  `id_TipoUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `tx_TipoUsuario` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_TipoUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `ctg_tiposusuario`
--

INSERT INTO `ctg_tiposusuario` (`id_TipoUsuario`, `tx_TipoUsuario`) VALUES
(1, 'Administrador'),
(2, 'Usuario Normal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_evento`
--

CREATE TABLE IF NOT EXISTS `detalle_evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evento` int(11) NOT NULL,
  `municipio` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tags` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `detalle_evento`
--

INSERT INTO `detalle_evento` (`id`, `evento`, `municipio`, `tags`) VALUES
(1, 1, '101', 'Etiqueta el Evento'),
(2, 2, '2', 'Etiqueta el Evento'),
(3, 3, '5', 'Etiqueta el Evento'),
(4, 4, '111', 'Etiqueta el Evento'),
(5, 5, '101', 'Etiqueta el Evento'),
(6, 6, '101', 'Etiqueta el Evento'),
(7, 7, '89', 'Etiqueta el Evento'),
(8, 8, '86', 'Etiqueta el Evento'),
(9, 9, '93', 'Etiqueta el Evento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE IF NOT EXISTS `evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evento` varchar(200) NOT NULL,
  `descripcion` varchar(600) NOT NULL,
  `fecha` date NOT NULL,
  `activo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`id`, `evento`, `descripcion`, `fecha`, `activo`) VALUES
(1, 'evento 1', 'DescripciÃ³n del Evento', '2014-01-07', 1),
(2, 'evento 2 ', 'DescripciÃ³n del Evento', '2014-02-01', 0),
(3, '3', 'DescripciÃ³n del Evento', '2014-03-01', 1),
(4, 'Visita ZinacantÃ¡n', 'DescripciÃ³n del Evento', '2014-01-05', 1),
(5, 'ENTREGA DE CERTIFICADOS IEA 24', 'DescripciÃ³n del Evento', '2014-01-24', 1),
(6, 'TOMA DE PROTESTA COLEGIO DE INGENIEROS', 'DescripciÃ³n del Evento', '2014-02-20', 1),
(7, 'FERIA INTERNACIONAL DE TAPACHULA', 'DescripciÃ³n del Evento', '2014-02-28', 1),
(8, 'UNIVERSIDAD POLITECNICA DE CHIAPAS', 'DescripciÃ³n del Evento', '2014-02-26', 1),
(9, 'PACTO NO VIOLENCIA', 'DescripciÃ³n del Evento', '2014-03-24', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeriaimagenes`
--

CREATE TABLE IF NOT EXISTS `galeriaimagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `archivo` varchar(200) NOT NULL,
  `directorio` varchar(200) NOT NULL,
  `evento` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Volcado de datos para la tabla `galeriaimagenes`
--

INSERT INTO `galeriaimagenes` (`id`, `archivo`, `directorio`, `evento`) VALUES
(2, '2_2.jpg', '2014/April/Wednesday30', 2),
(3, '3_3.jpg', '2014/April/Wednesday30', 3),
(4, '1_4.jpg', '2014/April/Wednesday30', 1),
(5, '1_5.jpg', '2014/April/Wednesday30', 1),
(6, '1_6.jpg', '2014/April/Wednesday30', 1),
(7, '1_7.jpg', '2014/April/Wednesday30', 1),
(8, '4_8.jpg', '2014/April/Wednesday30', 4),
(9, '4_9.jpg', '2014/April/Wednesday30', 4),
(10, '4_10.jpg', '2014/April/Wednesday30', 4),
(11, '5_11.jpg', '2014/April/Wednesday30', 5),
(12, '5_12.jpg', '2014/April/Wednesday30', 5),
(13, '5_13.jpg', '2014/April/Wednesday30', 5),
(14, '5_14.jpg', '2014/April/Wednesday30', 5),
(15, '5_15.jpg', '2014/April/Wednesday30', 5),
(16, '5_16.jpg', '2014/April/Wednesday30', 5),
(17, '6_17.jpg', '2014/April/Wednesday30', 6),
(18, '6_18.jpg', '2014/April/Wednesday30', 6),
(19, '6_19.jpg', '2014/April/Wednesday30', 6),
(20, '6_20.jpg', '2014/April/Wednesday30', 6),
(21, '6_21.jpg', '2014/April/Wednesday30', 6),
(22, '6_22.jpg', '2014/April/Wednesday30', 6),
(23, '6_23.jpg', '2014/April/Wednesday30', 6),
(24, '7_24.jpg', '2014/April/Wednesday30', 7),
(25, '7_25.jpg', '2014/April/Wednesday30', 7),
(26, '7_26.jpg', '2014/April/Wednesday30', 7),
(27, '8_27.jpg', '2014/April/Wednesday30', 8),
(28, '8_28.jpg', '2014/April/Wednesday30', 8),
(29, '8_29.jpg', '2014/April/Wednesday30', 8),
(30, '9_30.jpg', '2014/April/Wednesday30', 9),
(31, '9_31.jpg', '2014/April/Wednesday30', 9),
(32, '9_32.jpg', '2014/April/Wednesday30', 9),
(33, '9_33.jpg', '2014/April/Wednesday30', 9),
(34, '9_34.jpg', '2014/April/Wednesday30', 9),
(35, '9_35.jpg', '2014/April/Wednesday30', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE IF NOT EXISTS `municipios` (
  `id` int(11) NOT NULL,
  `municipio` varchar(250) NOT NULL,
  `cabecera` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id`, `municipio`, `cabecera`) VALUES
(1, 'Acacoyagua', 'Acacoyagua'),
(2, 'Acala', 'Acala'),
(3, 'Acapetahua', 'Acapetahua'),
(4, 'Altamirano', 'Altamirano'),
(5, 'Amatán', 'Amatán'),
(6, 'Amatenango de la Frontera', 'Amatenango de la Frontera'),
(7, 'Amatenango del Valle', 'Amatenango del Valle'),
(8, 'Ángel Albino Corzo', 'Jaltenango de la Paz'),
(9, 'Arriaga', 'Arriaga'),
(10, 'Bejucal de Ocampo', 'Bejucal de Ocampo'),
(11, 'Bella Vista', 'Bella Vista'),
(12, 'BerriozÃ¡bal', 'BerriozÃ¡bal'),
(13, 'Bochil', 'Bochil'),
(14, 'El Bosque', 'El Bosque'),
(15, 'CacahoatÃ¡n', 'CacahoatÃ¡n'),
(16, 'CatazajÃ¡', 'CatazajÃ¡'),
(17, 'Cintalapa', 'Cintalapa de Figueroa'),
(18, 'Coapilla', 'Coapila'),
(19, 'ComitÃ¡n de DomÃ­nguez', 'ComitÃ¡n de DomÃ­nguez'),
(20, 'La Concordia', 'La Concordia'),
(21, 'Copainal', 'Copainal'),
(22, 'Chalchihuit', 'Chalchihuit'),
(23, 'Chamula', 'San Juan Chamula'),
(24, 'Chanal', 'Chanal'),
(25, 'Chapultenango', 'Chapultenango'),
(26, 'Chenalh', 'Chenalh'),
(27, 'Chiapa de Corzo', 'Chiapa de Corzo'),
(28, 'Chiapilla', 'Chiapilla'),
(29, 'Chicoas', 'Chicoas'),
(30, 'Chicomuselo', 'Chicomuselo'),
(31, 'Chil', 'Chil'),
(32, 'Escuintla', 'Escuintla'),
(33, 'Francisco Le', 'Rivera el Viejo Carmen'),
(34, 'Frontera Comalapa', 'Frontera Comalapa'),
(35, 'Frontera Hidalgo', 'Frontera Hidalgo'),
(36, 'La Grandeza', 'La Grandeza'),
(37, 'Huehuet', 'Huehuet'),
(38, 'Huixt', 'Huixt'),
(39, 'Huitiup', 'Huitiup'),
(40, 'Huixtla', 'Huixtla'),
(41, 'La Independencia', 'La Independencia'),
(42, 'Ixhuat', 'Ixhuat'),
(43, 'Ixtacomit', 'Ixtacomit'),
(44, 'Ixtapa', 'Ixtapa'),
(45, 'Ixtapangajoya', 'Ixtapangajoya'),
(46, 'Jiquipilas', 'Jiquipilas'),
(47, 'Jitotol', 'Jitotol'),
(48, 'Ju', 'Ju'),
(49, 'Larr', 'San Andr'),
(50, 'La Libertad', 'La Libertad'),
(51, 'Mapastepec', 'Mapastepec'),
(52, 'Las Margaritas', 'Las Margaritas'),
(53, 'Mazapa de Madero', 'Mazapa de Madero'),
(54, 'Mazat', 'Mazat'),
(55, 'Metapa', 'Metapa de Dom'),
(56, 'Mitontic', 'Mitontic'),
(57, 'Motozintla', 'Motozintla'),
(58, 'Nicol', 'Nicol'),
(59, 'Ocosingo', 'Ocosingo'),
(60, 'Ocotepec', 'Ocotepec'),
(61, 'Ocozocoautla de Espinosa', 'Ocozocoautla de Espinosa'),
(62, 'Ostuac', 'Ostuac'),
(63, 'Osumacinta', 'Osumacinta'),
(64, 'Oxchuc', 'Oxchuc'),
(65, 'Palenque', 'Palenque'),
(66, 'Pantelh', 'Pantelh'),
(67, 'Pantepec', 'Pantepec'),
(68, 'Pichucalco', 'Pichucalco'),
(69, 'Pijijiapan', 'Pijijiapan'),
(70, 'El Porvenir', 'El Porvenir de Velasco Su'),
(71, 'Villa Comaltitl', 'Villa Comaltitl'),
(72, 'Pueblo Nuevo Solistahuac', 'Pueblo Nuevo Solistahuac'),
(73, 'Ray', 'Ray'),
(74, 'Reforma', 'Reforma'),
(75, 'Las Rosas', 'Las Rosas'),
(76, 'Sabanilla', 'Sabanilla'),
(77, 'Salto de Agua', 'Salto de Agua'),
(78, 'San Crist', 'San Crist'),
(79, 'San Fernando', 'San Fernando'),
(80, 'Siltepec', 'Siltepec'),
(81, 'Simojovel', 'Simojovel de Allende'),
(82, 'Sital', 'Sital'),
(83, 'Socoltenango', 'Socoltenango'),
(84, 'Solosuchiapa', 'Solosuchiapa'),
(85, 'Soyal', 'Soyal'),
(86, 'Suchiapa', 'Suchiapa'),
(87, 'Suchiate', 'Ciudad Hidalgo'),
(88, 'Sunuapa', 'Sunuapa'),
(89, 'Tapachula', 'Tapachula de C'),
(90, 'Tapalapa', 'Tapalapa'),
(91, 'Tapilula', 'Tapilula'),
(92, 'Tecpat', 'Tecpat'),
(93, 'Tenejapa', 'Tenejapa'),
(94, 'Teopisca', 'Teopisca'),
(95, 'En la actualidad no existe municipio con la clave 0952', ''),
(96, 'Tila', 'Tila'),
(97, 'Tonal', 'Tonal'),
(98, 'Totolapa', 'Totolapa'),
(99, 'La Trinitaria', 'La Trinitaria'),
(100, 'Tumbal', 'Tumbal'),
(101, 'Tuxtla GutiÃ©rrez', 'Tuxtla GutiÃ©rrez'),
(102, 'Tuxtla Chico', 'Tuxtla Chico'),
(103, 'Tuzant', 'Tuzant'),
(104, 'Tzimol', 'Tzimol'),
(105, 'Uni', 'Uni'),
(106, 'Venustiano Carranza', 'Venustiano Carranza'),
(107, 'Villa Corzo', 'Ciudad de Villa Corzo'),
(108, 'Villaflores', 'Villaflores'),
(109, 'Yajal', 'Yajal'),
(110, 'San Lucas', 'San Lucas'),
(111, 'Zinacant', 'Zinacant'),
(112, 'San Juan Cancuc', 'San Juan Cancuc'),
(113, 'Aldama', 'Aldama'),
(114, 'Benem', 'Benem'),
(115, 'Maravilla Tenejapa', 'Maravilla Tenejapa'),
(116, 'Marqu', 'Zamora Pico de Oro'),
(117, 'Montecristo de Guerrero', 'Montecristo de Guerrero'),
(118, 'San AndrÃ©s', 'San AndrÃ©s'),
(119, 'Santiago el Pinar', 'Santiago el Pinar'),
(120, 'Belisario Dom', 'Rodulfo Figueroa'),
(121, 'Emiliano Zapata', '20 de Noviembre'),
(122, 'El Parral', 'El Parral'),
(123, 'Mezcalapa', 'Raudales Malpaso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `tx_nombre` varchar(50) NOT NULL,
  `tx_apellidoPaterno` varchar(50) DEFAULT NULL,
  `tx_apellidoMaterno` varchar(50) DEFAULT NULL,
  `tx_correo` varchar(100) DEFAULT NULL,
  `tx_username` varchar(50) DEFAULT NULL,
  `tx_password` varchar(250) DEFAULT NULL,
  `id_TipoUsuario` int(11) DEFAULT NULL,
  `dt_registro` datetime DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `id_TipoUsuario` (`id_TipoUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tbl_users`
--

INSERT INTO `tbl_users` (`id_usuario`, `tx_nombre`, `tx_apellidoPaterno`, `tx_apellidoMaterno`, `tx_correo`, `tx_username`, `tx_password`, `id_TipoUsuario`, `dt_registro`) VALUES
(1, 'Leonides', 'Zavala', 'Vidal', 'lzavala@gmail.com', 'lzavala', 'eb0a191797624dd3a48fa681d3061212', 1, '2012-11-09 17:35:40');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`id_TipoUsuario`) REFERENCES `ctg_tiposusuario` (`id_TipoUsuario`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
