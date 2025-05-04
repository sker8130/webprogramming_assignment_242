
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `branches`
--

CREATE TABLE `branches` (
  `ID` int(11) NOT NULL,
  `location` varchar(256) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `image` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Chỉ mục cho bảng `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT cho bảng `branches`
--

ALTER TABLE `branches`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Đang đổ dữ liệu cho bảng `branches`
--

INSERT INTO `branches` (`ID`, `location`, `description`, `image`) VALUES
(1, 'Hanoi', 'Nestled in the heart of Hanoi, Tasty Bites brings its signature flavors to the vibrant culinary scene of the capital. Whether you are exploring the historic Old Quarter or enjoying the modern bustle, our Hanoi branch offers a welcoming space to savor our delicious. Experience the authentic taste of Tasty Bites, crafted with fresh ingredients and a passion for flavor, right here in Hanoi.', 'app/views/admin/introduction/uploads/locations/dd13e89818f71f2b0729b2be947db216.jpg'),
(2, 'Ho Chi Minh City', 'In the dynamic metropolis of Ho Chi Minh City, Tasty Bites provides a delicious escape from the urban energy. Located in District 1, our Ho Chi Minh City branch offers a wide selection from our menu, perfect for a quick bite, a casual meal with friends, or a satisfying family dinner. Join us and discover why Tasty Bites has become a favorite for those seeking quality and taste in this bustling city.', 'app/views/admin/introduction/uploads/locations/c3a8645827c04521c18be26d6dde6a11.jpg'),
(3, 'Da Nang', 'Embracing the coastal charm of Da Nang, Tasty Bites offers a fresh and flavorful dining experience by the sea. Situated in the city center, our Da Nang branch is the perfect spot to enjoy our offerings after a day of exploring the beautiful beaches and vibrant city life. Come and taste the freshness and local inspiration that makes Tasty Bites a must-visit in Da Nang.', 'app/views/admin/introduction/uploads/locations/DaNang.jpg'),
(4, 'Nha Trang', 'Discover the taste of Tasty Bites in the beautiful resort city of Nha Trang. Our branch, located close to the hotels, offers a relaxed and inviting atmosphere to enjoy our menu. Whether you are a local resident or a visitor soaking up the sun, Tasty Bites in Nha Trang is your go-to destination for a satisfying and delicious meal that captures the essence of this coastal paradise.', 'app/views/admin/introduction/uploads/locations/NhaTrang.jpg');

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `members`
--

CREATE TABLE `members` (
  `position` varchar(128) NOT NULL,
  `name` varchar(256) NOT NULL,
  `description` varchar(256) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Chỉ mục cho bảng `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT cho bảng `members`
--
ALTER TABLE `members`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Đang đổ dữ liệu cho bảng `members`
--

INSERT INTO `members` (`position`, `name`, `description`, `ID`) VALUES
('COO', 'Nguyen Minh Tuan', 'The COO ensures smooth operations across all Tasty Bites branches.', 1),
('CEO', 'Tran Thi Lan Anh', 'The CEO leads Tasty Bites with creativity and a strong vision for growth.', 2),
('CTO', 'Pham Quoc Tuan', 'The CTO manages and optimizes Tasty Bites’ technology systems for better customer experience.', 3),
('Head Chef - HCM', 'Le Minh Tu', 'Le Minh Tu is the Head Chef at the HCM branch, creating innovative and high-quality dishes.', 4),
('Head Chef - Hanoi', 'Nguyen Quang Duy', 'Nguyen Quang Duy is the Head Chef at the Hanoi branch, known for his refined and flavorful dishes.', 5),
('Head Chef - Da Nang', 'Phan Thi Thanh Mai', 'Phan Thi Thanh Mai is the Head Chef at the Da Nang branch, blending fresh ingredients with modern cooking techniques.', 6),
('Head Chef - Nha Trang', 'Vo Ngoc Binh', 'Vo Ngoc Binh is the Head Chef at the Nha Trang branch, specializing in fresh seafood dishes.', 7),
('Sous Chef – HCM', 'Tran Anh Duy', 'Tran Anh Duy is the Sous Chef at the HCM branch, supporting the Head Chef and maintaining dish quality.', 8),
('Sous Chef – Hanoi', 'Hoang Quang Huy', 'Hoang Quang Huy is the Sous Chef at the Hanoi branch, ensuring consistency and creativity in every dish.', 9),
('Sous Chef – Da Nang', 'Le Thi Lan', 'Le Thi Lan is the Sous Chef at the Da Nang branch, assisting in kitchen operations and menu development.', 10),
('Sous Chef – Nha Trang', 'Phan Minh Tuan', 'Phan Minh Tuan is the Sous Chef at the Nha Trang branch, overseeing kitchen coordination and quality control.', 11),
('Accountant', 'Kim Ngan', 'This is description, Kim Ngan update description.', 12);

-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `specialservice`
--

CREATE TABLE `specialservice` (
  `title` varchar(128) NOT NULL,
  `description` varchar(512) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Chỉ mục cho bảng `specialservice`
--
ALTER TABLE `specialservice`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT cho bảng `specialservice`
--
ALTER TABLE `specialservice`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT; 

--
-- Đang đổ dữ liệu cho bảng `specialservice`
--

INSERT INTO `specialservice` (`title`, `description`, `ID`) VALUES
('Birthday Party', 'Celebrate your birthday at Tasty Bites with a personalized menu, decorations, and a lively atmosphere, making your special day unforgettable.', 1),
('Anniversary Party', 'Mark your anniversary with a memorable celebration at Tasty Bites, offering tailored menus and an inviting setting perfect for romantic gatherings.', 2),
('Corporate Event', 'Host your corporate events at Tasty Bites, where we provide professional service, customized menus, and a dynamic environment for business success.', 3),
('Grand Opening Party', 'Celebrate the launch of your new business or venue at Tasty Bites with an exciting grand opening party, complete with delicious food and a lively atmosphere.', 4),
('Christmas Party', 'Experience the festive spirit at Tasty Bites with our Christmas parties, featuring themed decor, a special holiday menu, and a warm, joyful ambiance.', 5),
('Halloween Partyy', 'Enjoy a spooky and fun Halloween celebration at Tasty Bites with themed decorations, creative food and drinks, and a thrilling atmosphere for everyone.', 6);

-- --------------------------------------------------------
