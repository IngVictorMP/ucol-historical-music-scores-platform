-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2023 a las 15:37:10
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bibliotecafime`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `Codigo_Libro` int(10) NOT NULL COMMENT 'Codigo del libro',
  `Nombre_Libro` varchar(60) NOT NULL COMMENT 'Nombre del libro',
  `Editorial` varchar(25) NOT NULL COMMENT 'Editorial Libro',
  `Autor` varchar(25) NOT NULL COMMENT 'Autor Del Libro',
  `Genero` varchar(25) NOT NULL COMMENT 'Genero del Libro',
  `Pais_Autor` varchar(25) NOT NULL COMMENT 'Pais del Autor',
  `Num_Paginas` int(5) NOT NULL COMMENT 'Numero de Paginas del libro',
  `Año_Edicion` year(4) NOT NULL COMMENT 'Año de Edicion del libro',
  `Precio_Libro` double NOT NULL COMMENT 'Precio del libro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`Codigo_Libro`, `Nombre_Libro`, `Editorial`, `Autor`, `Genero`, `Pais_Autor`, `Num_Paginas`, `Año_Edicion`, `Precio_Libro`) VALUES
(1, 'Don Quijote de la Mancha I', 'Anaya', 'Miguel de Cervantes', 'Caballeresco', 'España', 517, '1991', 2750),
(2, 'Don Quijote de la Mancha II', 'Anaya', 'Miguel de Cervantes', 'Caballeresco', 'España', 611, '1991', 3125),
(3, 'Historias de Nueva Orleans', 'Alfaguara', 'William Faulkner', 'Novela', 'Estados Unidos', 186, '1985', 675),
(4, 'El Principito', 'Andina', 'Antoine Saint-Exupery', 'Aventura', 'Francia', 120, '1996', 750),
(5, 'El Principe', 'S.M.', 'Maquiavelo', 'Politico', 'Italia', 210, '1995', 1125),
(6, 'Diplomacia', 'S.M.', 'Henry Kissinger', 'Politico', 'Alemania', 825, '1997', 1750),
(7, 'Los Windsor', 'Plaza & Janes', 'Kitty Kelley', 'Biografias', 'Gran Bentaña', 620, '1998', 1130),
(8, 'El Ultimo Emperador', 'Caralt', 'Pu-Yi', 'Autobiografias', 'China', 353, '1989', 995),
(9, 'Fortunata y Jacinta', 'Plaza & Janes', 'Pérez Galdós', 'Novela', 'España', 625, '1984', 725);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `Num_Pedido` int(5) NOT NULL COMMENT 'Numero de Pedido de libro',
  `Codigo_Libro` int(10) NOT NULL COMMENT 'Codigo Del Libro',
  `Codigo_Usuario` int(10) NOT NULL COMMENT 'Codigo Del Usuario',
  `Fecha_Salida` date NOT NULL COMMENT 'Fecha de salida del Fecha de salida del libro',
  `Fecha_Limite_Devolucion` date NOT NULL COMMENT 'Fecha limite de devolucion del libro',
  `Fecha_Devolucion` date NOT NULL COMMENT 'Fecha de devolucion del libro'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`Num_Pedido`, `Codigo_Libro`, `Codigo_Usuario`, `Fecha_Salida`, `Fecha_Limite_Devolucion`, `Fecha_Devolucion`) VALUES
(1, 1, 3, '1999-11-01', '1999-11-15', '1999-11-13'),
(2, 3, 2, '1999-11-03', '1999-11-20', '1999-11-22'),
(3, 2, 5, '1999-11-18', '1999-11-30', '1999-11-25'),
(4, 5, 6, '1999-11-21', '1999-12-03', '1999-12-05'),
(5, 9, 2, '1999-11-21', '1999-12-05', '1999-11-30'),
(6, 2, 4, '1999-11-26', '1999-12-07', '1999-12-01'),
(7, 4, 3, '1999-11-30', '1999-12-07', '1999-12-08'),
(8, 1, 1, '1999-12-01', '1999-12-09', '1999-12-11'),
(9, 3, 6, '1999-12-03', '1999-12-09', '1999-12-09'),
(10, 7, 3, '1999-12-03', '1999-12-18', '1999-12-15'),
(11, 3, 2, '1999-12-05', '1999-12-22', '1999-12-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Codigo_Usuario` int(10) NOT NULL,
  `Nombre_Usuario` varchar(15) NOT NULL,
  `Apellidos_Usuario` varchar(25) NOT NULL,
  `DNI` varchar(15) NOT NULL,
  `Domicilio` varchar(15) NOT NULL,
  `Poblacion` varchar(30) NOT NULL,
  `Provincia` varchar(20) NOT NULL,
  `Fecha_Nacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Codigo_Usuario`, `Nombre_Usuario`, `Apellidos_Usuario`, `DNI`, `Domicilio`, `Poblacion`, `Provincia`, `Fecha_Nacimiento`) VALUES
(1, 'Ines', 'Posadas Gil', '42.117.892-S', 'Av. Escaleritas', 'Las Palmas G.C.', 'Las Palmas', '1971-07-04'),
(2, 'Jose', 'Sánchez Pons', '31.765.348-D', 'Mesa y Lopez 51', 'Las Palmas G.C.', 'Las Palmas', '1966-09-06'),
(3, 'Miguel', 'Gómez Sáez', '11.542-981-G', 'Gran Via 71', 'Madrid', 'Madrid', '1976-12-06'),
(4, 'Eva', 'Santana Páez', '78.542.450-L', 'Pío Baroja 23', 'Bilbao', 'Vizcaya', '1980-05-23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`Codigo_Libro`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`Num_Pedido`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Codigo_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `Num_Pedido` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Numero de Pedido de libro', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Codigo_Usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
