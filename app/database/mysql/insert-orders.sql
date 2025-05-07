USE `restaurant`;

-- Insert test data for orders
INSERT INTO orders (UserID, TotalAmount, OrderStatus, CreateAt, PayAt, ShipperID) VALUES
(1, 12.99, 'Completed', '2025-05-06 10:00:00', '2025-05-06 10:00:00', 1),
(2, 14.49, 'Pending', '2025-05-06 11:00:00', '2025-05-06 11:00:00', 2);

-- Insert test data for order_items
INSERT INTO order_items (OrderID, ProductID, Quantity) VALUES
(1, 1, 1), -- User 1 ordered Chicken Supreme Pizza
(2, 1, 1), -- User 2 ordered Chicken Supreme Pizza
(2, 3, 1); -- User 2 also ordered Cola