-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Янв 10 2021 г., 21:14
-- Версия сервера: 10.2.36-MariaDB
-- Версия PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `coorxyz_training`
--

-- --------------------------------------------------------

--
-- Структура таблицы `geom_sessions`
--

CREATE TABLE `geom_sessions` (
  `user_token` varchar(60) NOT NULL,
  `user_id` varchar(40) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `geom_sessions`
--

INSERT INTO `geom_sessions` (`user_token`, `user_id`, `timestamp`) VALUES
('f5190c6a02e99ac6da039c7a33a10a2f', '6cc46a91-4e15-11eb-b5c9-a0369fc4af22', '2021-01-04 02:22:53');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `geom_sessions`
--
ALTER TABLE `geom_sessions`
  ADD PRIMARY KEY (`user_token`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
