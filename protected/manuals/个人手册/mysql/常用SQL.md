
常用sql
======

	# 更新后台账户，使用admin/admin
	UPDATE ecs_admin_user SET user_name='admin', PASSWORD='21232f297a57a5a743894a0e4a801fc3' WHERE user_name='adminandadmin';
	
	# 清空表
	TRUNCATE tb_goods;
	
	# 复制表
	CREATE TABLE ecs_goods_201311 LIKE ecs_goods;
	INSERT INTO ecs_goods_201311 SELECT * FROM ecs_goods;
	
	# 修改主键：先删除，后添加
	ALTER TABLE tb_goods DROP PRIMARY KEY;
	ALTER TABLE tb_goods ADD PRIMARY KEY(goods_id);
	
	# 修改唯一索引：先删除，后添加
	ALTER TABLE tb_goods DROP INDEX unique_index;
	ALTER TABLE tb_goods ADD UNIQUE unique_index (goods_sn);
	
	# 修改表描述
	ALTER TABLE tb_goods COMMENT '';
	
	# 增加列
	ALTER TABLE ADD tb_goods goods_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '' FIRST;
	ALTER TABLE ADD tb_goods goods_sn VARCHAR(60) UNIQUE COMMENT '' AFTER goods_name;
	ALTER TABLE ADD tb_goods is_new TINYINT(1) UNSIGNED DEFAULT 1 COMMENT '' AFTER goods_sn;
	
	# check table
	mysqlcheck -uroot -p123456 dbname table_01 table_02 ...;
	mysqlcheck -uroot -p123456 dbname;
	
	# repair table
	mysqlcheck -uroot -p123456 -r dbname table_01 table_02 ...;
	mysqlcheck -uroot -p123456 -r dbname;
	
	# 垂直拼接多行
	# 可以排序和设置分割符. 拼接结果字符有长度限制：select @@global.group_concat_max_len，默认为1024.
	# 设置：set global group_concat_max_len=102400.
	SELECT
		GROUP_CONCAT(CONCAT(ao.option_id, '#',ao.attr_value) SEPARATOR ' ') AS OPTIONS
	FROM `scm`.`ecs_goods_type` AS gt
		LEFT JOIN `scm`.`ecs_attribute` AS a
			ON a.cat_id = gt.cat_id
		LEFT JOIN `scm`.`ecs_attribute_option` AS ao
			ON ao.attr_id = a.attr_id
	GROUP BY a.attr_id
	ORDER BY gt.cat_id, a.attr_id, ao.option_id;
	
	# 有底限的自动减一
	UPDATE `em`.`ecs_child_supply` 
	SET sup_inventory = IF((sup_inventory - 1) > 0, (sup_inventory - 1), 0)  
	WHERE child_id = '37521' 
	AND sup_sn='G002'
	
	# 时间格式化转换
	SELECT UNIX_TIMESTAMP(NOW());
	SELECT UNIX_TIMESTAMP('2014/05/12 10:03:00');
	SELECT FROM_UNIXTIME(UNIX_TIMESTAMP(NOW()), '%Y年%m月%d %H:%i:%s');
	
	# 查表创建/更新/检查时间
	USE information_schema
	SELECT create_time FROM TABLES WHERE table_name = 'documents';
	SELECT update_time FROM TABLES WHERE table_name = 'documents';
	SELECT check_time FROM TABLES WHERE table_name = 'documents';
	
	# 按IN排序
	$id_set_order = implode(',', $goods_ids);
	ORDER BY FIND_IN_SET(g.goods_id, '{$id_set_order}')
	
	# 导入大SQL文件
	max_allowed_packet = 1024M
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
