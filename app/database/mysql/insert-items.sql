USE `restaurant`;

-- Insert categories into the categories table (only if they don't already exist)
INSERT IGNORE INTO `categories` (`CategoryID`, `CategoryName`, `Description`) VALUES
(1, 'Pizza', NULL),
(2, 'Fast Food', NULL),
(3, 'Dessert', NULL),
(4, 'Appetizer', NULL),
(5, 'Main Course', NULL),
(6, 'Rice Dish', NULL),
(7, 'Salad', NULL),
(8, 'Beverage', NULL),
(9, 'Topping', NULL),
(10, 'Breakfast', NULL),
(11, 'Street Food', NULL),
(12, 'Alcohol', NULL);

-- Insert products into the products table
INSERT INTO `products` (`CategoryID`, `ProductName`, `Description`, `Price`, `Image`) VALUES
(1, 'Chicken Supreme Pizza', 'Topped with chicken, onion, capsicum, black olive, and green chilli.', 12.99, 'chicken_supreme_pizza.jpg'),
(2, 'Hamburger Burger with Beef', 'Juicy beef patty with lettuce, tomato, cheese, and special sauce.', 8.99, 'beef_hamburger.jpg'),
(3, 'Belgium Waffles with Strawberries', 'Crispy Belgian waffles topped with fresh strawberries and whipped cream.', 6.50, 'belgium_waffles.jpg'),
(4, 'Chicken Skewers', 'Grilled chicken skewers marinated in herbs and spices.', 9.99, 'chicken_skewers.jpg'),
(5, 'Delicious Food on a White Plate', 'A chef''s special platter with a mix of grilled vegetables, roasted chicken, and garlic bread.', 15.00, 'delicious_plate.jpg'),
(6, 'Mutton or Lamb Biryani', 'Fragrant basmati rice cooked with tender mutton or lamb, flavored with spices.', 14.50, 'biryani.jpg'),
(7, 'Spicy Fried Tubtim Fish Salad', 'Crispy fried tubtim fish served with a spicy Thai salad.', 11.99, 'tubtim_fish_salad.jpg'),
(8, 'Fresh Cola Drink with Green Lime', 'Chilled cola served with a slice of fresh green lime.', 2.50, 'cola_lime.jpg'),
(3, 'Ice Cream Cone', 'Classic vanilla ice cream in a crispy cone.', 3.00, 'ice_cream_cone.jpg'),
(3, 'Chocolate Ice Cream', 'Rich and creamy chocolate ice cream.', 4.00, 'chocolate_ice_cream.jpg'),
(9, 'Chocolate Toppings for Ice Cream Cups', 'Smooth chocolate sauce and chocolate chips, perfect for topping ice cream cups.', 1.50, 'chocolate_topping.jpg'),
(10, 'Healthy Breakfast', 'A balanced breakfast with oatmeal, fresh fruits, and yogurt.', 7.99, 'healthy_breakfast.jpg'),
(10, 'Breakfast with Coffee and Fresh Croissants', 'A delightful breakfast combo of freshly baked croissants and a cup of coffee.', 5.99, 'croissant_coffee.jpg'),
(10, 'Fried Eggs, Sausages, Zucchini', 'A hearty breakfast with fried eggs, sausages, and grilled zucchini.', 8.50, 'eggs_sausages_zucchini.jpg'),
(10, 'Salad, Fried Eggs, and Pastry', 'A light meal with a fresh salad, fried eggs, and a buttery pastry.', 9.00, 'salad_eggs_pastry.jpg'),
(5, 'Doner with Grilled Chicken', 'Grilled chicken wrapped in flatbread with fresh vegetables and tzatziki sauce.', 10.99, 'doner_chicken.jpg'),
(2, 'Hot Dogs', 'Classic hot dog with mustard, ketchup, and onions in a soft bun.', 5.99, 'hot_dogs.jpg'),
(7, 'Greek Salad', 'Fresh salad with tomatoes, cucumbers, olives, feta cheese, and Greek dressing.', 8.50, 'greek_salad.jpg'),
(11, 'Dahi Puri', 'Crispy puri filled with spiced yogurt, tamarind chutney, and sev.', 6.99, 'dahi_puri.jpg'),
(12, 'Mojito', 'Refreshing cocktail with rum, mint, lime, soda, and sugar.', 7.50, 'mojito.jpg'),
(12, 'Margarita', 'Classic cocktail with tequila, lime juice, and triple sec, served with a salted rim.', 8.00, 'margarita.jpg'),
(12, 'Pina Colada', 'Tropical cocktail with rum, pineapple juice, and coconut cream.', 8.50, 'pina_colada.jpg');