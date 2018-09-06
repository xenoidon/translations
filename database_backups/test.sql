-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Сен 06 2018 г., 15:06
-- Версия сервера: 5.7.22-0ubuntu0.17.10.1
-- Версия PHP: 7.1.17-0ubuntu0.17.10.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `conversion`
--

CREATE TABLE `conversion` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_id_to_translate` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_transaction` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `translation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `conversion`
--

INSERT INTO `conversion` (`id`, `user_id`, `user_id_to_translate`, `status`, `created_at`, `updated_at`, `time_transaction`, `translation`) VALUES
(1, 5, 4, 3, '2018-09-06 08:01:16', '2018-09-06 08:01:16', '2018-09-06 01:01:00', 111);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '10',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `balance`) VALUES
(3, 'test1', 'l9X0v-2jD1x3ghdqYaYC-PYh3IoAAVBM', '$2y$13$JGC3dl6RnNDdjk0/79/S7OdAw9XWk4blfTdSKkCyTQaPpRTmnbU5m', NULL, 'test1@test1.ru', 10, '2018-09-05 20:54:40', '2018-09-05 20:54:40', 1209),
(4, 'test2', 'h4xDlIHE8b9WsYjmYjpJNEF-690TkGvw', '$2y$13$kILpr5IH/87lPQEaT3tAnul/qsHqj57Tm0fyyXMnx38GBAXGrGDVe', NULL, 'test2@test2.ru', 10, '2018-09-05 20:55:42', '2018-09-05 20:55:42', 913),
(5, 'test3', 'VncomutXnbLUqJoBZgJ-ubf2Mb4GOZLs', '$2y$13$tX2mgK59EB7hm8.KTz7qnu.NrvRBVRU2Efk3T2g2JYHVIp0/n1oqy', NULL, 'test3@test3.ru', 10, '2018-09-06 01:01:03', '2018-09-06 01:01:03', 889);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `conversion`
--
ALTER TABLE `conversion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-conversion-user_id` (`user_id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `conversion`
--
ALTER TABLE `conversion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `conversion`
--
ALTER TABLE `conversion`
  ADD CONSTRAINT `fk-conversion-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
