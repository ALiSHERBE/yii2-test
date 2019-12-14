-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Хост: mysql:3306
-- Время создания: Дек 10 2019 г., 20:36
-- Версия сервера: 5.5.62
-- Версия PHP: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `app`
--

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) CHARACTER SET utf8 NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1575630256),
('m191205_011657_create_web_cars_table', 1575630258),
('m191205_011931_create_web_users_table', 1575630258),
('m191205_012015_create_web_photos_table', 1575630258),
('m191205_012035_create_web_brands_table', 1575630258),
('m191205_012056_create_web_options_table', 1575630258),
('m191209_234427_create_web_car_option_table', 1575937490);

-- --------------------------------------------------------

--
-- Структура таблицы `web_brands`
--

CREATE TABLE `web_brands` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `depth` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `web_brands`
--

INSERT INTO `web_brands` (`id`, `title`, `lft`, `rgt`, `depth`) VALUES
(1, 'Марки', 1, 42, 0),
(2, 'BMW', 2, 9, 1),
(3, 'Audi', 10, 13, 1),
(4, 'Ferrari', 14, 19, 1),
(5, 'Lamborghini', 20, 29, 1),
(6, 'Tesla', 30, 33, 1),
(7, 'Aventador', 21, 22, 2),
(8, 'Urus', 25, 26, 2),
(9, 'Huracan', 23, 24, 2),
(10, 'A6', 11, 12, 2),
(11, 'Gallardo', 27, 28, 2),
(12, 'California', 15, 16, 2),
(13, 'Mercedes', 34, 41, 1),
(14, 'GLC-Class', 35, 36, 2),
(15, 'G-Class', 37, 38, 2),
(16, 'AMG GT', 39, 40, 2),
(17, 'X5', 3, 4, 2),
(18, 'X6', 5, 6, 2),
(19, 'F12', 17, 18, 2),
(20, 'X4', 7, 8, 2),
(21, 'Cybertruck', 31, 32, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `web_cars`
--

CREATE TABLE `web_cars` (
  `id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `price` varchar(255) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mileage` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `main_photo_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `web_cars`
--

INSERT INTO `web_cars` (`id`, `created_at`, `updated_at`, `price`, `phone`, `mileage`, `main_photo_id`, `model_id`, `brand_id`, `user_id`) VALUES
(1, '2019-12-10 20:05:52', '2019-12-10 20:05:52', '5450000', '+798989888888', '0', 0, 21, 6, 0),
(2, '2019-12-10 20:07:37', '2019-12-10 20:17:18', '1450000', '84442111232', '5500', 4, 18, 2, 0),
(3, '2019-12-10 20:34:07', '2019-12-10 20:34:07', '5450000', '+79892222222', '9800', 0, 10, 3, 0),
(4, '2019-12-10 20:34:59', '2019-12-10 20:34:59', '1450000', '+798989888888', '555', 0, 8, 5, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `web_car_option`
--

CREATE TABLE `web_car_option` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `web_car_option`
--

INSERT INTO `web_car_option` (`id`, `car_id`, `option_id`) VALUES
(1, 1, 6),
(2, 1, 4),
(3, 1, 13),
(4, 1, 9),
(5, 1, 10),
(6, 1, 16),
(7, 1, 17),
(8, 2, 12),
(9, 3, 13),
(10, 3, 8),
(11, 4, 12),
(12, 4, 7),
(13, 4, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `web_options`
--

CREATE TABLE `web_options` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `web_options`
--

INSERT INTO `web_options` (`id`, `title`, `parent_id`) VALUES
(1, 'безопасность', NULL),
(2, 'экстерьер', NULL),
(3, 'комфорт', NULL),
(4, 'Биксенововые фары', 2),
(5, 'Подушка безопасности водителя', 1),
(6, 'Сигнализация', 1),
(7, 'Круиз контроль', 3),
(8, 'Доступ без ключа', 3),
(9, 'Электропривод сидений', 3),
(10, 'Электрозеркала', 3),
(11, 'мультимедиа', NULL),
(12, 'Диодные фары', 2),
(13, 'Панорамная крыша', 2),
(14, 'Bluetooth', 11),
(15, 'Система контроля давления в шинах', 1),
(16, 'Сабвуфер', 11),
(17, 'Сенсорный дисплей', 11),
(18, 'DVD', 11);

-- --------------------------------------------------------

--
-- Структура таблицы `web_photos`
--

CREATE TABLE `web_photos` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `file` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `web_photos`
--

INSERT INTO `web_photos` (`id`, `car_id`, `file`) VALUES
(1, 1, '1576008352_vOgAJWWw.jpeg'),
(2, 2, '1576008457_L5-qupli.jpg'),
(3, 2, '1576008461_wLiDL3-4.jpg'),
(4, 2, '1576008465_aah8z-UQ.jpg'),
(5, 3, '1576010047_taSAJ-Dc.jpg'),
(6, 3, '1576010051_-Z5soPAf.jpg'),
(7, 4, '1576010099_lxfzYV7o.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `web_users`
--

CREATE TABLE `web_users` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `web_brands`
--
ALTER TABLE `web_brands`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `web_cars`
--
ALTER TABLE `web_cars`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `web_car_option`
--
ALTER TABLE `web_car_option`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `web_options`
--
ALTER TABLE `web_options`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `web_photos`
--
ALTER TABLE `web_photos`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `web_users`
--
ALTER TABLE `web_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `web_brands`
--
ALTER TABLE `web_brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `web_cars`
--
ALTER TABLE `web_cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `web_car_option`
--
ALTER TABLE `web_car_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `web_options`
--
ALTER TABLE `web_options`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `web_photos`
--
ALTER TABLE `web_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `web_users`
--
ALTER TABLE `web_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
