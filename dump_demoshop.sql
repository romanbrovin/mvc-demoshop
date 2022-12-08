# Дамп таблицы m_banner
# ------------------------------------------------------------

CREATE TABLE `m_banner` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `photo` char(20) NOT NULL DEFAULT '',
  `url` text NOT NULL,
  `sort_order` smallint(3) NOT NULL DEFAULT '0',
  `comment_admin` char(90) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_basket
# ------------------------------------------------------------

CREATE TABLE `m_basket` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `product_id` int(9) NOT NULL DEFAULT '0' COMMENT 'ID товара',
  `order_id` int(9) NOT NULL DEFAULT '0' COMMENT 'ID заказа',
  `amount` mediumint(6) NOT NULL DEFAULT '0',
  `price_adv` int(9) NOT NULL DEFAULT '0' COMMENT 'цена продажи на сайте',
  `price_dbs` int(9) NOT NULL DEFAULT '0' COMMENT 'цена продажи dbs',
  `price_ozon` int(9) NOT NULL DEFAULT '0' COMMENT 'цена продажи ozon',
  `price_wb` int(9) NOT NULL DEFAULT '0' COMMENT 'цена продажи wilderries',
  `price_avito` int(9) NOT NULL DEFAULT '0' COMMENT 'цена продажи avito',
  `price_avg` int(9) NOT NULL DEFAULT '0' COMMENT 'средняя цена закупки товара',
  `is_checkout` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'заказ оформлен',
  `role` char(5) NOT NULL DEFAULT '' COMMENT 'user,admin',
  `uid` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_category
# ------------------------------------------------------------

CREATE TABLE `m_category` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `name` char(60) NOT NULL DEFAULT '',
  `url` char(150) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `photo` char(20) NOT NULL DEFAULT '' COMMENT 'аватарка',
  `cost_all` bigint(10) NOT NULL DEFAULT '0' COMMENT 'себестоимость всех товаров в категории',
  `amount_all` mediumint(6) NOT NULL DEFAULT '0' COMMENT 'всего товаров в категории',
  `cost_active` bigint(10) NOT NULL DEFAULT '0' COMMENT 'себестоимость активных товаров в категории',
  `amount_active` mediumint(6) NOT NULL DEFAULT '0' COMMENT 'кол-во активных товаров в категории',
  `selling_active` bigint(20) NOT NULL DEFAULT '0' COMMENT 'активных товаров продается на эту сумму',
  `sort_order` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'порядок сортировки',
  `seo_title` varchar(250) NOT NULL,
  `seo_description` varchar(250) NOT NULL,
  `comment_admin` char(90) NOT NULL DEFAULT '',
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'скрыть всю категорию',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_const
# ------------------------------------------------------------

CREATE TABLE `m_const` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `name` char(20) NOT NULL DEFAULT '',
  `value` bigint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `m_const` (`id`, `created_at`, `updated_at`, `name`, `value`)
VALUES
	(1,'2022-01-01 01:01:01','2022-01-01 01:01:01','cost_all',0),
	(2,'2022-01-01 01:01:01','2022-01-01 01:01:01','cost_active',0),
	(3,'2022-01-01 01:01:01','2022-01-01 01:01:01','selling_active',0),
	(4,'2022-01-01 01:01:01','2022-01-01 01:01:01','amount_all',0),
	(5,'2022-01-01 01:01:01','2022-01-01 01:01:01','amount_active',0),
	(6,'2022-01-01 01:01:01','2022-01-01 01:01:01','income_money',0),
	(7,'2022-01-01 01:01:01','2022-01-01 01:01:01','income_percent',0),
	(8,'2022-01-01 01:01:01','2022-01-01 01:01:01','adv',0),
	(9,'2022-01-01 01:01:01','2022-01-01 01:01:01','dbs',0),
	(10,'2022-01-01 01:01:01','2022-01-01 01:01:01','ozon',0);


# Дамп таблицы m_cost_category
# ------------------------------------------------------------

CREATE TABLE `m_cost_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `name` varchar(150) NOT NULL DEFAULT '',
  `comment_admin` char(90) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_costs
# ------------------------------------------------------------

CREATE TABLE `m_costs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `cost_category_id` mediumint(9) NOT NULL DEFAULT '0',
  `amount` mediumint(6) NOT NULL DEFAULT '0',
  `comment_admin` char(90) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_facts
# ------------------------------------------------------------

CREATE TABLE `m_facts` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `name` text NOT NULL,
  `comment_admin` char(90) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_marketplace
# ------------------------------------------------------------

