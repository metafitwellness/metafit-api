-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 16, 2025 at 02:23 PM
-- Server version: 10.11.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u253610572_metafit_prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(100) NOT NULL,
  `name` text NOT NULL,
  `date` text NOT NULL,
  `img` text NOT NULL,
  `des` text NOT NULL,
  `status` text NOT NULL,
  `footer_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `name`, `date`, `img`, `des`, `status`, `footer_status`) VALUES
(1, '10 Tips for Maintaining a Healthy Lifestyle Year-Round', '16-03-2025', 'blog-01.jpg', 'Maintaining a healthy lifestyle year-round is achievable with consistent habits that support your physical and mental well-being. One of the key pillars is staying hydrated, as water is essential for digestion, nutrient absorption, and overall bodily functions. Aim to drink at least eight glasses of water daily, adjusting for factors like weather and physical activity. A balanced diet is equally important, as it fuels your body with the nutrients it needs for energy, growth, and repair. Incorporate a variety of fruits, vegetables, lean proteins, and whole grains to ensure you’re getting a range of vitamins and minerals.', '1', '1'),
(2, 'Tips for Maintaining a Healthy Lifestyle Year-Round\r\n', '16-03-2025', 'blog-02.jpg', 'Regular physical activity is another cornerstone of a healthy lifestyle. Engaging in at least 150 minutes of moderate exercise per week, such as walking or cycling, can boost your cardiovascular health, strengthen muscles, and improve mood. Equally important is prioritizing sleep. Getting 7-9 hours of quality sleep each night helps regulate your mood, enhances mental clarity, and supports physical health. With these tips in mind, you’ll be on your way to maintaining a healthy lifestyle all year long.', '1', '1'),
(3, 'An extra important note to remember is that consistency is key. Small, sustainable', '16-03-2025', 'blog-03.jpg', 'Regular physical activity is another cornerstone of a healthy lifestyle. Engaging in at least 150 minutes of moderate exercise per week, such as walking or cycling, can boost your cardiovascular health, strengthen muscles, and improve mood. Equally important is prioritizing sleep. Getting 7-9 hours of quality sleep each night helps regulate your mood, enhances mental clarity, and supports physical health. With these tips in mind, you’ll be on your way to maintaining a healthy lifestyle all year long.', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `state_id` int(11) DEFAULT NULL,
  `active` int(1) DEFAULT 0,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city_name`, `state_id`, `active`, `image`) VALUES
