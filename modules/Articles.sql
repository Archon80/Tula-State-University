-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 17 2016 г., 00:21
-- Версия сервера: 5.5.48
-- Версия PHP: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `YBS`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Articles`
--

CREATE TABLE IF NOT EXISTS `Articles` (
  `id_article` int(7) NOT NULL,
  `author` varchar(100) NOT NULL,
  `article_name` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `year` varchar(5) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `article_page` varchar(20) DEFAULT NULL,
  `notes` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='Таблица статей сборника';

--
-- Дамп данных таблицы `Articles`
--

INSERT INTO `Articles` (`id_article`, `author`, `article_name`, `category`, `year`, `status`, `filename`, `article_page`, `notes`) VALUES
(3, 'Иванов Иван Иванович', 'Статья о программировании', 'Категория - программирование', '2015', 'Статус - отдана в печать', 'Имя файла - ХЗ', 'Страницы - ХЗ', 'Заметки: программирование это круто\r\n'),
(4, 'Петров Петр Петрович', 'Статья о дизайне', 'Категория - дизайн', '2016', 'Статус - напечатана', 'Имя файла - ХЗ', 'Страницы - ХЗ', 'Заметки: дизайн это круто\r\n'),
(16, 'q', 'q', 'q', 'q', 'q', 'q', 'q', 'notes'),
(17, 'w', 'w', 'w', 'w', 'w', 'w', 'w', 'notes');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Articles`
--
ALTER TABLE `Articles`
  ADD PRIMARY KEY (`id_article`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Articles`
--
ALTER TABLE `Articles`
  MODIFY `id_article` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
