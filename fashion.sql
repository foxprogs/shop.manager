SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `categories` (`id`, `name`) VALUES
(4, 'Аксессуары'),
(2, 'Дети'),
(3, 'Женщины'),
(1, 'Мужчины');

CREATE TABLE `category_product` (
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `category_product` (`category_id`, `product_id`) VALUES
(1, 3),
(2, 2),
(2, 7),
(3, 1),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(4, 4),
(4, 7);

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'operator', 'Оператор – может заходить в административный интерфейс и видеть список заказов.'),
(2, 'admin', 'Администратор – может заходить в административный интерфейс, видеть список заказов и управлять товарами.');

CREATE TABLE `group_user` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `group_user` (`group_id`, `user_id`) VALUES
(1, 1),
(2, 1),
(1, 2);

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_delivery` tinyint(1) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `payment_type` tinyint(1) NOT NULL,
  `comment` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `orders` (`id`, `status`, `product_id`, `price`, `name`, `phone`, `email`, `is_delivery`, `address`, `payment_type`, `comment`, `created_at`) VALUES
(1, 0, 1, 779, 'Степанова Мария', '87776665544', 'manya_step@mail.ru', 1, '', 1, '', '2020-01-23 18:50:06'),
(2, 1, 7, 4100, 'Бикторова Алла Витальевна', '87073035544', 'bav_1974@bk.ru', 2, 'г. Усть-Кут, ул. Ленина, д. 17, кв. 33', 2, 'Здание за зеленым торговым центром. Сдачу с 5000', '2020-01-23 18:52:18');

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL,
  `is_new` tinyint(1) NOT NULL DEFAULT '0',
  `is_sale` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `products` (`id`, `name`, `is_active`, `price`, `is_new`, `is_sale`) VALUES
(1, 'Юбка со складками', 1, 499, 0, 0),
(2, 'Брюки', 1, 1999, 1, 0),
(3, 'Кардиган', 1, 3299, 0, 1),
(4, 'Попугай', 1, 1299, 1, 1),
(5, 'Проверка', 1, 199, 0, 1),
(6, 'Футболка', 1, 899, 1, 1),
(7, 'Пушкин', 1, 4100, 1, 1);

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `user_name`, `email`, `password`) VALUES
(1, 'Test1', 'test1@mail.ru', '$2y$10$jRD9pC./N5ZafNSooZOGx.W//aWWFhS/ugsnOfEKKMvLtm45fD14.'),
(2, 'Test2', 'test2@mail.ru', '$2y$10$DjuOIQzx1VLvO47E8K0XXOi.t7Kqb5yiG3P4ybfjW534f3NiKqQ7q'),
(3, 'Test3', 'test3@mail.ru', '$2y$10$xQrwto1i2NBzKuhcHO1lOen70ppVHQ1uo/BOBAxOqIVWBKaIj1Br.');


ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `category_product`
  ADD UNIQUE KEY `category_id` (`category_id`,`product_id`) USING BTREE,
  ADD KEY `product_id` (`product_id`);

ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `group_user`
  ADD PRIMARY KEY (`user_id`,`group_id`) USING BTREE,
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `category_product`
  ADD CONSTRAINT `category_product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `group_user`
  ADD CONSTRAINT `group_user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

