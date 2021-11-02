CREATE TABLE obo_recipe
(id INT, 
branch_id INT,
recipe_name VARCHAR(200),
image VARCHAR(200), 
description VARCHAR(10000));

CREATE TABLE obo_recipe_ingredients
(id INT, 
branch_id INT,
recipe_id INT,
ingredient_name VARCHAR(200), 
serving_count INT);

CREATE TABLE obo_recipe_procedure
(id INT, 
branch_id INT,
recipe_id INT,
instruction_id INT, 
recipe_notes  VARCHAR(10000),
detail_steps VARCHAR(10000));

CREATE TABLE obo_item_desciption
(id INT, 
branch_id INT,
item_id INT,
specification VARCHAR(1000));

alter table predefined_menu_additional add (video VARCHAR(10000));

alter table predefined_menu add (description VARCHAR(10000));

CREATE TABLE item_related_images
(id INT, 
branch_id INT,
item_id INT,
image_path VARCHAR(1000));
