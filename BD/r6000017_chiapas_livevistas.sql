-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-02-2014 a las 01:36:34
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
-- Estructura Stand-in para la vista `View_CuentaFotos`
--
CREATE TABLE IF NOT EXISTS `View_CuentaFotos` (
`evento` int(11)
,`fotos` bigint(21)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `View_DetalleEvento`
--
CREATE TABLE IF NOT EXISTS `View_DetalleEvento` (
`evento` int(11)
,`municipio` varchar(250)
,`tags` varchar(250)
,`fotos` bigint(21)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `View_EventoReciente`
--
CREATE TABLE IF NOT EXISTS `View_EventoReciente` (
`descripcion` varchar(600)
,`evento` int(11)
,`Total` bigint(21)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `View_EventosAnios`
--
CREATE TABLE IF NOT EXISTS `View_EventosAnios` (
`Anio` int(4)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `View_EventosMeses`
--
CREATE TABLE IF NOT EXISTS `View_EventosMeses` (
`Mes` int(2)
,`Anio` int(4)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `View_fotouser`
--
CREATE TABLE IF NOT EXISTS `View_fotouser` (
`id` int(11)
,`archivo` varchar(200)
,`directorio` varchar(200)
,`evento` int(11)
,`fecha` date
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `View_GaleriaEvento`
--
CREATE TABLE IF NOT EXISTS `View_GaleriaEvento` (
`IdEvento` int(11)
,`NombreEvento` varchar(200)
,`Descripcion` varchar(600)
,`fecha` date
,`IdImagen` int(11)
,`archivo` varchar(200)
,`directorio` varchar(200)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `View_GaleriaTop`
--
CREATE TABLE IF NOT EXISTS `View_GaleriaTop` (
`id` int(11)
,`archivo` varchar(200)
,`directorio` varchar(200)
,`evento` int(11)
,`fecha` date
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `View_Lista_Imagenes`
--
CREATE TABLE IF NOT EXISTS `View_Lista_Imagenes` (
`id` int(11)
,`archivo` varchar(200)
,`directorio` varchar(200)
,`evento` int(11)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `View_ResumenEventos`
--
CREATE TABLE IF NOT EXISTS `View_ResumenEventos` (
`id` int(11)
,`archivo` varchar(200)
,`directorio` varchar(200)
,`evento` int(11)
,`fecha` date
);
-- --------------------------------------------------------

--
-- Estructura para la vista `View_CuentaFotos`
--
DROP TABLE IF EXISTS `View_CuentaFotos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`r6000017`@`%` SQL SECURITY DEFINER VIEW `View_CuentaFotos` AS select `evento`.`id` AS `evento`,count(0) AS `fotos` from (`evento` join `galeriaimagenes` on((`galeriaimagenes`.`evento` = `evento`.`id`))) group by `evento`.`id`;

-- --------------------------------------------------------

--
-- Estructura para la vista `View_DetalleEvento`
--
DROP TABLE IF EXISTS `View_DetalleEvento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`r6000017`@`%` SQL SECURITY DEFINER VIEW `View_DetalleEvento` AS select `detalle_evento`.`evento` AS `evento`,`detalle_evento`.`municipio` AS `municipio`,`detalle_evento`.`tags` AS `tags`,`View_CuentaFotos`.`fotos` AS `fotos` from (`detalle_evento` join `View_CuentaFotos` on((`View_CuentaFotos`.`evento` = `detalle_evento`.`evento`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `View_EventoReciente`
--
DROP TABLE IF EXISTS `View_EventoReciente`;

CREATE ALGORITHM=UNDEFINED DEFINER=`r6000017`@`%` SQL SECURITY DEFINER VIEW `View_EventoReciente` AS select `evento`.`descripcion` AS `descripcion`,`galeriaimagenes`.`evento` AS `evento`,count(`galeriaimagenes`.`id`) AS `Total` from (`galeriaimagenes` join `evento` on((`evento`.`id` = `galeriaimagenes`.`evento`))) group by `galeriaimagenes`.`evento`;

-- --------------------------------------------------------

--
-- Estructura para la vista `View_EventosAnios`
--
DROP TABLE IF EXISTS `View_EventosAnios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`r6000017`@`%` SQL SECURITY DEFINER VIEW `View_EventosAnios` AS select year(`evento`.`fecha`) AS `Anio` from `evento` group by year(`evento`.`fecha`);

-- --------------------------------------------------------

--
-- Estructura para la vista `View_EventosMeses`
--
DROP TABLE IF EXISTS `View_EventosMeses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`r6000017`@`%` SQL SECURITY DEFINER VIEW `View_EventosMeses` AS select month(`evento`.`fecha`) AS `Mes`,year(`evento`.`fecha`) AS `Anio` from `evento` group by year(`evento`.`fecha`),month(`evento`.`fecha`);

-- --------------------------------------------------------

--
-- Estructura para la vista `View_fotouser`
--
DROP TABLE IF EXISTS `View_fotouser`;

CREATE ALGORITHM=UNDEFINED DEFINER=`r6000017`@`%` SQL SECURITY DEFINER VIEW `View_fotouser` AS select `galeriaimagenes`.`id` AS `id`,`galeriaimagenes`.`archivo` AS `archivo`,`galeriaimagenes`.`directorio` AS `directorio`,`galeriaimagenes`.`evento` AS `evento`,`evento`.`fecha` AS `fecha` from (`galeriaimagenes` join `evento` on((`galeriaimagenes`.`evento` = `evento`.`id`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `View_GaleriaEvento`
--
DROP TABLE IF EXISTS `View_GaleriaEvento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`r6000017`@`%` SQL SECURITY DEFINER VIEW `View_GaleriaEvento` AS select `e`.`id` AS `IdEvento`,`e`.`evento` AS `NombreEvento`,`e`.`descripcion` AS `Descripcion`,`e`.`fecha` AS `fecha`,`g`.`id` AS `IdImagen`,`g`.`archivo` AS `archivo`,`g`.`directorio` AS `directorio` from (`evento` `e` join `galeriaimagenes` `g` on((`e`.`id` = `g`.`evento`))) where (`e`.`activo` = 1);

-- --------------------------------------------------------

--
-- Estructura para la vista `View_GaleriaTop`
--
DROP TABLE IF EXISTS `View_GaleriaTop`;

CREATE ALGORITHM=UNDEFINED DEFINER=`r6000017`@`%` SQL SECURITY DEFINER VIEW `View_GaleriaTop` AS select `galeriaimagenes`.`id` AS `id`,`galeriaimagenes`.`archivo` AS `archivo`,`galeriaimagenes`.`directorio` AS `directorio`,`galeriaimagenes`.`evento` AS `evento`,`evento`.`fecha` AS `fecha` from (`galeriaimagenes` join `evento` on((`galeriaimagenes`.`evento` = `evento`.`id`))) where (`evento`.`activo` = 1) order by rand() limit 24;

-- --------------------------------------------------------

--
-- Estructura para la vista `View_Lista_Imagenes`
--
DROP TABLE IF EXISTS `View_Lista_Imagenes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`r6000017`@`%` SQL SECURITY DEFINER VIEW `View_Lista_Imagenes` AS select `galeriaimagenes`.`id` AS `id`,`galeriaimagenes`.`archivo` AS `archivo`,`galeriaimagenes`.`directorio` AS `directorio`,`galeriaimagenes`.`evento` AS `evento` from `galeriaimagenes`;

-- --------------------------------------------------------

--
-- Estructura para la vista `View_ResumenEventos`
--
DROP TABLE IF EXISTS `View_ResumenEventos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`r6000017`@`%` SQL SECURITY DEFINER VIEW `View_ResumenEventos` AS select `galeriaimagenes`.`id` AS `id`,`galeriaimagenes`.`archivo` AS `archivo`,`galeriaimagenes`.`directorio` AS `directorio`,`galeriaimagenes`.`evento` AS `evento`,`evento`.`fecha` AS `fecha` from (`evento` join `galeriaimagenes` on((`galeriaimagenes`.`evento` = `evento`.`id`))) where (`evento`.`activo` = 1) group by `galeriaimagenes`.`evento` order by dayofmonth(`evento`.`fecha`) desc;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
