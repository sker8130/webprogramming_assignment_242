-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 07, 2025 at 07:34 PM
-- Server version: 11.7.2-MariaDB-log
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `image_path`) VALUES
(1, 'uploads/banners/banner1.png');
-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `BlogID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Preview` varchar(280) NOT NULL,
  `Content` longtext NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `WriterName` varchar(255) DEFAULT NULL,
  `IsPublic` enum('yes','no') NOT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `UpdatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`BlogID`, `Title`, `Preview`, `Content`, `Image`, `WriterName`, `IsPublic`, `CreatedAt`, `UpdatedAt`) VALUES
(1, 'The Age of the Chili-Head: Pizza Pros Pick from a Peck of Possible Peppers ', 'Despite their widespread popularity and mind-boggling range of varieties, peppers remain misunderstood by many. In the first place, they’re not even a vegetable—and they’re probably even more versatile than you think. “Technically, peppers are fruits (berries, in fact), but they’', '<p style=\"text-align: justify;\"><img src=\"https://www.pmq.com/wp-content/uploads/2023/07/BLAZE-PIZZA-PEPPERS-copy.jpg\" alt=\"This photo shows a pizza from Blaze Pizza (in a box) topped with jalape&ntilde;o peppers, yellow peppers, red onions and sausage\"></p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">Despite their widespread popularity and mind-boggling range of varieties, peppers remain misunderstood by many. In the first place, they&rsquo;re not even a vegetable&mdash;and they&rsquo;re probably even more versatile than you think. &ldquo;Technically, peppers are fruits (berries, in fact), but they&rsquo;re eaten as vegetables, and there&rsquo;s a plethora of peppers out there,&rdquo; explains Julia Chebotar, New York City-based chef, <a href=\"https://healthchefjulia.com/\" target=\"_blank\" rel=\"noopener\"><strong>culinary nutrition consultant</strong></a>, and former Food Network&nbsp;<em>Chopped</em>&nbsp;champion. &ldquo;In the age of the chili-head, there&rsquo;s a big market for habaneros, serranos, poblanos and New Mexico chilies as pizza toppings, while bell peppers can balance richer toppings such as crumbled sausage, caramelized onions and roasted garlic.&rdquo;</p>\r\n<p style=\"text-align: justify;\">Peppers can even go beyond the food menu, where they shine in pizzas, pastas, appetizers, soups, salads and more. &ldquo;What I love about peppers is, because they&rsquo;re fruits, they work really well for use in cocktails,&rdquo; notes chef Brad Kent, a food scientist, co-founder of&nbsp;<a href=\"https://www.blazepizza.com/\" target=\"_blank\" rel=\"noopener\"><strong>Blaze Pizza</strong></a>&nbsp;and that chain&rsquo;s former chief culinary officer. &ldquo;They can really accentuate other flavors if you choose the right combination, like habaneros with apricots and oranges.&rdquo; In other words, the pepper possibilities are practically endless.</p>\r\n<p style=\"text-align: justify;\"><strong>Sweet &rsquo;n&rsquo; Mild</strong><br>At the milder end of the pepper scale, bell and banana peppers remain fan favorites, adding characteristics like juiciness, tang or crunch, depending on the type used and how it&rsquo;s prepared. For example, Chebotar notes that bell peppers possess a natural sweetness, one that is further pronounced by the cooking process. But they can also add beautiful color and texture to dishes. &ldquo;When teamed up, these toppings make for a spectacular-looking pie,&rdquo; Chebotar says. &ldquo;If you want a full color spectrum on your next pizza, try banana, green, red and yellow peppers!&rdquo;</p>\r\n<p style=\"text-align: justify;\">Fabio Errante,&nbsp;<a href=\"https://www.fabioerrante.com/\" target=\"_blank\" rel=\"noopener\"><strong>London-based pizzaiolo</strong></a>&nbsp;and author of&nbsp;<a href=\"https://www.amazon.com/Fabioulous-Pizza-tricks-professional-kitchen-ebook/dp/B081CYFT2W/ref=sr_1_3?crid=3TNZDRPPXBGDC&amp;dib=eyJ2IjoiMSJ9.IvCsEDXRBsuIClWv3SsrYK-shOXvgCZ6FtXivY1p3AHLP_pcSowS6ZW_egrJOzu75BbI5XTwbLzY0PXdaZHjyg.Bvt7UusgpJ8_-ZGOfmsoD4SUPj4DdWMAuJrjlfIzvTE&amp;dib_tag=se&amp;keywords=fabulous+pizza&amp;qid=1745536043&amp;sprefix=fabulous+pizza%2Caps%2C241&amp;sr=8-3\" target=\"_blank\" rel=\"noopener\"><strong><em>Fabioulous Pizza</em></strong></a>, agrees that peppers in general boast impressive versatility, especially in Italian foods. Red bell peppers remain his favorite&mdash;such as in a simple &ldquo;bruschetta&rdquo; that replaces the typical tomatoes with peppers, topped with melted provolone, or in his go-to pasta salad recipe, which combines red pepper cream, sweet corn, fresh arugula and cubed mozzarella. (Make red pepper cream by blending together raw red peppers and cream cheese, plus a pinch of salt to taste.)</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<div id=\"attachment_66851\" class=\"wp-caption aligncenter\" style=\"text-align: justify;\"><img class=\"size-full wp-image-66851\" src=\"https://www.pmq.com/wp-content/uploads/2023/07/Yellow-peppers-courgettes-aubergine-skins.jpg\" sizes=\"auto, (max-width: 1000px) 100vw, 1000px\" srcset=\"https://www.pmq.com/wp-content/uploads/2023/07/Yellow-peppers-courgettes-aubergine-skins.jpg 1000w, https://www.pmq.com/wp-content/uploads/2023/07/Yellow-peppers-courgettes-aubergine-skins-300x225.jpg 300w, https://www.pmq.com/wp-content/uploads/2023/07/Yellow-peppers-courgettes-aubergine-skins-768x576.jpg 768w, https://www.pmq.com/wp-content/uploads/2023/07/Yellow-peppers-courgettes-aubergine-skins-827x620.jpg 827w, https://www.pmq.com/wp-content/uploads/2023/07/Yellow-peppers-courgettes-aubergine-skins-600x450.jpg 600w\" alt=\"This photo shows an overhead view of a pizza topped with yellow peppers and deep-fried eggplant ribbons.\" width=\"1000\" height=\"750\" loading=\"lazy\" aria-describedby=\"caption-attachment-66851\">\r\n<p id=\"caption-attachment-66851\" class=\"wp-caption-text\">Fabio Errante combines fleshy, sweet yellow peppers with marinated, deep-fried eggplant ribbons on a specialty pie.</p>\r\n</div>\r\n<p style=\"text-align: justify;\">&ldquo;During a heat wave, I would eat this pasta salad every day,&rdquo; Errante says. &ldquo;I like how peppers slightly change their taste depending on the color. Green bell peppers are a bit sour and pungent, so I&rsquo;d use them with meats or strong cheeses.&rdquo;</p>\r\n<p style=\"text-align: justify;\">Meanwhile, banana peppers &ldquo;can do so much more than soup up your sandwich,&rdquo; Chebotar explains. &ldquo;They&rsquo;re one of the most underrated pizza toppings out there.&rdquo; Kent said he also loves the &ldquo;beautiful color&rdquo; they add to any pizza.</p>\r\n<p style=\"text-align: justify;\"><strong>Heat &rsquo;n&rsquo; Smoke</strong><br>Seeking incredible depth of flavor with a little kick? Enter the world of hot peppers. If it&rsquo;s smokiness you&rsquo;re after, choose chipotles (smoked and dried jalape&ntilde;os)&mdash;they&rsquo;re especially useful in sauces. &ldquo;We see people using chipotle sauce as a base on pizza, instead of marinara or white sauce,&rdquo; notes Amy Wilson, managing director of Spin365 Marketing in Bentonville, Arkansas. &ldquo;Chipotle pairs well with many pizza toppings: proteins like pulled pork, chicken, bacon, steak, sausage and ham; veggies such as sweet peppers, black beans, corn, onion and cilantro; and cheeses like a Mexican blend, mozzarella or cotija.&rdquo;</p>\r\n<p style=\"text-align: justify;\">Or you can mix chipotle with ketchup for a smoky dipping sauce, ideal for serving with fries or onion rings.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<div id=\"attachment_66852\" class=\"wp-caption aligncenter\" style=\"text-align: justify;\"><img class=\"size-full wp-image-66852\" src=\"https://www.pmq.com/wp-content/uploads/2023/07/JULIA-CHEBOTAR.jpg\" sizes=\"auto, (max-width: 1000px) 100vw, 1000px\" srcset=\"https://www.pmq.com/wp-content/uploads/2023/07/JULIA-CHEBOTAR.jpg 1000w, https://www.pmq.com/wp-content/uploads/2023/07/JULIA-CHEBOTAR-300x200.jpg 300w, https://www.pmq.com/wp-content/uploads/2023/07/JULIA-CHEBOTAR-768x512.jpg 768w, https://www.pmq.com/wp-content/uploads/2023/07/JULIA-CHEBOTAR-895x597.jpg 895w, https://www.pmq.com/wp-content/uploads/2023/07/JULIA-CHEBOTAR-302x202.jpg 302w, https://www.pmq.com/wp-content/uploads/2023/07/JULIA-CHEBOTAR-390x260.jpg 390w\" alt=\"this photo shows Julia Chebotar, with red hair and wearing an off-the-shoulder green blouse, holding up a slice of pepperoni pizza from a delivery box.\" width=\"1000\" height=\"667\" loading=\"lazy\" aria-describedby=\"caption-attachment-66852\">\r\n<p id=\"caption-attachment-66852\" class=\"wp-caption-text\">Julia Chebotar</p>\r\n</div>\r\n<p style=\"text-align: justify;\">Meanwhile, Chebotar points to serranos and poblanos as perfect pizza toppers. &ldquo;Serrano is the spiciest of the green pepper pack, with a thin skin and thick flesh&mdash;excellent for eating raw in salsas, but also great roasted or grilled and then chopped up (no need to peel!) on top of your pizza,&rdquo; Chebotar explains. &ldquo;Poblanos, which get their name from the state of Puebla, Mexico, are perfect for roasting and stuffing, thanks to their heart shape and thick flesh. They&rsquo;re typically mild, though you may get the occasional spicy one&mdash;a great option for keto-friendly stuffed pizza peppers.&rdquo;</p>\r\n<p style=\"text-align: justify;\">As many modern palates seek ever-spicier taste sensations, an increasing number of customers are big fans of peppers that add a kick. Kent notes that hatch chilies &ldquo;have a more vegetal flavor that goes very well with tomato and works exceedingly well with cream cause. They reduce the heaviness of dairy and balance it out by adding acidity and a &lsquo;green&rsquo; flavor that enhances proteins like chicken. On pizzas especially, peppers just offer great flavor and texture to give the palate a break from the fattiness of cheeses.&rdquo;</p>\r\n<p style=\"text-align: justify;\">The quest for the perfect peppers became a bit of an obsession for Kent. But he soon realized that canned or jarred banana peppers and jalape&ntilde;os weren&rsquo;t always up to his standards. &ldquo;They typically come from a faraway country and are heat-treated, which destroys texture and crispness unless a chemical is added,&rdquo; he explains. &ldquo;Also, because of heating and shelf life, colors fade, so banana peppers may have artificial yellow color and sulfites to prevent browning, plus a preservative for food safety. And it&rsquo;s the same story with jalape&ntilde;os, too.&rdquo;</p>\r\n<p style=\"text-align: justify;\">Instead, during his tenure at Blaze, Kent worked with a family-owned pickle factory in Michigan to create high-quality banana peppers and jalape&ntilde;os. The peppers were fresh-packed, sans heat treating, and bolstered by natural color enhancers like turmeric. &ldquo;These peppers keep their fresh taste,&rdquo; Kent reports. &ldquo;They maintain their color, texture and flavor, and the jalape&ntilde;os retain their heat. We can then take advantage of those attributes for pizzas!&rdquo;</p>\r\n<p style=\"text-align: justify;\"><em>Tracy Morin is PMQ&rsquo;s associate editor. This story has been updated from the original article appearing in the April 2021 issue of&nbsp;</em>PMQ Pizza<em>.</em></p>', 'app/views/admin/blogs/uploads/cd8a909aa91b9375f48d282c5af31b88.jpg', 'Tracy Morin', 'yes', '2025-04-25 20:17:02', '2025-05-04 11:11:33'),
(2, 'Marco’s Pizza Launches New Menu Item: Pepperoni Bread\r\n', 'Marco’s Pizza, one of the largest pizza brands in the country, is introducing Pepperoni Bread, featuring shredded pepperoni. The side is a “Marco’s twist” on cheesy bread—and a new variation on the brand’s signature CheezyBread. For a limited time, Marco’s is selling the Pepperon', '<p style=\"text-align: justify;\"><img src=\"https://www.pmq.com/wp-content/uploads/2025/04/Marcos-pepperoni-bread-1200x832.jpg\"></p>\r\n<p style=\"text-align: justify;\">Marco&rsquo;s Pizza, one of the largest pizza brands in the country, is introducing Pepperoni Bread, featuring shredded pepperoni. The side is a &ldquo;Marco&rsquo;s twist&rdquo; on cheesy bread&mdash;and a new variation on the brand&rsquo;s signature CheezyBread.</p>\r\n<p style=\"text-align: justify;\">For a limited time, Marco&rsquo;s is selling the Pepperoni Bread for $5 at participating Marco&rsquo;s locations. Created by Marco&rsquo;s Italian founder Pasquale (&ldquo;Pat&rdquo;) Giammarco, the new side dish features crispy shredded pepperoni layered underneath three fresh cheeses, finished with garlic sauce and Marco&rsquo;s signature Romesan seasoning.</p>\r\n<p style=\"text-align: justify;\">&ldquo;At Marco&rsquo;s Pizza, we know that the perfect side can take pizza night to the next level, and our new Pepperoni Bread is here to steal the spotlight,&rdquo;&nbsp;said Denise Lauer, chief marketing officer&nbsp;at Marco&rsquo;s Pizza. &ldquo;With layers of crispy, shredded pepperoni and gooey cheese, we&rsquo;ve taken a beloved side and made it the ultimate sidekick to our delicious menu items at a value-forward price.&rdquo;</p>\r\n<p style=\"text-align: justify;\"><a href=\"related: Pizza Hut Hatches \'Pizza Caviar\' for Limited Time Dipping, Dunking and Bumping\"><strong>Related: Pizza Hut Hatches &lsquo;Pizza Caviar&rsquo; for Limited Time Dipping, Dunking and Bumping</strong></a></p>\r\n<p style=\"text-align: justify;\">&ldquo;Pepperoni Bread showcases Marco&rsquo;s commitment to crave-worthy flavors, spotlighting the brand&rsquo;s pepperoni variety, including classic, Old World, and crispy shredded pepperoni,&rdquo; a press release said. &ldquo;Fans of the&nbsp;Triple Pepperoni Magnifico&mdash;which also highlights the crispy, shredded variety&mdash;will recognize the satisfying crunch and deep flavor that turns America&rsquo;s favorite pizza topping into a must-have companion to any pizza meal.&rdquo;</p>\r\n<p style=\"text-align: justify;\">Marco&rsquo;s Pizza is the country&rsquo;s fifth-largest pizza brand in terms of revenue. In 2023, the brand recorded $1.03 billion worth of sales. Marco&rsquo;s Pizza boasts over 1,100 locations across the country.</p>', 'app/views/admin/blogs/uploads/dff27663015de7862cacddd26f84d20a.jpg', 'kiki', 'yes', '2025-04-25 21:01:23', '2025-05-04 10:37:29'),
(3, 'Papa Murphy’s Brings Back a Fan Favorite LTO Pizza and Launches a ‘Salad Refresh’\r\n', 'Spring seems to be the season for top pizza chains to bring back fan favorites for limited-time runs. Case in point: Papa Murphy’s and the Taco Grande Pizza. And it’s no coincidence that the specialty pie will be returning ahead of Cinco de Mayo. Available for a limited time from', '<p style=\"text-align: justify;\"><img src=\"https://www.pmq.com/wp-content/uploads/2025/04/PAPAMURPHY.jpeg\" alt=\"This photo shows the Taco Grande pizza with beef, tomatoes, black olives, cheese, black beans and salsa.\"></p>\r\n<p style=\"text-align: justify;\">Spring seems to be the season for top pizza chains to bring back fan favorites for limited-time runs. Case in point: <strong><a href=\"https://www.papamurphys.com/\" target=\"_blank\" rel=\"noreferrer noopener\">Papa Murphy&rsquo;s</a></strong>&nbsp;and the Taco Grande Pizza.<br><br>And it&rsquo;s no coincidence that the specialty pie will be returning ahead of Cinco de Mayo. Available for a limited time from April 21 to May 18, the Taco Grande can be ordered with beef or chicken and comes topped with Roma tomatoes, onions, black olives, hand-grated cheddar and whole-milk mozzarella, all layered over a base of refried beans and salsa on Papa Murphy&rsquo;s signature dough. Customers can order the Taco Grande Pizza online or in-store at participating locations.<br><br>&ldquo;Our guests wait all year for the Taco Grande Pizza, and we&rsquo;re excited to bring it back for another season,&rdquo; said&nbsp;Dallas Massey, Papa Murphy&rsquo;s senior vice president of marketing. &ldquo;It&rsquo;s a fresh, fun way to shake up mealtime with bold flavors that bring everyone together&mdash;whether you&rsquo;re celebrating Cinco de Mayo or just craving something different.&rdquo;</p>\r\n<p style=\"text-align: justify;\">Papa Murphy&rsquo;s is also updating its menu with what the chain calls a Salad Refresh. Along with favorites like the Garden Salad, Club Salad, Caesar Salad and Chicken Caesar Salad, the brand has rolled out a new Create Your Own Salad option. Guests can customize their salads with a choice of romaine lettuce or spinach and up to five toppings.</p>\r\n<p style=\"text-align: justify;\">&ldquo;We know our guests value fresh, high-quality and affordable meal options, and the new Create Your Own Salad gives them even more variety and control over their dining experience,&rdquo; Massey said.</p>', 'app/views/admin/blogs/uploads/d7f8bf0f9fb01fbf0af6cf1d1d94fe28.jpeg', 'cuongidk', 'yes', '2025-04-25 21:03:18', '2025-05-04 10:37:46'),
(4, 'Why Roman-Style Is ‘One of the Most Fun—and Most Difficult—Pizzas to Make’\r\n', '“Roman pizza is a fantasy—a canvas to show off what you can do,” says Vitangelo Recchia, owner of Bella Napoli Pizzeria & Restaurant in Port Charlotte, Florida. “You can be creative, making different styles with the same dough. It’s very versatile.” Indeed, “Roman style” may desc', '<p style=\"text-align: justify;\"><img src=\"https://www.pmq.com/wp-content/uploads/2025/04/romanpizza-april25-lead-1480x832.jpg\"></p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">&ldquo;Roman pizza is a fantasy&mdash;a canvas to show off what you can do,&rdquo; says Vitangelo Recchia, owner of&nbsp;<strong><span style=\"text-decoration: underline; color: rgb(53, 152, 219);\">Bella Napoli Pizzeria &amp; Restaurant </span></strong>in Port Charlotte, Florida. &ldquo;You can be creative, making different styles with the same dough. It&rsquo;s very versatile.&rdquo; Indeed, &ldquo;Roman style&rdquo; may describe a few options: Roman-style pan pizza, baked in a rectangular or square metal tray; pizza alla pala, formed in an oblong or oval shape and served up on a long wooden board; or pinsa, served on a smaller-size pala and made with different flours, like rice and soy.</p>\r\n<p style=\"text-align: justify;\">If you&rsquo;re used to making traditional round pies, such as the New York style, Recchia admits that Roman pizza might be a bit more challenging to tackle. But he believes the painstaking (and, traditionally, multiple-day) process gives the finished product an unforgettable flavor that&rsquo;s worth the effort.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\"><img src=\"https://www.pmq.com/wp-content/uploads/2025/04/romanpizza-april25-Vitangelo.jpg\"></p>\r\n<p style=\"text-align: justify; padding-left: 40px;\">&nbsp;</p>\r\n<p style=\"text-align: justify; padding-left: 40px;\"><span style=\"font-size: 10pt; color: rgb(186, 55, 42);\">Vitangelo Recchia, who learned how to make Roman pizza with master pizzaiolo Massimiliano Saieva, embraces a three-step baking process and lengthy fermentation to create a crispy, airy crust.</span></p>\r\n<p style=\"text-align: justify; padding-left: 40px;\">&nbsp;</p>\r\n<hr>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\"><strong>Roman Rules&nbsp;</strong></p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">Recchia, a&nbsp;<span style=\"color: rgb(53, 152, 219);\"><strong><span style=\"text-decoration: underline;\">U.S. Pizza Team member </span></strong></span>who studied the Roman pizza style under master pizzaiolo Massimiliano Saieva, nabbed second place with his Roman pizza (in the Pizza in Teglia category) in Parma, Italy&rsquo;s World Pizza Championship in 2022. He prescribes a three-step baking process for this style, allowing the oven to progressively dehydrate the dough.</p>\r\n<p style=\"text-align: justify;\">First, he cooks only the dough for 8 to 10 minutes, then bakes it another 4 to 5 minutes with the toppings, and finally finishes the slice in the oven (when ordered) for 1 to 1.5 minutes. &ldquo;The final product you get is crispy, airy and flavorful, with an abundance of tastes and smells,&rdquo; Recchia says. &ldquo;When you work this style properly, it&rsquo;s perfection from A to Z.&rdquo;</p>\r\n<p style=\"text-align: justify;\">That signature flavor may end with the baking process, but it starts with the ingredients and fermentation. Recchia recommends using 0 or 00 Italian flour, fresh or dry yeast, sea salt and a quality extra-virgin olive oil. After mixing (see Recchia&rsquo;s full recipe on page 47), the dough can be stored in the cooler for 24 to 48 hours, after which the dough balls are formed. Rechhia makes each ball 1.2 to 1.4 kilograms, then lets them rise for 30 to 45 minutes and places them back in the cooler (at 42&deg; to 45&deg;) overnight. The next day, he removes them from the cooler and leaves at room temperature for 45 to 60 minutes, after which they&rsquo;re ready to stretch. He then stretches the dough into oiled pans and cooks his pizzas in 620&deg; electric ovens&mdash;ideal for baking, he explains, because you can control the top and bottom heat. &ldquo;Roman pizza is all about time and temperature,&rdquo; Recchia says.</p>\r\n<p style=\"text-align: justify;\">When making Roman pizza, he adds, toppings are applied to the edge, so there&rsquo;s no raised crust like with a traditional round pizza. He makes his pies in 60-by-40-centimeter pans, which produce 12 slices, ideal for feeding groups of four or five. &ldquo;It&rsquo;s a street food,&rdquo; Recchia says. &ldquo;You can cut it in half or fold it like a New York slice, or you can put it on a tray and make it gourmet. It&rsquo;s one of the most fun&mdash;and most difficult&mdash;pizzas to make. The fun part is the look on people&rsquo;s faces, which is very rewarding. The difficulty is in learning the technique.&rdquo;</p>\r\n<p style=\"padding-left: 40px; text-align: justify;\">&nbsp;</p>\r\n<p style=\"padding-left: 40px; text-align: justify;\"><strong>&ldquo;It&rsquo;s one of the most fun&mdash;and most difficult&mdash;pizzas to make. The fun part is the look on people&rsquo;s faces, which is very rewarding. The difficulty is in learning the technique.&rdquo;</strong><br><strong>&mdash;Vitangelo Recchia, Bella Napoli Pizzeria &amp; Restaurant</strong></p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\"><strong>Can All Roads Lead to Rome?</strong></p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">While Roman-style pizza traditionally involves a high-hydration dough, a lengthy fermentation and high-quality Italian ingredients, Recchia believes in bringing the style to the modern day with new interpretations. Now a bestseller on his pizzeria&rsquo;s menu, his second-place Pizza in Teglia entry was a white pie, which is called &ldquo;Crostino Romano&rdquo; in this style. Dubbed Heart of Parma, the pizza is topped with lardo, three types of mushroom (royal trumpet, oyster and maitake), porcini mushroom dust, local sausage, stracchino cheese, arugula and Parmigiano-Reggiano.&nbsp;</p>\r\n<p style=\"text-align: justify;\">This year, he made a bigger splash at an Italian competition with a pie featuring a tomato base, cup-and-char pepperoni, stracciatella, Mike&rsquo;s Hot Honey and basil&mdash;all atop a four-hour-fermented dough. &ldquo;Italians would never do that, but Americans would,&rdquo; he says with a laugh. &ldquo;Italians may follow the rules of Roman pizza, but Americans are meant to break them. I like to give people an experience&mdash;and even if the Italians look at you like you&rsquo;re crazy, they can&rsquo;t stop eating it!&rdquo;</p>\r\n<p style=\"text-align: justify;\">Perhaps more importantly&mdash;at least for his bottom line back home&mdash;is that Recchia&rsquo;s customers are similarly bowled over by the Roman style, even though he also offers Sicilian pan, New York round, Detroit, stuffed and grandma pan pies on his menu. &ldquo;It&rsquo;s hard to do only Roman style; I&rsquo;ll spend more time explaining it than people spend enjoying it,&rdquo; he says. &ldquo;But when people try our Roman pizza, they say they&rsquo;ve never had anything like it. And they come back here because we have different styles of pizza.&rdquo;</p>\r\n<p style=\"text-align: justify;\">Moreover, Recchia emphasizes that Roman-style pizza&mdash;already spread significantly in recent years&mdash;is currently &ldquo;blowing up&rdquo; in the United States. He predicts it will only grow further, thanks to a combination of improved education, more flour companies from Italy entering the U.S. market, and even manufacturers selling premade Roman pizza bases that operators can buy frozen and simply add toppings.</p>\r\n<p style=\"text-align: justify;\">&ldquo;People are learning new techniques to make the dough quicker, too,&rdquo; Recchia adds. &ldquo;Angelo Iezzi of the API [Associazione Pizzerie Italiane, or Italian Pizzerias Association] developed a system in the &rsquo;90s to make Roman pizza in 96 hours. Now you can do it in four hours, or 24 hours, as long as you know how to work with it. In today&rsquo;s world, Americans don&rsquo;t have time to wait three or four days for Roman pizza&mdash;they want it now.&rdquo; &nbsp;&nbsp;</p>\r\n<p style=\"text-align: justify;\"><em><strong>Tracy Morin </strong>is PMQ&rsquo;s associate editor.</em></p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>', 'app/views/admin/blogs/uploads/62e5bda958ad5b2c073bf58cfeb9a1e7.jpg', 'Tracy Morin', 'yes', '2025-04-26 10:08:56', '2025-05-04 10:38:08'),
(5, 'Pizza Inn’s New Peeps Pizzert is ‘Ridiculous in the Best Way Possible’\r\n', 'Spring has sprung at Pizza Inn, and this year the Easter Bunny isn’t the only one delivering something sweet. For a limited time at participating locations, the buffet chain is launching its newest seasonal sensation: Peeps Pizzert. This limited-time Pizzert, a playful twist on P', '<p style=\"text-align: justify;\"><img src=\"https://www.pmq.com/wp-content/uploads/2025/04/PEEPS.jpg\" alt=\"This photo shows a pizza topped with green sugar crystals and a bunch of yellow Peeps in a circle.\"></p>\r\n<div class=\"single-post-thumbnail\">\r\n<div class=\"node-image__caption\">&nbsp;</div>\r\n<div class=\"node-image__caption\"><span style=\"font-size: 10pt; color: rgb(186, 55, 42);\">Pizza Inn is putting an Easter spin on its Pizzerts. (Pizza Inn)</span></div>\r\n</div>\r\n<div class=\"wd-shared-counts\">\r\n<div class=\"wd-shared-counts__inner\">&nbsp;</div>\r\n</div>\r\n<p style=\"text-align: justify;\">Spring has sprung at <span style=\"text-decoration: underline;\"><strong><span style=\"color: rgb(35, 111, 161); text-decoration: underline;\">Pizza Inn</span></strong></span>, and this year the Easter Bunny isn&rsquo;t the only one delivering something sweet. For a limited time at participating locations, the buffet chain is launching its newest seasonal sensation: Peeps Pizzert.</p>\r\n<p style=\"text-align: justify;\">This limited-time Pizzert, a playful twist on Pizza Inn&rsquo;s dessert pizza, features a Bavarian cream base, 10 classic yellow Peeps Chicks, and a generous sprinkle of &ldquo;Easter grass&rdquo; or green sugar crystals.</p>\r\n<p style=\"text-align: justify;\">&ldquo;We&rsquo;re always looking for innovative ways to surprise our guests with our unique Pizzert creations, and nothing exudes springtime joy quite like Peeps,&rdquo; said Brandon Solano, CEO of RAVE Restaurant Group. &ldquo;We thought, &lsquo;Why not take America&rsquo;s favorite marshmallow treat and put it on a Pizzert?&rsquo; It&rsquo;s ridiculous in the best way possible, and you won&rsquo;t find treats like these anywhere else.&rdquo;</p>\r\n<p style=\"text-align: justify;\">The Peeps Pizzert will be available starting today at participating Pizza Inn restaurants until April 20. The springtime treat is only available on Pizza Inn&rsquo;s buffet.</p>', 'app/views/admin/blogs/uploads/a3c76fc958b71cdaf614d29076925531.jpg', 'Cuong', 'yes', '2025-04-26 10:45:24', '2025-05-04 10:38:20'),
(6, 'What Is Biryani?\r\n', 'A world-renowned Indian dish, biryani takes time and practice to make but is worth every bit of the effort. Long-grained rice (like basmati) flavored with fragrant spices such as saffron and layered with lamb, chicken, fish, or vegetables and a thick gravy. The dish is then cover', '<p style=\"text-align: justify;\"><img src=\"https://www.thespruceeats.com/thmb/0hu9VHLhXVBHpMYI0EmFTLXE8cE=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc():format(webp)/mughlai-biryani-recipe-1957724-Hero-5b7b31fd46e0fb0050688825.jpg\" alt=\"Mughlai Biryani Recipe\"></p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">A world-renowned Indian dish, biryani takes time and practice to make but is worth every bit of the effort. Long-grained rice (like basmati) flavored with fragrant spices such as saffron and layered with lamb, chicken, fish, or vegetables and a thick gravy. The dish is then covered, its lid secured with dough, and then the biryani is cooked over a low flame. This is definitely a special occasion dish.</p>\r\n<p style=\"text-align: justify;\">There is much debate of how this dish came to be, but most agree that its origins began in Persia as a rustic rice-and-meat dish and then traveled to India. The various recipes of biryani were then born, mainly where there was culinary influence from Muslim foods, particularly in the city of Hyderabad in south India, but also along the southern coast. Biryani\'s many, many variations depend on where the dish is based. Some differences are subtle while others are distinguished by added or substituted ingredients.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\"><img src=\"https://www.thespruceeats.com/thmb/DdKf38-2eTL_5zsQ6Xce7k_9bvc=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc():format(webp)/all-about-biryani-1957507-finalv2-ct-806b7041d0eb42c1be8ae431de35cf17.png\" alt=\"what is biryani\"><br><span style=\"font-size: 8pt; color: rgb(149, 165, 166);\">Illustration: Colleen Tighe. &copy; The Spruce, 2019</span></p>\r\n<p style=\"text-align: justify;\"><span style=\"font-size: 14pt;\"><strong>The Components of Biryani</strong></span></p>\r\n<p style=\"text-align: justify;\"><br>The main components of this dish are rice, meat, marinade, and spices. Basmati rice is definitely prevalent, but you will also find other grains such as seeraga samba and jeerakasala. Depending on where the biryani is from will determine the type of protein; coastal regions, for example, will include fish and shrimp, while inland areas may incorporate chicken, goat, mutton, and beef (mainly buffalo, but if cow, would be outside of India).</p>\r\n<p style=\"text-align: justify;\">The meat is usually marinated before being cooked, and the most common marinade is yogurt-spiced based as the acid in the yogurt helps to tenderize the meat. It is the layers of spices that give a biryani its complex flavor, and these spices can be whole or ground, or individual or a spice mix (such as garam masala). Herbs and seeds may also be a part of the dish, which is often topped with caramelized onion, dried or fresh fruit, nuts, and fresh herbs.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\"><span style=\"font-size: 14pt;\"><strong>Types of Biryani</strong></span></p>\r\n<p style=\"text-align: justify;\"><br>There are several main types of biryani that are specific to certain communities. Each variety is named after the place it was created.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"padding-left: 40px; text-align: justify;\">- Sindhi biryani: This aromatic type of biryani is popular in Pakistan and known for its spicy taste, fragrant rice, and delicate meat. It is made with meat and basmati rice, vegetables, and various types of spices.&nbsp;</p>\r\n<p style=\"padding-left: 40px;\">- Hyderabadi biryani: This biryani is one of India\'s most popular types of biryani. It incorporates goat meat that is marinated and cooked along with the rice and is seasoned with coconut and saffron.&nbsp;</p>\r\n<p style=\"padding-left: 40px; text-align: justify;\">- Malabar Biriyani: This is the only version of biryani in Kerala, an Indian state. It is a popular dish eaten by the Malabar Muslim community and incorporates Khyma rice mixed with ghee.</p>\r\n<p style=\"padding-left: 40px; text-align: justify;\">- Calcutta/Kolkata biryani: This biryani mostly uses potatoes and eggs and only sometimes contains meat. It is much lighter spice-wise; the marinade is made of cinnamon, nutmeg, cloves, cardamom, and other spices, and the rice is flavored with ketaki or rose water and is yellow in color.</p>\r\n<p style=\"padding-left: 40px; text-align: justify;\">- Ambur biryani: This leather-tanning city in Tamil Nadu makes one of the most famous types of biryani, and the town has more biryani shops than any other city in the world. The meat and rice are cooked separately and then brought together, along with mint leaves and curd.</p>\r\n<p style=\"padding-left: 40px; text-align: justify;\">- Lucknowi biryani: This type of biryani is based on a Persian cooking style so it uses the dum pukht method where the meat and gravy are only cooked partially and are then layered and served in a sealed handi. The spice profile is not as intense.</p>\r\n<p style=\"padding-left: 40px; text-align: justify;\">- Mughlai biryani: This biryani is cooked with curd, chicken, almond paste, ghee, dry fruits, and green chilies, and has a rich flavor.</p>\r\n<p style=\"padding-left: 40px; text-align: justify;\">- Kalyani biryani: Small chunks of buffalo meat go into this more budget-friendly biryani. It is rich and flavorful but does not include more expensive ingredients.</p>', 'app/views/admin/blogs/uploads/327f51d29ce1812de8a9c34cf21c18b5.jpg', 'Petrina Verma Sarkar', 'yes', '2025-04-26 11:52:10', '2025-05-04 10:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `ID` int(11) NOT NULL,
  `location` varchar(256) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `image` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`ID`, `location`, `description`, `image`) VALUES
(1, 'Hanoi', 'Nestled in the heart of Hanoi, Tasty Bites brings its signature flavors to the vibrant culinary scene of the capital. Whether you are exploring the historic Old Quarter or enjoying the modern bustle, our Hanoi branch offers a welcoming space to savor our delicious. Experience the authentic taste of Tasty Bites, crafted with fresh ingredients and a passion for flavor, right here in Hanoi.', 'app/views/admin/introduction/uploads/locations/dd13e89818f71f2b0729b2be947db216.jpg'),
(2, 'Ho Chi Minh City', 'In the dynamic metropolis of Ho Chi Minh City, Tasty Bites provides a delicious escape from the urban energy. Located in District 1, our Ho Chi Minh City branch offers a wide selection from our menu, perfect for a quick bite, a casual meal with friends, or a satisfying family dinner. Join us and discover why Tasty Bites has become a favorite for those seeking quality and taste in this bustling city.', 'app/views/admin/introduction/uploads/locations/c3a8645827c04521c18be26d6dde6a11.jpg'),
(3, 'Da Nang', 'Embracing the coastal charm of Da Nang, Tasty Bites offers a fresh and flavorful dining experience by the sea. Situated in the city center, our Da Nang branch is the perfect spot to enjoy our offerings after a day of exploring the beautiful beaches and vibrant city life. Come and taste the freshness and local inspiration that makes Tasty Bites a must-visit in Da Nang.', 'app/views/admin/introduction/uploads/locations/DaNang.jpg'),
(4, 'Nha Trang', 'Discover the taste of Tasty Bites in the beautiful resort city of Nha Trang. Our branch, located close to the hotels, offers a relaxed and inviting atmosphere to enjoy our menu. Whether you are a local resident or a visitor soaking up the sun, Tasty Bites in Nha Trang is your go-to destination for a satisfying and delicious meal that captures the essence of this coastal paradise.', 'app/views/admin/introduction/uploads/locations/NhaTrang.jpg');
-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(100) NOT NULL,
  `Description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `CommentID` int(11) NOT NULL,
  `ParentID` int(11) DEFAULT NULL,
  `BlogID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Content` text NOT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `ContactID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Message` text NOT NULL,
  `Reply` text DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp(),
  `is_user_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`ContactID`, `UserID`, `Name`, `Email`, `Message`, `Reply`, `Status`, `CreatedAt`, `is_user_read`) VALUES
(1, NULL, 'Alice Nguyen', 'alice@example.com', 'I love your website!', 'tr', 'Read', '2025-05-08 00:30:03', 0),
(2, NULL, 'John Tran', 'john.tran@example.com', 'Can you help me with my order?', NULL, 'Pending', '2025-05-08 00:30:03', 0),
(3, NULL, 'Linh Vo', 'linh.vo@example.com', 'Great service, thank you!', NULL, 'Resolved', '2025-05-08 00:30:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fanda`
--

