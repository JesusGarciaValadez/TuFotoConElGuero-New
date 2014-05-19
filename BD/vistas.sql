
--
-- Estructura para la vista `ListaUsuarios`
--
DROP VIEW IF EXISTS `ListaUsuarios`;

  
CREATE VIEW `ListaUsuarios` AS select `tbl_users`.`tx_nombre` AS `tx_nombre`,`tbl_users`.`tx_apellidoPaterno` AS `tx_apellidoPaterno`,`ctg_tiposusuario`.`tx_TipoUsuario` AS `tx_TipoUsuario`,`tbl_users`.`id_usuario` AS `id_usuario` from (`tbl_users` left join `ctg_tiposusuario` on((`tbl_users`.`id_TipoUsuario` = `ctg_tiposusuario`.`id_TipoUsuario`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `View_CuentaFotos`
--

DROP VIEW IF EXISTS `View_CuentaFotos`; 

CREATE  VIEW  `View_CuentaFotos` AS select `evento`.`id` AS `evento`,count(0) AS `fotos` from (`evento` join `galeriaimagenes` on((`galeriaimagenes`.`evento` = `evento`.`id`))) group by `evento`.`id`;

-- --------------------------------------------------------

--
-- Estructura para la vista `View_DetalleEvento`
--

DROP VIEW IF EXISTS `View_DetalleEvento`;
CREATE   VIEW `View_DetalleEvento` AS select `detalle_evento`.`evento` AS `evento`,`municipios`.`municipio` AS `municipio`,`detalle_evento`.`tags` AS `tags`,`View_CuentaFotos`.`fotos` AS `fotos` from ((`detalle_evento` join `View_CuentaFotos` on((`View_CuentaFotos`.`evento` = `detalle_evento`.`evento`))) join `municipios` on((`municipios`.`id` = `detalle_evento`.`municipio`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `View_EventoReciente`
--

DROP VIEW IF EXISTS `View_EventoReciente`;
CREATE  view `View_EventoReciente` AS select `evento`.`descripcion` AS `descripcion`,`galeriaimagenes`.`evento` AS `evento`,count(`galeriaimagenes`.`id`) AS `Total` from (`galeriaimagenes` join `evento` on((`evento`.`id` = `galeriaimagenes`.`evento`))) group by `galeriaimagenes`.`evento`;

--
-- Estructura para la vista `View_ListaEventos`
--
DROP VIEW IF EXISTS `View_ListaEventos`;

CREATE  view `View_ListaEventos` AS select `galeriaimagenes`.`evento` AS `evento`,`evento`.`evento` AS `titulo`,`evento`.`descripcion` AS `descripcion`,`evento`.`fecha` AS `fecha`,`evento`.`activo` AS `activo`,`galeriaimagenes`.`id` AS `id`,`galeriaimagenes`.`directorio` AS `directorio`,`galeriaimagenes`.`archivo` AS `archivo` from (`evento` join `galeriaimagenes` on((`evento`.`id` = `galeriaimagenes`.`evento`))) group by `galeriaimagenes`.`evento` order by dayofmonth(`evento`.`fecha`) desc;

-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- Estructura para la vista `View_Eventos`
--

DROP VIEW IF EXISTS `View_Eventos`;
CREATE  view `View_Eventos` AS select `View_ListaEventos`.`evento` AS `evento`,`View_ListaEventos`.`titulo` AS `titulo`,`View_ListaEventos`.`descripcion` AS `descripcion`,`View_ListaEventos`.`fecha` AS `fecha`,`View_ListaEventos`.`activo` AS `activo`,`View_ListaEventos`.`id` AS `id`,`View_ListaEventos`.`directorio` AS `directorio`,`View_ListaEventos`.`archivo` AS `archivo`,`municipios`.`municipio` AS `municipio`,`detalle_evento`.`tags` AS `tags`,`municipios`.`id` AS `idmunicipio` from ((`View_ListaEventos` join `detalle_evento` on((`View_ListaEventos`.`evento` = `detalle_evento`.`evento`))) join `municipios` on((`municipios`.`id` = `detalle_evento`.`municipio`))) where (`View_ListaEventos`.`activo` = 1) group by `detalle_evento`.`evento`;

-- --------------------------------------------------------

--
-- Estructura para la vista `View_EventosAnios`
--

DROP VIEW IF EXISTS `View_EventosAnios`;
CREATE  view `View_EventosAnios` AS select year(`evento`.`fecha`) AS `Anio` from `evento` group by year(`evento`.`fecha`);

-- --------------------------------------------------------

--
-- Estructura para la vista `View_EventosMeses`
--

DROP VIEW IF EXISTS `View_EventosMeses`;
CREATE  view `View_EventosMeses` AS select month(`evento`.`fecha`) AS `Mes`,year(`evento`.`fecha`) AS `Anio` from `evento` where (`evento`.`activo` = 1) group by year(`evento`.`fecha`),month(`evento`.`fecha`) limit 0,30;

-- --------------------------------------------------------

--
-- Estructura para la vista `View_fotouser`
--

DROP VIEW IF EXISTS `View_fotouser`;
CREATE  view `View_fotouser` AS select `galeriaimagenes`.`id` AS `id`,`galeriaimagenes`.`archivo` AS `archivo`,`galeriaimagenes`.`directorio` AS `directorio`,`galeriaimagenes`.`evento` AS `evento`,`evento`.`fecha` AS `fecha` from (`galeriaimagenes` join `evento` on((`galeriaimagenes`.`evento` = `evento`.`id`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `View_GaleriaEvento`
--

DROP VIEW IF EXISTS `View_GaleriaEvento`;
CREATE  view `View_GaleriaEvento` AS select `e`.`id` AS `IdEvento`,`e`.`evento` AS `NombreEvento`,`e`.`descripcion` AS `Descripcion`,`e`.`fecha` AS `fecha`,`g`.`id` AS `IdImagen`,`g`.`archivo` AS `archivo`,`g`.`directorio` AS `directorio` from (`evento` `e` join `galeriaimagenes` `g` on((`e`.`id` = `g`.`evento`))) where (`e`.`activo` = 1);

-- --------------------------------------------------------

--
-- Estructura para la vista `View_GaleriaTop`
--

DROP VIEW IF EXISTS `View_GaleriaTop`;
CREATE  view `View_GaleriaTop` AS select `galeriaimagenes`.`id` AS `id`,`galeriaimagenes`.`archivo` AS `archivo`,`galeriaimagenes`.`directorio` AS `directorio`,`galeriaimagenes`.`evento` AS `evento`,`evento`.`fecha` AS `fecha` from (`galeriaimagenes` join `evento` on((`galeriaimagenes`.`evento` = `evento`.`id`))) where (`evento`.`activo` = 1) order by rand() limit 24;

-- --------------------------------------------------------


--
-- Estructura para la vista `View_Lista_Imagenes`
--

DROP VIEW IF EXISTS `View_Lista_Imagenes`;
CREATE  view `View_Lista_Imagenes` AS select `galeriaimagenes`.`id` AS `id`,`galeriaimagenes`.`archivo` AS `archivo`,`galeriaimagenes`.`directorio` AS `directorio`,`galeriaimagenes`.`evento` AS `evento` from `galeriaimagenes`;

-- --------------------------------------------------------

--
-- Estructura para la vista `View_ResumenEventos`
--

DROP VIEW IF EXISTS `View_ResumenEventos`;
CREATE  view `View_ResumenEventos` AS select `galeriaimagenes`.`id` AS `id`,`galeriaimagenes`.`archivo` AS `archivo`,`galeriaimagenes`.`directorio` AS `directorio`,`galeriaimagenes`.`evento` AS `evento`,`evento`.`fecha` AS `fecha` from (`evento` join `galeriaimagenes` on((`galeriaimagenes`.`evento` = `evento`.`id`))) where (`evento`.`activo` = 1) group by `galeriaimagenes`.`evento` order by dayofmonth(`evento`.`fecha`) desc;
