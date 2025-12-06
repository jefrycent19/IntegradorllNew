-- db/init_integradorll.sql
CREATE DATABASE IF NOT EXISTS integradorll
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE integradorll;

CREATE TABLE IF NOT EXISTS diets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  calories_target INT NOT NULL CHECK (calories_target > 0),
  notes VARCHAR(500) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS meals (
  id INT AUTO_INCREMENT PRIMARY KEY,
  diet_id INT NOT NULL,
  meal_date DATE NOT NULL,
  meal_type VARCHAR(30) NOT NULL,
  description VARCHAR(255) NULL,
  calories INT NOT NULL CHECK (calories > 0),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_meals_diet FOREIGN KEY (diet_id) REFERENCES diets(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO diets (name, calories_target, notes) VALUES
('Déficit calórico', 1800, 'Enfocado en pérdida de peso controlada'),
('Mantenimiento', 2200, 'Balanceada'),
('Superávit ligero', 2600, 'Para ganancia muscular');

INSERT INTO meals (diet_id, meal_date, meal_type, description, calories) VALUES
(1, CURDATE(), 'Desayuno', 'Avena con fruta', 350),
(1, CURDATE(), 'Almuerzo', 'Ensalada con pollo', 500),
(2, CURDATE(), 'Cena', 'Pescado al horno', 600),
(3, CURDATE(), 'Snack', 'Yogur griego', 180);
