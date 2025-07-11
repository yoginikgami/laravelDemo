-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 11, 2025 at 02:21 PM
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
-- Database: `schoolman`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `status` enum('Present','Absent','Leave') NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(10, '2025_07_08_035922_create_users_table', 1),
(11, '2025_07_08_040006_create_teachers_table', 1),
(12, '2025_07_08_040036_create_school_classes_table', 1),
(13, '2025_07_08_040120_create_subjects_table', 1),
(14, '2025_07_08_040151_create_students_table', 1),
(15, '2025_07_08_040257_create_attendances_table', 1),
(16, '2025_07_08_054135_add_two_factor_columns_to_users_table', 1),
(17, '2025_07_10_040543_create_cache_table', 1),
(18, '2025_07_10_121614_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2025-07-11 00:37:33', '2025-07-11 00:37:33'),
(2, 'Teacher', 'web', '2025-07-11 00:37:33', '2025-07-11 00:37:33');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_classes`
--

CREATE TABLE `school_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `section` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_classes`
--

INSERT INTO `school_classes` (`id`, `name`, `section`, `created_at`, `updated_at`) VALUES
(1, '1st Grad', 'A', '2025-07-11 01:23:02', '2025-07-11 01:23:02'),
(2, '2st Grad', 'A', '2025-07-11 01:23:05', '2025-07-11 01:23:05'),
(3, '1st Grad', 'B', '2025-07-11 01:23:09', '2025-07-11 01:23:09'),
(4, '3st Grad', 'A', '2025-07-11 01:23:16', '2025-07-11 01:23:16');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `roll_no` varchar(20) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `dob` date NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact_no` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `class_id`, `roll_no`, `gender`, `dob`, `photo`, `address`, `contact_no`, `created_at`, `updated_at`) VALUES
(1, 6, 1, '1', 'Female', '2018-02-05', 'student_photos/hiral_rajgor_2025-07-11.png', 'Bhuj', '9852140010', '2025-07-11 01:24:09', '2025-07-11 06:23:29'),
(2, 7, 1, '2', 'Male', '2019-08-25', 'student_photos/het_shah_2025-07-11.jpeg', 'Bhuj', '9652147852', '2025-07-11 01:25:34', '2025-07-11 05:44:16'),
(3, 8, 2, '1', 'Female', '2021-08-21', 'student_photos/VBKDKjwGnPdrKMBiji9TReU1hjsu3GLFjaGLJVd2.png', 'Madhapar', '985201410', '2025-07-11 06:07:42', '2025-07-11 06:07:42'),
(4, 9, 2, '2', 'Male', '2019-01-25', 'student_photos/nr48xbaosKjJaXQDmdlENuS24tukGZFvFTDyfWfT.png', 'Mirzapar', '9852100180', '2025-07-11 06:09:42', '2025-07-11 06:09:42'),
(5, 10, 2, '3', 'Male', '2018-05-10', 'student_photos/NRd9WSj7vUDKQCgf6texd19rll0PL7C9Q6LWLJzQ.png', 'Bhuj', '8787878787', '2025-07-11 06:11:16', '2025-07-11 06:11:16');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `class_id`, `teacher_id`, `created_at`, `updated_at`) VALUES
(1, 'Gujarati', 2, 1, '2025-07-11 01:25:48', '2025-07-11 01:25:48'),
(2, 'Computer', 2, 2, '2025-07-11 01:25:56', '2025-07-11 01:25:56'),
(3, 'Hindi', 1, 1, '2025-07-11 01:26:04', '2025-07-11 01:26:04'),
(4, 'Computer', 1, 2, '2025-07-11 04:25:32', '2025-07-11 04:25:32'),
(5, 'Math', 1, 4, '2025-07-11 04:25:42', '2025-07-11 04:25:42');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `joined_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `qualification`, `subject`, `phone`, `address`, `profile_photo`, `joined_date`, `created_at`, `updated_at`) VALUES
(1, 2, 'B.Ed', 'Hindi, Gujarati', '9854120327', 'Bhuj', 'teacher_photos/DfbUWuju9fatGrQtD8eEYP1R2sR1mB3szI9Ro3Ur.png', '2024-01-02', '2025-07-11 01:19:19', '2025-07-11 01:19:19'),
(2, 3, 'MCA', 'Computer', '9589589589', 'Bhuj', 'teacher_photos/OFTOQuKB72jF4rMOjVDCgBlXG0qLusUfcdWMOkM7.png', '2022-06-01', '2025-07-11 01:20:26', '2025-07-11 01:20:26'),
(3, 4, 'M.Ed', 'Social Science', '9521428001', 'Bhuj', 'teacher_photos/47tcs63q0PG9szQYDvaIfJoSKSwRscLlt3SLFvZZ.png', '2025-05-11', '2025-07-11 01:21:30', '2025-07-11 01:21:30'),
(4, 5, 'M.sc', 'Math, Science', '6848752100', 'Bhuj', 'teacher_photos/eJrsvbiB4QI0mOWcfYL1wYMkQZ4KS80NYUUEEsoc.png', '2021-09-08', '2025-07-11 01:22:43', '2025-07-11 01:22:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Rohan ', 'rohan@gmail.com', '$2y$12$n/K0frBAE4Fb9Cba64F0TunxP8ifaN8KgCYfL27bT5mOMjFZaa6Ja', NULL, NULL, NULL, 'Admin', NULL, NULL, NULL),
(2, 'Rupali Parmar', 'rupali@gmail.com', '$2y$12$0ZgpiGZBURBzMsnjJ7evtufKfiponPxerlgNUELmArX4nXDze6rAa', NULL, NULL, NULL, 'Teacher', NULL, '2025-07-11 01:19:19', '2025-07-11 01:19:19'),
(3, 'Teesha Shah', 'teesha@gmail.com', '$2y$12$Stk6tLIw8pY9RKJeZ0IFwuufqi8WzRgIGdXsVcPIL8Yhf4lkGLCM6', NULL, NULL, NULL, 'Teacher', NULL, '2025-07-11 01:20:26', '2025-07-11 01:20:26'),
(4, 'Rahul Patel', 'rahul@gmail.com', '$2y$12$C5d07cGaR2oNi2SiK8yLcOD1KbaiEDD3FADj.vM.9gvFQueFj1MaC', NULL, NULL, NULL, 'Teacher', NULL, '2025-07-11 01:21:30', '2025-07-11 01:21:30'),
(5, 'Het Patel', 'het@gmail.com', '$2y$12$LqLaGRnWQMh2KOLsPL6esuPoBsI8R6MAfHidtebdbtJJmZMt5WDzO', NULL, NULL, NULL, 'Teacher', NULL, '2025-07-11 01:22:43', '2025-07-11 01:22:43'),
(6, 'Hiral Rajgor', 'hiral@gmail.com', '$2y$12$3Byb0h91RdebS0.a3r0ePOhByuJrrJuF9or4MBy3sb18weL76OyTe', NULL, NULL, NULL, 'Student', NULL, '2025-07-11 01:24:09', '2025-07-11 01:24:09'),
(7, 'Het Shah', 'het123@gmail.com', '$2y$12$kxtcicranMIDWQC6J10PluMDFb0mWP6lEEZcSe5IQdIA8844oWcPu', NULL, NULL, NULL, 'Student', NULL, '2025-07-11 01:25:34', '2025-07-11 01:25:34'),
(8, 'Gargi Patel', 'gargi@gmail.com', '$2y$12$/XBBd3nFTvj0evXKhFX4GOpC9rs9S5DyJFPLa.KSuRUB5lM.vcVu2', NULL, NULL, NULL, 'Student', NULL, '2025-07-11 06:07:42', '2025-07-11 06:07:42'),
(9, 'Rahul Patel', 'rahul123@gmail.com', '$2y$12$IFhkSvZytshznaRt11Onlu5gCd9g8rbpr7eD6AS9ubxlpNgKOGHoq', NULL, NULL, NULL, 'Student', NULL, '2025-07-11 06:09:41', '2025-07-11 06:09:41'),
(10, 'Smit Shah', 'smit@gmail.com', '$2y$12$Q6etEzPjWbhkY8BFSyPdHemnjlEBAAGk5PyC9O6YHMFUfXA8/oOl.', NULL, NULL, NULL, 'Student', NULL, '2025-07-11 06:11:16', '2025-07-11 06:11:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_student_id_foreign` (`student_id`),
  ADD KEY `attendances_class_id_foreign` (`class_id`),
  ADD KEY `attendances_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `school_classes`
--
ALTER TABLE `school_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_class_id_foreign` (`class_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_class_id_foreign` (`class_id`),
  ADD KEY `subjects_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teachers_user_id_foreign` (`user_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `school_classes`
--
ALTER TABLE `school_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
