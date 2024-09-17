-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2021 at 02:46 AM
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
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `members` int(11) NOT NULL DEFAULT 0,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `ceoid` int(11) DEFAULT NULL,
  `typeid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `type`, `members`, `description`, `userid`, `ceoid`, `typeid`, `created_at`, `updated_at`) VALUES
(1, 'Company 01', 'IT', 0, NULL, 1, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_types`
--

CREATE TABLE `company_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_types`
--

INSERT INTO `company_types` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'IT', NULL, NULL),
(2, 'Telecom', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_workflows`
--

CREATE TABLE `company_workflows` (
  `companyid` int(11) NOT NULL,
  `workflowtype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_workflows`
--

INSERT INTO `company_workflows` (`companyid`, `workflowtype`, `created_at`, `updated_at`) VALUES
(1, 'all', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyid` int(11) NOT NULL,
  `director` int(11) NOT NULL,
  `isactive` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nonactive',
  `updatingfor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isdeleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `companyid`, `director`, `isactive`, `updatingfor`, `isdeleted`, `created_at`, `updated_at`) VALUES
(1, 'Department 01', NULL, 1, 5, 'active', NULL, NULL, NULL, NULL),
(2, 'Department 02', NULL, 1, 6, 'active', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invitations`
--

CREATE TABLE `invitations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `incoming_msg_id` int(11) NOT NULL,
  `outgoing_msg_id` int(11) NOT NULL,
  `msg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2021_05_01_141757_create_invitations_table', 1),
(9, '2021_05_01_141937_create_reminders_table', 1),
(13, '2021_05_01_144217_create_role_groups_table', 1),
(14, '2021_05_01_144258_create_role_group_companies_table', 1),
(18, '2021_05_01_144648_create_user_role_group_companies_table', 1),
(19, '2021_05_01_144702_create_user_role_groups_table', 1),
(21, '2021_05_01_144733_create_user_tasks_table', 1),
(23, '2021_05_07_232755_create_permissions_table', 1),
(24, '2021_05_07_233746_create_role_group_permissions_table', 1),
(25, '2021_05_07_234225_create_role_group_company_permissions_table', 1),
(26, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(45, '2021_05_21_103424_create_process_types_table', 5),
(46, '2014_10_12_000000_create_users_table', 6),
(48, '2021_05_24_193546_create_project_department_unit_section_users_table', 8),
(49, '2021_05_01_141412_create_companies_table', 9),
(52, '2021_05_01_141820_create_rules_table', 10),
(53, '2021_06_07_183955_create_jobs_table', 11),
(64, '2021_05_19_232541_create_departments_table', 12),
(65, '2021_05_19_232940_create_units_table', 12),
(66, '2021_05_01_142034_create_sections_table', 13),
(68, '2021_05_01_141919_create_projects_table', 14),
(69, '2021_05_01_142112_create_workspaces_table', 14),
(72, '2021_06_20_123159_create_notifications_table', 16),
(74, '2021_05_21_103043_create_processes_table', 17),
(75, '2021_06_26_123109_create_tickets_table', 17),
(76, '2021_06_26_123759_create_user_tickets_table', 17),
(85, '2021_05_01_142046_create_tasks_table', 18),
(86, '2021_08_20_172002_create_company_workflows_table', 19),
(87, '2021_08_20_182657_create_workflow_upper_levels_table', 20),
(88, '2021_08_20_183948_create_company_types_table', 21),
(90, '2021_08_21_012338_create_messages_table', 22),
(91, '2021_08_22_221105_create_user_workspaces_table', 22),
(92, '2021_08_13_175552_create_timers_table', 23);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0053a0cf-6c3d-4d6e-ba1a-0337a0c5007a', 'App\\Notifications\\NotificationAction', 'App\\Models\\User', 19, '[\"\"]', NULL, '2021-07-02 15:12:01', '2021-07-02 15:12:01'),
('c8bf97fa-598e-4745-a549-f38443275a0d', 'App\\Notifications\\NotificationAction', 'App\\Models\\User', 7, '[\"\"]', NULL, '2021-07-02 15:12:01', '2021-07-02 15:12:01'),
('e971ee6d-366b-4b90-84a2-db7e0e3b582c', 'App\\Notifications\\NotificationAction', 'App\\Models\\User', 21, '[\"\"]', NULL, '2021-07-02 15:12:01', '2021-07-02 15:12:01'),
('eb47d4a8-63f0-428d-af20-4858a0df04bf', 'App\\Notifications\\NotificationAction', 'App\\Models\\User', 5, '[\"\"]', NULL, '2021-07-02 15:12:01', '2021-07-02 15:12:01'),
('fc1a66a6-3e9c-4e17-8d3d-29f273e683f5', 'App\\Notifications\\NotificationAction', 'App\\Models\\User', 20, '[\"\"]', NULL, '2021-07-02 15:12:01', '2021-07-02 15:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(7, 'Add Permission', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(8, 'Edit Permission', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(9, 'Delete Permission', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(10, 'Show Permission', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(11, 'Assign Permission To RoleGroup', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(12, 'Remove Permission From RoleGroup', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(13, 'Add RoleGroupCompany', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(14, 'Edit RoleGroupCompany', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(15, 'Delete RoleGroupCompany', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(16, 'Show RoleGroupCompany', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(17, 'Assign RoleGroupCompany To User', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(18, 'Remove RoleGroupCompany From User', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(19, 'Add User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(20, 'Edit User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(21, 'Delete User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(22, 'Show User', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(23, 'Add Company', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(24, 'Edit Company', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(25, 'Delete Company', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(26, 'Show Company', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(27, 'Assign Company To User', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(28, 'Remove Company From User', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(29, 'Add Workspace', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(30, 'Edit Workspace', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(31, 'Delete Workspace', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(32, 'Show Workspace', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(33, 'Assign Workspace To Company', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(34, 'Remove Workspace From Company', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(35, 'Assign Workspace To User', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(36, 'Remove Workspace From User', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(37, 'Add Project', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(38, 'Edit Project', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(39, 'Delete Project', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(40, 'Show Project', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(41, 'Assign Project', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(42, 'Remove Project From User', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(44, 'Remove Project From Workspace', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(45, 'Add Section', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(46, 'Edit Section', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(47, 'Delete Section', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(48, 'Show Section', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(49, 'Assign Section To Unit', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(50, 'Remove Section From Unit', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(53, 'Add Task', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(54, 'Edit Task', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(55, 'Delete Task', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(56, 'Show Task', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(57, 'Assign Task To User', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(58, 'Remove Task From User', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(61, 'Add Notification', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(62, 'Edit Notification', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(63, 'Delete Notification', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(64, 'Show Notification', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(65, 'Assign Notification To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(66, 'Remove Notification From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(67, 'Add Reminder', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(68, 'Edit Reminder', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(69, 'Delete Reminder', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(70, 'Show Reminder', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(71, 'Assign Reminder To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(72, 'Remove Reminder From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(73, 'Add Job', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(74, 'Edit Job', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(75, 'Delete Job', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(76, 'Show Job', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(77, 'Assign Job To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(78, 'Remove Job From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(79, 'Add Invitation', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(80, 'Edit Invitation', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(81, 'Delete Invitation', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(82, 'Show Invitation', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(83, 'Assign Invitation To User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(84, 'Remove Invitation From User', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(85, 'Index RoleGroup', 'no', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(86, 'Index Permission', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(87, 'Index RoleGroupCompany', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(88, 'Index User', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(89, 'Index Company', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(90, 'Index Workspace', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(91, 'Index Project', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(92, 'Index Section', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(93, 'Index Task', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(94, 'Index Notification', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(95, 'Index Reminder', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(96, 'Index Job', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(97, 'Index Invitation', 'yes', '2021-05-10 09:27:43', '2021-05-10 09:27:43'),
(98, 'Add Department', 'yes', NULL, NULL),
(99, 'Edit Department', 'yes', NULL, NULL),
(100, 'Show Department', 'yes', NULL, NULL),
(101, 'Delete Department', 'yes', NULL, NULL),
(102, 'Assign user to Department', 'yes', NULL, NULL),
(103, 'Remove user from Department', 'yes', NULL, NULL),
(104, 'Assign Department to company', 'no', NULL, NULL),
(105, 'Remove Department from company', 'no', NULL, NULL),
(106, 'Add Unit', 'yes', NULL, NULL),
(107, 'Edit Unit', 'yes', NULL, NULL),
(108, 'Show Unit', 'yes', NULL, NULL),
(109, 'Delete Unit', 'yes', NULL, NULL),
(110, 'Assign Unit to Department', 'yes', NULL, NULL),
(111, 'Remove Unit from Department', 'yes', NULL, NULL),
(112, 'Assign Unit to Workspace', 'yes', NULL, NULL),
(113, 'Remove Unit from workspace', 'yes', NULL, NULL),
(114, 'Index Department', 'yes', NULL, NULL),
(115, 'Index Unit', 'yes', NULL, NULL),
(116, 'Assign User to Department', 'yes', NULL, NULL),
(117, 'Assign User to Unit', 'yes', NULL, NULL),
(118, 'Assign User to Section', 'yes', NULL, NULL),
(119, 'Remove User From Department', 'yes', NULL, NULL),
(120, 'Remove User From Unit', 'yes', NULL, NULL),
(121, 'Remove User From Section', 'yes', NULL, NULL),
(122, 'Add Process', 'yes', NULL, NULL),
(123, 'Edit Process', 'yes', NULL, NULL),
(124, 'Show Process', 'yes', NULL, NULL),
(125, 'Delete Process', 'yes', NULL, NULL),
(126, 'Index Process', 'yes', NULL, NULL),
(127, 'Assign Process To Task', 'yes', NULL, NULL),
(128, 'Remove Process From Task', 'yes', NULL, NULL),
(129, 'Assign Process To ProcessType', 'yes', NULL, NULL),
(130, 'Remove Process From ProcessType', 'yes', NULL, NULL),
(131, 'Add ProcessType', 'no', NULL, NULL),
(132, 'Edit ProcessType', 'no', NULL, NULL),
(133, 'Show ProcessType', 'no', NULL, NULL),
(134, 'Delete ProcessType', 'no', NULL, NULL),
(135, 'Index ProcessType', 'no', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(7, 'App\\Models\\User', 3, 'myapptoken', '946cc06dfa1e9eeb071cd381f92cb163dacad8170cf39a658f55e3193dce01fe', '[\"*\"]', '2021-05-18 13:25:01', '2021-05-18 12:52:29', '2021-05-18 13:25:01'),
(9, 'App\\Models\\User', 4, 'myapptoken', '8702081f8549a0dc9fcd60d09caa081bdbb5a9eb1825f679ddc5c7768d7bc6d7', '[\"*\"]', NULL, '2021-05-21 20:52:46', '2021-05-21 20:52:46'),
(10, 'App\\Models\\User', 5, 'myapptoken', 'd52f60c502f191402f16c23846ecbb549a7daef9b5ac7bff8e207455e681cbf3', '[\"*\"]', NULL, '2021-05-21 20:55:38', '2021-05-21 20:55:38'),
(11, 'App\\Models\\User', 6, 'myapptoken', '8b8922e419a7ed06c11dfa972c98f1accd90aa4aea9bd1bf0f078785cad21f3b', '[\"*\"]', NULL, '2021-05-21 20:56:11', '2021-05-21 20:56:11'),
(12, 'App\\Models\\User', 7, 'myapptoken', 'ec287b3dbac4e9d19a90c517efbef432b7e0479cb543cbf35d8c55f381077ee5', '[\"*\"]', NULL, '2021-05-21 20:57:48', '2021-05-21 20:57:48'),
(13, 'App\\Models\\User', 8, 'myapptoken', 'bfb954f9da2a4be3e889e9cf2649f20706bf28b0352e02bfaa0724bf290d943f', '[\"*\"]', NULL, '2021-05-21 20:58:23', '2021-05-21 20:58:23'),
(14, 'App\\Models\\User', 9, 'myapptoken', 'b2f67dfdc95550512ebffeb25a6619719027064ee6c2129ac2c25b7b7c01c175', '[\"*\"]', NULL, '2021-05-21 20:59:10', '2021-05-21 20:59:10'),
(16, 'App\\Models\\User', 11, 'myapptoken', '25b895380e85eb74c256ae5abbd60ff6c2404d21a222442c06212ec47fd3da6a', '[\"*\"]', NULL, '2021-05-21 21:00:34', '2021-05-21 21:00:34'),
(17, 'App\\Models\\User', 12, 'myapptoken', '2e88d1f92c22fdb8440ae51a3007e20bbf410c2e0cbbc48c7847a32282ebd9e2', '[\"*\"]', NULL, '2021-05-21 21:00:58', '2021-05-21 21:00:58'),
(18, 'App\\Models\\User', 13, 'myapptoken', '7f498a334e7b9b35a358b932346f208a3f88aa13503566dbcf3644c76125d98d', '[\"*\"]', NULL, '2021-05-21 21:02:56', '2021-05-21 21:02:56'),
(19, 'App\\Models\\User', 14, 'myapptoken', 'a0f1d1d681b5fa54cd68ddc0e9a5109b89332e052ed94dbe2e8a8586ce6780bc', '[\"*\"]', NULL, '2021-05-21 21:04:42', '2021-05-21 21:04:42'),
(20, 'App\\Models\\User', 15, 'myapptoken', 'eafb3c71a5f7d347fea90369353392ed714bade3437fd737af0fcfef06134422', '[\"*\"]', '2021-05-21 21:38:37', '2021-05-21 21:10:23', '2021-05-21 21:38:37'),
(28, 'App\\Models\\User', 2, 'myapptoken', 'b201d6317aaf95d47b5aea8d703d35d3960bdd9d1b534dcfa5e538a10a81dce1', '[\"*\"]', '2021-06-16 12:19:09', '2021-06-12 14:24:18', '2021-06-16 12:19:09'),
(29, 'App\\Models\\User', 3, 'myapptoken', '53d5e38acbb5fc1f3b58ebf8a51334dfbd96d7732eb2c83a8263f00a1c513847', '[\"*\"]', NULL, '2021-06-14 15:11:19', '2021-06-14 15:11:19'),
(30, 'App\\Models\\User', 4, 'myapptoken', '6d650a3f0690ebc4fef70bc907cf77dfb2a286854449990c6120f0c1a6b269ce', '[\"*\"]', NULL, '2021-06-14 15:12:05', '2021-06-14 15:12:05'),
(31, 'App\\Models\\User', 5, 'myapptoken', '47c307e96a7e39ebece29781a8cebf73267708c487e076d4e111d1dbd10b584d', '[\"*\"]', NULL, '2021-06-14 15:12:52', '2021-06-14 15:12:52'),
(32, 'App\\Models\\User', 6, 'myapptoken', '0bab37ae66fe01e14d2ffbcfde878333e94d88989c2c493666a64e6c43c87eab', '[\"*\"]', NULL, '2021-06-14 15:13:05', '2021-06-14 15:13:05'),
(33, 'App\\Models\\User', 7, 'myapptoken', '0c3fb15ec36bed346b8589d0bff00cd0b8104ec2ff3395e5aa2dedf14a623d12', '[\"*\"]', NULL, '2021-06-14 15:13:38', '2021-06-14 15:13:38'),
(34, 'App\\Models\\User', 8, 'myapptoken', '4c6ff1bfea93bbb2c8d7dd8715b09551c77b09128950bb1eba8a5dc8396f5766', '[\"*\"]', NULL, '2021-06-14 15:13:48', '2021-06-14 15:13:48'),
(35, 'App\\Models\\User', 9, 'myapptoken', '0f073030ed415270ec8376c5c447448ac35054c404965c2b28a8ce653d0d79bb', '[\"*\"]', NULL, '2021-06-14 15:13:56', '2021-06-14 15:13:56'),
(37, 'App\\Models\\User', 11, 'myapptoken', '1170ace582f32c18f0aa4fcbedf78ae5666c67a4153871e981c1f4ec84208393', '[\"*\"]', NULL, '2021-06-14 15:14:45', '2021-06-14 15:14:45'),
(38, 'App\\Models\\User', 12, 'myapptoken', 'a556d68f8b77a788679fd4d9ae67c3eb3dbbbba2b81bef38e23e71f49d5a9fed', '[\"*\"]', NULL, '2021-06-14 15:14:56', '2021-06-14 15:14:56'),
(39, 'App\\Models\\User', 13, 'myapptoken', '68fb939a44a4fba7f58b4bfbe99710f03b5a98f3160f2c79a7c3e23ff1d8b2ac', '[\"*\"]', NULL, '2021-06-14 15:15:03', '2021-06-14 15:15:03'),
(40, 'App\\Models\\User', 14, 'myapptoken', '144b0630e9eb2c8b72b2f860cfe9e78ac6a9459321d123fca152077db8b59dfe', '[\"*\"]', NULL, '2021-06-14 15:15:11', '2021-06-14 15:15:11'),
(41, 'App\\Models\\User', 15, 'myapptoken', 'aa5be1828e3a016a222343efd0e6348a6f1ed9a16a860d6ac27a52a2fd6ff903', '[\"*\"]', NULL, '2021-06-14 15:15:21', '2021-06-14 15:15:21'),
(42, 'App\\Models\\User', 16, 'myapptoken', '318bf668b9b390dc79c2bd5c532efdd4eb21f6b15fbc5611021b347e13b1be70', '[\"*\"]', NULL, '2021-06-14 15:15:30', '2021-06-14 15:15:30'),
(43, 'App\\Models\\User', 17, 'myapptoken', 'f17f7d235025dbeef52f475db39e9cf27e9695d8910efd0406e84fce91eb4c05', '[\"*\"]', NULL, '2021-06-14 15:15:39', '2021-06-14 15:15:39'),
(44, 'App\\Models\\User', 18, 'myapptoken', 'ca57db55c35df1ed4054323e59e9e07269c588500980e497c78cb480bff53c10', '[\"*\"]', NULL, '2021-06-14 15:15:50', '2021-06-14 15:15:50'),
(45, 'App\\Models\\User', 19, 'myapptoken', 'dc1781ba76fb1094f920c15151ade3b1a99f6f0dff263b109b63a1f4971ae9b8', '[\"*\"]', NULL, '2021-06-14 15:16:37', '2021-06-14 15:16:37'),
(46, 'App\\Models\\User', 20, 'myapptoken', '70f85ce5b3a43c881aaaeec2764b51a63cb7b6b27e351e180733761e03497fd8', '[\"*\"]', NULL, '2021-06-14 15:16:46', '2021-06-14 15:16:46'),
(47, 'App\\Models\\User', 21, 'myapptoken', '9408fbbcdd4152e0735d32b14da28baffd5c7eb959b5335230ee20313a162312', '[\"*\"]', NULL, '2021-06-14 15:16:55', '2021-06-14 15:16:55'),
(48, 'App\\Models\\User', 22, 'myapptoken', '1a73ce9423058f53b5b5c146cc3d3ec596c7d7d5fd4c95a77dcd46dc5ca98612', '[\"*\"]', NULL, '2021-06-14 15:17:03', '2021-06-14 15:17:03'),
(49, 'App\\Models\\User', 23, 'myapptoken', '016b1a59911988f6fd7cffcdb8a76a1640e099d2ad549759eaa175ab58df179e', '[\"*\"]', NULL, '2021-06-14 15:17:11', '2021-06-14 15:17:11'),
(50, 'App\\Models\\User', 24, 'myapptoken', '6e7dc79b9a41d522aad477b014e5a3f085f66ecb6058b4a606eb29e0453593d0', '[\"*\"]', NULL, '2021-06-14 15:17:28', '2021-06-14 15:17:28'),
(51, 'App\\Models\\User', 25, 'myapptoken', '4f59ec7a8b71e706c29d5969f8797d7cd74ccd3888cf5a4818a47a0194d36812', '[\"*\"]', NULL, '2021-06-14 15:17:35', '2021-06-14 15:17:35'),
(52, 'App\\Models\\User', 26, 'myapptoken', '60dbafa2ef9be809f5d0dc6f97d6b908185ed5d283cd2da716cff4f9ebf01ac4', '[\"*\"]', NULL, '2021-06-14 15:17:43', '2021-06-14 15:17:43'),
(53, 'App\\Models\\User', 27, 'myapptoken', 'a34ac55e148c878dbbffa32589e2b8fd242ed592845bb5aae33fc834bb930755', '[\"*\"]', NULL, '2021-06-14 15:17:51', '2021-06-14 15:17:51'),
(54, 'App\\Models\\User', 28, 'myapptoken', 'd23f97ca7205b9748d783949ebf2dc6f0a210280896366195b6e6b907de5c3f4', '[\"*\"]', NULL, '2021-06-14 15:17:59', '2021-06-14 15:17:59'),
(55, 'App\\Models\\User', 29, 'myapptoken', 'ed31d51c92840f9189a7c03e985ca94291d3a72bf747264763353adefc0a3e61', '[\"*\"]', NULL, '2021-06-14 15:18:09', '2021-06-14 15:18:09'),
(56, 'App\\Models\\User', 30, 'myapptoken', 'fec387c2a61da1e91ec01c5b2191aceacb33d7c506632c24199deb7579d8ca52', '[\"*\"]', NULL, '2021-06-14 15:18:16', '2021-06-14 15:18:16'),
(57, 'App\\Models\\User', 31, 'myapptoken', 'e17518dbec6d2bc38be81257d056199d93a54b998275dc4deca054eca12a1e98', '[\"*\"]', NULL, '2021-06-14 15:18:24', '2021-06-14 15:18:24'),
(58, 'App\\Models\\User', 32, 'myapptoken', '1dbb69b9575ee476e7669fdba3cd9cbbaee762397291027aa8233d0ec0f5abec', '[\"*\"]', NULL, '2021-06-14 15:18:32', '2021-06-14 15:18:32'),
(59, 'App\\Models\\User', 33, 'myapptoken', '016b943bec03868a6df2688a7b1a72e1b279eb12877026d0d3644b995b5d2058', '[\"*\"]', NULL, '2021-06-14 15:18:42', '2021-06-14 15:18:42'),
(60, 'App\\Models\\User', 34, 'myapptoken', '7b28faa2db1bede7ecbf31361c81735c14454000bc35b7c6b3bcd05b931c8c29', '[\"*\"]', NULL, '2021-06-14 15:18:50', '2021-06-14 15:18:50'),
(61, 'App\\Models\\User', 2, 'myapptoken', 'c7475bf17fff12b645c5ad8b7e70b780da1248f4cbb4e869d610b58d97259309', '[\"*\"]', '2021-06-15 15:28:17', '2021-06-14 15:50:37', '2021-06-15 15:28:17'),
(65, 'App\\Models\\User', 2, 'myapptoken', '80f6c90fd58ed6825f64eeb61f803ce9f6819df0bbf67553eb428f86935b01f4', '[\"*\"]', '2021-06-17 10:18:48', '2021-06-16 11:32:01', '2021-06-17 10:18:48'),
(66, 'App\\Models\\User', 2, 'myapptoken', '02db37e2c381d5651296ed4e4e6272e2115f1afd663180e51f1758a48a8123ba', '[\"*\"]', '2021-07-07 08:19:39', '2021-07-02 11:41:44', '2021-07-07 08:19:39'),
(67, 'App\\Models\\User', 1, 'myapptoken', '2080a2297bc969ebe62e14b7607bccf805ff4c3360f9d1da39ae7d4369726fff', '[\"*\"]', '2021-07-07 08:08:51', '2021-07-02 11:45:36', '2021-07-07 08:08:51'),
(68, 'App\\Models\\User', 7, 'myapptoken', '256f10980c7841bba2515302c09bac08bdc5fa10fdf7ee95a935b9c1aaf7279e', '[\"*\"]', '2021-07-02 14:58:40', '2021-07-02 11:47:51', '2021-07-02 14:58:40'),
(69, 'App\\Models\\User', 10, 'myapptoken', '7007fa822f7044d33bc778e0f505491a9aad2fea8f101f07a802f8eb2acad0ab', '[\"*\"]', '2021-07-02 11:50:47', '2021-07-02 11:49:52', '2021-07-02 11:50:47'),
(70, 'App\\Models\\User', 11, 'myapptoken', 'f29e380869de604e5fac29358d9194b4c22b06ae172fa33518b6f3ff80dd9c28', '[\"*\"]', '2021-07-02 22:06:52', '2021-07-02 12:33:01', '2021-07-02 22:06:52'),
(71, 'App\\Models\\User', 21, 'myapptoken', '5dd7881b858aea7c9f5ddfdd981d3537a62b5fc8afef05310d0084b7f974dfc2', '[\"*\"]', '2021-08-26 03:24:23', '2021-07-02 15:00:17', '2021-08-26 03:24:23'),
(72, 'App\\Models\\User', 21, 'myapptoken', '4b6878345debe34416304cdba5b3962bbc759c557c30f86abfb26c3f52f7654e', '[\"*\"]', '2021-07-02 16:18:10', '2021-07-02 16:17:19', '2021-07-02 16:18:10'),
(73, 'App\\Models\\User', 3, 'myapptoken', '6a9ba87d9563966531c7b0fd8e369915099b7bcf925894525d504ddd52a90afa', '[\"*\"]', '2021-07-06 09:47:20', '2021-07-06 09:46:42', '2021-07-06 09:47:20'),
(74, 'App\\Models\\User', 7, 'myapptoken', '7759509f76ee5bc048281d9b633f14fb92b5a0b18d74f32f8daf8ddb4adf850b', '[\"*\"]', '2021-07-07 08:23:26', '2021-07-06 10:00:54', '2021-07-07 08:23:26'),
(75, 'App\\Models\\User', 19, 'myapptoken', 'a1d0ec29fa6d1aa7a4767ddc8861af879af3063e8d50b1d0ebf2d1efe0f239c6', '[\"*\"]', '2021-07-06 13:25:21', '2021-07-06 13:11:41', '2021-07-06 13:25:21'),
(76, 'App\\Models\\User', 1, 'myapptoken', 'c6b2a1ee3bb35f5045fe36442a6b86ca2cceb8da7c0bbe3dfd031302d2026451', '[\"*\"]', '2021-07-30 15:34:01', '2021-07-30 15:25:10', '2021-07-30 15:34:01'),
(77, 'App\\Models\\User', 3, 'myapptoken', '940d8bae5ceac2d894c28c3301b80167364dc2e3074f2639a65646351c5920e4', '[\"*\"]', '2021-08-26 01:03:37', '2021-07-30 15:35:15', '2021-08-26 01:03:37'),
(78, 'App\\Models\\User', 2, 'myapptoken', 'd4ecf457c7f9c454337923cf8ae1ca7a2d69daf335d5532dbaf698548407cf7e', '[\"*\"]', '2021-08-20 13:31:36', '2021-07-30 16:55:55', '2021-08-20 13:31:36'),
(79, 'App\\Models\\User', 2, 'myapptoken', '19d42ddf660bc5a8c9b844c62541b1083b19db7a985a18430720f612149f0fe5', '[\"*\"]', NULL, '2021-08-20 12:10:30', '2021-08-20 12:10:30'),
(80, 'App\\Models\\User', 2, 'myapptoken', '1f2f5c2404585d613e3597dcb9be11e64556209eb1812567b6a08c19a325d943', '[\"*\"]', NULL, '2021-08-20 12:12:21', '2021-08-20 12:12:21'),
(81, 'App\\Models\\User', 2, 'myapptoken', '54751a57e4dd624c3ec15dd28a862094019250af54e3f5cd1b8ecd06489051b0', '[\"*\"]', '2021-08-20 16:48:01', '2021-08-20 13:56:51', '2021-08-20 16:48:01'),
(82, 'App\\Models\\User', 1, 'myapptoken', '27e82f1e05927529f1a227176630586ae34d35bfd8126c130c0c9f82e55915c2', '[\"*\"]', '2021-08-20 16:10:31', '2021-08-20 14:03:15', '2021-08-20 16:10:31'),
(83, 'App\\Models\\User', 1, 'myapptoken', 'c10d69634c186482044490552bfa670002a07569671340a6dcf4ffb6b4c968e0', '[\"*\"]', '2021-08-24 21:31:57', '2021-08-22 20:59:28', '2021-08-24 21:31:57'),
(84, 'App\\Models\\User', 5, 'myapptoken', '75464e591d6cd07cf008bad224ac3f0e7273b3b8b025f5b5943feb1fa9733ba8', '[\"*\"]', '2021-08-23 17:30:39', '2021-08-23 17:29:47', '2021-08-23 17:30:39'),
(85, 'App\\Models\\User', 7, 'myapptoken', '9c0dcb5cdcce52a1dc97cae32d608fe2a143cf2a286a3daabc3487e2ac4c1f70', '[\"*\"]', '2021-08-23 17:50:42', '2021-08-23 17:31:14', '2021-08-23 17:50:42'),
(86, 'App\\Models\\User', 1, 'myapptoken', 'f8e7e304657cc74f8744ce90456a56b7eb4011897ba4717dc25b88ed760742ef', '[\"*\"]', '2021-08-24 22:41:06', '2021-08-24 21:48:46', '2021-08-24 22:41:06'),
(87, 'App\\Models\\User', 1, 'myapptoken', '7ddb9e73b7fe5e888c66449dfb762116ce95246bbac3dc7d6659afa8890b6dd4', '[\"*\"]', '2021-08-25 12:51:59', '2021-08-24 22:02:28', '2021-08-25 12:51:59'),
(88, 'App\\Models\\User', 1, 'myapptoken', '5739b62ee0aada365840e83231db4dee273ba34448df42e6753efeed5f83b99f', '[\"*\"]', '2021-08-25 00:56:55', '2021-08-24 22:50:06', '2021-08-25 00:56:55'),
(89, 'App\\Models\\User', 1, 'myapptoken', '69233fd13ef17fb41626231d5da24440b3ee7c7e17c97862463ea1f39754ed21', '[\"*\"]', '2021-08-24 22:57:12', '2021-08-24 22:52:26', '2021-08-24 22:57:12'),
(90, 'App\\Models\\User', 1, 'myapptoken', '5f01f9a8a9f3efbc85560d4f5f23bb64a956c3860311ea9c02cf05d642e0e74c', '[\"*\"]', '2021-08-24 22:58:28', '2021-08-24 22:57:38', '2021-08-24 22:58:28'),
(91, 'App\\Models\\User', 1, 'myapptoken', '1a4136e99ffd57d9b1079f751f3ef965bb17976280bf8a271ccb512171b3a43f', '[\"*\"]', '2021-08-24 23:04:09', '2021-08-24 22:58:42', '2021-08-24 23:04:09'),
(92, 'App\\Models\\User', 1, 'myapptoken', '30bb5a60c0bcb7b936f8548113705bb5b9961b22b5baf90bde4f53d4e479ab39', '[\"*\"]', '2021-08-24 23:06:32', '2021-08-24 23:06:28', '2021-08-24 23:06:32'),
(93, 'App\\Models\\User', 1, 'myapptoken', 'acb2f7ab900757bb4e701d1f445e8e09020e201875ee6e6f99c25967ccaf695b', '[\"*\"]', '2021-08-24 23:18:20', '2021-08-24 23:08:18', '2021-08-24 23:18:20'),
(94, 'App\\Models\\User', 1, 'myapptoken', '9aad49b2a06ead8c7760e17fde4b7431d0eb3bcec7ba5f728bf47c531807f2d0', '[\"*\"]', '2021-08-25 00:19:05', '2021-08-25 00:06:36', '2021-08-25 00:19:05'),
(95, 'App\\Models\\User', 1, 'myapptoken', '05c4df9ce272e183e24f5acebe7187bf5bdce0072bd1e2151882cc8a3e9e7085', '[\"*\"]', '2021-08-25 17:38:14', '2021-08-25 00:30:15', '2021-08-25 17:38:14'),
(96, 'App\\Models\\User', 1, 'myapptoken', 'b813195834e46cb3788ce1a7965bf2eab92122f8571777cfbd8253f9682c48cd', '[\"*\"]', '2021-08-25 02:00:48', '2021-08-25 00:30:53', '2021-08-25 02:00:48'),
(97, 'App\\Models\\User', 1, 'myapptoken', '46c5947e3083fc3e311afae9f4c123c3b8da6ac3cde0cd424d08c76eea6fa18f', '[\"*\"]', NULL, '2021-08-25 12:22:21', '2021-08-25 12:22:21'),
(98, 'App\\Models\\User', 1, 'myapptoken', 'd597ab7e21287aaa8c7ee2ced5f8bcd10fb52440231a8ce8599ab7080c50027f', '[\"*\"]', '2021-08-26 11:27:00', '2021-08-25 12:22:48', '2021-08-26 11:27:00'),
(99, 'App\\Models\\User', 1, 'myapptoken', 'c69d97bbc4559e8c124553733db4417b840c623f53a7207c561397cbccff11f7', '[\"*\"]', '2021-08-26 12:36:07', '2021-08-25 22:30:48', '2021-08-26 12:36:07'),
(100, 'App\\Models\\User', 1, 'myapptoken', 'eb2078ac7c77cba7f1efc5c6baf9e66ef2a0b30ef22482aa5e28f635bec3c6f2', '[\"*\"]', '2021-08-26 09:24:59', '2021-08-26 05:48:52', '2021-08-26 09:24:59'),
(101, 'App\\Models\\User', 1, 'myapptoken', '10b3fe6e7c7640a70755f0b3c4c4d7f3f999db7dee04bf73bb629b79456b2d32', '[\"*\"]', '2021-08-27 00:43:10', '2021-08-26 12:53:18', '2021-08-27 00:43:10');

-- --------------------------------------------------------

--
-- Table structure for table `processes`
--

CREATE TABLE `processes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `taskid` int(11) DEFAULT NULL,
  `ticketid` int(11) DEFAULT NULL,
  `typeid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isactive` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `processes`
--

INSERT INTO `processes` (`id`, `taskid`, `ticketid`, `typeid`, `userid`, `priority`, `status`, `description`, `isactive`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 2, 2, 1, 'Approved', NULL, 'active', '2021-07-30 15:37:50', '2021-07-30 21:12:35'),
(2, 2, NULL, 3, 1, 0, 'Confirmed', NULL, 'active', '2021-07-30 15:37:50', '2021-08-26 03:22:07'),
(5, 2, NULL, 2, 1, 1, 'Approved', NULL, 'active', '2021-07-30 21:12:35', '2021-08-26 03:21:16'),
(6, 3, NULL, 3, 1, 1, 'Pending Confirm', NULL, 'active', '2021-08-20 16:25:09', '2021-08-20 16:25:09'),
(7, 2, NULL, 2, 1, 1, 'Pending Approve', NULL, 'active', '2021-08-20 16:30:24', '2021-08-20 16:30:24'),
(8, 2, 2, 2, 1, 1, 'Pending Review', NULL, 'active', '2021-08-26 01:03:37', '2021-08-26 03:14:03');

-- --------------------------------------------------------

--
-- Table structure for table `process_types`
--

CREATE TABLE `process_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `process_types`
--

INSERT INTO `process_types` (`id`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'pending', '', NULL, NULL),
(2, 'Approve', '', NULL, NULL),
(3, 'Recivied confirm', '', NULL, NULL),
(4, 'Review', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT 'No Label',
  `createdby` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `startdate` datetime NOT NULL,
  `enddate` datetime DEFAULT NULL,
  `workspaceid` int(11) NOT NULL,
  `pmid` int(11) NOT NULL,
  `isactive` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nonactive',
  `updatingfor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isdeleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `label`, `createdby`, `status`, `startdate`, `enddate`, `workspaceid`, `pmid`, `isactive`, `updatingfor`, `isdeleted`, `created_at`, `updated_at`) VALUES
(1, 'Project 01', NULL, 'No Label', 3, 'new', '2021-06-14 06:13:16', NULL, 1, 4, 'active', NULL, NULL, NULL, NULL),
(2, 'Project 02', NULL, 'No Label', 3, 'new', '2021-06-14 06:13:16', NULL, 1, 4, 'active', NULL, NULL, NULL, NULL),
(3, 'Project 03', NULL, 'No Label', 3, 'new', '2021-06-14 06:13:16', NULL, 2, 4, 'active', NULL, NULL, NULL, NULL),
(4, 'Project 04', NULL, 'No Label', 3, 'new', '2021-06-14 06:13:16', NULL, 2, 4, 'active', NULL, NULL, NULL, NULL),
(10, 'Project 05', NULL, 'No Label', 1, 'new', '2021-06-19 14:47:56', NULL, 37, 1, 'active', NULL, '1', '2021-08-24 22:04:24', '2021-08-26 00:05:17'),
(19, 'Project 10', NULL, 'No Label', 1, 'new', '2021-06-19 14:47:56', NULL, 37, 1, 'nonactive', NULL, NULL, '2021-08-25 12:42:33', '2021-08-25 12:42:33'),
(21, 'Address Line 1', 'QQQ', NULL, 1, 'new', '2021-08-24 00:00:00', '2021-08-26 00:00:00', 37, 1, 'nonactive', '10', NULL, '2021-08-25 17:25:46', '2021-08-25 17:25:46'),
(22, 'Project 12', NULL, 'No Label', 1, 'new', '2021-06-19 14:47:56', NULL, 37, 1, 'nonactive', NULL, NULL, '2021-08-25 17:38:14', '2021-08-25 17:38:14'),
(23, 'a', 'sdd', 'New', 1, 'new', '2021-08-25 00:00:00', '2021-08-23 00:00:00', 37, 1, 'active', NULL, '1', '2021-08-25 17:45:41', '2021-08-25 18:54:57'),
(25, 'ghujiop', 'yuiop', 'Canceled', 1, 'new', '2021-08-13 00:00:00', '2021-08-23 00:00:00', 37, 1, 'nonactive', NULL, NULL, '2021-08-26 13:13:06', '2021-08-26 13:13:06'),
(26, 'ghujiop', 'yuiop', 'Canceled', 1, 'new', '2021-08-13 00:00:00', '2021-08-23 00:00:00', 37, 1, 'nonactive', NULL, NULL, '2021-08-26 13:13:09', '2021-08-26 13:13:09'),
(27, 'ghujiop', 'yuiop', 'Canceled', 1, 'new', '2021-08-13 00:00:00', '2021-08-23 00:00:00', 37, 1, 'nonactive', NULL, NULL, '2021-08-26 13:13:10', '2021-08-26 13:13:10'),
(28, 'ghujiop', 'yuiop', 'Canceled', 1, 'new', '2021-08-13 00:00:00', '2021-08-23 00:00:00', 37, 1, 'nonactive', NULL, NULL, '2021-08-26 13:13:12', '2021-08-26 13:13:12'),
(29, 'ghujiop', 'yuiop', 'Canceled', 1, 'new', '2021-08-13 00:00:00', '2021-08-23 00:00:00', 37, 1, 'nonactive', NULL, NULL, '2021-08-26 13:13:13', '2021-08-26 13:13:13'),
(30, 'ghujiop', 'yuiop', 'Canceled', 1, 'new', '2021-08-13 00:00:00', '2021-08-23 00:00:00', 37, 1, 'nonactive', NULL, NULL, '2021-08-26 13:13:14', '2021-08-26 13:13:14'),
(31, 'ghujiop', 'yuiop', 'Canceled', 1, 'new', '2021-08-13 00:00:00', '2021-08-23 00:00:00', 37, 1, 'nonactive', NULL, NULL, '2021-08-26 13:13:14', '2021-08-26 13:13:14'),
(32, 'ghujiop', 'yuiop', 'Canceled', 1, 'new', '2021-08-13 00:00:00', '2021-08-23 00:00:00', 37, 1, 'nonactive', NULL, NULL, '2021-08-26 13:13:15', '2021-08-26 13:13:15'),
(33, 'ghujiop', 'yuiop', 'Canceled', 1, 'new', '2021-08-13 00:00:00', '2021-08-23 00:00:00', 37, 1, 'nonactive', NULL, NULL, '2021-08-26 13:13:15', '2021-08-26 13:13:15'),
(34, 'ghujiop', 'yuiop', 'Canceled', 1, 'new', '2021-08-13 00:00:00', '2021-08-23 00:00:00', 37, 1, 'nonactive', NULL, NULL, '2021-08-26 13:13:20', '2021-08-26 13:13:20'),
(35, 'rbfdf', 'dsdfgfd', 'New', 1, 'new', '2021-08-19 00:00:00', '2021-08-31 00:00:00', 37, 1, 'nonactive', NULL, NULL, '2021-08-26 13:14:37', '2021-08-26 13:14:37');

-- --------------------------------------------------------

--
-- Table structure for table `project_department_unit_section_users`
--

CREATE TABLE `project_department_unit_section_users` (
  `projectid` int(11) NOT NULL,
  `departmentid` int(11) DEFAULT NULL,
  `unitid` int(11) DEFAULT NULL,
  `sectionid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_department_unit_section_users`
--

INSERT INTO `project_department_unit_section_users` (`projectid`, `departmentid`, `unitid`, `sectionid`, `userid`, `created_at`, `updated_at`) VALUES
(8, NULL, NULL, NULL, 1, '2021-08-24 01:45:14', '2021-08-24 01:45:14'),
(9, NULL, NULL, NULL, 1, '2021-08-24 21:30:45', '2021-08-24 21:30:45'),
(10, NULL, NULL, NULL, 1, '2021-08-24 22:04:24', '2021-08-24 22:04:24'),
(11, NULL, NULL, NULL, 1, '2021-08-25 01:53:39', '2021-08-25 01:53:39'),
(15, NULL, NULL, NULL, 1, '2021-08-25 02:27:05', '2021-08-25 02:27:05'),
(19, NULL, NULL, NULL, 1, '2021-08-25 12:42:33', '2021-08-25 12:42:33'),
(22, NULL, NULL, NULL, 1, '2021-08-25 17:38:14', '2021-08-25 17:38:14'),
(23, NULL, NULL, NULL, 1, '2021-08-25 17:45:41', '2021-08-25 17:45:41'),
(25, NULL, NULL, NULL, 1, '2021-08-26 13:13:06', '2021-08-26 13:13:06'),
(26, NULL, NULL, NULL, 1, '2021-08-26 13:13:09', '2021-08-26 13:13:09'),
(27, NULL, NULL, NULL, 1, '2021-08-26 13:13:10', '2021-08-26 13:13:10'),
(28, NULL, NULL, NULL, 1, '2021-08-26 13:13:12', '2021-08-26 13:13:12'),
(29, NULL, NULL, NULL, 1, '2021-08-26 13:13:13', '2021-08-26 13:13:13'),
(30, NULL, NULL, NULL, 1, '2021-08-26 13:13:14', '2021-08-26 13:13:14'),
(31, NULL, NULL, NULL, 1, '2021-08-26 13:13:14', '2021-08-26 13:13:14'),
(32, NULL, NULL, NULL, 1, '2021-08-26 13:13:15', '2021-08-26 13:13:15'),
(33, NULL, NULL, NULL, 1, '2021-08-26 13:13:15', '2021-08-26 13:13:15'),
(34, NULL, NULL, NULL, 1, '2021-08-26 13:13:20', '2021-08-26 13:13:20'),
(35, NULL, NULL, NULL, 1, '2021-08-26 13:14:37', '2021-08-26 13:14:37');

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_groups`
--

CREATE TABLE `role_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adjictive` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_groups`
--

INSERT INTO `role_groups` (`id`, `adjictive`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', NULL, NULL),
(2, 'Super Admin', NULL, NULL),
(3, 'Admin', NULL, NULL),
(4, 'User', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_group_companies`
--

CREATE TABLE `role_group_companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adjictive` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_group_companies`
--

INSERT INTO `role_group_companies` (`id`, `adjictive`, `created_at`, `updated_at`) VALUES
(1, 'Company Owner', NULL, NULL),
(2, 'CEO', NULL, NULL),
(3, 'Manager', NULL, NULL),
(4, 'Project Manager', NULL, NULL),
(5, 'Director (Department Manager)', NULL, NULL),
(6, 'Head Of Unit(HOU)', NULL, NULL),
(7, 'Head Of Section(HOS)', NULL, NULL),
(8, 'Employee', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_group_company_permissions`
--

CREATE TABLE `role_group_company_permissions` (
  `rolegroupcompanyid` int(11) NOT NULL,
  `permissionid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_group_company_permissions`
--

INSERT INTO `role_group_company_permissions` (`rolegroupcompanyid`, `permissionid`, `created_at`, `updated_at`) VALUES
(7, 7, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 8, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 9, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 10, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 11, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 13, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 14, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 15, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 16, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 17, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 18, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 22, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 23, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 24, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 25, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 26, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 27, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 28, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 29, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 30, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 31, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 32, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 33, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 34, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 35, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 36, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 37, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 38, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 39, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 40, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 41, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 42, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 43, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 44, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 45, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 46, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 47, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 48, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 49, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 50, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 53, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 54, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 55, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 56, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 57, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 58, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 61, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 62, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 63, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 64, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 67, '2021-05-21 20:50:38', '2021-05-21 20:50:38'),
(7, 68, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 69, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 73, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 74, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 75, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 76, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 79, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 80, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 81, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 82, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 86, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 87, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 88, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 89, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 90, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 91, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 92, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 93, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 94, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 95, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 96, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 97, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 98, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 99, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 100, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 101, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 102, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 103, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 106, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 107, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 108, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 109, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 110, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 111, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 112, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 113, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 114, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 115, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 116, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 117, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 118, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 119, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 120, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 121, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 122, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 123, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 124, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 125, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 126, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 127, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 128, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 129, '2021-05-21 20:50:39', '2021-05-21 20:50:39'),
(7, 130, '2021-05-21 20:50:39', '2021-05-21 20:50:39');

-- --------------------------------------------------------

--
-- Table structure for table `role_group_permissions`
--

CREATE TABLE `role_group_permissions` (
  `rolegroupid` int(11) NOT NULL,
  `permissionid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_group_permissions`
--

INSERT INTO `role_group_permissions` (`rolegroupid`, `permissionid`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 2, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 3, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 4, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 5, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 6, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 7, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 8, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 9, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 10, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 11, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 12, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 13, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 14, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 15, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 16, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 17, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 18, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 19, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 20, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 21, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 22, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 23, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 24, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 25, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 26, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 27, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 28, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 29, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 30, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 31, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 32, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 33, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 34, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 35, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 36, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 37, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 38, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 39, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 40, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 41, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 42, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 43, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 44, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 45, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 46, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 47, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 48, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 49, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 50, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 53, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 54, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 55, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 56, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 57, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 58, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 61, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 62, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 63, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 64, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 65, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 66, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 67, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 68, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 69, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 70, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 71, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 72, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 73, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 74, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 75, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 76, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 77, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 78, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 79, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 80, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 81, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 82, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 83, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 84, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 85, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 86, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 87, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 88, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 89, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 90, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 91, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 92, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 93, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 94, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 95, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 96, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 97, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 98, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 99, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 100, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 101, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 102, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 103, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 104, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 105, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 106, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 107, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 108, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 109, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 110, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 111, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 112, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 113, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 114, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 115, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 116, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 117, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 118, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 119, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 120, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 121, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 122, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 123, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 124, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 125, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 126, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 127, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 128, '2021-05-21 20:47:07', '2021-05-21 20:47:07'),
(1, 129, '2021-05-21 20:47:08', '2021-05-21 20:47:08'),
(1, 130, '2021-05-21 20:47:08', '2021-05-21 20:47:08'),
(1, 131, '2021-05-21 20:47:08', '2021-05-21 20:47:08'),
(1, 132, '2021-05-21 20:47:08', '2021-05-21 20:47:08'),
(1, 133, '2021-05-21 20:47:08', '2021-05-21 20:47:08'),
(1, 134, '2021-05-21 20:47:08', '2021-05-21 20:47:08'),
(1, 135, '2021-05-21 20:47:08', '2021-05-21 20:47:08'),
(5, 23, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unitid` int(11) NOT NULL,
  `hos` int(11) NOT NULL,
  `isactive` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nonactive',
  `updatingfor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isdeleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `description`, `unitid`, `hos`, `isactive`, `updatingfor`, `isdeleted`, `created_at`, `updated_at`) VALUES
(1, 'Section 01', NULL, 1, 11, 'active', NULL, NULL, NULL, NULL),
(2, 'Section 02', NULL, 1, 12, 'active', NULL, NULL, NULL, NULL),
(3, 'Section 03', NULL, 2, 13, 'active', NULL, NULL, NULL, NULL),
(4, 'Section 04', NULL, 2, 14, 'active', NULL, NULL, NULL, NULL),
(5, 'Section 05', NULL, 3, 15, 'active', NULL, NULL, NULL, NULL),
(6, 'Section 06', NULL, 3, 16, 'active', NULL, NULL, NULL, NULL),
(7, 'Section 07', NULL, 4, 17, 'active', NULL, NULL, NULL, NULL),
(8, 'Section 08', NULL, 4, 18, 'active', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime DEFAULT NULL,
  `createdby` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `projectid` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `isactive` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nonactive',
  `updatingfor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isdeleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relatedto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relatedid` int(11) DEFAULT NULL,
  `dependontask` int(11) DEFAULT NULL,
  `_lft` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `_rgt` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `description`, `startdate`, `enddate`, `createdby`, `type`, `projectid`, `priority`, `status`, `isactive`, `updatingfor`, `isdeleted`, `relatedto`, `relatedid`, `dependontask`, `_lft`, `_rgt`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Task 01', NULL, '2021-06-19 22:30:57', '2021-06-19 22:30:57', 3, 'custom', NULL, 1, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, '2021-07-30 15:37:50', '2021-07-30 15:37:50'),
(2, 'Create', NULL, '2021-07-30 18:37:50', NULL, 3, 'General', NULL, 1, 'ApprovedAndConfirmed', 'nonactive', NULL, NULL, 'task', 1, NULL, 3, 4, NULL, '2021-07-30 15:37:50', '2021-08-26 03:22:07'),
(5, 'Create', NULL, '2021-08-24 04:36:53', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'workspace', 33, NULL, 5, 6, NULL, '2021-08-24 01:36:53', '2021-08-24 01:36:53'),
(6, 'Create', NULL, '2021-08-24 04:45:14', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 8, NULL, 7, 8, NULL, '2021-08-24 01:45:15', '2021-08-24 01:45:15'),
(7, 'Create', NULL, '2021-08-25 00:20:58', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'workspace', 34, NULL, 9, 10, NULL, '2021-08-24 21:20:58', '2021-08-24 21:20:58'),
(8, 'Create', NULL, '2021-08-25 00:28:17', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'workspace', 35, NULL, 11, 12, NULL, '2021-08-24 21:28:17', '2021-08-24 21:28:17'),
(9, 'Create', NULL, '2021-08-25 00:30:45', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 9, NULL, 13, 14, NULL, '2021-08-24 21:30:45', '2021-08-24 21:30:45'),
(10, 'Create', NULL, '2021-08-25 00:49:48', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'workspace', 36, NULL, 15, 16, NULL, '2021-08-24 21:49:48', '2021-08-24 21:49:48'),
(11, 'Create', NULL, '2021-08-25 01:02:45', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'workspace', 37, NULL, 17, 18, NULL, '2021-08-24 22:02:45', '2021-08-24 22:02:45'),
(12, 'Create', NULL, '2021-08-25 01:04:24', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 10, NULL, 19, 20, NULL, '2021-08-24 22:04:24', '2021-08-24 22:04:24'),
(13, 'Create', NULL, '2021-08-25 04:06:07', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'workspace', 38, NULL, 21, 22, NULL, '2021-08-25 01:06:07', '2021-08-25 01:06:07'),
(14, 'Create', NULL, '2021-08-25 04:53:39', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 11, NULL, 23, 24, NULL, '2021-08-25 01:53:39', '2021-08-25 01:53:39'),
(15, 'Update', NULL, '2021-08-25 05:21:26', NULL, 1, 'General', NULL, 2, 'In Progress', 'nonactive', NULL, NULL, 'project', 10, NULL, 25, 26, NULL, '2021-08-25 02:21:26', '2021-08-25 02:21:26'),
(16, 'Update', NULL, '2021-08-25 05:22:34', NULL, 1, 'General', NULL, 3, 'In Progress', 'nonactive', NULL, NULL, 'project', 10, NULL, 27, 28, NULL, '2021-08-25 02:22:34', '2021-08-25 02:22:34'),
(17, 'Create', NULL, '2021-08-25 05:27:05', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 15, NULL, 29, 30, NULL, '2021-08-25 02:27:05', '2021-08-25 02:27:05'),
(18, 'Update', NULL, '2021-08-25 15:36:47', NULL, 1, 'General', NULL, 4, 'In Progress', 'nonactive', NULL, NULL, 'project', 10, NULL, 31, 32, NULL, '2021-08-25 12:36:47', '2021-08-25 12:36:47'),
(19, 'Update', NULL, '2021-08-25 15:37:17', NULL, 1, 'General', NULL, 5, 'In Progress', 'nonactive', NULL, NULL, 'project', 10, NULL, 33, 34, NULL, '2021-08-25 12:37:17', '2021-08-25 12:37:17'),
(20, 'Update', NULL, '2021-08-25 15:37:53', NULL, 1, 'General', NULL, 6, 'In Progress', 'nonactive', NULL, NULL, 'project', 10, NULL, 35, 36, NULL, '2021-08-25 12:37:53', '2021-08-25 12:37:53'),
(21, 'Create', NULL, '2021-08-25 15:42:33', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 19, NULL, 37, 38, NULL, '2021-08-25 12:42:33', '2021-08-25 12:42:33'),
(22, 'Update', NULL, '2021-08-25 15:43:15', NULL, 1, 'General', NULL, 7, 'In Progress', 'nonactive', NULL, NULL, 'project', 10, NULL, 39, 40, NULL, '2021-08-25 12:43:15', '2021-08-25 12:43:15'),
(23, 'Create', NULL, '2021-08-25 15:51:59', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'workspace', 39, NULL, 41, 42, NULL, '2021-08-25 12:51:59', '2021-08-25 12:51:59'),
(24, 'Update', NULL, '2021-08-25 20:23:55', NULL, 1, 'General', NULL, 2, 'In Progress', 'nonactive', NULL, NULL, 'workspace', 38, NULL, 43, 44, NULL, '2021-08-25 17:23:55', '2021-08-25 17:23:55'),
(25, 'Update', NULL, '2021-08-25 20:25:46', NULL, 1, 'General', NULL, 8, 'Pending', 'nonactive', NULL, NULL, 'project', 10, NULL, 45, 46, NULL, '2021-08-25 17:25:46', '2021-08-25 17:25:46'),
(26, 'Create', NULL, '2021-08-25 20:38:14', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 22, NULL, 47, 48, NULL, '2021-08-25 17:38:14', '2021-08-25 17:38:14'),
(27, 'Create', NULL, '2021-08-25 20:45:41', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 23, NULL, 49, 50, NULL, '2021-08-25 17:45:41', '2021-08-25 17:45:41'),
(28, 'Update', NULL, '2021-08-25 21:38:23', NULL, 1, 'General', NULL, 2, 'In Progress', 'nonactive', NULL, NULL, 'project', 23, NULL, 51, 52, NULL, '2021-08-25 18:38:23', '2021-08-25 18:38:23'),
(29, 'Update', NULL, '2021-08-25 21:45:44', NULL, 1, 'General', NULL, 3, 'In Progress', 'nonactive', NULL, NULL, 'workspace', 38, NULL, 53, 54, NULL, '2021-08-25 18:45:44', '2021-08-25 18:45:44'),
(30, 'Delete', NULL, '2021-08-25 21:59:36', NULL, 1, 'General', NULL, 3, 'In Progress', 'nonactive', NULL, NULL, 'project', 23, NULL, 55, 56, NULL, '2021-08-25 18:59:36', '2021-08-25 18:59:36'),
(31, 'Delete', NULL, '2021-08-25 21:59:36', NULL, 1, 'General', NULL, 4, 'In Progress', 'nonactive', NULL, NULL, 'project', 23, NULL, 57, 58, NULL, '2021-08-25 18:59:36', '2021-08-25 18:59:36'),
(32, 'Delete', NULL, '2021-08-25 22:00:23', NULL, 1, 'General', NULL, 5, 'In Progress', 'nonactive', NULL, NULL, 'project', 23, NULL, 59, 60, NULL, '2021-08-25 19:00:23', '2021-08-25 19:00:23'),
(33, 'Delete', NULL, '2021-08-25 22:00:23', NULL, 1, 'General', NULL, 6, 'In Progress', 'nonactive', NULL, NULL, 'project', 23, NULL, 61, 62, NULL, '2021-08-25 19:00:23', '2021-08-25 19:00:23'),
(34, 'Delete', NULL, '2021-08-25 22:00:40', NULL, 1, 'General', NULL, 7, 'In Progress', 'nonactive', NULL, NULL, 'project', 23, NULL, 63, 64, NULL, '2021-08-25 19:00:40', '2021-08-25 19:00:40'),
(35, 'Delete', NULL, '2021-08-25 22:00:40', NULL, 1, 'General', NULL, 8, 'In Progress', 'nonactive', NULL, NULL, 'project', 23, NULL, 65, 66, NULL, '2021-08-25 19:00:40', '2021-08-25 19:00:40'),
(36, 'Create', NULL, '2021-08-25 22:01:43', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'workspace', 43, NULL, 67, 68, NULL, '2021-08-25 19:01:43', '2021-08-25 19:01:43'),
(37, 'Delete', NULL, '2021-08-25 22:02:16', NULL, 1, 'General', NULL, 2, 'In Progress', 'active', NULL, NULL, 'workspace', 43, NULL, 69, 70, NULL, '2021-08-25 19:02:16', '2021-08-25 19:02:16'),
(38, 'Task Project', NULL, '2021-06-19 22:30:57', '2021-06-19 22:30:57', 3, 'custom', NULL, 1, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 71, 72, NULL, '2021-08-25 22:29:48', '2021-08-25 22:29:48'),
(39, 'Task Project', NULL, '2021-06-19 22:30:57', '2021-06-19 22:30:57', 1, 'custom', NULL, 1, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 73, 74, NULL, '2021-08-25 22:30:29', '2021-08-25 22:30:29'),
(40, 'Task Project', NULL, '2021-06-19 22:30:57', '2021-06-19 22:30:57', 1, 'custom', NULL, 1, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 75, 76, NULL, '2021-08-25 22:31:36', '2021-08-25 22:31:36'),
(41, 'Task Project', NULL, '2021-06-19 22:30:57', '2021-06-19 22:30:57', 1, 'custom', NULL, 1, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 77, 78, NULL, '2021-08-25 22:34:48', '2021-08-25 22:34:48'),
(42, 'Task Project', NULL, '2021-06-19 22:30:57', '2021-06-19 22:30:57', 1, 'custom', NULL, 1, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 79, 80, NULL, '2021-08-25 22:35:29', '2021-08-25 22:35:29'),
(43, 'Task Project', NULL, '2021-06-19 22:30:57', '2021-06-19 22:30:57', 1, 'custom', NULL, 1, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 81, 82, NULL, '2021-08-25 22:35:43', '2021-08-25 22:35:43'),
(44, 'Task Project', NULL, '2021-06-19 22:30:57', '2021-06-19 22:30:57', 1, 'custom', NULL, 1, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 83, 84, NULL, '2021-08-25 22:37:16', '2021-08-25 22:37:16'),
(45, 'Create', NULL, '2021-08-26 01:37:16', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 44, NULL, 85, 86, NULL, '2021-08-25 22:37:16', '2021-08-25 22:37:16'),
(46, 'Task Project', NULL, '2021-06-19 22:30:57', '2021-06-19 22:30:57', 1, 'custom', NULL, 1, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 87, 88, NULL, '2021-08-25 23:01:25', '2021-08-25 23:01:25'),
(47, 'Create', NULL, '2021-08-26 02:01:25', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 46, NULL, 89, 90, NULL, '2021-08-25 23:01:25', '2021-08-25 23:01:25'),
(48, 'Task Project', NULL, '2021-06-19 22:30:57', '2021-06-19 22:30:57', 1, 'project', 10, 1, 'new', 'active', NULL, NULL, NULL, NULL, NULL, 91, 92, NULL, '2021-08-25 23:02:00', '2021-08-25 23:02:00'),
(49, 'Create', NULL, '2021-08-26 02:02:00', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 48, NULL, 93, 94, NULL, '2021-08-25 23:02:00', '2021-08-25 23:02:00'),
(50, 'Delete', NULL, '2021-08-26 03:04:54', NULL, 1, 'General', NULL, 9, 'In Progress', 'nonactive', NULL, NULL, 'project', 23, NULL, 95, 96, NULL, '2021-08-26 00:04:54', '2021-08-26 00:04:54'),
(51, 'Delete', NULL, '2021-08-26 03:04:54', NULL, 1, 'General', NULL, 10, 'In Progress', 'nonactive', NULL, NULL, 'project', 23, NULL, 97, 98, NULL, '2021-08-26 00:04:54', '2021-08-26 00:04:54'),
(52, 'Delete', NULL, '2021-08-26 03:05:17', NULL, 1, 'General', NULL, 9, 'In Progress', 'nonactive', NULL, NULL, 'project', 10, NULL, 99, 100, NULL, '2021-08-26 00:05:17', '2021-08-26 00:05:17'),
(53, 'Delete', NULL, '2021-08-26 03:05:17', NULL, 1, 'General', NULL, 10, 'In Progress', 'nonactive', NULL, NULL, 'project', 10, NULL, 101, 102, NULL, '2021-08-26 00:05:17', '2021-08-26 00:05:17'),
(54, 'Task 12', NULL, '2021-06-29 22:30:57', '2021-08-19 22:30:57', 1, 'project', 10, 1, 'Reviewing', 'active', NULL, NULL, NULL, NULL, NULL, 103, 108, NULL, '2021-08-26 00:14:07', '2021-08-26 03:28:15'),
(55, 'Create', NULL, '2021-08-26 03:14:07', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 54, NULL, 109, 110, NULL, '2021-08-26 00:14:07', '2021-08-26 00:14:07'),
(56, 'Task 12', NULL, '2021-06-29 22:30:57', '2021-08-19 22:30:57', 1, 'custom', NULL, 1, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 111, 112, NULL, '2021-08-26 00:27:30', '2021-08-26 00:27:30'),
(58, 'Task 13', NULL, '2021-06-29 22:30:57', '2021-08-19 22:30:57', 1, 'custom', NULL, NULL, 'new', 'nonactive', NULL, NULL, NULL, NULL, 54, 113, 114, NULL, '2021-08-26 00:29:56', '2021-08-26 00:29:56'),
(59, 'Create', NULL, '2021-08-26 03:29:56', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 58, NULL, 115, 116, NULL, '2021-08-26 00:29:56', '2021-08-26 00:29:56'),
(60, 'Task 14', NULL, '2021-06-29 22:30:57', '2021-08-19 22:30:57', 1, 'custom', NULL, NULL, 'new', 'nonactive', NULL, NULL, NULL, NULL, 54, 117, 118, NULL, '2021-08-26 00:30:30', '2021-08-26 00:30:30'),
(61, 'Create', NULL, '2021-08-26 03:30:30', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 60, NULL, 119, 120, NULL, '2021-08-26 00:30:30', '2021-08-26 00:30:30'),
(62, 'Task 14', NULL, '2021-06-29 22:30:57', '2021-08-19 22:30:57', 1, 'custom', NULL, NULL, 'new', 'active', NULL, NULL, NULL, NULL, NULL, 121, 122, NULL, '2021-08-26 00:31:41', '2021-08-26 00:31:41'),
(63, 'Create', NULL, '2021-08-26 03:31:41', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 62, NULL, 123, 124, NULL, '2021-08-26 00:31:41', '2021-08-26 00:31:41'),
(64, 'Task Project 34', NULL, '2021-06-19 22:30:57', '2021-06-19 22:30:57', 3, 'custom', NULL, NULL, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 125, 126, NULL, '2021-08-26 00:42:24', '2021-08-26 00:42:24'),
(65, 'Create', NULL, '2021-08-26 03:42:24', '2021-06-19 22:30:57', 3, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 64, NULL, 127, 132, NULL, '2021-08-26 00:42:24', '2021-08-26 00:42:24'),
(66, 'Task Project 65', NULL, '2021-06-19 22:30:57', '2021-06-19 22:30:57', 3, 'custom', NULL, NULL, 'new', 'active', NULL, NULL, NULL, NULL, NULL, 133, 134, NULL, '2021-08-26 00:42:44', '2021-08-26 00:42:44'),
(67, 'Create', NULL, '2021-08-26 03:42:44', NULL, 3, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 66, NULL, 135, 136, NULL, '2021-08-26 00:42:44', '2021-08-26 00:42:44'),
(68, 'Task Project 66', NULL, '2021-06-19 22:30:57', '2021-06-17 22:30:57', 3, 'custom', NULL, NULL, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 128, 129, 65, '2021-08-26 00:49:34', '2021-08-26 00:49:34'),
(69, 'Create', NULL, '2021-08-26 03:49:34', NULL, 3, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 68, NULL, 130, 131, 65, '2021-08-26 00:49:34', '2021-08-26 00:49:34'),
(70, 'task 12.1', 'new first task', '2021-08-09 00:00:00', '2021-08-11 00:00:00', 1, 'custom', NULL, NULL, 'new', 'active', NULL, NULL, NULL, NULL, NULL, 104, 105, 54, '2021-08-26 00:55:04', '2021-08-26 00:55:04'),
(71, 'Create', NULL, '2021-08-26 03:55:04', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 70, NULL, 106, 107, 54, '2021-08-26 00:55:04', '2021-08-26 00:55:04'),
(72, '12.2', 'aaa', '2021-08-01 00:00:00', '2021-08-04 00:00:00', 1, 'custom', NULL, NULL, 'new', 'nonactive', NULL, NULL, NULL, NULL, 54, 137, 138, NULL, '2021-08-26 00:56:43', '2021-08-26 00:56:43'),
(73, 'Create', NULL, '2021-08-26 03:56:43', NULL, 1, 'General', NULL, 1, 'In Progress', 'active', NULL, NULL, 'task', 72, NULL, 139, 140, NULL, '2021-08-26 00:56:43', '2021-08-26 00:56:43'),
(74, 'task 22', NULL, '2021-06-19 22:30:57', '2021-08-27 22:30:57', 3, 'custom', NULL, NULL, 'new', 'active', NULL, NULL, NULL, NULL, NULL, 141, 142, NULL, '2021-08-26 00:58:59', '2021-08-26 00:58:59'),
(75, 'Create', NULL, '2021-08-26 03:58:59', NULL, 3, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 74, NULL, 143, 144, NULL, '2021-08-26 00:58:59', '2021-08-26 00:58:59'),
(76, 'task 22', NULL, '2021-06-19 22:30:57', '2021-08-27 22:30:57', 3, 'project', 10, NULL, 'new', 'active', NULL, NULL, NULL, NULL, NULL, 145, 146, NULL, '2021-08-26 01:03:37', '2021-08-26 01:03:37'),
(77, 'Create', NULL, '2021-08-26 04:03:37', NULL, 3, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 76, NULL, 147, 148, NULL, '2021-08-26 01:03:37', '2021-08-26 01:03:37'),
(78, 'task 100', 'new task', '2021-08-24 00:00:00', '2021-09-01 00:00:00', 1, 'project', 10, NULL, 'new', 'active', NULL, NULL, NULL, NULL, NULL, 149, 150, NULL, '2021-08-26 01:05:50', '2021-08-26 01:05:50'),
(79, 'Create', NULL, '2021-08-26 04:05:50', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 78, NULL, 151, 152, NULL, '2021-08-26 01:05:50', '2021-08-26 01:05:50'),
(80, 'ava', 'asdd', '2021-08-27 00:00:00', '2021-08-27 00:00:00', 1, 'project', 10, NULL, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 153, 154, NULL, '2021-08-26 01:10:53', '2021-08-26 01:10:53'),
(81, 'Create', NULL, '2021-08-26 04:10:53', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 80, NULL, 155, 156, NULL, '2021-08-26 01:10:53', '2021-08-26 01:10:53'),
(82, 'ava', 'asdd', '2021-08-27 00:00:00', '2021-08-27 00:00:00', 1, 'project', 10, NULL, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 157, 158, NULL, '2021-08-26 01:11:37', '2021-08-26 01:11:37'),
(83, 'Create', NULL, '2021-08-26 04:11:37', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 82, NULL, 159, 160, NULL, '2021-08-26 01:11:37', '2021-08-26 01:11:37'),
(84, 'asddas', 'asdasdas', '2021-08-24 00:00:00', '2021-09-03 00:00:00', 1, 'project', 10, NULL, 'new', 'nonactive', NULL, NULL, NULL, NULL, NULL, 161, 162, NULL, '2021-08-26 01:12:55', '2021-08-26 01:12:55'),
(85, 'Create', NULL, '2021-08-26 04:12:55', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'task', 84, NULL, 163, 164, NULL, '2021-08-26 01:12:55', '2021-08-26 01:12:55'),
(86, 'Delete', NULL, '2021-08-26 08:56:47', NULL, 1, 'General', NULL, 2, 'In Progress', 'nonactive', NULL, NULL, 'workspace', 37, NULL, 165, 166, NULL, '2021-08-26 05:56:47', '2021-08-26 05:56:47'),
(87, 'Create', NULL, '2021-08-26 16:13:06', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 25, NULL, 167, 168, NULL, '2021-08-26 13:13:06', '2021-08-26 13:13:06'),
(88, 'Create', NULL, '2021-08-26 16:13:09', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 26, NULL, 169, 170, NULL, '2021-08-26 13:13:09', '2021-08-26 13:13:09'),
(89, 'Create', NULL, '2021-08-26 16:13:10', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 27, NULL, 171, 172, NULL, '2021-08-26 13:13:10', '2021-08-26 13:13:10'),
(90, 'Create', NULL, '2021-08-26 16:13:12', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 28, NULL, 173, 174, NULL, '2021-08-26 13:13:12', '2021-08-26 13:13:12'),
(91, 'Create', NULL, '2021-08-26 16:13:13', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 29, NULL, 175, 176, NULL, '2021-08-26 13:13:13', '2021-08-26 13:13:13'),
(92, 'Create', NULL, '2021-08-26 16:13:14', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 30, NULL, 177, 178, NULL, '2021-08-26 13:13:14', '2021-08-26 13:13:14'),
(93, 'Create', NULL, '2021-08-26 16:13:14', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 31, NULL, 179, 180, NULL, '2021-08-26 13:13:14', '2021-08-26 13:13:14'),
(94, 'Create', NULL, '2021-08-26 16:13:15', NULL, 1, 'General', NULL, 1, 'In Progress', 'nonactive', NULL, NULL, 'project', 32, NULL, 181, 182, NULL, '2021-08-26 13:13:15', '2021-08-26 13:13:15'),
(95, 'Create', NULL, '2021-08-26 16:13:15', NULL, 1, 'General', NULL, 2, 'In Progress', 'nonactive', NULL, NULL, 'project', 33, NULL, 183, 184, NULL, '2021-08-26 13:13:15', '2021-08-26 13:13:15'),
(96, 'Create', NULL, '2021-08-26 16:13:20', NULL, 1, 'General', NULL, 2, 'In Progress', 'nonactive', NULL, NULL, 'project', 34, NULL, 185, 186, NULL, '2021-08-26 13:13:20', '2021-08-26 13:13:20'),
(97, 'Create', NULL, '2021-08-26 16:14:37', NULL, 1, 'General', NULL, 2, 'In Progress', 'nonactive', NULL, NULL, 'project', 35, NULL, 187, 188, NULL, '2021-08-26 13:14:37', '2021-08-26 13:14:37');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `name`, `type`, `description`, `startdate`, `enddate`, `createdby`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ticket 01', 'vacation', NULL, '2021-05-22 00:46:05', '2021-05-22 00:46:05', 2, 'new', '2021-07-06 19:20:12', '2021-07-06 19:20:12'),
(2, 'Ticket 01', 'vacation', NULL, '2021-05-22 00:46:05', '2021-05-22 00:46:05', 1, 'Approved', '2021-08-26 02:22:21', '2021-08-26 03:14:03'),
(4, 'Ticket 02', 'Vacation', NULL, '2021-05-22 00:46:05', '2021-05-28 00:46:05', 1, 'new', '2021-08-26 02:27:35', '2021-08-26 02:27:35');

-- --------------------------------------------------------

--
-- Table structure for table `timers`
--

CREATE TABLE `timers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `duration` time DEFAULT NULL,
  `started_at` datetime NOT NULL,
  `stopped_at` datetime DEFAULT NULL,
  `isactive` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timers`
--

INSERT INTO `timers` (`id`, `name`, `task_id`, `user_id`, `duration`, `started_at`, `stopped_at`, `isactive`, `created_at`, `updated_at`) VALUES
(1, 'first task timer', 7, 1, '04:58:00', '2021-08-23 18:42:36', '2021-08-23 21:30:05', 'False', '2021-08-23 15:42:36', '2021-08-23 18:30:05'),
(2, 'first timer', NULL, 1, '04:58:00', '2021-08-23 21:27:38', '2021-08-23 21:30:27', 'False', '2021-08-23 18:27:38', '2021-08-23 18:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workspaceid` int(11) DEFAULT NULL,
  `departmentid` int(11) NOT NULL,
  `hou` int(11) NOT NULL,
  `isactive` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nonactive',
  `updatingfor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isdeleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `description`, `workspaceid`, `departmentid`, `hou`, `isactive`, `updatingfor`, `isdeleted`, `created_at`, `updated_at`) VALUES
(1, 'Unit 01', NULL, 1, 1, 7, 'active', NULL, NULL, NULL, NULL),
(2, 'Unit 02', NULL, 1, 1, 8, 'active', NULL, NULL, NULL, NULL),
(3, 'Unit 03', NULL, 1, 2, 9, 'active', NULL, NULL, NULL, NULL),
(4, 'Unit 04', NULL, 1, 2, 10, 'active', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonenumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` datetime DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `companyid` int(11) DEFAULT NULL,
  `departmentid` int(11) DEFAULT NULL,
  `unitid` int(11) DEFAULT NULL,
  `sectionid` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `email_verified_at`, `password`, `phonenumber`, `birthday`, `remember_token`, `img`, `companyid`, `departmentid`, `unitid`, `sectionid`, `created_at`, `updated_at`) VALUES
(1, 'Azad', 'Alketaan', 'azad-kh@outlook.com', NULL, '$2y$10$h11n3Yin3kegLT1MkUtAU.3mkwwapE6Y0qQ8SseZY8ug4KM6tWK9W', '123456789', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-05-21 21:45:13', '2021-05-21 21:45:13'),
(2, 'Azad', 'CEO', 'azad@user.com', NULL, '$2y$10$rm5uyT9OJM2B6ncUh1bs7eYuk.gHgrPYzEsU5MRXhfpkNV92gYhbS', '123456789', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-05-21 21:46:05', '2021-05-23 13:27:41'),
(3, 'Azad', 'Manager', 'azad1@user.com', NULL, '$2y$10$9crPSvuO778oU8AQJfoRje1ZsBYo0UgLbC3LzDr91XFg4BiohNnSS', '123456789', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-06-14 15:11:18', '2021-06-14 15:11:18'),
(4, 'Azad', 'Project Manager', 'azad2@user.com', NULL, '$2y$10$DE2sDjTCmwYS8yY/rQXeJeCTcuL6ZHtyghWrXcFpHX6ntAy3f5bKS', '123456789', NULL, NULL, NULL, 1, NULL, NULL, NULL, '2021-06-14 15:12:05', '2021-06-14 15:12:05'),
(5, 'Azad', 'Director 01', 'azad3@user.com', NULL, '$2y$10$cBW.KPLWGxim0YgLpB/xj.37FPmtksJOo6EF.MEan6XuE1GxRfmmO', '123456789', NULL, NULL, NULL, 1, 1, NULL, NULL, '2021-06-14 15:12:52', '2021-06-14 15:12:52'),
(6, 'Azad', 'Director 02', 'azad4@user.com', NULL, '$2y$10$8o5zq99OJspXJiBdQggq5eiT7CcYN4jJf0iB3G3ii0shhLiFe42Zm', '123456789', NULL, NULL, NULL, 1, 2, NULL, NULL, '2021-06-14 15:13:05', '2021-06-14 15:13:05'),
(7, 'Azad', 'HOU 01', 'azad5@user.com', NULL, '$2y$10$BYVgZo0MrHBDyFUt7kvrAeq/mqJ9wyOD/gXRuRI7XdyACDrJ1dO5O', '123456789', NULL, NULL, NULL, 1, 1, 1, NULL, '2021-06-14 15:13:38', '2021-06-14 15:13:38'),
(8, 'Azad', 'HOU 02', 'azad6@user.com', NULL, '$2y$10$C/ojjoymHGeiyb2RNq.otesRvgw.B0TETyyAcNH0U3c8b0nn1mGfS', '123456789', NULL, NULL, NULL, 1, 1, 2, NULL, '2021-06-14 15:13:48', '2021-06-14 15:13:48'),
(9, 'Azad', 'HOU 03', 'azad7@user.com', NULL, '$2y$10$fwQI5L11gWM9DoFulwrTiOETikSxbChpdhH6uLDz4JJdpaIXtzY9C', '123456789', NULL, NULL, NULL, 1, 2, 3, NULL, '2021-06-14 15:13:56', '2021-06-14 15:13:56'),
(10, 'Azad', 'HOU 04', 'azad8@user.com', NULL, '$2y$10$OZ.jjZH51jn5BW2HUrJ7puZnZEfyIDYtp8LwHrKVVPLFq/Z3EBRme', '123456789', NULL, NULL, NULL, 1, 2, 4, NULL, '2021-06-14 15:14:04', '2021-06-14 15:14:04'),
(11, 'Azad', 'HOS 01', 'azad9@user.com', NULL, '$2y$10$xRXUT8/B8Nckmj5IMa8/heYXXB4PV9YWU59lwAvvF9EIwoUlUlu9C', '123456789', NULL, NULL, NULL, 1, 1, 1, 1, '2021-06-14 15:14:45', '2021-06-14 15:14:45'),
(12, 'Azad', 'HOS 02', 'azad10@user.com', NULL, '$2y$10$57TZc0cfkbUPOob0BNTyROcKC5rrimKHiKxBji1XMmVirHsdkcZji', '123456789', NULL, NULL, NULL, 1, 1, 1, 2, '2021-06-14 15:14:56', '2021-06-14 15:14:56'),
(13, 'Azad', 'HOS 03', 'azad11@user.com', NULL, '$2y$10$0jeb0NV3W2fssYYEmE.AuOTl0ijxPEBaNtlV5VtliPAkMEnOEeDHC', '123456789', NULL, NULL, NULL, 1, 1, 2, 3, '2021-06-14 15:15:03', '2021-06-14 15:15:03'),
(14, 'Azad', 'HOS 04', 'azad12@user.com', NULL, '$2y$10$OyDtARbMjdtv5CMAofK80OJzqUfuDBaV.LDxRExr6RqiNn9K.xTe.', '123456789', NULL, NULL, NULL, 1, 1, 2, 4, '2021-06-14 15:15:11', '2021-06-14 15:15:11'),
(15, 'Azad', 'HOS 05', 'azad13@user.com', NULL, '$2y$10$Xx6VNdVfuwhfhhAnBCgqqOO4hUe3O.44vpnebnDP8K6/ZkPBqYtn.', '123456789', NULL, NULL, NULL, 1, 2, 3, 5, '2021-06-14 15:15:21', '2021-06-14 15:15:21'),
(16, 'Azad', 'HOS 06', 'azad14@user.com', NULL, '$2y$10$YUR1hiKv6xOKmN6VAM0sNeZ8DntA76RMipJ3oCXyLxN8wn3aCjKhC', '123456789', NULL, NULL, NULL, 1, 2, 3, 6, '2021-06-14 15:15:30', '2021-06-14 15:15:30'),
(17, 'Azad', 'HOS 07', 'azad15@user.com', NULL, '$2y$10$5VpV1vamVGOpWnRCZkuv7OqibyCNlkkq3zm9RSV2jnHDLuGD71fJu', '123456789', NULL, NULL, NULL, 1, 2, 4, 7, '2021-06-14 15:15:39', '2021-06-14 15:15:39'),
(18, 'Azad', 'HOS 08', 'azad16@user.com', NULL, '$2y$10$cqJt2t4I3NFa.MMuD1qFSelIj7Ybb6Ixczvdlnoi6avM8sMSuyr8S', '123456789', NULL, NULL, NULL, 1, 2, 4, 8, '2021-06-14 15:15:50', '2021-06-14 15:15:50'),
(19, 'Azad', 'Employee 01', 'azad17@user.com', NULL, '$2y$10$YWj43SBbPzKVtlPhM/Na0.O4kWJ76wh6WqcXdaovv/AxTlbq99e2O', '123456789', NULL, NULL, NULL, 1, 1, 1, 1, '2021-06-14 15:16:37', '2021-06-14 15:16:37'),
(20, 'Azad', 'Employee 02', 'azad18@user.com', NULL, '$2y$10$WdnUzgjjnBB2/YFk6DB58eKqwTznnifVhyn.Otme/U2rLuXJPl7W.', '123456789', NULL, NULL, NULL, 1, 1, 1, 1, '2021-06-14 15:16:46', '2021-06-14 15:16:46'),
(21, 'Azad', 'Employee 03', 'azad19@user.com', NULL, '$2y$10$aBh/7vyXbHuveNYFF6m4m.c2eezHIZSk/rayZ3FC.zhTkXhMuBOz2', '123456789', NULL, NULL, NULL, 1, 1, 1, 2, '2021-06-14 15:16:55', '2021-06-14 15:16:55'),
(22, 'Azad', 'Employee 04', 'azad20@user.com', NULL, '$2y$10$PRM5Cze0.bF0zAkzaRZeZunkHwRn1D9Vo5ndgmsVMy9PJLmTZSbnm', '123456789', NULL, NULL, NULL, 1, 1, 1, 2, '2021-06-14 15:17:03', '2021-06-14 15:17:03'),
(23, 'Azad', 'Employee 05', 'azad21@user.com', NULL, '$2y$10$H23XiP1cXzKIamhUUdOB2eMH6PrPKrGZRsymZRWhenEhTTzO9VV3m', '123456789', NULL, NULL, NULL, 1, 1, 2, 3, '2021-06-14 15:17:11', '2021-06-14 15:17:11'),
(24, 'Azad', 'Employee 06', 'azad22@user.com', NULL, '$2y$10$QaQ2el1nU7MMxmhoLJ9qA.YQmRevbeB/qwTyM72PzPSICy.0jbU9G', '123456789', NULL, NULL, NULL, 1, 1, 2, 3, '2021-06-14 15:17:28', '2021-06-14 15:17:28'),
(25, 'Azad', 'Employee 07', 'azad23@user.com', NULL, '$2y$10$zA45L7MkAI5OXcHoKgeEBeCGE9y422A5ZV.0LNrNLJ3VdfqC96diS', '123456789', NULL, NULL, NULL, 1, 1, 2, 4, '2021-06-14 15:17:35', '2021-06-14 15:17:35'),
(26, 'Azad', 'Employee 08', 'azad24@user.com', NULL, '$2y$10$vCIru32XNC.XK6jE5d.E6.oOK7GS5wT4T.ZLT9eKBm3A9tNO0A4H6', '123456789', NULL, NULL, NULL, 1, 1, 2, 4, '2021-06-14 15:17:43', '2021-06-14 15:17:43'),
(27, 'Azad', 'Employee 09', 'azad25@user.com', NULL, '$2y$10$yVNs812pk5GHbrl93afg7uMkH264S3k17JCPLPwpnOY0RVnWZgwk2', '123456789', NULL, NULL, NULL, 1, 2, 3, 5, '2021-06-14 15:17:51', '2021-06-14 15:17:51'),
(28, 'Azad', 'Employee 10', 'azad26@user.com', NULL, '$2y$10$QBCEqOOkGoZ2cyq23dYMAO2hXA5A8ej1tWzYZ5kRG5KYhhmHyU3Da', '123456789', NULL, NULL, NULL, 1, 2, 3, 5, '2021-06-14 15:17:59', '2021-06-14 15:17:59'),
(29, 'Azad', 'Employee 11', 'azad27@user.com', NULL, '$2y$10$mm6zOJITfxXobqCldC6jOec1lRF3ZzBkPyWe2xPpwxIB10AAagqdK', '123456789', NULL, NULL, NULL, 1, 2, 3, 6, '2021-06-14 15:18:09', '2021-06-14 15:18:09'),
(30, 'Azad', 'Employee 12', 'azad28@user.com', NULL, '$2y$10$eAuTPunGvXirJtKFlpZdSOJZ/aexv/GH3g7vdfwSi6qpdUd.vwaVy', '123456789', NULL, NULL, NULL, 1, 2, 3, 6, '2021-06-14 15:18:16', '2021-06-14 15:18:16'),
(31, 'Azad', 'Employee 13', 'azad29@user.com', NULL, '$2y$10$X0b8y5knhSxRX6npb3RrNOSz9N2AyLxKlF7WCEUAZbM.vYW.9qYGO', '123456789', NULL, NULL, NULL, 1, 2, 4, 7, '2021-06-14 15:18:24', '2021-06-14 15:18:24'),
(32, 'Azad', 'Employee 14', 'azad30@user.com', NULL, '$2y$10$nd4oXEu9rHEpbuDGM.BD7O4u5v/mJd1iE0qQzEylLtlfPCJXulW3q', '123456789', NULL, NULL, NULL, 1, 2, 4, 7, '2021-06-14 15:18:32', '2021-06-14 15:18:32'),
(33, 'Azad', 'Employee 15', 'azad31@user.com', NULL, '$2y$10$k3tFt8KtzC2IG8u/WR2rhOaunug568E520.FqjY47UrxL.vjmHtjm', '123456789', NULL, NULL, NULL, 1, 2, 4, 8, '2021-06-14 15:18:42', '2021-06-14 15:18:42'),
(34, 'Azad', 'Employee 16', 'azad32@user.com', NULL, '$2y$10$At.13Fyxn5nHJ3CPqZPFWOScg93WNQ9crVIXnuYp5ob5tiN7vAuMy', '123456789', NULL, NULL, NULL, 1, 2, 4, 8, '2021-06-14 15:18:50', '2021-06-14 15:18:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_role_groups`
--

CREATE TABLE `user_role_groups` (
  `userid` int(11) NOT NULL,
  `rolegroupid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_role_groups`
--

INSERT INTO `user_role_groups` (`userid`, `rolegroupid`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(1, 2, NULL, NULL),
(1, 3, NULL, NULL),
(1, 4, NULL, NULL),
(2, 5, '2021-05-21 21:46:05', '2021-05-21 21:46:05'),
(1, 5, NULL, NULL),
(3, 4, '2021-06-14 15:11:19', '2021-06-14 15:11:19'),
(4, 4, '2021-06-14 15:12:05', '2021-06-14 15:12:05'),
(5, 4, '2021-06-14 15:12:52', '2021-06-14 15:12:52'),
(6, 4, '2021-06-14 15:13:05', '2021-06-14 15:13:05'),
(7, 4, '2021-06-14 15:13:38', '2021-06-14 15:13:38'),
(8, 4, '2021-06-14 15:13:48', '2021-06-14 15:13:48'),
(9, 4, '2021-06-14 15:13:56', '2021-06-14 15:13:56'),
(10, 4, '2021-06-14 15:14:04', '2021-06-14 15:14:04'),
(11, 4, '2021-06-14 15:14:45', '2021-06-14 15:14:45'),
(12, 4, '2021-06-14 15:14:56', '2021-06-14 15:14:56'),
(13, 4, '2021-06-14 15:15:03', '2021-06-14 15:15:03'),
(14, 4, '2021-06-14 15:15:11', '2021-06-14 15:15:11'),
(15, 4, '2021-06-14 15:15:21', '2021-06-14 15:15:21'),
(16, 4, '2021-06-14 15:15:30', '2021-06-14 15:15:30'),
(17, 4, '2021-06-14 15:15:39', '2021-06-14 15:15:39'),
(18, 4, '2021-06-14 15:15:50', '2021-06-14 15:15:50'),
(19, 4, '2021-06-14 15:16:37', '2021-06-14 15:16:37'),
(20, 4, '2021-06-14 15:16:46', '2021-06-14 15:16:46'),
(21, 4, '2021-06-14 15:16:55', '2021-06-14 15:16:55'),
(22, 4, '2021-06-14 15:17:03', '2021-06-14 15:17:03'),
(23, 4, '2021-06-14 15:17:11', '2021-06-14 15:17:11'),
(24, 4, '2021-06-14 15:17:28', '2021-06-14 15:17:28'),
(25, 4, '2021-06-14 15:17:35', '2021-06-14 15:17:35'),
(26, 4, '2021-06-14 15:17:43', '2021-06-14 15:17:43'),
(27, 4, '2021-06-14 15:17:51', '2021-06-14 15:17:51'),
(28, 4, '2021-06-14 15:17:59', '2021-06-14 15:17:59'),
(29, 4, '2021-06-14 15:18:09', '2021-06-14 15:18:09'),
(30, 4, '2021-06-14 15:18:16', '2021-06-14 15:18:16'),
(31, 4, '2021-06-14 15:18:24', '2021-06-14 15:18:24'),
(32, 4, '2021-06-14 15:18:32', '2021-06-14 15:18:32'),
(33, 4, '2021-06-14 15:18:42', '2021-06-14 15:18:42'),
(34, 4, '2021-06-14 15:18:50', '2021-06-14 15:18:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_role_group_companies`
--

CREATE TABLE `user_role_group_companies` (
  `userid` int(11) NOT NULL,
  `rolegroupcompanyid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_role_group_companies`
--

INSERT INTO `user_role_group_companies` (`userid`, `rolegroupcompanyid`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 2, NULL, NULL),
(3, 3, NULL, NULL),
(4, 4, NULL, NULL),
(5, 5, NULL, NULL),
(6, 5, NULL, NULL),
(7, 6, NULL, NULL),
(8, 6, NULL, NULL),
(9, 6, NULL, NULL),
(10, 6, NULL, NULL),
(11, 7, NULL, NULL),
(12, 7, NULL, NULL),
(13, 7, NULL, NULL),
(14, 7, NULL, NULL),
(15, 7, NULL, NULL),
(16, 7, NULL, NULL),
(17, 7, NULL, NULL),
(18, 7, NULL, NULL),
(19, 8, NULL, NULL),
(20, 8, NULL, NULL),
(21, 8, NULL, NULL),
(22, 8, NULL, NULL),
(23, 8, NULL, NULL),
(24, 8, NULL, NULL),
(25, 8, NULL, NULL),
(26, 8, NULL, NULL),
(27, 8, NULL, NULL),
(28, 8, NULL, NULL),
(29, 8, NULL, NULL),
(30, 8, NULL, NULL),
(31, 8, NULL, NULL),
(32, 8, NULL, NULL),
(33, 8, NULL, NULL),
(34, 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_tasks`
--

CREATE TABLE `user_tasks` (
  `userid` int(11) NOT NULL,
  `taskid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_tasks`
--

INSERT INTO `user_tasks` (`userid`, `taskid`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-07-06 07:13:48', '2021-07-06 07:13:48'),
(2, 1, '2021-07-06 07:13:48', '2021-07-06 07:13:48'),
(3, 1, '2021-07-06 07:13:48', '2021-07-06 07:13:48'),
(19, 2, '2021-07-06 10:02:28', '2021-07-06 10:02:28'),
(19, 1, '2021-07-06 13:09:29', '2021-07-06 13:09:29'),
(19, 1, '2021-07-06 13:10:27', '2021-07-06 13:10:27'),
(19, 1, '2021-07-06 13:14:18', '2021-07-06 13:14:18'),
(19, 3, '2021-07-06 13:17:43', '2021-07-06 13:17:43'),
(19, 5, '2021-07-06 13:18:29', '2021-07-06 13:18:29'),
(19, 7, '2021-07-06 13:18:34', '2021-07-06 13:18:34'),
(19, 9, '2021-07-06 13:18:53', '2021-07-06 13:18:53'),
(19, 11, '2021-07-06 13:19:04', '2021-07-06 13:19:04'),
(19, 13, '2021-07-06 13:50:40', '2021-07-06 13:50:40'),
(19, 15, '2021-07-06 14:01:36', '2021-07-06 14:01:36'),
(19, 17, '2021-07-06 14:02:28', '2021-07-06 14:02:28'),
(19, 19, '2021-07-06 14:02:40', '2021-07-06 14:02:40'),
(19, 21, '2021-07-06 14:05:12', '2021-07-06 14:05:12'),
(19, 23, '2021-07-06 14:09:03', '2021-07-06 14:09:03'),
(19, 25, '2021-07-06 14:10:29', '2021-07-06 14:10:29'),
(19, 27, '2021-07-06 14:13:58', '2021-07-06 14:13:58'),
(19, 29, '2021-07-06 14:14:33', '2021-07-06 14:14:33'),
(19, 31, '2021-07-06 14:16:22', '2021-07-06 14:16:22'),
(19, 33, '2021-07-06 14:17:05', '2021-07-06 14:17:05'),
(19, 35, '2021-07-06 14:18:30', '2021-07-06 14:18:30'),
(19, 37, '2021-07-06 14:21:08', '2021-07-06 14:21:08'),
(19, 39, '2021-07-06 14:22:03', '2021-07-06 14:22:03'),
(19, 41, '2021-07-06 14:24:19', '2021-07-06 14:24:19'),
(19, 43, '2021-07-06 16:19:18', '2021-07-06 16:19:18'),
(19, 45, '2021-07-06 16:22:34', '2021-07-06 16:22:34'),
(19, 47, '2021-07-06 16:24:10', '2021-07-06 16:24:10'),
(1, 54, '2021-07-06 19:24:35', '2021-07-06 19:24:35'),
(1, 1, '2021-07-07 08:09:03', '2021-07-07 08:09:03'),
(1, 1, '2021-07-07 08:19:34', '2021-07-07 08:19:34'),
(1, 1, '2021-07-07 08:21:48', '2021-07-07 08:21:48'),
(1, 3, '2021-07-07 08:22:46', '2021-07-07 08:22:46'),
(1, 5, '2021-07-07 08:22:53', '2021-07-07 08:22:53'),
(1, 7, '2021-07-07 08:23:21', '2021-07-07 08:23:21'),
(1, 9, '2021-07-07 08:23:26', '2021-07-07 08:23:26'),
(4, 6, '2021-07-30 15:29:31', '2021-07-30 15:29:31'),
(4, 7, '2021-07-30 15:30:43', '2021-07-30 15:30:43'),
(4, 9, '2021-07-30 15:32:25', '2021-07-30 15:32:25'),
(4, 11, '2021-07-30 15:33:19', '2021-07-30 15:33:19'),
(4, 1, '2021-07-30 15:34:02', '2021-07-30 15:34:02'),
(4, 1, '2021-07-30 15:36:16', '2021-07-30 15:36:16'),
(4, 3, '2021-07-30 15:37:17', '2021-07-30 15:37:17'),
(4, 1, '2021-07-30 15:37:50', '2021-07-30 15:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_tickets`
--

CREATE TABLE `user_tickets` (
  `userid` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_tickets`
--

INSERT INTO `user_tickets` (`userid`, `ticketid`, `created_at`, `updated_at`) VALUES
(2, 1, '2021-07-06 19:20:12', '2021-07-06 19:20:12'),
(1, 2, '2021-08-26 02:22:21', '2021-08-26 02:22:21'),
(1, 3, '2021-08-26 02:22:57', '2021-08-26 02:22:57'),
(1, 4, '2021-08-26 02:27:35', '2021-08-26 02:27:35');

-- --------------------------------------------------------

--
-- Table structure for table `user_workspaces`
--

CREATE TABLE `user_workspaces` (
  `workspaceid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_workspaces`
--

INSERT INTO `user_workspaces` (`workspaceid`, `userid`, `created_at`, `updated_at`) VALUES
(33, 1, '2021-08-24 01:36:52', '2021-08-24 01:36:52'),
(34, 1, '2021-08-24 21:20:58', '2021-08-24 21:20:58'),
(35, 1, '2021-08-24 21:28:17', '2021-08-24 21:28:17'),
(36, 1, '2021-08-24 21:49:48', '2021-08-24 21:49:48'),
(37, 1, '2021-08-24 22:02:45', '2021-08-24 22:02:45'),
(38, 1, '2021-08-25 01:06:07', '2021-08-25 01:06:07'),
(39, 1, '2021-08-25 12:51:59', '2021-08-25 12:51:59'),
(43, 1, '2021-08-25 19:01:43', '2021-08-25 19:01:43');

-- --------------------------------------------------------

--
-- Table structure for table `workflow_upper_levels`
--

CREATE TABLE `workflow_upper_levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `workflowtype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upperlevel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workflow_upper_levels`
--

INSERT INTO `workflow_upper_levels` (`id`, `workflowtype`, `upperlevel`, `created_at`, `updated_at`) VALUES
(1, 'Department', '2', NULL, NULL),
(2, 'Unit', '2', NULL, NULL),
(3, 'Section', '2', NULL, NULL),
(4, 'Project Task', '2', NULL, NULL),
(5, 'Custom Task', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workspaces`
--

CREATE TABLE `workspaces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdby` int(11) NOT NULL,
  `companyid` int(11) NOT NULL,
  `managerid` int(11) NOT NULL,
  `isactive` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nonactive',
  `updatingfor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isdeleted` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workspaces`
--

INSERT INTO `workspaces` (`id`, `name`, `description`, `createdby`, `companyid`, `managerid`, `isactive`, `updatingfor`, `isdeleted`, `created_at`, `updated_at`) VALUES
(1, 'Workspace 01', NULL, 2, 1, 3, 'active', NULL, NULL, NULL, NULL),
(2, 'Workspace 02', NULL, 2, 1, 3, 'active', NULL, NULL, NULL, '2021-06-17 03:26:04'),
(37, 'Workspace 05', 'new workspace', 1, 1, 1, 'active', NULL, '1', '2021-08-24 22:02:45', '2021-08-26 05:56:47'),
(38, 'workspace 06', 'new workspace', 1, 1, 1, 'active', NULL, NULL, '2021-08-25 01:06:07', '2021-08-25 01:06:07'),
(39, 'Workspace 09', 'new workspace', 1, 1, 1, 'nonactive', NULL, NULL, '2021-08-25 12:51:59', '2021-08-25 12:51:59'),
(40, 'Workspace 07', 'late workspace', 1, 1, 1, 'nonactive', '38', NULL, '2021-08-25 17:23:38', '2021-08-25 17:23:38'),
(41, 'Workspace 07', 'late workspace', 1, 1, 1, 'nonactive', '38', NULL, '2021-08-25 17:23:55', '2021-08-25 17:23:55'),
(42, 'asdsf', '132241', 1, 1, 1, 'active', '38', NULL, '2021-08-25 18:45:44', '2021-08-25 18:45:44'),
(43, 'workspace 09', 'sad', 1, 1, 1, 'active', NULL, '1', '2021-08-25 19:01:43', '2021-08-25 19:02:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_types`
--
ALTER TABLE `company_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `processes`
--
ALTER TABLE `processes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Process_Index` (`taskid`,`ticketid`,`status`);

--
-- Indexes for table `process_types`
--
ALTER TABLE `process_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_groups`
--
ALTER TABLE `role_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_group_companies`
--
ALTER TABLE `role_group_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks__lft__rgt_parent_id_index` (`_lft`,`_rgt`,`parent_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timers`
--
ALTER TABLE `timers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `workflow_upper_levels`
--
ALTER TABLE `workflow_upper_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workspaces`
--
ALTER TABLE `workspaces`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_types`
--
ALTER TABLE `company_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `processes`
--
ALTER TABLE `processes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `process_types`
--
ALTER TABLE `process_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_groups`
--
ALTER TABLE `role_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_group_companies`
--
ALTER TABLE `role_group_companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `timers`
--
ALTER TABLE `timers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `workflow_upper_levels`
--
ALTER TABLE `workflow_upper_levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `workspaces`
--
ALTER TABLE `workspaces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
