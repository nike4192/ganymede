-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Янв 10 2021 г., 21:15
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
-- Структура таблицы `geom_users`
--

CREATE TABLE `geom_users` (
  `id` varchar(40) NOT NULL DEFAULT uuid(),
  `login` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password_hash` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `geom_users`
--

INSERT INTO `geom_users` (`id`, `login`, `email`, `password_hash`) VALUES
('6cc46a91-4e15-11eb-b5c9-a0369fc4af22', 'fake', 'fake@mail.com', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `geom_users`
--
ALTER TABLE `geom_users`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
