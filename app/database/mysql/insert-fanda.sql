--
-- Cấu trúc bảng cho bảng `fanda`
--

CREATE TABLE `fanda` (
  `ID` int(11) NOT NULL,
  `question` varchar(1000) NOT NULL,
  `answer` varchar(1000) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Chỉ mục cho bảng `fanda`
--
ALTER TABLE `fanda`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT cho bảng `fanda`
--
ALTER TABLE `fanda`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Đang đổ dữ liệu cho bảng `fanda`
--

INSERT INTO `fanda` (`ID`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(1, 'Where are your restaurant locations?', 'We have four convenient locations in Vietnam: Hanoi, Ho Chi Minh City, Da Nang, and Nha Trang. Please check our \"Locations\" page for specific addresses.', '2025-05-06 22:35:12', '2025-05-06 22:35:12'),
(2, 'What are your opening hours?', 'We are open daily from 9:00 AM to 10:00 PM, including Saturdays and Sundays, at all our locations.', '2025-05-06 22:35:12', '2025-05-06 22:35:12'),
(3, 'Do you offer delivery services?', 'Yes, we offer delivery through various online platforms. Please check our website or your preferred delivery app for availability in your area.', '2025-05-06 22:35:12', '2025-05-06 22:35:12'),
(4, 'What kind of food do you serve?', 'We specialize in delicious fast food including pizza, hamburgers, french fries, and fried chicken.', '2025-05-06 22:35:12', '2025-05-06 22:35:12'),
(5, 'Can I see your menu online?', ' Absolutely! You can view our full menu with prices and descriptions on our \"Homepage\" page.', '2025-05-06 22:35:12', '2025-05-06 22:35:12'),
(6, 'Do you have vegetarian options?', 'Yes, we offer a selection of tasty vegetarian options on our menu. Please note that the specific vegetarian dishes available may vary slightly between our different locations. Please see our \"Menu\" for details specific to each branch.', '2025-05-06 22:35:12', '2025-05-06 22:35:12'),
(7, 'Are your ingredients fresh?', 'We are committed to using fresh, high-quality ingredients in all our dishes.', '2025-05-06 22:35:12', '2025-05-06 22:35:12'),
(8, 'How can I place an order for pickup?', ' You can place a pickup order by calling your nearest Tasty Bites location or through our online ordering system.', '2025-05-06 22:35:12', '2025-05-06 22:35:12'),
(9, 'Do you offer catering services for events?', 'Yes, we offer catering services for various events. You can view our catering offers in the \"Special Services\" section of our website, or contact us directly for a personalized response and the best options for your needs.', '2025-05-06 22:35:12', '2025-05-06 22:35:12'),
(10, 'Do you have any special promotions or discounts?', 'Yes, we frequently offer special promotions and discounts! When available, discounted prices will be clearly displayed, and you can find our latest advertisements on our official website.', '2025-05-06 22:35:12', '2025-05-06 22:35:12');

-- --------------------------------------------------------