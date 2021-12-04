alter table obo_city_config add column branch_exists varchar(1) DEFAULT 'N';
 
 
alter table predefined_menu_categories add column icon varchar(255) DEFAULT NULL;

ALTER TABLE wera_order_item_details MODIFY item_name varchar(500);
