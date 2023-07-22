-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-07-2023 a las 22:09:09
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `psicouees`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `room` varchar(50) NOT NULL,
  `faculty` varchar(100) NOT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `finish_time` time NOT NULL,
  `status_room` varchar(20) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exam_number`
--

CREATE TABLE `exam_number` (
  `id` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `ascendancy` int(2) DEFAULT NULL,
  `res` int(2) DEFAULT NULL,
  `est` int(2) DEFAULT NULL,
  `soc` int(2) DEFAULT NULL,
  `aut` int(2) DEFAULT NULL,
  `cau` int(2) DEFAULT NULL,
  `ori` int(2) DEFAULT NULL,
  `com` int(2) DEFAULT NULL,
  `vit` int(2) DEFAULT NULL,
  `patient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipg`
--

CREATE TABLE `ipg` (
  `id` int(11) NOT NULL,
  `tetrad` int(2) NOT NULL,
  `A` varchar(11) NOT NULL,
  `B` varchar(11) NOT NULL,
  `C` varchar(11) NOT NULL,
  `D` varchar(11) NOT NULL,
  `caution` int(2) DEFAULT NULL,
  `originality` int(2) DEFAULT NULL,
  `comprehension` int(2) DEFAULT NULL,
  `vitality` int(2) DEFAULT NULL,
  `exam_number_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_adults`
--

CREATE TABLE `m_adults` (
  `score` int(3) NOT NULL,
  `ascendancy` int(2) DEFAULT NULL,
  `res` int(2) DEFAULT NULL,
  `est` int(2) DEFAULT NULL,
  `soc` int(2) DEFAULT NULL,
  `cau` int(2) DEFAULT NULL,
  `ori` int(2) DEFAULT NULL,
  `com` int(2) DEFAULT NULL,
  `vit` int(2) DEFAULT NULL,
  `aut` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `m_teens`
--

CREATE TABLE `m_teens` (
  `score` int(3) NOT NULL,
  `ascendancy` int(2) DEFAULT NULL,
  `res` int(2) DEFAULT NULL,
  `est` int(2) DEFAULT NULL,
  `soc` int(2) DEFAULT NULL,
  `cau` int(2) DEFAULT NULL,
  `ori` int(2) DEFAULT NULL,
  `com` int(2) DEFAULT NULL,
  `vit` int(2) DEFAULT NULL,
  `aut` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `credential_id` varchar(100) NOT NULL,
  `dui` varchar(10) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `gender` varchar(2) NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cell_phone_number` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ppg`
--

CREATE TABLE `ppg` (
  `id` int(11) NOT NULL,
  `tetrad` int(2) NOT NULL,
  `A` varchar(20) NOT NULL,
  `B` varchar(20) NOT NULL,
  `C` varchar(20) NOT NULL,
  `D` varchar(20) NOT NULL,
  `ascendancy` int(2) DEFAULT NULL,
  `responsibility` int(2) DEFAULT NULL,
  `emotional` int(2) DEFAULT NULL,
  `sociability` int(2) DEFAULT NULL,
  `self_esteem` int(2) DEFAULT NULL,
  `exam_number_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_role` varchar(25) NOT NULL,
  `description` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `w_adults`
--

CREATE TABLE `w_adults` (
  `score` int(3) NOT NULL,
  `ascendancy` int(2) DEFAULT NULL,
  `res` int(2) DEFAULT NULL,
  `est` int(2) DEFAULT NULL,
  `soc` int(2) DEFAULT NULL,
  `cau` int(2) DEFAULT NULL,
  `ori` int(2) DEFAULT NULL,
  `com` int(2) DEFAULT NULL,
  `vit` int(2) DEFAULT NULL,
  `aut` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `w_teens`
--

CREATE TABLE `w_teens` (
  `score` int(3) NOT NULL,
  `ascendancy` int(2) DEFAULT NULL,
  `res` int(2) DEFAULT NULL,
  `est` int(2) DEFAULT NULL,
  `soc` int(2) DEFAULT NULL,
  `cau` int(2) DEFAULT NULL,
  `ori` int(2) DEFAULT NULL,
  `com` int(2) DEFAULT NULL,
  `vit` int(2) DEFAULT NULL,
  `aut` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_id` (`patient_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `patient_id_2` (`patient_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indices de la tabla `exam_number`
--
ALTER TABLE `exam_number`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_id` (`patient_id`),
  ADD KEY `patient_id_2` (`patient_id`);

--
-- Indices de la tabla `ipg`
--
ALTER TABLE `ipg`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_number_id` (`exam_number_id`),
  ADD KEY `exam_number_id_2` (`exam_number_id`);

--
-- Indices de la tabla `m_adults`
--
ALTER TABLE `m_adults`
  ADD PRIMARY KEY (`score`);

--
-- Indices de la tabla `m_teens`
--
ALTER TABLE `m_teens`
  ADD PRIMARY KEY (`score`);

--
-- Indices de la tabla `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ppg`
--
ALTER TABLE `ppg`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_number_id` (`exam_number_id`),
  ADD KEY `exam_number_id_2` (`exam_number_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `w_adults`
--
ALTER TABLE `w_adults`
  ADD PRIMARY KEY (`score`);

--
-- Indices de la tabla `w_teens`
--
ALTER TABLE `w_teens`
  ADD PRIMARY KEY (`score`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`id`) REFERENCES `patients` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `exam_number`
--
ALTER TABLE `exam_number`
  ADD CONSTRAINT `exam_number_ibfk_1` FOREIGN KEY (`id`) REFERENCES `patients` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ipg`
--
ALTER TABLE `ipg`
  ADD CONSTRAINT `ipg_ibfk_1` FOREIGN KEY (`id`) REFERENCES `exam_number` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ppg`
--
ALTER TABLE `ppg`
  ADD CONSTRAINT `ppg_ibfk_1` FOREIGN KEY (`id`) REFERENCES `exam_number` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
