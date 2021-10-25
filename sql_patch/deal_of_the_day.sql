alter table predefined_menu add (deals_of_the_day VARCHAR(1), disc_per DECIMAL(20,2));

alter table predefined_menu add (best_seller VARCHAR(1));

CREATE TABLE predefined_menu_additional
(id INT, 
BRANCH_ID INT,
mapped_id INT,
net_weight VARCHAR(55), 
gross_weight VARCHAR(55), 
delivery_time VARCHAR(55));