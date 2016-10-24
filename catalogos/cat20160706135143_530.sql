
CREATE TABLE `admin` (
  `id` int(11) NOT NULL default '1',
  `user_name` varchar(35) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `buenas_practicas`
-- 

CREATE TABLE `buenas_practicas` (
  `id_buena_practica` int(11) NOT NULL auto_increment,
  `id_empresa` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `diagnostico_inicial` text NOT NULL,
  `solucion` text NOT NULL,
  `resultado` text NOT NULL,
  `inversion` int(11) NOT NULL,
  `amortizacion` int(11) NOT NULL,
  `consumo_proceso_previo` int(11) NOT NULL,
  `consumo_proceso_posterior` int(11) NOT NULL,
  `ahorro_energetico` double(5,2) NOT NULL,
  `ahorro_economico` double(5,2) NOT NULL,
  `financiamiento` text NOT NULL,
  `img_folder` varchar(150) NOT NULL,
  PRIMARY KEY  (`id_buena_practica`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `catalogos`
-- 

CREATE TABLE `catalogos` (
  `id_catalogo` int(20) NOT NULL auto_increment,
  `nombre` varchar(200) NOT NULL,
  `archivo` varchar(250) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_proveedor` int(5) NOT NULL,
  PRIMARY KEY  (`id_catalogo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `diagnosticos`
-- 

CREATE TABLE `diagnosticos` (
  `id_diagnostico` int(20) NOT NULL auto_increment,
  `id_empresa` int(5) NOT NULL,
  `ranking` double(5,2) NOT NULL default '0.00',
  `consumo_especifico` double(5,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id_diagnostico`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `discusiones`
-- 

CREATE TABLE `discusiones` (
  `id_discusion` int(20) NOT NULL auto_increment,
  `titulo` varchar(250) NOT NULL,
  `mensaje` text NOT NULL,
  `id_tipo` int(2) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `id_mejora` int(10) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY  (`id_discusion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `empresas`
-- 

CREATE TABLE `empresas` (
  `id_user` int(10) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `rut` char(12) NOT NULL,
  `descripcion` text NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `web` varchar(150) NOT NULL,
  `rubro` varchar(150) NOT NULL,
  `produccion` varchar(100) NOT NULL,
  `situacion_gremial` int(11) NOT NULL,
  `nivel_ventas` int(11) NOT NULL,
  `realizado_eficiencia` int(11) NOT NULL,
  `realizado_capacitaciones` int(11) NOT NULL,
  `realizado_auditorias` int(11) NOT NULL,
  `realizado_implementacion` int(11) NOT NULL,
  `realizado_otras` varchar(250) NOT NULL,
  PRIMARY KEY  (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `energia`
-- 

CREATE TABLE `energia` (
  `id_energia` int(2) NOT NULL auto_increment,
  `energia` varchar(100) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id_energia`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `evaluacion_proveedores`
-- 

CREATE TABLE `evaluacion_proveedores` (
  `id_voto` int(11) NOT NULL auto_increment,
  `id_padre` int(11) NOT NULL default '0',
  `id_proveedor` int(10) NOT NULL,
  `nota` int(1) NOT NULL,
  `mensaje` text collate latin1_spanish_ci NOT NULL,
  `id_user` int(10) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY  (`id_voto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `eventos`
-- 

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `nombre` char(200) NOT NULL,
  `fecha` datetime NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `imagenes`
-- 

CREATE TABLE `imagenes` (
  `id_img` int(21) NOT NULL auto_increment,
  `imagen` varchar(50) NOT NULL,
  `id_user` int(11) NOT NULL,
  `principal` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id_img`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `imagenes_rubros`
-- 

CREATE TABLE `imagenes_rubros` (
  `id_img` int(21) NOT NULL auto_increment,
  `id_rubro` int(11) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `principal` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id_img`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `intereses_mejoras`
-- 

CREATE TABLE `intereses_mejoras` (
  `id_interes_mejora` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_mejora` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `intereses_proveedores`
-- 

CREATE TABLE `intereses_proveedores` (
  `id_intereses_proveedores` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `mejoras`
-- 

CREATE TABLE `mejoras` (
  `id_mejora` int(10) NOT NULL auto_increment,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY  (`id_mejora`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `mensajes`
-- 

CREATE TABLE `mensajes` (
  `id_mensaje` int(25) NOT NULL auto_increment,
  `mensaje` text NOT NULL,
  `id_discusion` int(20) NOT NULL,
  `id_padre` int(25) NOT NULL default '0',
  `id_user` int(10) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY  (`id_mensaje`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `operaciones`
-- 

CREATE TABLE `operaciones` (
  `id_operacion` int(10) NOT NULL auto_increment,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `uso_calor` int(1) NOT NULL,
  `uso_frio` int(1) NOT NULL,
  `uso_electricidad` int(1) NOT NULL,
  `uso_combustible` int(1) NOT NULL,
  `activo` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id_operacion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `proveedores`
-- 

CREATE TABLE `proveedores` (
  `id_user` int(10) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `logo` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `web` varchar(150) NOT NULL,
  `tipo` varchar(150) NOT NULL,
  `rubro` varchar(250) NOT NULL,
  `produccion` varchar(100) NOT NULL,
  `valoracion` double(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `proyectos`
-- 

CREATE TABLE `proyectos` (
  `id_proyecto` int(20) NOT NULL auto_increment,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `localizacion` varchar(150) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `recurso` varchar(100) NOT NULL,
  `tipo_energia` int(2) NOT NULL,
  `capacidad_instalada` int(2) NOT NULL,
  `procesos_intervenidos` varchar(50) NOT NULL,
  `energia_ahorro` double(10,2) NOT NULL,
  `porcentaje_ahorro` double(5,2) NOT NULL default '0.00',
  `inversion` int(11) NOT NULL,
  `payback_esperado` int(11) NOT NULL,
  `tipo_financiamiento` int(11) NOT NULL,
  `fecha_implementacion` datetime NOT NULL,
  `subsidio` int(11) NOT NULL,
  `modelo_negocio` varchar(200) NOT NULL,
  `rol_proveedor` varchar(200) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `img_folder` varchar(150) NOT NULL,
  PRIMARY KEY  (`id_proyecto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `proyectos_consultados`
-- 

CREATE TABLE `proyectos_consultados` (
  `id_rubro` int(5) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `porcentaje` double(5,2) NOT NULL,
  `id_pc` int(5) NOT NULL auto_increment,
  PRIMARY KEY  (`id_pc`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rubros`
-- 

CREATE TABLE `rubros` (
  `id_rubro` int(5) NOT NULL auto_increment,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` varchar(60) NOT NULL,
  `consumo_especifico` char(50) NOT NULL,
  `consumo_electrico` double(5,2) NOT NULL,
  `consumo_comb` double(5,2) NOT NULL,
  `diagrama_flujo` varchar(150) NOT NULL,
  `activo` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id_rubro`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rubros_mejoras`
-- 

CREATE TABLE `rubros_mejoras` (
  `id_rubro_mejora` int(11) NOT NULL,
  `id_rubro` int(11) NOT NULL,
  `id_mejora` int(11) NOT NULL,
  `ahorro_min` double(5,2) NOT NULL,
  `ahorro_max` double(5,2) NOT NULL,
  `pri_min` int(11) NOT NULL,
  `pri_max` int(11) NOT NULL,
  `valoracion` double(5,2) NOT NULL,
  `fuente` char(150) NOT NULL,
  `activo` int(1) NOT NULL default '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rubros_operaciones`
-- 

CREATE TABLE `rubros_operaciones` (
  `id_rubro_operacion` int(11) NOT NULL,
  `id_rubro` int(11) NOT NULL,
  `id_operacion` int(11) NOT NULL,
  `consumo_especifico` double(5,2) NOT NULL,
  `orden` int(11) NOT NULL,
  `fuente` char(150) NOT NULL,
  `activo` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id_rubro_operacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tipos_discusion`
-- 

CREATE TABLE `tipos_discusion` (
  `id_tipo` int(2) NOT NULL auto_increment,
  `titulo` varchar(200) collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id_tipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuarios`
-- 

CREATE TABLE `usuarios` (
  `id_user` int(10) NOT NULL auto_increment,
  `email` varchar(100) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `tipo` int(1) NOT NULL default '1',
  `activo` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuarios_eventos`
-- 

CREATE TABLE `usuarios_eventos` (
  `id_usuario_evento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;