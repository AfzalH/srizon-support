```sql

  CREATE TABLE `orders` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `p_id` int(10) unsigned NOT NULL,
    `p_date` varchar(127) NOT NULL,
    `status` varchar(127) NOT NULL,
    `country` varchar(127) NOT NULL,
    `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `email` varchar(255) NOT NULL,
    `product_name` varchar(127) NOT NULL,
    `product_id` int(11) NOT NULL,
    `payment_method` varchar(127) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `purchase_id_unique` (`p_id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

```

after that make the names of the product match by update query... something like

```sql 

update orders set product_name='Srizon Facebook Album Pro' where product_name='Srizon Facebook Album Pro pack';

```

after that update the product_id
```

update orders set product_id=4 where product_name='Srizon Facebook Album Pro';
update orders set product_id=3 where product_name='JFBAlbum';
update orders set product_id=2 where product_name='JUserTube';
update orders set product_id=5 where product_name='SrizonYoutubeAlbumPro';
update orders set product_id=9 where product_name='Srizon Tag';
update orders set product_id=7 where product_name='Srizon Flickr Gallery';
update orders set product_id=8 where product_name='Srizon Image Slider';

```