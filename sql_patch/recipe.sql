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