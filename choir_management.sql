-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2024-11-16 05:19:43
-- 服务器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `choir_management`
--

-- --------------------------------------------------------

-- 表的结构 `Attendance`
CREATE TABLE `Attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `absence_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`attendance_id`),
  KEY `idx_member_id` (`member_id`),
  KEY `idx_date` (`date`),
  FOREIGN KEY (`member_id`) REFERENCES `Member`(`member_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 转存表中的数据 `Attendance`
INSERT INTO `Attendance` (`attendance_id`, `member_id`, `date`, `status`, `absence_reason`) VALUES
(1, 1, '2024-11-15', 1, 'N/A');

-- --------------------------------------------------------

-- 表的结构 `Dues`
CREATE TABLE `Dues` (
  `dues_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` ENUM('Venmo', 'Check', 'Mail') DEFAULT 'Cash',
  `payment_frequency` ENUM('Monthly', 'Yearly') DEFAULT 'Monthly',
  PRIMARY KEY (`dues_id`),
  KEY `member_id` (`member_id`),
  FOREIGN KEY (`member_id`) REFERENCES `Member`(`member_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 转存表中的数据 `Dues`
INSERT INTO `Dues` (`member_id`, `amount`, `payment_date`, `payment_method`, `payment_frequency`) VALUES
(3, 150.00, '2024-01-01', 'Cash', 'Yearly');

-- --------------------------------------------------------

-- 表的结构 `Member`
CREATE TABLE `Member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `voice_part_id` int(11) DEFAULT NULL,
  `status_flag` tinyint(1) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `name_in_donor_list` varchar(255) DEFAULT NULL, -- 新增列
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 转存表中的数据 `Member`
INSERT INTO `Member` (`member_id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `join_date`, `voice_part_id`, `status_flag`, `notes`, `name_in_donor_list`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', '123-456-7890', '123 Main St', '2023-01-01', NULL, 1, 'Choir Leader', NULL),
(2, 'Jane', 'Smith', 'jane.smith@example.com', '987-654-3210', '456 Elm St', '2023-02-15', NULL, 1, 'Section Leader', NULL);

-- --------------------------------------------------------

-- 表的结构 `Role`
CREATE TABLE `Role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 插入预定义角色数据
INSERT INTO `Role` (`role_name`) VALUES
('Admin'),
('Manager'),
('Member');

-- --------------------------------------------------------

-- 表的结构 `User`
CREATE TABLE `User` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  FOREIGN KEY (`member_id`) REFERENCES `Member` (`member_id`),
  FOREIGN KEY (`role_id`) REFERENCES `Role` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- 表的结构 `UploadedFiles`
CREATE TABLE `UploadedFiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 转存表中的数据 `UploadedFiles`
INSERT INTO `UploadedFiles` (`file_name`, `file_path`, `uploaded_at`) VALUES
('example.csv', '/uploads/example.csv', '2024-11-16 10:00:00');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- 表的索引 `Attendance`
--
ALTER TABLE `Attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `idx_member_id` (`member_id`),
  ADD KEY `idx_date` (`date`);

--
-- 表的索引 `Dues`
--
ALTER TABLE `Dues`
  ADD PRIMARY KEY (`dues_id`),
  ADD KEY `member_id` (`member_id`);

--
-- 表的索引 `Member`
--
ALTER TABLE `Member`
  ADD PRIMARY KEY (`member_id`);

--
-- 表的索引 `Role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`role_id`);

--
-- 表的索引 `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `role_id` (`role_id`);

--
-- 使用表AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `Attendance`
--
ALTER TABLE `Attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `Dues`
--
ALTER TABLE `Dues`
  MODIFY `dues_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `Member`
--
ALTER TABLE `Member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `Role`
--
ALTER TABLE `Role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 限制导出的表
--

--
-- 限制表 `Attendance`
--
ALTER TABLE `Attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `Member` (`member_id`);

--
-- 限制表 `Dues`
--
ALTER TABLE `Dues`
  ADD CONSTRAINT `dues_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `Member` (`member_id`);

--
-- 限制表 `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `Member` (`member_id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `Role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