CREATE TABLE `m_marketplace` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `short_name` char(10) NOT NULL,
  `name` varchar(150) NOT NULL DEFAULT '',
  `tooltip` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `m_marketplace` (`id`, `created_at`, `updated_at`, `short_name`, `name`, `tooltip`)
VALUES
	(1,'2022-01-01 01:01:01','2022-01-01 01:01:01','adv','На сайте','Цена продажи на сайте'),
	(2,'2022-01-01 01:01:01','2022-01-01 01:01:01','dbs','Яндекс.Маркет','Цена продажи на Яндекс.Маркет'),
	(3,'2022-01-01 01:01:01','2022-01-01 01:01:01','ozon','OZON','Цена продажи на OZON'),
	(4,'2022-01-01 01:01:01','2022-01-01 01:01:01','wb','Wildberries','Цена продажи на Wildberries'),
	(5,'2022-01-01 01:01:01','2022-01-01 01:01:01','avito','Авито','Цена продажи на Авито');


# Дамп таблицы m_order
# ------------------------------------------------------------

CREATE TABLE `m_order` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL COMMENT 'дата формирования заказа',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00' COMMENT 'обновление',
  `checkouted_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00' COMMENT 'дата оформления',
  `confirmed_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00' COMMENT 'дата подтверждения',
  `paid_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00' COMMENT 'дата оплаты',
  `transited_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00' COMMENT 'дата отправки заказа',
  `delivered_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00' COMMENT 'дата доставки',
  `returned_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00' COMMENT 'дата возврата',
  `written_off_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00' COMMENT 'дата списания',
  `canceled_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00' COMMENT 'дата отмены',
  `payment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-онлайн, 2-наложка',
  `delivery_type` char(11) NOT NULL DEFAULT 'mail' COMMENT 'Доставка по России или курьер по городу',
  `delivery_service` char(50) NOT NULL DEFAULT '' COMMENT 'Почта, СДЭК, Boxberry',
  `delivery_variant` varchar(100) NOT NULL DEFAULT '' COMMENT 'ПВЗ или курьер до двери',
  `delivery_days` char(20) NOT NULL DEFAULT '',
  `delivery_track` varchar(30) NOT NULL DEFAULT '' COMMENT 'трек номер',
  `marketplace` char(10) NOT NULL DEFAULT '' COMMENT 'озон, яндекс.маркет',
  `marketplace_order` varchar(100) NOT NULL DEFAULT '',
  `order_sum` int(9) NOT NULL DEFAULT '0' COMMENT 'сумма заказа',
  `delivery_price` int(9) NOT NULL DEFAULT '0' COMMENT 'стоимость доставки',
  `cod` int(9) NOT NULL DEFAULT '0' COMMENT 'наложенный платеж',
  `bonus` int(9) NOT NULL DEFAULT '0' COMMENT 'списанные бонусы',
  `promocode` int(9) NOT NULL DEFAULT '0',
  `total_sum` int(9) NOT NULL DEFAULT '0' COMMENT 'итого к оплате',
  `address` text NOT NULL COMMENT 'адрес доставки',
  `promocode_id` int(9) NOT NULL DEFAULT '0',
  `current_status` char(100) NOT NULL DEFAULT 'new' COMMENT 'текущий статус заказа',
  `can_cancel` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-да, 2-нет отменить заказ',
  `comment_user` char(250) NOT NULL,
  `comment_admin` char(90) NOT NULL,
  `role` char(5) NOT NULL DEFAULT '' COMMENT 'user,admin',
  `costs` int(9) NOT NULL DEFAULT '0' COMMENT 'все расходы по заказу (закупка+доставка+бонусы+наложка)',
  `profit` int(9) NOT NULL DEFAULT '0' COMMENT 'итоговая прибыль',
  `uid` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_paykeeper
# ------------------------------------------------------------

CREATE TABLE `m_paykeeper` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `order_id` int(9) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `sum` float NOT NULL DEFAULT '0',
  `ps_id` varchar(255) NOT NULL DEFAULT '',
  `fop_receipt_key` varchar(255) NOT NULL DEFAULT '',
  `bank_id` varchar(255) NOT NULL DEFAULT '',
  `card_number` varchar(255) NOT NULL DEFAULT '',
  `card_holder` varchar(255) NOT NULL DEFAULT '',
  `card_expiry` varchar(255) NOT NULL DEFAULT '',
  `withdraw_amount` float NOT NULL DEFAULT '0',
  `operation_id` varchar(255) NOT NULL DEFAULT '',
  `sender` int(9) NOT NULL,
  `is_return` tinyint(1) NOT NULL DEFAULT '0',
  `uid` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_product
# ------------------------------------------------------------

CREATE TABLE `m_product` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `article` char(20) NOT NULL DEFAULT '' COMMENT 'артикул продукта',
  `barcode` varchar(20) NOT NULL DEFAULT '' COMMENT 'выделение цветом',
  `category_id` int(9) NOT NULL DEFAULT '0',
  `name` char(150) NOT NULL DEFAULT '' COMMENT 'название продукта',
  `preview` text NOT NULL,
  `description` text NOT NULL,
  `youtube` text NOT NULL COMMENT 'ссылка на ютуб',
  `age` smallint(3) NOT NULL DEFAULT '0' COMMENT 'минимальный возраст',
  `year` smallint(4) NOT NULL DEFAULT '0' COMMENT 'год производства товара',
  `parts` smallint(5) NOT NULL DEFAULT '0' COMMENT 'кол-во деталей',
  `figures` smallint(4) NOT NULL DEFAULT '0' COMMENT 'кол-во фигурок',
  `length` smallint(4) NOT NULL DEFAULT '0' COMMENT 'длина товара',
  `width` smallint(4) NOT NULL DEFAULT '0' COMMENT 'ширина товара',
  `height` smallint(4) NOT NULL DEFAULT '0' COMMENT 'высота товара',
  `weight` float NOT NULL DEFAULT '0' COMMENT 'вес товара',
  `length_pack` smallint(4) NOT NULL DEFAULT '0' COMMENT 'длина упаковки',
  `width_pack` smallint(4) NOT NULL DEFAULT '0' COMMENT 'ширина упаковки',
  `height_pack` smallint(4) NOT NULL DEFAULT '0' COMMENT 'высота упаковки',
  `weight_pack` float NOT NULL DEFAULT '0' COMMENT 'вес товара в упаковке',
  `photo` text NOT NULL COMMENT 'массив фотографий',
  `price_avg` int(9) NOT NULL DEFAULT '0' COMMENT 'средняя цена закупки',
  `price_adv` int(9) NOT NULL DEFAULT '0' COMMENT 'цена продажи на сайте без скидки',
  `price_adv_discount` int(9) NOT NULL DEFAULT '0' COMMENT 'цена продажи на сайте со скидкой',
  `price_adv_discount_sum` int(9) NOT NULL DEFAULT '0' COMMENT 'размер скидки на сайте',
  `price_adv_discount_percent` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'размер скидки на сайте в процентах',
  `price_adv_profit` int(9) NOT NULL DEFAULT '0' COMMENT 'ожидаемый доход после продажи через сайт',
  `price_adv_profit_percent` int(9) NOT NULL DEFAULT '0' COMMENT 'ожидаемый доход в процентах после продажи через сайт',
  `price_dbs` int(9) NOT NULL DEFAULT '0',
  `price_dbs_discount` int(9) NOT NULL DEFAULT '0',
  `price_dbs_discount_sum` int(9) NOT NULL DEFAULT '0',
  `price_dbs_discount_percent` tinyint(2) NOT NULL DEFAULT '0',
  `price_dbs_profit` int(9) NOT NULL DEFAULT '0',
  `price_dbs_profit_percent` int(9) NOT NULL DEFAULT '0',
  `price_ozon` int(9) NOT NULL DEFAULT '0',
  `price_ozon_discount` int(9) NOT NULL DEFAULT '0',
  `price_ozon_discount_sum` int(9) NOT NULL DEFAULT '0',
  `price_ozon_discount_percent` tinyint(2) NOT NULL DEFAULT '0',
  `price_ozon_profit` int(9) NOT NULL DEFAULT '0',
  `price_ozon_profit_percent` int(9) NOT NULL DEFAULT '0',
  `price_wb` int(9) NOT NULL DEFAULT '0',
  `price_wb_discount` int(9) NOT NULL DEFAULT '0',
  `price_wb_discount_sum` int(9) NOT NULL DEFAULT '0',
  `price_wb_discount_percent` tinyint(2) NOT NULL DEFAULT '0',
  `price_wb_profit` int(9) NOT NULL DEFAULT '0',
  `price_wb_profit_percent` int(9) NOT NULL DEFAULT '0',
  `price_avito` int(9) NOT NULL DEFAULT '0',
  `price_avito_discount` int(9) NOT NULL DEFAULT '0',
  `price_avito_discount_sum` int(9) NOT NULL DEFAULT '0',
  `price_avito_discount_percent` tinyint(2) NOT NULL DEFAULT '0',
  `price_avito_profit` int(9) NOT NULL DEFAULT '0',
  `price_avito_profit_percent` int(9) NOT NULL DEFAULT '0',
  `tag_new` tinyint(1) NOT NULL DEFAULT '0',
  `tag_hit` tinyint(1) NOT NULL DEFAULT '0',
  `tag_rare` tinyint(1) NOT NULL DEFAULT '0',
  `tag_low_price` tinyint(1) NOT NULL DEFAULT '0',
  `amount` mediumint(6) NOT NULL DEFAULT '0' COMMENT 'всего товаров',
  `amount_active` mediumint(6) NOT NULL DEFAULT '0' COMMENT 'в продаже товаров',
  `bonus` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'бонусы за покупку',
  `counter` int(9) NOT NULL DEFAULT '0' COMMENT 'счетчик посещений',
  `comment_admin` char(90) NOT NULL,
  `is_soon` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'скоро в продаже',
  `is_select` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'выделение цветом',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_promocode
# ------------------------------------------------------------

CREATE TABLE `m_promocode` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `name` varchar(150) NOT NULL DEFAULT '',
  `price` int(9) NOT NULL DEFAULT '1',
  `max_count` int(9) NOT NULL DEFAULT '1',
  `used_count` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_report
# ------------------------------------------------------------

CREATE TABLE `m_report` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `tbl_name` varchar(20) NOT NULL DEFAULT '',
  `tbl_id` mediumint(9) NOT NULL DEFAULT '0',
  `amount` mediumint(6) NOT NULL DEFAULT '0',
  `comment_admin` char(90) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_stats
# ------------------------------------------------------------

CREATE TABLE `m_stats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(9) NOT NULL,
  `amount_sells` smallint(4) NOT NULL DEFAULT '0',
  `amount_storage` smallint(4) NOT NULL DEFAULT '0',
  `total_costs` mediumint(7) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_storage
