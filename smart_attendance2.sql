-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2026 at 04:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_attendance2`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_session_id` bigint(20) UNSIGNED NOT NULL,
  `scanned_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `user_id`, `attendance_session_id`, `scanned_at`, `created_at`, `updated_at`) VALUES
(5, 2, 9, '2026-08-25 14:11:31', '2026-08-25 14:11:31', '2026-08-25 14:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_sessions`
--

CREATE TABLE `attendance_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lecturer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_code` varchar(255) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `token_generated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_sessions`
--

INSERT INTO `attendance_sessions` (`id`, `lecturer_id`, `course_code`, `session_token`, `token_generated_at`, `is_active`, `created_at`, `updated_at`) VALUES
(9, 1, 'COM 111', 'yxEKsNpl4afdVKmVEiaxQE5sVLd57IEFigbBi3T2', '2026-08-25 14:10:29', 0, '2026-08-25 14:10:29', '2026-08-28 00:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lecturer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_code` varchar(255) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `units` tinyint(3) UNSIGNED NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `lecturer_id`, `course_code`, `course_title`, `level`, `department`, `created_at`, `updated_at`, `semester`, `units`) VALUES
(1, 1, 'COM 111', 'Introduction to Computer Science', '100', 'Computer Science', '2026-08-25 15:03:03', '2026-08-25 15:03:03', 'First', 3),
(142, NULL, 'COM 211', 'Data Structures', '200', 'Computer Science', '2026-08-25 14:06:07', '2026-08-25 14:06:07', 'First', 3),
(143, NULL, 'COM 212', 'Systems Analysis and Design', '200', 'Computer Science', '2026-08-25 14:06:07', '2026-08-25 14:06:07', 'First', 3),
(144, NULL, 'COM 213', 'Operating Systems I', '200', 'Computer Science', '2026-08-25 14:06:07', '2026-08-25 14:06:07', 'First', 3),
(145, NULL, 'COM 214', 'Computer Programming III (OOP)', '200', 'Computer Science', '2026-08-25 14:06:07', '2026-08-25 14:06:07', 'First', 3),
(146, NULL, 'COM 215', 'Computer Architecture', '200', 'Computer Science', '2026-08-25 14:06:07', '2026-08-25 14:06:07', 'First', 2),
(147, NULL, 'MTH 211', 'Mathematical Methods', '200', 'Computer Science', '2026-08-25 14:06:08', '2026-08-25 14:06:08', 'First', 3),
(148, NULL, 'ENT 211', 'Entrepreneurship I', '200', 'Computer Science', '2026-08-25 14:06:08', '2026-08-25 14:06:08', 'First', 2),
(149, NULL, 'GNS 101', 'Use of English I', '100', 'Computer Science', '2026-08-25 14:06:34', '2026-08-25 14:06:34', 'First', 2),
(150, NULL, 'COM 112', 'Computer Programming I', '100', 'Computer Science', '2026-08-25 14:06:34', '2026-08-25 14:06:34', 'First', 3),
(151, NULL, 'COM 113', 'Digital Electronics', '100', 'Computer Science', '2026-08-25 14:06:34', '2026-08-25 14:06:34', 'First', 2),
(152, NULL, 'MTH 111', 'Elementary Mathematics I', '100', 'Computer Science', '2026-08-25 14:06:34', '2026-08-25 14:06:34', 'First', 3),
(153, NULL, 'PHY 101', 'General Physics I', '100', 'Computer Science', '2026-08-25 14:06:34', '2026-08-25 14:06:34', 'First', 2),
(154, NULL, 'GNS 103', 'Citizenship Education', '100', 'Computer Science', '2026-08-25 14:06:34', '2026-08-25 14:06:34', 'First', 2),
(172, NULL, 'COM 121', 'Computer Programming II', '100', 'Computer Science', '2026-08-25 15:08:48', '2026-08-25 15:08:48', 'Second', 3),
(173, NULL, 'COM 122', 'Data Processing', '100', 'Computer Science', '2026-08-25 15:08:48', '2026-08-25 15:08:48', 'Second', 2),
(174, NULL, 'COM 221', 'File Processing and Management', '200', 'Computer Science', '2026-08-25 15:08:48', '2026-08-25 15:08:48', 'Second', 2),
(175, NULL, 'COM 224', 'Web Technology I', '200', 'Computer Science', '2026-08-25 15:08:48', '2026-08-25 15:08:48', 'Second', 3),
(176, NULL, 'COM 311', 'Database Management Systems I', '300', 'Computer Science', '2026-08-25 15:08:48', '2026-08-25 15:08:48', 'First', 3),
(177, NULL, 'COM 312', 'Software Engineering I', '300', 'Computer Science', '2026-08-25 15:08:48', '2026-08-25 15:08:48', 'First', 3),
(178, NULL, 'COM 321', 'Database Management Systems II', '300', 'Computer Science', '2026-08-25 15:08:48', '2026-08-25 15:08:48', 'Second', 3),
(179, NULL, 'COM 323', 'Web Technology II', '300', 'Computer Science', '2026-08-25 15:08:48', '2026-08-25 15:08:48', 'Second', 3),
(180, NULL, 'COM 411', 'Advanced Database Management', '400', 'Computer Science', '2026-08-25 15:08:48', '2026-08-25 15:08:48', 'First', 3),
(181, NULL, 'COM 412', 'Artificial Intelligence', '400', 'Computer Science', '2026-08-25 15:08:48', '2026-08-25 15:08:48', 'First', 3),
(182, NULL, 'COM 422', 'Cloud Computing', '400', 'Computer Science', '2026-08-25 15:08:48', '2026-08-25 15:08:48', 'Second', 3),
(183, NULL, 'COM 423', 'Machine Learning / Data Mining', '400', 'Computer Science', '2026-08-25 15:08:48', '2026-08-25 15:08:48', 'Second', 3);

-- --------------------------------------------------------

--
-- Table structure for table `course_user`
--

CREATE TABLE `course_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_user`
--

INSERT INTO `course_user` (`id`, `user_id`, `course_id`, `created_at`, `updated_at`) VALUES
(36, 2, 1, '2026-08-25 15:03:03', '2026-08-25 15:03:03'),
(37, 2, 150, NULL, NULL),
(38, 2, 151, NULL, NULL),
(39, 2, 149, NULL, NULL),
(40, 2, 154, NULL, NULL),
(41, 2, 152, NULL, NULL),
(42, 2, 153, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_activities`
--

CREATE TABLE `login_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `logged_in_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_activities`
--

INSERT INTO `login_activities` (`id`, `user_id`, `ip_address`, `user_agent`, `logged_in_at`, `created_at`, `updated_at`) VALUES
(1, 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-26 10:41:00', '2026-08-26 10:41:00', '2026-08-26 10:41:00'),
(2, 2, '102.89.41.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-08-28 00:39:53', '2026-08-28 00:39:53', '2026-08-28 00:39:53'),
(3, 2, '102.89.41.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-08-28 00:56:08', '2026-08-28 00:56:08', '2026-08-28 00:56:08'),
(4, 1, '102.89.46.46', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-28 00:56:59', '2026-08-28 00:56:59', '2026-08-28 00:56:59'),
(5, 2, '102.89.46.46', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-28 00:58:49', '2026-08-28 00:58:49', '2026-08-28 00:58:49'),
(6, 2, '105.113.67.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-04 11:38:23', '2026-09-04 11:38:23', '2026-09-04 11:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_25_113050_create_attendance_sessions_table', 1),
(5, '2026_06_25_113105_create_attendances_table', 1),
(6, '2026_06_28_190050_create_timetables_table', 1),
(7, '2026_06_29_083057_create_courses_table', 1),
(8, '2026_06_29_083112_create_course_user_table', 1),
(9, '2026_08_19_000001_add_role_to_users_table', 1),
(10, '2026_08_22_000001_add_profile_photo_to_users_table', 1),
(11, '2026_08_22_000002_add_semester_and_units_to_courses_table', 2),
(12, '2026_08_22_000003_add_semester_to_users_table', 2),
(13, '2026_08_22_000004_fix_courses_unique_index', 3),
(14, '2026_08_23_120000_add_is_hod_to_users_table', 4),
(15, '2026_08_23_120001_add_lecturer_id_to_attendance_sessions_table', 4),
(16, '2026_08_23_000001_add_token_generated_at_to_attendance_sessions_table', 5),
(17, '2026_08_23_000002_add_unique_index_to_attendances_table', 5),
(18, '2026_08_24_000001_add_lecturer_id_to_courses_table', 6),
(19, '2026_08_25_154121_add_otp_columns_to_users_table', 7),
(20, '2026_08_26_000001_create_login_activities_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `timetables`
--

CREATE TABLE `timetables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `day_of_week` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timetables`
--

INSERT INTO `timetables` (`id`, `course_code`, `day_of_week`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(1, 'GNS 101', 'Monday', '08:00:00', '10:00:00', '2026-08-22 04:30:41', '2026-08-22 04:30:41'),
(2, 'COM 111', 'Monday', '10:15:00', '12:15:00', '2026-08-22 04:30:41', '2026-08-22 04:30:41'),
(3, 'COM 112', 'Tuesday', '09:00:00', '12:00:00', '2026-08-22 04:30:41', '2026-08-22 04:30:41'),
(4, 'COM 113', 'Wednesday', '08:00:00', '11:00:00', '2026-08-22 04:30:41', '2026-08-22 04:30:41'),
(5, 'MTH 111', 'Thursday', '13:00:00', '15:00:00', '2026-08-22 04:30:41', '2026-08-22 04:30:41'),
(6, 'PHY 101', 'Friday', '10:00:00', '12:00:00', '2026-08-22 04:30:41', '2026-08-22 04:30:41'),
(7, 'GNS 103', 'Friday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(8, 'GNS 102', 'Monday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(9, 'COM 121', 'Monday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(10, 'COM 122', 'Tuesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(11, 'COM 123', 'Tuesday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(12, 'MTH 121', 'Wednesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(13, 'STA 121', 'Thursday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(14, 'GNS 104', 'Friday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(15, 'COM 211', 'Monday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(16, 'COM 212', 'Monday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(17, 'COM 213', 'Tuesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(18, 'COM 214', 'Tuesday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(19, 'COM 215', 'Wednesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(20, 'MTH 211', 'Thursday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(21, 'ENT 211', 'Friday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(22, 'COM 221', 'Monday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(23, 'COM 222', 'Monday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(24, 'COM 223', 'Tuesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(25, 'COM 224', 'Tuesday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(26, 'COM 225', 'Wednesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(27, 'ENT 221', 'Thursday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(28, 'IT 200', 'Friday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(29, 'COM 311', 'Monday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(30, 'COM 312', 'Monday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(31, 'COM 313', 'Tuesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(32, 'COM 314', 'Tuesday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(33, 'COM 315', 'Wednesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(34, 'COM 316', 'Thursday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(35, 'GNS 311', 'Friday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(36, 'COM 321', 'Monday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(37, 'COM 322', 'Monday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(38, 'COM 323', 'Tuesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(39, 'COM 324', 'Tuesday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(40, 'COM 325', 'Wednesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(41, 'COM 326', 'Thursday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(42, 'PRO 320', 'Friday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(43, 'COM 411', 'Monday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(44, 'COM 412', 'Monday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(45, 'COM 413', 'Tuesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(46, 'COM 414', 'Tuesday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(47, 'COM 415', 'Wednesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(48, 'COM 416', 'Thursday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(49, 'COM 417', 'Friday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(50, 'COM 421', 'Monday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(51, 'COM 422', 'Monday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(52, 'COM 423', 'Tuesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(53, 'COM 424', 'Tuesday', '10:15:00', '12:15:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(54, 'COM 425', 'Wednesday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(55, 'COM 426', 'Thursday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47'),
(56, 'ENT 421', 'Friday', '08:00:00', '10:00:00', '2026-08-22 06:52:47', '2026-08-22 06:52:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `otp_code` varchar(255) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'student',
  `is_hod` tinyint(1) NOT NULL DEFAULT 0,
  `matric_number` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `profile_photo_path` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `otp_code`, `otp_expires_at`, `role`, `is_hod`, `matric_number`, `phone_number`, `department`, `level`, `semester`, `profile_photo_path`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Odubela Lecturer', 'odubelatomiwa123@gmail.com', NULL, '$2y$12$6c64O0wy2CmPoiws45XJS.0L05AdzEHV83XSNiJc1fSPTGVajsIA.', '465365', '2026-08-27 10:31:25', 'lecturer', 0, NULL, NULL, 'Computer Science', '400', 'First', NULL, NULL, '2026-08-25 15:03:03', '2026-08-27 10:21:25'),
(2, 'Oluwatomiwa Odubela', 'odubelatomiwa508@gmail.com', NULL, '$2y$12$KylorMV3venmyQ0k6Uk92OOzrKLrrTTMCrN.vLONR5KwDLJU1XAMK', '542223', '2026-08-25 15:07:41', 'student', 0, 'CSC/2026/001', '09125808797', 'Computer Science', '100', 'First', 'profile-photos/2xncOGBUTiaVco8u76pX5a4ClCmW6lCLunO8h0Le.jpg', NULL, '2026-08-25 15:03:03', '2026-08-25 15:06:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_user_id_attendance_session_id_unique` (`user_id`,`attendance_session_id`),
  ADD UNIQUE KEY `attendance_session_user_unique` (`attendance_session_id`,`user_id`);

--
-- Indexes for table `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance_sessions_session_token_unique` (`session_token`),
  ADD KEY `attendance_sessions_lecturer_id_foreign` (`lecturer_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_code_level_semester_unique` (`course_code`,`level`,`semester`),
  ADD KEY `courses_lecturer_id_foreign` (`lecturer_id`);

--
-- Indexes for table `course_user`
--
ALTER TABLE `course_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_user_user_id_foreign` (`user_id`),
  ADD KEY `course_user_course_id_foreign` (`course_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_activities`
--
ALTER TABLE `login_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_activities_user_id_ip_address_index` (`user_id`,`ip_address`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `course_user`
--
ALTER TABLE `course_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_activities`
--
ALTER TABLE `login_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_attendance_session_id_foreign` FOREIGN KEY (`attendance_session_id`) REFERENCES `attendance_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  ADD CONSTRAINT `attendance_sessions_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `course_user`
--
ALTER TABLE `course_user`
  ADD CONSTRAINT `course_user_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `login_activities`
--
ALTER TABLE `login_activities`
  ADD CONSTRAINT `login_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
