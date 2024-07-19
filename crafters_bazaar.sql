-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Час створення: Лис 21 2023 р., 15:58
-- Версія сервера: 8.0.35-0ubuntu0.20.04.1
-- Версія PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `crafters_bazaar`
--

-- --------------------------------------------------------

--
-- Структура таблиці `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sum` decimal(8,2) DEFAULT NULL,
  `discount` decimal(8,2) DEFAULT NULL,
  `total` decimal(8,2) DEFAULT NULL,
  `active` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint UNSIGNED NOT NULL,
  `cart_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `pricediscount` decimal(8,2) DEFAULT NULL,
  `active` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `category_users`
--

CREATE TABLE `category_users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `category_users`
--

INSERT INTO `category_users` (`id`, `name`, `del`, `created_at`, `updated_at`) VALUES
(1, 'Користувач', 0, NULL, NULL),
(2, 'Продавець', 0, NULL, NULL),
(3, 'Покупець', 0, NULL, NULL),
(4, 'Співробітник', 0, NULL, NULL),
(5, 'SEO', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `cities`
--

CREATE TABLE `cities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `index` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `colors`
--

CREATE TABLE `colors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `colors`
--

INSERT INTO `colors` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Чорний', '#000000', NULL, NULL),
(2, 'Білий', '#ffffff', NULL, NULL),
(3, 'Червоний', '#ff0000', NULL, NULL),
(4, 'Зелений', '#00ff00', NULL, NULL),
(5, 'Синій', '#0000ff', NULL, NULL),
(6, 'Жовтий', '#ffff00', NULL, NULL),
(7, 'Фіолетовий', '#ff00ff', NULL, NULL),
(8, 'Помаранчевий', '#ffa500', NULL, NULL),
(9, 'Темно-зелений', '#008000', NULL, NULL),
(10, 'Пурпурний', '#800080', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `deliveries`
--

CREATE TABLE `deliveries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `deliveries`
--

INSERT INTO `deliveries` (`id`, `name`, `del`, `created_at`, `updated_at`) VALUES
(1, 'Самовивіз з Нової Пошти', 0, NULL, NULL),
(2, 'Адресна доставка', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint UNSIGNED NOT NULL,
  `pict` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `headershow` tinyint(1) NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '999',
  `enddate` datetime NOT NULL,
  `percent` int NOT NULL DEFAULT '0',
  `article` int NOT NULL DEFAULT '0',
  `actual` int NOT NULL DEFAULT '0',
  `active` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `kind_payments`
--

CREATE TABLE `kind_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `kind_payments`
--

INSERT INTO `kind_payments` (`id`, `name`, `active`, `del`, `created_at`, `updated_at`) VALUES
(1, 'Оплата карткою', 1, 0, NULL, NULL),
(2, 'Оплата готівкою', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `kind_products`
--

CREATE TABLE `kind_products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `active` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `kind_products`
--

INSERT INTO `kind_products` (`id`, `name`, `user_id`, `active`, `del`, `created_at`, `updated_at`) VALUES
(1, 'Сумки', 1, 0, 0, '2023-11-16 15:58:14', '2023-11-16 15:58:14');

-- --------------------------------------------------------

--
-- Структура таблиці `language`
--

CREATE TABLE `language` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(203, '2013_03_12_145132_create_newposts_table', 1),
(204, '2013_03_13_072049_create_roles_table', 1),
(205, '2013_03_13_072049_create_status_products_table', 1),
(206, '2013_05_12_150609_create_deliveries_table', 1),
(207, '2013_09_16_202239_create_sizes_table', 1),
(208, '2013_09_16_202247_create_cities_table', 1),
(209, '2013_09_16_202247_create_colors_table', 1),
(210, '2013_09_18_160610_create_category_users_table', 1),
(211, '2014_10_12_000000_create_users_table', 1),
(212, '2014_10_12_100000_create_password_resets_table', 1),
(213, '2019_08_19_000000_create_failed_jobs_table', 1),
(214, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(215, '2023_03_06_160110_create_kind_products_table', 1),
(216, '2023_03_06_160110_create_sub_kind_products_table', 1),
(217, '2023_03_06_160111_create_products_table', 1),
(218, '2023_03_06_160111_create_reviews_table', 1),
(219, '2023_03_06_160444_create_status_orders_table', 1),
(220, '2023_03_06_160525_create_kind_payments_table', 1),
(221, '2023_04_18_150102_create_carts_table', 1),
(222, '2023_04_18_150103_create_cart_items_table', 1),
(223, '2023_04_18_150103_create_wish_items_table', 1),
(224, '2023_04_19_143010_create_orders_table', 1),
(225, '2023_04_20_143036_create_discounts_table', 1),
(226, '2023_07_12_150829_create_language', 1),
(227, '2023_07_12_151337_create_translate', 1),
(228, '2023_07_12_151419_create_translatehaslang', 1),
(229, '2023_09_16_202247_create_product_photos_table', 1);

-- --------------------------------------------------------

--
-- Структура таблиці `newposts`
--

CREATE TABLE `newposts` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `delivery_id` bigint UNSIGNED NOT NULL,
  `kind_payment_id` bigint UNSIGNED NOT NULL,
  `card` int DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `newposts_id` bigint UNSIGNED DEFAULT NULL,
  `promocode` int DEFAULT NULL,
  `pricedelivery` decimal(12,2) DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `status_order_id` bigint UNSIGNED NOT NULL,
  `cart_id` bigint UNSIGNED NOT NULL,
  `active` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kind_product_id` bigint UNSIGNED DEFAULT NULL,
  `sub_kind_product_id` bigint UNSIGNED DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `links_networks` text COLLATE utf8mb4_unicode_ci,
  `price` int DEFAULT NULL,
  `stock_balance` int DEFAULT NULL,
  `size_id` bigint UNSIGNED DEFAULT NULL,
  `color_id` bigint UNSIGNED DEFAULT NULL,
  `status_product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `active` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `products`
--

INSERT INTO `products` (`id`, `name`, `kind_product_id`, `sub_kind_product_id`, `content`, `links_networks`, `price`, `stock_balance`, `size_id`, `color_id`, `status_product_id`, `user_id`, `active`, `del`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 'Сумка Хіт', 1, 1, 'вфівіфвфівфів увфі вфів фів іфв фв', NULL, 10000, 1, NULL, NULL, 1, 1, 0, 0, NULL, '2023-11-16 15:58:07', '2023-11-16 16:19:07');

-- --------------------------------------------------------

--
-- Структура таблиці `product_photos`
--

CREATE TABLE `product_photos` (
  `id` bigint UNSIGNED NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ext` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` int NOT NULL,
  `hover_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hover_ext` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hover_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `zoom_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `zoom_ext` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `zoom_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `small_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `small_ext` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `small_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `product_photos`
--

INSERT INTO `product_photos` (`id`, `filename`, `ext`, `path`, `link`, `queue`, `hover_filename`, `hover_ext`, `hover_path`, `zoom_filename`, `zoom_ext`, `zoom_path`, `small_filename`, `small_ext`, `small_path`, `product_id`, `created_at`, `updated_at`) VALUES
(1, '20231116_181830_1.jpg', 'jpg', 'photos', '', 1, '', '', '', '', '', '', '20231116_181830_1_small.jpg', 'jpg', 'photos', 1, '2023-11-16 16:18:30', '2023-11-16 16:18:30'),
(2, '20231116_181841_1-2.jpg', 'jpg', 'photos', '', 1, '', '', '', '', '', '', '20231116_181841_1-2_small.jpg', 'jpg', 'photos', 1, '2023-11-16 16:18:41', '2023-11-16 16:18:41'),
(3, '20231116_181857_1-3.jpg', 'jpg', 'photos', '', 1, '', '', '', '', '', '', '20231116_181857_1-3_small.jpg', 'jpg', 'photos', 1, '2023-11-16 16:18:57', '2023-11-16 16:18:57');

-- --------------------------------------------------------

--
-- Структура таблиці `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `roles`
--

INSERT INTO `roles` (`id`, `name`, `del`, `created_at`, `updated_at`) VALUES
(1, 'Супер Адмін', 0, NULL, NULL),
(2, 'Адміністратор', 0, NULL, NULL),
(3, 'Начальник', 0, NULL, NULL),
(4, 'Продавець', 0, NULL, NULL),
(5, 'Віп користувач', 0, NULL, NULL),
(6, 'Зареєстрований користувач', 0, NULL, NULL),
(7, 'Не зареєстрований користувач', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Великий', NULL, NULL),
(2, 'Середній', NULL, NULL),
(3, 'Малий', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `status_orders`
--

CREATE TABLE `status_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `status_orders`
--

INSERT INTO `status_orders` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Нове', NULL, NULL),
(2, 'Затверджене', NULL, NULL),
(3, 'Відправлене', NULL, NULL),
(4, 'Доставлене', NULL, NULL),
(5, 'Отримане', NULL, NULL),
(6, 'Виконане', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `status_products`
--

CREATE TABLE `status_products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `status_products`
--

INSERT INTO `status_products` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Новий', NULL, NULL),
(2, 'На затверджені', NULL, NULL),
(3, 'В продажу', NULL, NULL),
(4, 'Проданий', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `sub_kind_products`
--

CREATE TABLE `sub_kind_products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kind_product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `active` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `sub_kind_products`
--

INSERT INTO `sub_kind_products` (`id`, `name`, `kind_product_id`, `user_id`, `active`, `del`, `created_at`, `updated_at`) VALUES
(1, 'Чоловічі сумки', 1, 1, 0, 0, '2023-11-16 15:58:14', '2023-11-16 15:58:14');

-- --------------------------------------------------------

--
-- Структура таблиці `translate`
--

CREATE TABLE `translate` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `translatehaslang`
--

CREATE TABLE `translatehaslang` (
  `id` bigint UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `translate_id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint UNSIGNED NOT NULL DEFAULT '6',
  `category_user_id` bigint UNSIGNED NOT NULL DEFAULT '1',
  `gender` bigint UNSIGNED DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_id` bigint UNSIGNED DEFAULT NULL,
  `paymentkind_id` bigint UNSIGNED DEFAULT NULL,
  `newpost_id` bigint UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `active` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `surname`, `secondname`, `phone`, `role_id`, `category_user_id`, `gender`, `birthday`, `city`, `address`, `delivery_id`, `paymentkind_id`, `newpost_id`, `email_verified_at`, `active`, `del`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'chmyk_vika@ukr.net', '$2y$10$tyFvMKzkHTcLN6Jqvm93je5980aUIsQVGmAkv2rEfYrP5L3t5lPgu', 'Віка', NULL, NULL, '0971129869', 6, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2023-11-16 15:57:46', '2023-11-16 15:58:07');

-- --------------------------------------------------------

--
-- Структура таблиці `wish_items`
--

CREATE TABLE `wish_items` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `active` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `del` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Індекси таблиці `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Індекси таблиці `category_users`
--
ALTER TABLE `category_users`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Індекси таблиці `kind_payments`
--
ALTER TABLE `kind_payments`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `kind_products`
--
ALTER TABLE `kind_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kind_products_user_id_foreign` (`user_id`);

--
-- Індекси таблиці `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `newposts`
--
ALTER TABLE `newposts`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_cart_id_foreign` (`cart_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_kind_payment_id_foreign` (`kind_payment_id`),
  ADD KEY `orders_newposts_id_foreign` (`newposts_id`),
  ADD KEY `orders_status_order_id_foreign` (`status_order_id`);

--
-- Індекси таблиці `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Індекси таблиці `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Індекси таблиці `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_kind_product_id_foreign` (`kind_product_id`),
  ADD KEY `products_sub_kind_product_id_foreign` (`sub_kind_product_id`),
  ADD KEY `products_size_id_foreign` (`size_id`),
  ADD KEY `products_color_id_foreign` (`color_id`),
  ADD KEY `products_status_product_id_foreign` (`status_product_id`),
  ADD KEY `products_user_id_foreign` (`user_id`),
  ADD KEY `products_admin_id_foreign` (`admin_id`);

--
-- Індекси таблиці `product_photos`
--
ALTER TABLE `product_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_photos_product_id_foreign` (`product_id`);

--
-- Індекси таблиці `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Індекси таблиці `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `status_orders`
--
ALTER TABLE `status_orders`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `status_products`
--
ALTER TABLE `status_products`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `sub_kind_products`
--
ALTER TABLE `sub_kind_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_kind_products_kind_product_id_foreign` (`kind_product_id`),
  ADD KEY `sub_kind_products_user_id_foreign` (`user_id`);

--
-- Індекси таблиці `translate`
--
ALTER TABLE `translate`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `translatehaslang`
--
ALTER TABLE `translatehaslang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translatehaslang_translate_id_foreign` (`translate_id`),
  ADD KEY `translatehaslang_language_id_foreign` (`language_id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_category_user_id_foreign` (`category_user_id`),
  ADD KEY `users_delivery_id_foreign` (`delivery_id`),
  ADD KEY `users_newpost_id_foreign` (`newpost_id`);

--
-- Індекси таблиці `wish_items`
--
ALTER TABLE `wish_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wish_items_user_id_foreign` (`user_id`),
  ADD KEY `wish_items_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `category_users`
--
ALTER TABLE `category_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблиці `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблиці `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблиці `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `kind_payments`
--
ALTER TABLE `kind_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблиці `kind_products`
--
ALTER TABLE `kind_products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблиці `language`
--
ALTER TABLE `language`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT для таблиці `newposts`
--
ALTER TABLE `newposts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблиці `product_photos`
--
ALTER TABLE `product_photos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблиці `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблиці `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблиці `status_orders`
--
ALTER TABLE `status_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблиці `status_products`
--
ALTER TABLE `status_products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблиці `sub_kind_products`
--
ALTER TABLE `sub_kind_products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблиці `translate`
--
ALTER TABLE `translate`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `translatehaslang`
--
ALTER TABLE `translatehaslang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблиці `wish_items`
--
ALTER TABLE `wish_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `kind_products`
--
ALTER TABLE `kind_products`
  ADD CONSTRAINT `kind_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_kind_payment_id_foreign` FOREIGN KEY (`kind_payment_id`) REFERENCES `kind_payments` (`id`),
  ADD CONSTRAINT `orders_newposts_id_foreign` FOREIGN KEY (`newposts_id`) REFERENCES `newposts` (`id`),
  ADD CONSTRAINT `orders_status_order_id_foreign` FOREIGN KEY (`status_order_id`) REFERENCES `status_orders` (`id`),
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `products_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`),
  ADD CONSTRAINT `products_kind_product_id_foreign` FOREIGN KEY (`kind_product_id`) REFERENCES `kind_products` (`id`),
  ADD CONSTRAINT `products_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `products_status_product_id_foreign` FOREIGN KEY (`status_product_id`) REFERENCES `status_products` (`id`),
  ADD CONSTRAINT `products_sub_kind_product_id_foreign` FOREIGN KEY (`sub_kind_product_id`) REFERENCES `sub_kind_products` (`id`),
  ADD CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `product_photos`
--
ALTER TABLE `product_photos`
  ADD CONSTRAINT `product_photos_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `sub_kind_products`
--
ALTER TABLE `sub_kind_products`
  ADD CONSTRAINT `sub_kind_products_kind_product_id_foreign` FOREIGN KEY (`kind_product_id`) REFERENCES `kind_products` (`id`),
  ADD CONSTRAINT `sub_kind_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `translatehaslang`
--
ALTER TABLE `translatehaslang`
  ADD CONSTRAINT `translatehaslang_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `translatehaslang_translate_id_foreign` FOREIGN KEY (`translate_id`) REFERENCES `translate` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_category_user_id_foreign` FOREIGN KEY (`category_user_id`) REFERENCES `category_users` (`id`),
  ADD CONSTRAINT `users_delivery_id_foreign` FOREIGN KEY (`delivery_id`) REFERENCES `deliveries` (`id`),
  ADD CONSTRAINT `users_newpost_id_foreign` FOREIGN KEY (`newpost_id`) REFERENCES `newposts` (`id`),
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `wish_items`
--
ALTER TABLE `wish_items`
  ADD CONSTRAINT `wish_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `wish_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
