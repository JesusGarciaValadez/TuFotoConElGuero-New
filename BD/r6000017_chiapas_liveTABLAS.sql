-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-02-2014 a las 01:35:36
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `detalle_evento`
--

INSERT INTO `detalle_evento` (`id`, `evento`, `municipio`, `tags`) VALUES
(1, 17, 'Arriaga', 'Evento No. 1'),
(2, 18, 'Arriaga', 'Tuxtla Gutiérrez'),
(3, 19, 'Arriaga', 'Tuxtla Evento No. 2'),
(4, 20, 'Arriaga', 'Tuxtla Gutiérrez'),
(5, 21, 'Arriaga', 'Tuxtla Gutiérrez'),
(6, 22, 'Arriaga', 'Tuxtla Gutiérrez'),
(7, 23, 'Arriaga', 'Tuxtla Gutiérrez'),
(8, 24, 'Arriaga', 'Tuxtla Gutiérrez'),
(9, 17, 'Arriaga', 'Evento No. 1'),
(10, 18, 'Arriaga', 'algo'),
(11, 19, 'Arriaga', 'nombre del evento'),
(12, 20, 'Arriaga', 'nombre del evento'),
(13, 21, 'Arriaga', 'nombre del evento'),
(14, 22, 'Arriaga', 'nombre del evento'),
(15, 23, 'Arriaga', 'nombre del evento'),
(16, 24, 'Arriaga', 'nombre del evento');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`id`, `evento`, `descripcion`, `fecha`, `activo`) VALUES
(17, 'Evento No. 1', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2013-12-03', 1),
(18, '12/02/2013', '-', '2013-12-04', 0),
(19, 'Evento No. 2', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2013-12-05', 1),
(20, 'Evento No. 3', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2013-12-06', 1),
(21, 'evento 9 de dic 2013', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2013-12-09', 1),
(31, 'evento 4 ', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2013-12-01', 0),
(32, 'evento 4 ', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2013-12-01', 1),
(33, 'evento 5', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2013-12-02', 1),
(34, 'evento007', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2013-12-04', 1),
(35, 'EVENTO006', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2013-12-08', 1),
(36, 'evento008', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2013-12-07', 1),
(37, 'evento009', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2013-12-05', 1),
(38, 'evento10', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2013-12-04', 1),
(39, 'evento11', 'evento009', '2013-12-08', 1),
(40, 'evento12', 'evento009', '2013-12-04', 1),
(41, 'evento13', 'evento009', '2013-12-05', 1),
(42, 'evento 1 enero', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2014-01-01', 1),
(43, 'evento 2 enero ', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2014-01-02', 1),
(44, 'evento 1 febrero', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel\r\n', '2014-02-01', 1),
(45, 'evento 3 de enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-03', 1),
(46, 'evento 4 enero ', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-04', 1),
(47, 'evento5 enero ', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-05', 1),
(48, 'evento 6 enero ', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-06', 1),
(49, 'evento 7 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-07', 1),
(50, 'evento 8 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-08', 1),
(51, 'evento 9 de enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-09', 1),
(52, 'evento 10 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-10', 1),
(53, 'evento 11 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-11', 1),
(54, 'evento 12 de enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-12', 1),
(55, 'evento 13 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-13', 1),
(56, 'evento 14 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-14', 1),
(57, 'evento 15 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-15', 1),
(58, 'evento 16 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-16', 1),
(59, 'evento 17', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-02-17', 1),
(60, 'evento 17 de enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-17', 1),
(61, 'evento 17 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-17', 1),
(62, 'evento 18 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-18', 1),
(63, 'evento 19 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-19', 1),
(64, 'evento 20 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-20', 1),
(65, 'evento 21 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-21', 1),
(66, 'evento 22 de enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-22', 1),
(67, 'evento 23 enenro', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-23', 1),
(68, 'evento 24 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-24', 1),
(69, 'evento 25 enero', 'El trozo de texto estÃ¡ndar de Lorem Ipsum usado desde el aÃ±o 1500 es reproducido debajo para aquellos interesados. Las secciones 1.10.32 y 1.10.33 de ', '2014-01-25', 1),
(70, 'evento 2 febrero ', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2014-02-02', 1),
(71, 'evento 3 febrero', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2014-02-03', 1),
(72, 'evento 4 febrero', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2014-02-04', 1),
(73, 'evento 5 febrero', 'Etiam porta sem malesuada magna mollis euismod. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis ornare vel', '2014-02-05', 1),
(74, 'evento 1 de febrero', 'En caso de Ã©xito, devuelve un identificador de recurso de imagen, y FALSE en caso de error.\r\n', '2014-02-01', 1),
(75, 'evento 3 del 1 de febrero', 'Si el archivo no se puede abrir, se ejecuta la instrucciÃ³n que se encuentra luego del operador "or" en nuestro caso llamamos a la funciÃ³n die que fina', '2014-02-01', 1),
(76, 'evento 4 del 1 de febrero ', 'Si el archivo no se puede abrir, se ejecuta la instrucciÃ³n que se encuentra luego del operador "or" en nuestro caso llamamos a la funciÃ³n die que fina', '2014-02-01', 1),
(77, 'evento 4 del 1 de febrero ', 'Si el archivo no se puede abrir, se ejecuta la instrucciÃ³n que se encuentra luego del operador "or" en nuestro caso llamamos a la funciÃ³n die que fina', '2014-02-01', 1),
(78, '1 nov 2013', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean aliquam ac risus id sodales. In sit amet nisl sed orci dictum accumsan. Mauris leo mag', '2013-11-01', 1),
(79, 'evento 2 nov 2013', 'Phasellus at vestibulum risus, et iaculis arcu. Nulla ac lacinia nibh. Morbi convallis tellus eu metus porttitor pellentesque. Phasellus ac interdum l', '2013-11-02', 1),
(80, 'evento 2 del 1 nov 2013', 'Phasellus at vestibulum risus, et iaculis arcu. Nulla ac lacinia nibh. Morbi convallis tellus eu metus porttitor pellentesque. Phasellus ac interdum l', '2013-11-01', 1),
(81, '1 oct 2013 ', 'Phasellus at vestibulum risus, et iaculis arcu. Nulla ac lacinia nibh. Morbi convallis tellus eu metus porttitor pellentesque. Phasellus ac interdum l', '2013-10-31', 1),
(82, '17 sep 2013', 'Phasellus at vestibulum risus, et iaculis arcu. Nulla ac lacinia nibh. Morbi convallis tellus eu metus porttitor pellentesque. Phasellus ac interdum l', '2013-09-17', 1),
(83, '6 feb 2014', 'Phasellus at vestibulum risus, et iaculis arcu. Nulla ac lacinia nibh. Morbi convallis tellus eu metus porttitor pellentesque. Phasellus ac interdum l', '2014-02-06', 1),
(84, '7 feb 2014', 'Phasellus at vestibulum risus, et iaculis arcu. Nulla ac lacinia nibh. Morbi convallis tellus eu metus porttitor pellentesque. Phasellus ac interdum l', '2014-02-07', 1),
(85, '8 feb 2014', 'Phasellus at vestibulum risus, et iaculis arcu. Nulla ac lacinia nibh. Morbi convallis tellus eu metus porttitor pellentesque. Phasellus ac interdum l', '2014-02-08', 1),
(86, '7 feb 2014', 'Phasellus at vestibulum risus, et iaculis arcu. Nulla ac lacinia nibh. Morbi convallis tellus eu metus porttitor pellentesque. Phasellus ac interdum l', '2014-02-07', 1),
(87, '9 feb 2014', 'Phasellus at vestibulum risus, et iaculis arcu. Nulla ac lacinia nibh. Morbi convallis tellus eu metus porttitor pellentesque. Phasellus ac interdum l', '2014-02-09', 1),
(88, '10 feb 2014', 'Phasellus at vestibulum risus, et iaculis arcu. Nulla ac lacinia nibh. Morbi convallis tellus eu metus porttitor pellentesque. Phasellus ac interdum l', '2014-02-10', 1),
(89, '11 feb 2014 ', 'Phasellus at vestibulum risus, et iaculis arcu. Nulla ac lacinia nibh. Morbi convallis tellus eu metus porttitor pellentesque. Phasellus ac interdum l', '2014-02-12', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=568 ;

--
-- Volcado de datos para la tabla `galeriaimagenes`
--

INSERT INTO `galeriaimagenes` (`id`, `archivo`, `directorio`, `evento`) VALUES
(27, '6I2A6136.jpg', 'Evento-1', 17),
(28, 'DSC_0062.jpg', 'Evento-1', 17),
(29, 'DSC_0115.jpg', 'Evento-1', 17),
(30, 'DSC_0375.jpg', 'Evento-1', 17),
(31, 'IMG_8122.jpg', 'Evento-1', 17),
(32, 'IMG_8683.jpg', 'Evento-1', 17),
(33, 'IMG_8814.jpg', 'default', 18),
(34, 'IMG_8805.jpg', 'default', 18),
(42, 'IMG_8780.jpg', 'Evento-3', 20),
(43, 'IMG_8783.jpg', 'Evento-3', 20),
(44, 'IMG_8789.jpg', 'Evento-3', 20),
(45, 'IMG_8796.jpg', 'Evento-3', 20),
(46, 'IMG_8818.jpg', 'Evento-3', 20),
(165, '2.jpg', 'Evento-1', 17),
(172, '9.jpg', 'Evento-1', 17),
(175, '12.jpg', 'Evento-1', 17),
(176, '13.jpg', 'Evento-1', 17),
(178, '15.jpg', 'Evento-1', 17),
(180, '17.jpg', 'Evento-1', 17),
(181, '18.jpg', 'Evento-1', 17),
(185, '22.jpg', 'Evento-1', 17),
(186, '23.jpg', 'Evento-1', 17),
(187, '24.jpg', 'Evento-1', 17),
(189, '26.jpg', 'Evento-1', 17),
(190, '27.jpg', 'Evento-1', 17),
(191, '28.jpg', 'Evento-1', 17),
(192, '29.jpg', 'Evento-1', 17),
(193, '30.jpg', 'Evento-1', 17),
(194, '31.jpg', 'Evento-1', 17),
(195, '32.jpg', 'Evento-1', 17),
(196, '33.jpg', 'Evento-1', 17),
(197, '34.jpg', 'Evento-1', 17),
(198, '35.jpg', 'Evento-1', 17),
(199, '36.jpg', 'Evento-1', 17),
(200, '37.jpg', 'Evento-1', 17),
(201, '38.jpg', 'Evento-1', 17),
(202, '39.jpg', 'Evento-1', 17),
(203, '40.jpg', 'Evento-1', 17),
(204, '41.jpg', 'Evento-1', 17),
(205, '42.jpg', 'Evento-1', 17),
(206, '43.jpg', 'Evento-1', 17),
(207, '44.jpg', 'Evento-1', 17),
(208, '45.jpg', 'Evento-1', 17),
(209, '46.jpg', 'Evento-1', 17),
(210, '47.jpg', 'Evento-1', 17),
(211, '48.jpg', 'Evento-1', 17),
(212, '49.jpg', 'Evento-1', 17),
(213, '50.jpg', 'Evento-1', 17),
(214, '51.jpg', 'Evento-1', 17),
(215, '52.jpg', 'Evento-1', 17),
(216, '53.jpg', 'Evento-1', 17),
(270, '1.jpg', 'Evento-3', 20),
(271, '2.jpg', 'Evento-3', 20),
(272, '3.jpg', 'Evento-3', 20),
(273, '4.jpg', 'Evento-3', 20),
(274, '5.jpg', 'Evento-3', 20),
(275, '6.jpg', 'Evento-3', 20),
(277, '8.jpg', 'Evento-3', 20),
(278, '9.jpg', 'Evento-3', 20),
(279, '10.jpg', 'Evento-3', 20),
(280, '11.jpg', 'Evento-3', 20),
(281, '12.jpg', 'Evento-3', 20),
(282, '13.jpg', 'Evento-3', 20),
(283, '14.jpg', 'Evento-3', 20),
(284, '15.jpg', 'Evento-3', 20),
(285, '16.jpg', 'Evento-3', 20),
(286, '17.jpg', 'Evento-3', 20),
(287, '18.jpg', 'Evento-3', 20),
(288, '19.jpg', 'Evento-3', 20),
(289, '20.jpg', 'Evento-3', 20),
(290, '21.jpg', 'Evento-3', 20),
(291, '22.jpg', 'Evento-3', 20),
(292, '23.jpg', 'Evento-3', 20),
(293, '24.jpg', 'Evento-3', 20),
(294, '25.jpg', 'Evento-3', 20),
(295, '26.jpg', 'Evento-3', 20),
(296, '27.jpg', 'Evento-3', 20),
(297, '28.jpg', 'Evento-3', 20),
(298, '29.jpg', 'Evento-3', 20),
(299, '30.jpg', 'Evento-3', 20),
(300, '31.jpg', 'Evento-3', 20),
(301, '32.jpg', 'Evento-3', 20),
(302, '33.jpg', 'Evento-3', 20),
(303, '34.jpg', 'Evento-3', 20),
(304, '35.jpg', 'Evento-3', 20),
(305, '36.jpg', 'Evento-3', 20),
(306, '37.jpg', 'Evento-3', 20),
(307, '38.jpg', 'Evento-3', 20),
(308, '39.jpg', 'Evento-3', 20),
(309, '40.jpg', 'Evento-3', 20),
(310, '41.jpg', 'Evento-3', 20),
(311, '42.jpg', 'Evento-3', 20),
(312, '43.jpg', 'Evento-3', 20),
(313, '44.jpg', 'Evento-3', 20),
(314, '45.jpg', 'Evento-3', 20),
(315, '46.jpg', 'Evento-3', 20),
(316, '47.jpg', 'Evento-3', 20),
(317, '48.jpg', 'Evento-3', 20),
(318, '49.jpg', 'Evento-3', 20),
(319, '50.jpg', 'Evento-3', 20),
(320, '51.jpg', 'Evento-3', 20),
(321, '52.jpg', 'Evento-3', 20),
(322, '53.jpg', 'Evento-3', 20),
(488, '40.jpg', 'EVENTO006', 35),
(489, '18.jpg', 'evento008', 36),
(490, '28.jpg', 'evento009', 37),
(491, '31.jpg', 'evento10', 38),
(492, '22.jpg', 'evento11', 39),
(493, '49.jpg', 'evento12', 40),
(495, 'IMG_9694.jpg', 'enero', 42),
(496, '7.jpg', 'default', 43),
(497, 'deporte.jpg', 'febrero', 44),
(498, 'deporte3.jpg', 'enero', 45),
(499, 'deporte4.jpg', 'enero', 46),
(500, 'deporte5.jpg', 'enero', 47),
(501, 'deporte6.jpg', 'enero', 48),
(502, 'deporte7.jpg', 'enero', 49),
(503, 'deporte8.jpg', 'enero', 50),
(504, 'deporte9.jpg', 'enero', 51),
(505, 'deporte10.jpg', 'enero', 52),
(506, '12_2.jpg', 'enero', 53),
(507, '13.jpg', 'enero', 54),
(508, '14.jpg', 'enero', 55),
(509, '15.jpg', 'enero', 56),
(510, '16.jpg', 'enero', 57),
(511, '17.jpg', 'enero', 58),
(512, '25-2.jpg', 'enero', 59),
(513, '20.jpg', 'enero', 61),
(514, '21.jpg', 'enero', 62),
(515, '22.jpg', 'enero', 63),
(516, '23-2.jpg', 'enero', 64),
(517, '24.jpg', 'enero', 65),
(518, '27-2.jpg', 'enero', 66),
(519, '26-2.jpg', 'enero', 67),
(520, '29-2.jpg', 'enero', 68),
(521, '30.jpg', 'enero', 69),
(530, '70.jpg', 'febrero', 70),
(531, '71.jpg', 'febrero', 71),
(532, '72.jpg', 'febrero', 72),
(533, '73.jpg', 'febrero', 73),
(534, '59.jpg', 'febrero', 59),
(540, '01022014.jpg', 'febrero', 44),
(541, '74.jpg', 'febrero', 74),
(542, '75.jpg', 'febrero', 75),
(543, '01022014-2.jpg', 'febrero', 77),
(544, '17.jpg', 'noviembre', 78),
(545, '6.jpg', 'noviembre', 79),
(546, 'IMG_4730.jpg', 'noviembre', 80),
(547, 'IMG_4734.jpg', 'noviembre', 80),
(548, 'IMG_2540.jpg', 'octubre', 81),
(549, 'IMG_2540-2.jpg', 'septiembre', 82),
(550, '6.jpg', 'febrero', 83),
(551, '8.jpg', 'febrero', 85),
(552, '7-2.jpg', 'febrero', 86),
(553, '9.jpg', 'febrero', 87),
(554, '10.jpg', 'febrero', 88),
(555, '11.jpg', 'febrero', 89),
(556, '6.jpg', '', 32),
(557, '2.jpg', '', 32),
(558, 'evento22.jpg', 'Evento-2', 19),
(559, 'evento23.jpg', 'Evento-2', 19),
(560, '71.jpg', 'evento007', 34),
(561, '72.jpg', 'evento007', 34),
(562, '73.jpg', 'evento007', 34),
(563, '51.jpg', 'evento005', 33),
(564, '522.jpg', 'evento005', 33),
(565, '131.jpg', 'default', 41),
(566, '91.jpg', '13-12t', 21),
(567, '92.jpg', '13-12t', 21);

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
(12, 'Berriozábal', 'Berriozábal'),
(13, 'Bochil', 'Bochil'),
(14, 'El Bosque', 'El Bosque'),
(15, 'Cacahoat', 'Cacahoat'),
(16, 'Catazaj', 'Catazaj'),
(17, 'Cintalapa', 'Cintalapa de Figueroa'),
(18, 'Coapilla', 'Coapila'),
(19, 'Comit', 'Comit'),
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
(101, 'Tuxtla Gutiérrez', 'Tuxtla Gutiérrez'),
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
(118, 'San Andr', 'San Andr'),
(119, 'Santiago el Pinar', 'Santiago el Pinar'),
(120, 'Belisario Dom', 'Rodulfo Figueroa'),
(121, 'Emiliano Zapata3', '20 de Noviembre'),
(122, 'El Parral3', 'El Parral'),
(123, 'Mezcalapa3', 'Raudales Malpaso');

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