CREATE TABLE `fanda` (
  `ID` int(11) NOT NULL,
  `question` varchar(1000) NOT NULL,
  `answer` varchar(1000) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `fanda`
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

--
-- Table structure for table `footer`
--

CREATE TABLE `footer` (
  `id` int(11) NOT NULL,
  `working_hour_1` varchar(100) DEFAULT NULL,
  `working_hour_2` varchar(100) DEFAULT NULL,
  `phone_1` varchar(20) DEFAULT NULL,
  `phone_2` varchar(20) DEFAULT NULL,
  `hotline` varchar(20) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `copyright` varchar(255) DEFAULT NULL,
  `place_1` varchar(255) DEFAULT NULL,
  `place_2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `footer`
--

INSERT INTO `footer` (`id`, `working_hour_1`, `working_hour_2`, `phone_1`, `phone_2`, `hotline`, `image_path`, `copyright`, `place_1`, `place_2`) VALUES
(1, '7.30 AM - 9.30 PM', '7.30 AM - 9.30 PM', '0387847976', '0387847976', '1900 8383', '', 'Copyright © 2025 | sker', 'TastyBite Estella', 'TastyBite HN'),
(2, NULL, NULL, NULL, NULL, NULL, 'uploads/logosf/1746637874_logo-img-2.png', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `header`
--

CREATE TABLE `header` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `header`
--

INSERT INTO `header` (`id`, `image_path`) VALUES
(1, 'uploads/logos/logo2.png'),
(2, 'uploads/logos/logo3.png'),
(3, 'uploads/logos/logo4.png'),
(4, 'uploads/logos/1746635030_logo-img-2.png'),
(5, 'uploads/logos/1746637251_logo-img-1.png'),
(6, 'uploads/logosf/1746637723_logo-img-2.png'),
(7, 'uploads/logosf/1746637851_logo-img-2.png');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `position` varchar(128) NOT NULL,
  `name` varchar(256) NOT NULL,
  `description` varchar(256) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`position`, `name`, `description`, `ID`) VALUES
('COO', 'Nguyen Minh Tuan', 'The COO ensures smooth operations across all Tasty Bites branches.', 1),
('CEO', 'Tran Thi Lan Anh', 'The CEO leads Tasty Bites with creativity and a strong vision for growth.', 2),
('CTO', 'Pham Quoc Tuan', 'The CTO manages and optimizes Tasty Bites’ technology systems for better customer experience.', 3),
('Head Chef - HCM', 'Duong Kha Co', 'Duong Kha Co is the Head Chef at the HCM branch, creating innovative and high-quality dishes.', 4),
('Head Chef - Hanoi', 'Nguyen Quang Duy', 'Nguyen Quang Duy is the Head Chef at the Hanoi branch, known for his refined and flavorful dishes.', 5),
('Head Chef - Da Nang', 'Phan Thi Thanh Mai', 'Phan Thi Thanh Mai is the Head Chef at the Da Nang branch, blending fresh ingredients with modern cooking techniques.', 6),
('Head Chef - Nha Trang', 'Vo Ngoc Binh', 'Vo Ngoc Binh is the Head Chef at the Nha Trang branch, specializing in fresh seafood dishes.', 7),
('Sous Chef – HCM', 'Tran Anh Duy', 'Tran Anh Duy is the Sous Chef at the HCM branch, supporting the Head Chef and maintaining dish quality.', 8),
('Sous Chef – Hanoi', 'Hoang Quang Huy', 'Hoang Quang Huy is the Sous Chef at the Hanoi branch, ensuring consistency and creativity in every dish.', 9),
('Sous Chef – Da Nang', 'Le Thi Lan', 'Le Thi Lan is the Sous Chef at the Da Nang branch, assisting in kitchen operations and menu development.', 10),
('Sous Chef – Nha Trang', 'Phan Minh Tuan', 'Phan Minh Tuan is the Sous Chef at the Nha Trang branch, overseeing kitchen coordination and quality control.', 11),
('Accountant', 'Kim Ngan', 'This is description, Kim Ngan update description.', 12);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL,
  `OrderStatus` varchar(20) NOT NULL DEFAULT 'Pending',
  `CreateAt` datetime DEFAULT current_timestamp(),
  `PayAt` datetime DEFAULT current_timestamp(),
  `ShipperID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `OrderItemID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `popular_dishes`
--

CREATE TABLE `popular_dishes` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `dish_order` int(11) DEFAULT NULL,
  `alt_text` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `popular_dishes`
--

INSERT INTO `popular_dishes` (`id`, `image_path`, `dish_order`, `alt_text`) VALUES
(2, 'uploads/popular_dishes/image_Dishes_1.png', 2, 'dish1'),
(3, 'uploads/popular_dishes/image_Dishes_2.png', 3, 'dish2'),
(4, 'uploads/popular_dishes/image_Dishes_3.png', 4, 'dish3'),
(5, 'uploads/popular_dishes/image_Dishes_4.png', 5, 'dish4'),
(6, 'uploads/popular_dishes/image_Dishes_5.png', 6, 'dish5');


-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL CHECK (`Price` >= 0),
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Rating` int(11) NOT NULL,
  `Comment` varchar(255) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shippers`
--

CREATE TABLE `shippers` (
  `ShipperID` int(11) NOT NULL,
  `ShipperName` varchar(100) NOT NULL,
  `CarID` int(11) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Avatar` varchar(255) DEFAULT NULL,
  `Gender` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specialservice`
--

CREATE TABLE `specialservice` (
  `title` varchar(128) NOT NULL,
  `description` varchar(512) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `specialservice`
--

INSERT INTO `specialservice` (`title`, `description`, `ID`) VALUES
('Birthday Party', 'Celebrate your birthday at Tasty Bites with a personalized menu, decorations, and a lively atmosphere, making your special day unforgettable.', 1),
('Anniversary Party', 'Mark your anniversary with a memorable celebration at Tasty Bites, offering tailored menus and an inviting setting perfect for romantic gatherings.', 2),
('Corporate Event', 'Host your corporate events at Tasty Bites, where we provide professional service, customized menus, and a dynamic environment for business success.', 3),
('Grand Opening Party', 'Celebrate the launch of your new business or venue at Tasty Bites with an exciting grand opening party, complete with delicious food and a lively atmosphere.', 4),
('Christmas Party', 'Experience the festive spirit at Tasty Bites with our Christmas parties, featuring themed decor, a special holiday menu, and a warm, joyful ambiance.', 5),
('Halloween Partyy', 'Enjoy a spooky and fun Halloween celebration at Tasty Bites with themed decorations, creative food and drinks, and a thrilling atmosphere for everyone.', 6);

-- --------------------------------------------------------

--
-- Table structure for table `special_menu`
--

CREATE TABLE `special_menu` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `special_menu`
--

INSERT INTO `special_menu` (`id`, `image_path`, `title`) VALUES
(1, 'uploads/special_menu/image_specialManu_1.png', 'Burger'),
(2, 'uploads/special_menu/image_specialManu_2.png', 'Fried chicken'),
(3, 'uploads/special_menu/image_specialManu_3.png', 'Doner Chicken'),
(4, 'uploads/special_menu/image_specialManu_4.png', 'Pizza'),
(5, 'uploads/special_menu/image_specialManu_5.png', 'Hot Dogs'),
(6, 'uploads/special_menu/image_specialManu_6.png', 'Chicken Skewers'),
(7, 'uploads/special_menu/image_specialManu_7.png', 'Greek Salad'),
(8, 'uploads/special_menu/image_specialManu_8.png', 'Dahi Puri'),
(9, 'uploads/special_menu/image_specialManu_9.png', 'Ice cream with Chocolate'),
(10, 'uploads/special_menu/image_specialManu_10.png', 'Cocktail Glasses');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `TokenID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiresAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Avatar` varchar(255) DEFAULT NULL,
  `Gender` varchar(20) DEFAULT NULL,
  `Role` varchar(20) DEFAULT NULL,
  `DateofBirth` datetime DEFAULT NULL,
  `loginAttempts` int(11) DEFAULT 0,
  `lastAttemptTime` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `PasswordHash`, `Email`, `Phone`, `Avatar`, `Gender`, `Role`, `DateofBirth`, `loginAttempts`, `lastAttemptTime`) VALUES
(1, 'cuongnguyen23', '$2y$10$ALeyQnSshJmBpOJ6yuw1.eTC.aauMZWBD8/CPKekHJKs8ddfxuWiS', 'cuong.nguyenmsmsms23@hcmut.edu.vn', '0912665234', 'assets/default-pfp.png', 'male', 'member', '2003-06-07 00:00:00', 0, '2025-05-07 13:09:26'),
(2, 'admin', '$2y$10$NUdbLpNkfaaISQb/VmzWf.hBkXx7LnNxqQ.8hA17/aNtzAEU.zlka', 'admin@gmail.com', NULL, 'assets/default-pfp.png', NULL, 'admin', NULL, 0, '2025-05-07 13:09:26'),
(3, 'duytran45', '$2y$10$5xfUtK15jlILv32l04mZCOMYqlSdCXP0E6IKCMrDNlFXsNrLDRz.e', 'duytran@gmail.com', '0932565734', 'assets/default-pfp.png', 'female', 'member', '2001-06-08 00:00:00', 0, '2025-05-07 13:09:26'),
(4, 'vyle9098', '$2y$10$RjPgx.nc8SiMiO8xDYPe/OaZNfdokxsuaMauKeyavfYQu/stSt.jK', 'vyle@gmail.com', '0912785231', 'assets/default-pfp.png', 'female', 'member', '2001-05-23 00:00:00', 0, '2025-05-07 13:09:26'),
(5, 'amy34', '$2y$10$U5ViyjsyERNrc9RZ7il9xuQc/ZkulLZQaZis.Ff.JFBxkiTQEgE5O', 'amy@gmail.com', '0979784201', 'assets/default-pfp.png', 'male', 'member', '2006-05-30 00:00:00', 0, '2025-05-07 13:09:26'),
(6, 'trangdang123', '$2y$10$Vnnnl7XBxvnaQgeIkyQiFOu/qpmHTCAm1XDTGGFN72Kb1GrVPqz.m', 'trangdang@gmail.com', '0334745231', 'assets/default-pfp.png', 'other', 'member', '1990-05-07 00:00:00', 0, '2025-05-07 13:09:26'),
(7, 'nhuhuynh1227', '$2y$10$DwvKm5/9oseO3ABSNGgLfOQp24amWzBKTBSkO48OGCHYWy3yds182', 'nhuhuynh@gmail.com', '0912731231', 'assets/default-pfp.png', 'female', 'member', '1993-05-29 00:00:00', 0, '2025-05-07 13:09:26');
-- --------------------------------------------------------

--
-- Table structure for table `visit_us`
--

CREATE TABLE `visit_us` (
  `id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `working_hours_description` varchar(255) DEFAULT NULL,
  `dphone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `visit_us`
--

INSERT INTO `visit_us` (`id`, `address`, `phone`, `email`, `working_hours_description`, `dphone`) VALUES
(1, '88, 01 Song Hanh, An Phu, District 2, HCMC', '+84 387 847 976', 'tastybite@gmal.com', '7:30 am to 9:30pm on Weekdays', '+84 387 847 976');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`BlogID`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `ParentID` (`ParentID`),
  ADD KEY `BlogID` (`BlogID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`ContactID`),
  ADD KEY `fk_contacts_user` (`UserID`);

--
-- Indexes for table `fanda`
--
ALTER TABLE `fanda`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header`
--
ALTER TABLE `header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ShipperID` (`ShipperID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`OrderItemID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `popular_dishes`
--
ALTER TABLE `popular_dishes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `shippers`
--
ALTER TABLE `shippers`
  ADD PRIMARY KEY (`ShipperID`),
  ADD UNIQUE KEY `CarID` (`CarID`);

--
-- Indexes for table `specialservice`
--
ALTER TABLE `specialservice`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `special_menu`
--
ALTER TABLE `special_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`TokenID`),
  ADD KEY `tokens_ibfk_1` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `visit_us`
--
ALTER TABLE `visit_us`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `BlogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `ContactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fanda`
--
ALTER TABLE `fanda`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `header`
--
ALTER TABLE `header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `OrderItemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `popular_dishes`
--
ALTER TABLE `popular_dishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shippers`
--
ALTER TABLE `shippers`
  MODIFY `ShipperID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specialservice`
--
ALTER TABLE `specialservice`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `special_menu`
--
ALTER TABLE `special_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `TokenID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `visit_us`
--
ALTER TABLE `visit_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`ParentID`) REFERENCES `comments` (`CommentID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`BlogID`) REFERENCES `blogs` (`BlogID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `fk_contacts_user` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`ShipperID`) REFERENCES `shippers` (`ShipperID`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`CategoryID`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`) ON DELETE CASCADE;

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
