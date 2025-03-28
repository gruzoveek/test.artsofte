-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Хост: 10.19.5.31:3307
-- Время создания: Мар 27 2025 г., 09:13
-- Версия сервера: 10.5.17-MariaDB-1:10.5.17+maria~deb10-log
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_artsofte`
--

-- --------------------------------------------------------

--
-- Структура таблицы `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, 'Жигули'),
(2, 'Москвич'),
(3, 'ГАЗ'),
(4, 'УАЗ');

-- --------------------------------------------------------

--
-- Структура таблицы `car`
--

CREATE TABLE IF NOT EXISTS `car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_773DE69D44F5D008` (`brand_id`),
  KEY `IDX_773DE69D7975B7E7` (`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `car`
--

INSERT INTO `car` (`id`, `brand_id`, `model_id`, `photo`, `price`) VALUES
(1, 1, 1, 'photo1.jpg', 1005000),
(2, 1, 2, 'photo2.jpg', 1500000),
(3, 2, 3, 'photo3.jpg', 1000000),
(4, 3, 4, 'photo4.jpg', 2000000),
(5, 3, 5, 'photo5.jpg', 2100000),
(6, 3, 6, 'photo6.jpg', 2800000);

-- --------------------------------------------------------

--
-- Структура таблицы `credit_program`
--

CREATE TABLE IF NOT EXISTS `credit_program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interest_rate` decimal(4,1) NOT NULL,
  `loan_term` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initial_payment` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `credit_program`
--

INSERT INTO `credit_program` (`id`, `interest_rate`, `loan_term`, `title`, `initial_payment`) VALUES
(1, '18.0', 72, 'Дешево-сердито', '200000.00'),
(2, '9.0', 24, 'Дорого-богато', '800000.00');

-- --------------------------------------------------------

--
-- Структура таблицы `credit_program_request`
--

CREATE TABLE IF NOT EXISTS `credit_program_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` int(11) NOT NULL,
  `initial_payment` decimal(10,2) NOT NULL,
  `loan_term` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `credit_request`
--

CREATE TABLE IF NOT EXISTS `credit_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) DEFAULT NULL,
  `credit_program_id` int(11) DEFAULT NULL,
  `initial_payment` decimal(10,2) NOT NULL,
  `loan_term` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_113E8B0C3C6F69F` (`car_id`),
  KEY `IDX_113E8B0CDC0BCB4` (`credit_program_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `doctrine_migration_versions`
--

CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `model`
--

CREATE TABLE IF NOT EXISTS `model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `model`
--

INSERT INTO `model` (`id`, `name`) VALUES
(1, '2107'),
(2, '2109'),
(3, '412'),
(4, '21'),
(5, '3110'),
(6, '24');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `FK_773DE69D44F5D008` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_773DE69D7975B7E7` FOREIGN KEY (`model_id`) REFERENCES `model` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `credit_request`
--
ALTER TABLE `credit_request`
  ADD CONSTRAINT `FK_113E8B0C3C6F69F` FOREIGN KEY (`car_id`) REFERENCES `car` (`id`),
  ADD CONSTRAINT `FK_113E8B0CDC0BCB4` FOREIGN KEY (`credit_program_id`) REFERENCES `credit_program` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