(1, 'Udaipur', 1, 1, 'udaipur.webp'),
(2, 'Indore', 2, 1, 'indore.jpg'),
(4, 'Ujjain', 2, 1, 'ujjain.jpg'),
(5, 'Ahmedabad', 10, 1, ''),
(6, 'Rajsamand', 1, 1, ''),
(7, 'Delhi', 1, 1, ''),
(8, 'Chandigarh', 23, 1, ''),
(9, 'Rishikesh', 30, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `lab_test`
--

CREATE TABLE `lab_test` (
  `id` int(100) NOT NULL,
  `name` text NOT NULL,
  `des` text NOT NULL,
  `img` text NOT NULL,
  `price` text NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lab_test`
--

INSERT INTO `lab_test` (`id`, `name`, `des`, `img`, `price`, `status`) VALUES
(1, 'Metafit Rapid Vital', 'CBC, RBS, HbA1c, Total cholesterol, Liver Profile, Kidney Profile, Thyroid Profile, Vit.B12, Vit.D3', 'rv.jpg', '1839', '1'),
(2, 'Metafit Essential Screen', 'CBC, FBS, ESR, TSH, Sr cholesterol, Kidney Profile, Liver Profile, Urine Analysis\n', 'es.jpg', '1299', '1'),
(3, 'Metafit Gold Wellness', 'Cardiac Risk Marker, Iron Deficiency Profile, Lipid Profile, Liver Profile, Kidney Profile, Thyroid Profile\n', 'gt.jpg', '2500', '1'),
(4, 'Metafit Silver Balance', 'CBC, FBS, HbA1c, UTSH, Lipid Profile, Liver Profile, Kidney Profile, Vit.B12, Vit.D3', 'st.jpg', '1799', '1'),
(5, 'Metafit Platinum Complete', 'CBC, FBS, HbA1c, Cardiac Markers, Iron Deficiency, Lipid Profile, Liver Profile, Kidney Profile, Thyroid Profile, Testosterone, Vit.B12, Vit.D3', 'plt.jpg', '2850', '1');

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_sec`
--

CREATE TABLE `lab_test_sec` (
  `id` int(100) NOT NULL,
  `name` text NOT NULL,
  `img` text NOT NULL,
  `heading` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lab_test_sec`
--

INSERT INTO `lab_test_sec` (`id`, `name`, `img`, `heading`) VALUES
(1, '<p>Regular lab tests are the foundation of proactive health management, helping detect underlying issues before they become serious. Accurate diagnostics enable doctors to create tailored treatment plans for more effective and targeted care. At MetaFit, we prioritize convenience by offering home collection services for lab tests across 18,000 pincodes in India. This means you can access essential health check-ups without leaving your home, saving time and effort. Whether you\'re managing a condition or enhancing your wellness journey, our comprehensive lab tests and focus on Ayurvedic wellness ensure you\'re on the path to optimal health and vitality.</p>\r\n								<p>लैब टेस्ट और डायग्नोस्टिक्स आपके स्वास्थ्य के लिए क्यों आवश्यक हैं\r\nनियमित लैब टेस्ट सक्रिय स्वास्थ्य प्रबंधन की नींव हैं, जो संभावित समस्याओं का पता लगाने में मदद करते हैं इससे पहले कि वे गंभीर हो जाएं। सटीक डायग्नोस्टिक्स डॉक्टरों को व्यक्तिगत उपचार योजनाएँ बनाने में मदद करती हैं, जिससे अधिक प्रभावी और लक्षित देखभाल मिलती है। MetaFit में, हम सुविधा को प्राथमिकता देते हैं और 18,000 पिनकोड्स में लैब टेस्ट के लिए होम कलेक्शन सेवाएँ प्रदान करते हैं। इसका मतलब है कि आप अपने घर से बाहर जाए बिना आवश्यक स्वास्थ्य जांच करवा सकते हैं, समय और प्रयास बचा सकते हैं। चाहे आप किसी स्थिति का प्रबंधन कर रहे हों या अपनी वेलनेस यात्रा को बेहतर बना रहे हों, हमारे विस्तृत लैब टेस्ट और आयुर्वेदिक वेलनेस पर ध्यान केंद्रित करने से आप सर्वोत्तम स्वास्थ्य और जीवन शक्ति की दिशा में कदम बढ़ा सकते हैं।\r\n</p>', 'callto.jpg', 'Why Lab Tests and Diagnostics Are Essential for Your Health');

-- --------------------------------------------------------

--
-- Table structure for table `onboardings`
--

CREATE TABLE `onboardings` (
  `id` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `planId` int(11) DEFAULT NULL,
  `amount` varchar(10) DEFAULT NULL,
  `rzp_orderId` varchar(40) DEFAULT NULL,
  `rzp_paymentId` varchar(40) DEFAULT NULL,
  `rzp_signature` text DEFAULT NULL,
  `dateAdded` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `onboardings`
--

INSERT INTO `onboardings` (`id`, `userId`, `planId`, `amount`, `rzp_orderId`, `rzp_paymentId`, `rzp_signature`, `dateAdded`, `status`, `active`) VALUES
(1, 5, 1, '0', NULL, NULL, NULL, '2025-03-01 00:00:00', 'captured', 1),
(2, 6, 3, '1499900', 'order_Q1bGrX9zZhdFe1', 'pay_Q1bHjDBBh8Fgrh', 'bdfadc1f4a1f5a3c043ee6c80ec5df61947d741f04cd311084f9d786e55af867', '2025-03-01 16:57:25', 'active', 1),
(3, 7, 1, '0', NULL, NULL, NULL, '2025-03-01 00:00:00', 'captured', 1),
(4, 8, 1, '0', NULL, NULL, NULL, '2025-03-01 00:00:00', 'captured', 1),
(5, 9, 1, '0', NULL, NULL, NULL, '2025-03-01 00:00:00', 'captured', 1),
(6, 10, 1, '0', NULL, NULL, NULL, '2025-03-01 00:00:00', 'captured', 1),
(7, 11, 3, '1499900', 'order_Q1cofHhXjxVYK4', 'pay_Q1colghTh4ucU2', '35175dfa053d6753e7c9552a35a5751e4413de1c2ac170a2221af54da37c41fa', '2025-03-01 18:28:06', 'active', 1),
(8, 12, 2, '599900', 'order_Q1dF51hVeN2T2m', 'pay_Q1dFHTAtHbFU8v', 'bb64b16012f6e18b9a1e870f5dfeda2dae031e98f27ee38b816c82652e79bd8e', '2025-03-01 18:53:07', 'active', 1),
(9, 14, 1, '0', NULL, NULL, NULL, '2025-03-02 00:00:00', 'active', 1),
(10, 15, 1, '0', NULL, NULL, NULL, '2025-03-02 00:00:00', 'active', 1),
(11, 17, 1, '0', NULL, NULL, NULL, '2025-03-04 00:00:00', 'active', 1),
(12, 18, 1, '0', NULL, NULL, NULL, '2025-03-04 00:00:00', 'active', 1),
(13, 19, 1, '0', NULL, NULL, NULL, '2025-03-04 00:00:00', 'active', 1),
(14, 20, 1, '0', NULL, NULL, NULL, '2025-03-04 00:00:00', 'active', 1),
(15, 21, 1, '0', NULL, NULL, NULL, '2025-03-04 00:00:00', 'active', 1),
(16, 22, 1, '0', NULL, NULL, NULL, '2025-03-04 00:00:00', 'active', 1),
(17, 23, 1, '0', NULL, NULL, NULL, '2025-03-04 00:00:00', 'active', 1),
(18, 24, 1, '0', NULL, NULL, NULL, '2025-03-06 00:00:00', 'active', 1),
(19, 29, 1, '0', NULL, NULL, NULL, '2025-03-06 00:00:00', 'active', 1),
(20, 30, 1, '0', NULL, NULL, NULL, '2025-03-06 00:00:00', 'active', 1),
(21, 31, 1, '0', NULL, NULL, NULL, '2025-03-06 00:00:00', 'active', 1),
(22, 32, 1, '0', NULL, NULL, NULL, '2025-03-06 00:00:00', 'active', 1),
(23, 34, 1, '0', NULL, NULL, NULL, '2025-03-06 00:00:00', 'active', 1),
(24, 35, 1, '0', NULL, NULL, NULL, '2025-03-06 00:00:00', 'active', 1),
(25, 38, 1, '0', NULL, NULL, NULL, '2025-03-09 00:00:00', 'active', 1),
(26, 40, 1, '0', NULL, NULL, NULL, '2025-03-10 00:00:00', 'active', 1),
(27, 13, 2, '999900', 'order_Q5YIiNHpSvUPqV', 'pay_Q5YJ4ssRLBq87H', '39bc6c2016a5f0e053a6a313d62c30dd976131dd4e813093fcc3382f7d4674ea', '2025-03-11 16:39:08', 'active', 0),
(28, 13, 2, '999900', 'order_Q5YJU0CCTgx01d', 'pay_Q5YJgFp7zYwKwa', '3a2e8f20cd00dd761504339b6b3b1e803ac139bf61131ae73a4cdfaed2831a5e', '2025-03-11 16:39:51', 'active', 1),
(29, 33, 2, '999900', 'order_Q5YN11HqSphWYP', 'pay_Q5YNOUVGOGgVVm', '57328b4691b2338349be341d0c0b62104b66479fe350495e621a30eab8af33ae', '2025-03-11 16:43:12', 'active', 1),
(30, 43, 1, '0', NULL, NULL, NULL, '2025-03-13 00:00:00', 'active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `plan` varchar(30) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `onboarding` int(10) DEFAULT NULL,
  `monthly` int(10) DEFAULT NULL,
  `monthValidity` int(2) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `plan`, `description`, `onboarding`, `monthly`, `monthValidity`, `active`) VALUES
(1, 'Free Plan', '<table style=\"width: 100%; border-collapse: collapse;\">\n    <thead>\n        <tr>\n            <th style=\"border: 1px solid black; padding: 10px; text-align: left;\">Feature/Service</th>\n            <th style=\"border: 1px solid black; padding: 10px; text-align: left;\">Status</th>\n        </tr>\n    </thead>\n    <tbody>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Content Creation & Promotions</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: red;\">✘</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">YouTube Shorts & Video Promotion</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: red;\">✘</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">ERP & Client Management</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: red;\">✘</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Targeted Ad Campaigns</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: red;\">✘</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Access to Health-Fitness Seminars</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: red;\">✘</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Lead Generation & Ads</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: red;\">✘</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Promotional Reels (3)</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: red;\">✘</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Priority Visibility</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: red;\">✘</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Promotional Creative (5)</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: red;\">✘</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">24/7 Customer Support</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: red;\">✘</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Visibility on Website or App</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔ <span style=\"color: blue;\">(Enabled)</span></td>\n        </tr>\n    </tbody>\n</table>', 0, 0, 12, 1),
(2, 'Growth Plan', '<table style=\"width: 100%; border-collapse: collapse;\">\r\n    <thead>\r\n        <tr>\r\n            <th style=\"border: 1px solid black; padding: 10px; text-align: left;\">Feature/Service</th>\r\n            <th style=\"border: 1px solid black; padding: 10px; text-align: left;\">Status</th>\r\n        </tr>\r\n    </thead>\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Content Creation & Promotions</td>\r\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">YouTube Shorts & Video Promotion</td>\r\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">ERP & Client Management</td>\r\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Targeted Ad Campaigns</td>\r\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Access to Health-Fitness Seminars</td>\r\n            <td style=\"border: 1px solid black; padding: 10px; color: red;\">✘</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Lead Generation & Ads</td>\r\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Promotional Reels (3)</td>\r\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Priority Visibility</td>\r\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Promotional Creative (5)</td>\r\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">24/7 Customer Support</td>\r\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\r\n        </tr>\r\n        <tr>\r\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Visibility on Website or App</td>\r\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔ <span style=\"color: blue;\">(Enabled)</span></td>\r\n        </tr>\r\n    </tbody>\r\n</table>', 9999, 1770, 1, 1),
(3, 'Premium Plan', '<table style=\"width: 100%; border-collapse: collapse;\">\n    <thead>\n        <tr>\n            <th style=\"border: 1px solid black; padding: 10px; text-align: left;\">Feature/Service</th>\n            <th style=\"border: 1px solid black; padding: 10px; text-align: left;\">Status</th>\n        </tr>\n    </thead>\n    <tbody>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Content Creation & Promotions</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">YouTube Shorts & Video Promotion</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">ERP & Client Management</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Targeted Ad Campaigns</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Access to Health-Fitness Seminars</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Lead Generation & Ads</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Promotional Reels (3)</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Priority Visibility</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Promotional Creative (5)</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">24/7 Customer Support</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\n        </tr>\n        <tr>\n            <td style=\"border: 1px solid black; padding: 10px; text-align: left;\">Visibility on Website or App</td>\n            <td style=\"border: 1px solid black; padding: 10px; color: green;\">✔</td>\n        </tr>\n    </tbody>\n</table>\n', 19999, 1770, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `segments`
--

CREATE TABLE `segments` (
  `id` int(11) NOT NULL,
  `segement` varchar(50) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `color_code` text NOT NULL,
  `heading` text NOT NULL,
  `des` text NOT NULL,
  `des_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `segments`
--

INSERT INTO `segments` (`id`, `segement`, `active`, `image`, `color_code`, `heading`, `des`, `des_img`) VALUES
(1, 'Diagnostic / Lab Tests', 1, 'labt.png', 'transparent linear-gradient(93deg, #E6B300 0%, #D6BA54 100%) 0% 0% no-repeat padding-box', '', '', ''),
(2, 'Yoga Classes', 1, 'yogaicon.png', 'transparent linear-gradient(93deg, #66E6BF 0%, #60FFD0 100%) 0% 0% no-repeat padding-box', 'MetaFit Wellness', '<p>At MetaFit Wellness, we bring the best yoga teachers directly to your doorstep! Whether you\'re looking to boost flexibility, reduce stress, or improve overall well-being, our expert instructors offer personalized yoga sessions tailored just for you. Choose from a variety of styles like Hatha, Vinyasa, Ashtanga, and more – all from the comfort of your home. Our certified teachers focus on your unique needs, helping you achieve your fitness and wellness goals faster. Start your journey to balance and vitality today with MetaFit Wellness – your personal guide to yoga excellence!</p>\r\n								<p> MetaFit Wellness में हम सबसे बेहतरीन योग शिक्षकों को सीधे आपके दरवाजे तक लाते हैं! चाहे आप लचीलापन बढ़ाना चाहते हों, तनाव कम करना चाहते हों, या संपूर्ण स्वास्थ्य में सुधार, हमारे विशेषज्ञ प्रशिक्षक आपके लिए व्यक्तिगत योग सत्र प्रदान करते हैं। हठ, विन्यास, अष्टांग और अन्य जैसे विभिन्न योग शैलियों में से चुनें – और वह भी अपने घर के आराम से। हमारे प्रमाणित शिक्षक आपकी विशेष आवश्यकताओं पर ध्यान केंद्रित करते हैं, जिससे आप अपने फिटनेस और वेलनेस लक्ष्यों को जल्दी हासिल कर सकें। आज ही MetaFit Wellness के साथ अपने संतुलन और vitality की यात्रा शुरू करें!</p>', 'yoga_des.webp'),
(3, 'Wellness / Naturopathy Centers', 1, 'nath.png', 'transparent linear-gradient(269deg, #E2A2B2 0%, #F55F84 100%) 0% 0% no-repeat padding-box', '', '', ''),
(5, 'Ayurvedic Doctor', 1, 'doctor.png', 'transparent linear-gradient(90deg, #FDBC5E 0%, #FBCF90 100%) 0% 0% no-repeat padding-box', '', '', ''),
(6, 'Psychologist (Mental Health professionals )', 1, 'mentalhl.png', 'transparent linear-gradient(90deg, #bddd00 0%, #b7eb85 100%) 0% 0% no-repeat padding-box', '', '', ''),
(11, 'MetaFit Exclusive Services', 1, 'exclu.png', 'transparent linear-gradient(90deg, #6f5efd 0%, #f990fb 100%) 0% 0% no-repeat padding-box', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `state_name` varchar(255) NOT NULL,
  `active` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `state_name`, `active`) VALUES
(1, 'Rajasthan', 1),
(2, 'Madhya Pradesh', 1),
(4, 'Andhra Pradesh', 1),
(5, 'Arunachal Pradesh', 1),
(6, 'Assam', 1),
(7, 'Bihar', 1),
(8, 'Chhattisgarh', 1),
(9, 'Goa', 1),
(10, 'Gujarat', 1),
(11, 'Haryana', 1),
(12, 'Himachal Pradesh', 1),
(13, 'Jharkhand', 1),
(14, 'Karnataka', 1),
(15, 'Kerala', 1),
(16, 'Madhya Pradesh', 1),
(17, 'Maharashtra', 1),
(18, 'Manipur', 1),
(19, 'Meghalaya', 1),
(20, 'Mizoram', 1),
(21, 'Nagaland', 1),
(22, 'Odisha', 1),
(23, 'Punjab', 1),
(24, 'Rajasthan', 1),
(25, 'Sikkim', 1),
(26, 'Tamil Nadu', 1),
(27, 'Telangana', 1),
(28, 'Tripura', 1),
(29, 'Uttar Pradesh', 1),
(30, 'Uttarakhand', 1),
(31, 'West Bengal', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `userId` varchar(20) DEFAULT NULL,
  `planId` varchar(20) DEFAULT NULL,
  `subscriptionId` varchar(22) DEFAULT NULL,
  `paymentId` varchar(50) DEFAULT NULL,
  `status` varchar(16) DEFAULT NULL,
  `current_start` int(11) DEFAULT NULL,
  `current_end` int(11) DEFAULT NULL,
  `auth_attempts` int(11) DEFAULT NULL,
  `total_count` int(11) DEFAULT NULL,
  `paid_count` int(11) DEFAULT NULL,
  `remaining_count` int(11) DEFAULT NULL,
  `short_url` varchar(40) DEFAULT NULL,
  `dateAdded` datetime DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `userId`, `planId`, `subscriptionId`, `paymentId`, `status`, `current_start`, `current_end`, `auth_attempts`, `total_count`, `paid_count`, `remaining_count`, `short_url`, `dateAdded`, `active`) VALUES
(1, '5', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-01 00:00:00', 1),
(2, '7', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-01 00:00:00', 1),
(3, '8', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-01 00:00:00', 1),
(4, '9', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-01 00:00:00', 1),
(5, '10', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-01 00:00:00', 1),
(6, '11', 'plan_PpBSgsf2sASPZL', 'sub_Q1cr8qABPkpnY6', NULL, 'active', NULL, NULL, 0, 240, 0, 239, 'https://rzp.io/rzp/mZXFiuDo', '2025-03-01 18:30:29', 1),
(7, '14', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-02 00:00:00', 1),
(8, '15', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-02 00:00:00', 1),
(9, '17', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-04 00:00:00', 1),
(10, '18', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-04 00:00:00', 1),
(11, '19', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-04 00:00:00', 1),
(12, '20', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-04 00:00:00', 1),
(13, '21', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-04 00:00:00', 1),
(14, '22', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-04 00:00:00', 1),
(15, '23', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-04 00:00:00', 1),
(16, '24', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-06 00:00:00', 1),
(17, '29', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-06 00:00:00', 1),
(18, '30', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-06 00:00:00', 1),
(19, '31', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-06 00:00:00', 1),
(20, '32', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-06 00:00:00', 1),
(22, '35', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-06 00:00:00', 1),
(23, '38', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-09 00:00:00', 1),
(24, '40', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-10 00:00:00', 1),
(25, '33', 'plan_Q5YAauJm2trWDb', 'sub_Q5YP4xwBkZJJcF', NULL, 'created', NULL, NULL, 0, 240, 0, 239, 'https://rzp.io/rzp/IAEtQWI', '2025-03-11 16:45:10', 1),
(26, '43', '1', 'FREE PLAN', NULL, 'active', NULL, NULL, NULL, 12, 12, 0, NULL, '2025-03-13 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tempusers`
--

CREATE TABLE `tempusers` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `segment` int(11) DEFAULT NULL,
  `city` int(1) NOT NULL DEFAULT 0,
  `emailId` varchar(30) DEFAULT NULL,
  `password` varchar(36) DEFAULT NULL,
  `countryCode` varchar(5) DEFAULT NULL,
  `phoneNumber` varchar(16) DEFAULT NULL,
  `firstLogin` int(1) NOT NULL DEFAULT 1,
  `attempt` int(1) NOT NULL DEFAULT 0,
  `referral` varchar(30) DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT 0,
  `otp` varchar(6) DEFAULT NULL,
  `addedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedOn` datetime DEFAULT current_timestamp(),
  `deletedOn` datetime DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `status` enum('pending','registered','rejected','deleted','verified','active') NOT NULL DEFAULT 'pending',
  `reason` varchar(50) DEFAULT NULL,
  `planId` int(11) DEFAULT NULL,
  `onboardingAmount` varchar(10) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tempusers`
--

INSERT INTO `tempusers` (`id`, `name`, `segment`, `city`, `emailId`, `password`, `countryCode`, `phoneNumber`, `firstLogin`, `attempt`, `referral`, `admin`, `otp`, `addedOn`, `updatedOn`, `deletedOn`, `userId`, `status`, `reason`, `planId`, `onboardingAmount`, `active`) VALUES
(1, NULL, NULL, 0, NULL, '5f4dcc3b5aa765d61d8327deb882cf99', NULL, '9000000000', 0, 0, NULL, 1, NULL, '2025-03-01 12:32:02', '2025-03-01 12:32:02', NULL, NULL, 'pending', NULL, NULL, NULL, 1),
(5, 'testing', 1, 1, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '8005623769', 1, 0, '', 0, '123456', '2025-03-01 16:48:00', '2025-03-01 16:48:00', NULL, NULL, '', NULL, 1, '0', 1),
(6, 'Paid', 2, 1, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '8058199878', 1, 0, '', 0, '123456', '2025-03-01 16:56:42', '2025-03-01 16:56:42', NULL, NULL, '', NULL, 3, '14999', 1),
(10, 'mlk', 1, 1, NULL, '5f4dcc3b5aa765d61d8327deb882cf99', NULL, '8770078128', 1, 0, '', 0, '123456', '2025-03-01 18:26:50', '2025-03-01 18:26:50', NULL, NULL, '', NULL, 1, '0', 1),
(11, 'mkml', 1, 1, NULL, '5f4dcc3b5aa765d61d8327deb882cf99', NULL, '8518842075', 1, 0, '', 0, '123456', '2025-03-01 18:27:57', '2025-03-01 18:27:57', NULL, NULL, '', NULL, 3, '14999', 1),
(12, 'mlkm', 1, 1, NULL, '5f4dcc3b5aa765d61d8327deb882cf99', NULL, '8518842075', 1, 0, '', 0, '123456', '2025-03-01 18:52:57', '2025-03-01 18:52:57', NULL, NULL, '', NULL, 2, '5999', 1),
(14, 'Rohit', 6, 1, NULL, 'f925916e2754e5e03f75dd58a5733251', NULL, '9403757119', 1, 0, '', 0, '744285', '2025-03-02 04:46:38', '2025-03-02 04:46:38', NULL, NULL, '', NULL, 1, '0', 1),
(16, 'Urmila kumawat', 2, 1, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '8209679846', 1, 1, '', 0, '991517', '2025-03-04 13:39:51', '2025-03-04 13:39:51', NULL, NULL, 'deleted', NULL, 1, '0', 0),
(17, 'urmila kumawat', 2, 1, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '8209679846', 1, 0, '', 0, '367436', '2025-03-04 14:09:26', '2025-03-04 14:09:26', NULL, NULL, '', NULL, 1, '0', 1),
(18, 'Mahima Sarupria', 2, 1, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '9119336558', 1, 0, '', 0, '573745', '2025-03-04 17:00:23', '2025-03-04 17:00:23', NULL, NULL, '', NULL, 1, '0', 1),
(19, 'Rekha Soni', 3, 1, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 1, 1, '', 0, '958993', '2025-03-04 17:10:46', '2025-03-04 17:10:46', NULL, NULL, '', NULL, 1, '0', 1),
(20, 'Dr Sonali Chauhan', 6, 1, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 1, 0, '', 0, '205846', '2025-03-04 17:29:37', '2025-03-04 17:29:37', NULL, NULL, '', NULL, 1, '0', 1),
(21, 'Dr. Dahar Prajapat', 5, 1, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 1, 0, '', 0, '339941', '2025-03-04 17:39:20', '2025-03-04 17:39:20', NULL, NULL, '', NULL, 1, '0', 1),
(22, 'Dr Chandra Mohan Chouhan', 5, 1, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 1, 0, '', 0, '773240', '2025-03-04 17:52:39', '2025-03-04 17:52:39', NULL, NULL, '', NULL, 1, '0', 1),
(23, 'Vishnu Kumawat', 2, 1, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 1, 0, '', 0, '486701', '2025-03-04 18:04:52', '2025-03-04 18:04:52', NULL, NULL, '', NULL, 1, '0', 1),
(24, 'Dr. Sandhya Choudhry ', 11, 1, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 1, 0, '', 0, '425513', '2025-03-06 17:11:25', '2025-03-06 17:11:25', NULL, NULL, '', NULL, 1, '0', 1),
(37, 'Kiran bhabhi', 2, 1, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '9660112440', 1, 0, '', 0, '123456', '2025-03-09 12:43:08', '2025-03-09 12:43:08', NULL, NULL, 'deleted', NULL, 1, '0', 0),
(38, 'Kiran Dave', 2, 1, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '9660112440', 1, 0, '', 0, '123456', '2025-03-09 12:50:54', '2025-03-09 12:50:54', NULL, NULL, 'registered', NULL, 1, '0', 1),
(39, 'veneeta aanad ', 6, 8, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '9872001968', 1, 0, '', 0, '123456', '2025-03-10 12:40:01', '2025-03-10 12:40:01', NULL, NULL, 'pending', NULL, 1, '0', 1),
(40, 'veneeta anand ', 6, 8, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 1, 0, '', 0, '123456', '2025-03-10 12:41:48', '2025-03-10 12:41:48', NULL, NULL, 'registered', NULL, 1, '0', 1),
(42, 'Aradhya Sahu', 1, 9, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '6394442432', 1, 0, '', 0, '123456', '2025-03-13 09:15:36', '2025-03-13 09:15:36', NULL, NULL, 'deleted', NULL, 1, '0', 0),
(43, 'Aradhya Sahu', 2, 9, NULL, 'e10adc3949ba59abbe56e057f20f883e', NULL, '6394442432', 1, 0, '', 0, '123456', '2025-03-13 09:16:09', '2025-03-13 09:16:09', NULL, NULL, 'registered', NULL, 1, '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(275) DEFAULT NULL,
  `segment` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `expiryDate` date DEFAULT NULL,
  `emailId` varchar(30) DEFAULT NULL,
  `password` varchar(36) DEFAULT NULL,
  `countryCode` varchar(5) DEFAULT NULL,
  `phoneNumber` varchar(16) DEFAULT NULL,
  `firstLogin` int(1) NOT NULL DEFAULT 1,
  `isSubscribed` int(1) DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT 0,
  `referral` varchar(30) DEFAULT NULL,
  `addedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `deletedOn` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `accountStatus` varchar(40) DEFAULT NULL,
  `planId` int(11) DEFAULT NULL,
  `onboardingAmount` varchar(10) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `verificationStatus` varchar(15) DEFAULT 'initiated',
  `verificationRemark` varchar(90) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `segment`, `city`, `expiryDate`, `emailId`, `password`, `countryCode`, `phoneNumber`, `firstLogin`, `isSubscribed`, `admin`, `referral`, `addedOn`, `updatedOn`, `deletedOn`, `status`, `accountStatus`, `planId`, `onboardingAmount`, `otp`, `verificationStatus`, `verificationRemark`, `active`) VALUES
(1, 'Admin', NULL, NULL, NULL, NULL, '5f4dcc3b5aa765d61d8327deb882cf99', NULL, '9000000000', 0, 0, 1, NULL, '2025-03-01 12:34:10', '2025-03-01 12:34:10', NULL, 0, NULL, NULL, NULL, NULL, 'initiated', NULL, 1),
(16, 'urmila kumawat', 2, 1, NULL, 'URMILAKUMAWAT987@GMAIL.COM', 'e10adc3949ba59abbe56e057f20f883e', NULL, '8209679846', 0, 0, 0, '', '2025-03-04 14:10:25', '2025-03-04 14:39:20', NULL, 0, 'active', 1, '0', NULL, 'approved', '', 1),
(17, 'Mahima Sarupria', 2, 1, NULL, 'mahimasarupria@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '9119336558', 0, 0, 0, '', '2025-03-04 17:01:01', '2025-03-04 17:07:55', NULL, 0, 'active', 1, '0', NULL, 'approved', '', 1),
(18, 'Rekha Soni', 3, 1, NULL, 'rvsoni1972@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 0, 0, 0, '', '2025-03-04 17:11:28', '2025-03-04 17:16:48', NULL, 0, 'active', 1, '0', NULL, 'approved', '', 1),
(19, 'Dr Sonali Chauhan', 2, 1, NULL, 'sonali@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 0, 0, 0, '', '2025-03-04 17:29:48', '2025-03-04 17:36:39', NULL, 0, 'active', 1, '0', NULL, 'approved', '', 1),
(20, 'Dr. Dahar Prajapat', 5, 1, NULL, 'prajapatdahar@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 0, 0, 0, '', '2025-03-04 17:39:39', '2025-03-04 17:43:52', NULL, 0, 'active', 1, '0', NULL, 'approved', '', 1),
(21, 'Dr Chandra Mohan Chouhan', 5, 1, NULL, 'chauhan.ayurveda01@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 0, 0, 0, '', '2025-03-04 17:52:54', '2025-03-04 17:57:00', NULL, 0, 'active', 1, '0', NULL, 'approved', '', 1),
(22, 'Vishnu Kumawat', 2, 1, NULL, 'divyamyogalaya33@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 0, 0, 0, '', '2025-03-04 18:05:03', '2025-03-04 18:09:10', NULL, 0, 'active', 1, '0', NULL, 'approved', '', 1),
(23, 'Dr. Sandhya Choudhry ', 11, 1, NULL, 'drsandhya1997@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 0, 0, 0, '', '2025-03-06 17:11:36', '2025-03-06 17:38:04', NULL, 0, 'active', 1, '0', NULL, 'approved', '', 1),
(30, ' lkmmdflkg AP', 2, 2, NULL, 'test@gmg.com', '5f4dcc3b5aa765d61d8327deb882cf99', NULL, '9039993702', 1, 0, 0, '', '2025-03-06 18:28:56', '2025-03-06 18:28:56', NULL, 0, 'registered', 2, '5999', NULL, 'initiated', NULL, 1),
(31, 'Kiran Dave', 2, 1, NULL, 'kiranbharatdave@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '9660112440', 0, 0, 0, '', '2025-03-09 12:52:37', '2025-03-09 12:59:43', NULL, 0, 'active', 1, '0', NULL, 'approved', '', 1),
(32, 'veneeta anand ', 6, 8, NULL, 'veneetaanand08@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '8829912389', 0, 0, 0, '', '2025-03-10 12:43:27', '2025-03-10 12:48:23', NULL, 0, 'active', 1, '0', NULL, 'approved', '', 1),
(34, 'Aradhya Sahu', 2, 9, NULL, 'aradhyasahu0001@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '6394442432', 0, 0, 0, '', '2025-03-13 09:17:52', '2025-03-13 09:24:23', NULL, 0, 'active', 1, '0', NULL, 'approved', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_profile`
--

CREATE TABLE `users_profile` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `Designation` varchar(100) DEFAULT NULL,
  `homeAddress` text DEFAULT NULL,
  `officeAddress` text DEFAULT NULL,
  `Degree` varchar(100) DEFAULT NULL,
  `passoutYear` varchar(4) DEFAULT NULL,
  `yearsOfExperience` int(4) DEFAULT NULL,
  `self_photo` varchar(90) DEFAULT NULL,
  `aadhar_photo` varchar(90) DEFAULT NULL,
  `clinic_photo` varchar(90) DEFAULT NULL,
  `achievements` text DEFAULT NULL,
  `pan_card_photo_front` varchar(90) DEFAULT NULL,
  `pan_card_photo_back` varchar(90) DEFAULT NULL,
  `bank_name` varchar(90) DEFAULT NULL,
  `bank_ac` varchar(70) DEFAULT NULL,
  `bank_ifsc` varchar(30) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `google_map_url` varchar(255) DEFAULT NULL,
  `alternative_contact` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_profile`
--

INSERT INTO `users_profile` (`id`, `userId`, `Designation`, `homeAddress`, `officeAddress`, `Degree`, `passoutYear`, `yearsOfExperience`, `self_photo`, `aadhar_photo`, `clinic_photo`, `achievements`, `pan_card_photo_front`, `pan_card_photo_back`, `bank_name`, `bank_ac`, `bank_ifsc`, `instagram_url`, `linkedin_url`, `youtube_url`, `facebook_url`, `website_url`, `google_map_url`, `alternative_contact`) VALUES
(12, 41, 'yoga teacher 1,2,3 level ', 'near by celbration mall maitri yoga udaipur ,313001 ', '', '', '2018', 0, NULL, NULL, NULL, '', NULL, NULL, '', '', '', 'Yog_ki_kiran', '', '', '', '', '', ''),
(13, 16, 'YOGA TEACHER ', 'A32 HAR BHOLE NATH socity, odav ,RAMRAJ NAGAR,AHMDABAD  382415', 'A32 HAR BHOLE NATH socity, odav ,RAMRAJ NAGAR,AHMDABAD ', 'yoga TTC 200 hr .pre natal and post natal', '2024', 1, 'img_67c70ae0af2840.73220043.jpeg', NULL, NULL, '', NULL, NULL, '', '', '', '', '', '', '', '', '', ''),
(14, 17, 'Yoga Instructor', '846/15, Madhav Colony Kalka Mata Mandir pahada udaipur 313001', 'hotel meera nagar margarita, sardarpura,udaipur ', '200 hours', '2020', 5, 'img_67c732d2156c18.10508347.jpeg', 'img_67c732d22521e9.60144553.jpeg', NULL, '', 'img_67c732d23205b0.71404698.jpeg', NULL, '', '30077961235', 'sbin0001533', 'asanawithpassion', '', '', 'https://www.facebook.com/share/1TX5rieGfr/', '', '', ''),
(15, 18, 'Naturopathy & Homeopathy', '18,a jawahar nagar 1st floor udaipur ', 'shuddhi by arogyas world of wellness 100 fit road shobahgpura', 'MD (AM)', '2006', 19, 'img_67c7356e3a6013.90212249.jpeg', NULL, NULL, '', NULL, NULL, '', '', '', 'https://www.instagram.com/aarogyas_world_of_wellness/', '', '', 'https://www.facebook.com/profile.php?id=100001141167424&ref=ig_profile_ac', 'https://www.shuddhibyaarogyas.com', '', ''),
(16, 19, 'Consultant Physiotherapist', 'meera nagar ,100 fit road ,udaipur 313001', 'meera nagar , 100 fit road ,313001', 'BPT ', '2018', 7, 'img_67c73a0654b9c7.10381789.jpeg', NULL, NULL, '', NULL, NULL, '', '', '', 'https://www.instagram.com/kasee_yoga_physiotherapy/', '', '', '', 'https://kaseehealthcare.com', '', '9530366923'),
(17, 20, 'Ayurvedic doctor', 'Nagda restorent ,Univercity Udaipur 313001', 'Nagda restorent ,Univercity Udaipur 313001', 'BAMS ,MD,MA', '2010', 15, NULL, NULL, NULL, '', NULL, NULL, '', '', '', '', '', '', '', '', '', ''),
(18, 21, 'Ayurvedic Doctor ', 'jain mandir univercity road udaipur 313001', 'jain mandir univercity road udaipur 313001', 'BAMS,M.A,M.D', '2010', 15, 'img_67c73ec3dba454.73990590.jpg', NULL, NULL, '', NULL, NULL, '', '', '', '', '', '', '', '', '', ''),
(19, 22, 'Yoga Instructor', 'tvs choroha rajsamand 313324', 'divya yoga class rajsamand 313324', '200 hour ', '2018', 8, 'img_67c741b4d03af0.63418424.jpg', NULL, NULL, '', NULL, NULL, '', '', '', 'https://www.instagram.com/divyamyogalaya_rajsamand/', '', '', '', '', '', ' 8769943820'),
(20, 23, 'Ayurvedic Practitioner and Consultant ', 'Flat no 206,mahaveer height bedla,syphone udipur', 'Opp.BSF Camp,Near Petrol Pump,udaipur ', 'BAMS', '2021', 0, 'img_67c9d81ee3cf27.42112027.jpeg', NULL, NULL, '', NULL, NULL, '', '61193049869', 'sbbj0010676', '', '', '', '', '', '', ''),
(21, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 30, 'nkn', 'kjn', 'kjn', 'kjn', '3434', 55, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'k', 'nkj', 'njk', 'nkj', 'nkj', 'n', '8770078128'),
(28, 31, 'Yoga Teacher ', ' Flat no 102,1st floor B block, Sanyam Apartment, Swami Nagar, Bhuvana,', 'Maitri Yog Studio, Swami Nagar, Parmanand Garden, Near Neelkanth hosptial udaipur', 'Certified Yoga Professional By Ayush Ministry (Yoga Wellness', '2020', 13, 'img_67cd90aada1784.69591287.jpeg', 'img_67cd90ab049b26.53368424.jpeg', NULL, '', NULL, NULL, '', '50100527154913', 'HDFC0002242', '', '', '', '', '', '', ''),
(29, 32, 'Psychiatrist (Mental health professional)', 'chandigarh ,housing board', 'chandigarh , housing board', 'MD ,DO', '2010', 15, 'img_67cedf7ee3e668.38999976.jpg', NULL, NULL, '', NULL, NULL, '', '', '', 'https://www.instagram.com/championveneeta/', '', '', '', '', '', ''),
(31, 34, 'Yoga Instructor', 'Balrampur,uttarpradesh ,rishikesh ,271201', 'Balrampur,uttarpradesh ,rishikesh ,271201', '200 hour ttc', '2025', 2, 'img_67d2a422a3c758.31403463.jpg', NULL, NULL, '', NULL, NULL, '', '7625025313', 'idib000k503', '', '', 'yogaradhyaa', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `lab_test`
--
ALTER TABLE `lab_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_test_sec`
--
ALTER TABLE `lab_test_sec`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `onboardings`
--
ALTER TABLE `onboardings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `segments`
--
ALTER TABLE `segments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tempusers`
--
ALTER TABLE `tempusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emailId` (`emailId`);

--
-- Indexes for table `users_profile`
--
ALTER TABLE `users_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lab_test`
--
ALTER TABLE `lab_test`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lab_test_sec`
--
ALTER TABLE `lab_test_sec`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `onboardings`
--
ALTER TABLE `onboardings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `segments`
--
ALTER TABLE `segments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tempusers`
--
ALTER TABLE `tempusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users_profile`
--
ALTER TABLE `users_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