# ------------------------------------------------------------

CREATE TABLE `m_storage` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `product_id` int(9) NOT NULL COMMENT 'ID товара',
  `warehouse_id` int(9) NOT NULL DEFAULT '0' COMMENT 'ID склада, term_meta',
  `supplier_id` int(9) NOT NULL DEFAULT '0' COMMENT 'ID поставщика, term_meta',
  `price` mediumint(6) NOT NULL DEFAULT '0' COMMENT 'цена закупки',
  `amount` smallint(4) NOT NULL DEFAULT '0' COMMENT 'кол-во товара',
  `rack` smallint(4) NOT NULL DEFAULT '0' COMMENT 'стеллаж',
  `pallet` smallint(4) NOT NULL DEFAULT '0' COMMENT 'паллет',
  `box` smallint(4) NOT NULL DEFAULT '0' COMMENT 'коробка',
  `comment_admin` char(90) NOT NULL DEFAULT '',
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'скрыть товар на складе',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_supplier
# ------------------------------------------------------------

CREATE TABLE `m_supplier` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `name` varchar(150) NOT NULL DEFAULT '',
  `comment_admin` char(90) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Дамп таблицы m_user
# ------------------------------------------------------------

CREATE TABLE `m_user` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `surname` varchar(150) NOT NULL DEFAULT '',
  `name` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(150) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(20) NOT NULL DEFAULT '',
  `ip` varchar(40) NOT NULL DEFAULT '' COMMENT 'айпи при регистрации',
  `ua` varchar(255) NOT NULL DEFAULT '' COMMENT 'юзер агент при регистрации',
  `bonus` int(9) NOT NULL DEFAULT '0' COMMENT 'накопленные бонусы',
  `purchases` int(9) NOT NULL DEFAULT '0' COMMENT 'кол-во покупок',
  `counter` int(9) NOT NULL DEFAULT '0' COMMENT 'счетчик авторизаций клиента',
  `comment_admin` char(90) NOT NULL DEFAULT '',
  `role` char(5) NOT NULL DEFAULT 'user' COMMENT 'user,admin',
  `uid` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `m_user` (`id`, `created_at`, `updated_at`, `surname`, `name`, `email`, `password`, `phone`, `ip`, `ua`, `bonus`, `purchases`, `counter`, `comment_admin`, `role`, `uid`)
VALUES
	(1,'2022-12-01 01:01:01','2022-12-01 01:01:01','Роман','Администратор','admin@shop.ru','$2y$10$1ShaSr0PJuHB8ULQkPMgFO2LTjXDfQx6ku9UB.dx5XiApT61oSM.S','71234567890','','',0,0,0,'','admin','f4da6ad4ddb06839485a240386afb3a4');


# Дамп таблицы m_warehouse
# ------------------------------------------------------------

CREATE TABLE `m_warehouse` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '1999-11-11 00:00:00',
  `name` varchar(150) NOT NULL DEFAULT '',
  `comment_admin` char(90) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
