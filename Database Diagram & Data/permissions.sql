-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2021 at 02:28 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskit`
--

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forcompany` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `forcompany`, `created_at`, `updated_at`) VALUES
(1, 'Add RoleGroup', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(2, 'Edit RoleGroup', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(3, 'Delete RoleGroup', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(4, 'Show RoleGroup', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(5, 'Assign RoleGroup To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(6, 'Remove RoleGroup From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(7, 'Add Permission', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(8, 'Edit Permission', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(9, 'Delete Permission', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(10, 'Show Permission', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(11, 'Assign Permission To RoleGroup', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(12, 'Remove Permission From RoleGroup', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(13, 'Add RoleGroupCompany', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(14, 'Edit RoleGroupCompany', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(15, 'Delete RoleGroupCompany', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(16, 'Show RoleGroupCompany', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(17, 'Assign RoleGroupCompany To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(18, 'Remove RoleGroupCompany From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(19, 'Add User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(20, 'Edit User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(21, 'Delete User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(22, 'Show User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(23, 'Add Company', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(24, 'Edit Company', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(25, 'Delete Company', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(26, 'Show Company', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(27, 'Assign Company To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(28, 'Remove Company From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(29, 'Add Workspace', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(30, 'Edit Workspace', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(31, 'Delete Workspace', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(32, 'Show Workspace', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(33, 'Assign Workspace To Company', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(34, 'Remove Workspace From Company', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(35, 'Assign Workspace To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(36, 'Remove Workspace From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(37, 'Add Project', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(38, 'Edit Project', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(39, 'Delete Project', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(40, 'Show Project', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(41, 'Assign Project To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(42, 'Remove Project From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(43, 'Assign Project To Workspace', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(44, 'Remove Project From Workspace', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(45, 'Add Section', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(46, 'Edit Section', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(47, 'Delete Section', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(48, 'Show Section', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(49, 'Assign Section To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(50, 'Remove Section From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(51, 'Assign Section To Project', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(52, 'Remove Section From Project', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(53, 'Add Task', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(54, 'Edit Task', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(55, 'Delete Task', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(56, 'Show Task', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(57, 'Assign Task To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(58, 'Remove Task From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(59, 'Assign Task To Section', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(60, 'Remove Task From Section', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(61, 'Add Notification', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(62, 'Edit Notification', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(63, 'Delete Notification', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(64, 'Show Notification', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(65, 'Assign Notification To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(66, 'Remove Notification From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(67, 'Add Reminder', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(68, 'Edit Reminder', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(69, 'Delete Reminder', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(70, 'Show Reminder', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(71, 'Assign Reminder To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(72, 'Remove Reminder From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(73, 'Add Job', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(74, 'Edit Job', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(75, 'Delete Job', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(76, 'Show Job', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(77, 'Assign Job To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(78, 'Remove Job From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(79, 'Add Invitation', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(80, 'Edit Invitation', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(81, 'Delete Invitation', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(82, 'Show Invitation', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(83, 'Assign Invitation To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(84, 'Remove Invitation From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(85, 'Index RoleGroup', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(86, 'Index Permission', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(87, 'Index RoleGroupCompany', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(88, 'Index User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(89, 'Index Company', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(90, 'Index Workspace', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(91, 'Index Project', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(92, 'Index Section', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(93, 'Index Task', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(94, 'Index Notification', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(95, 'Index Reminder', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(96, 'Index Job', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(97, 'Index Invitation', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
