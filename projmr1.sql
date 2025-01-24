-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 04:09 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projmr1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Super Admin','Moderator','Support') DEFAULT 'Moderator',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`admin_id`, `username`, `password`, `role`, `created_date`, `status`) VALUES
(1, 'admin1', 'password1', 'Super Admin', '2025-01-03 14:22:54', 'Active'),
(2, 'admin2', 'password2', 'Moderator', '2025-01-03 14:22:54', 'Active'),
(3, '', '$2y$10$4CVn6THQSxwv0pht8VJy4OOHrw.IEmhnubcEWPwhoZa8VpEmzCDhi', '', '2025-01-12 17:03:51', 'Active'),
(4, '', '$2y$10$Iv2pfU03opwb23waDf4z8eBtGUWFaizRxbpu5Om78tchTfO8TUEHi', '', '2025-01-12 17:04:22', 'Active'),
(5, 'rahat', '$2y$10$41x7ZaCBCJ9k99LkuLcTQuqL./ynnoD.UNKur9XNb6w5JQY8Q1V1G', 'Support', '2025-01-12 17:35:07', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `calendar_events`
--

CREATE TABLE `calendar_events` (
  `event_id` int(11) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `employee_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `calendar_events`
--

INSERT INTO `calendar_events` (`event_id`, `event_title`, `event_date`, `employee_id`) VALUES
(1, 'Team Meeting', '2024-01-10', 1),
(2, 'Project Deadline', '2024-01-15', 2);

-- --------------------------------------------------------

--
-- Table structure for table `collaborations`
--

CREATE TABLE `collaborations` (
  `collaboration_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `collaborator_id` int(11) NOT NULL,
  `collaboration_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `collaborations`
--

INSERT INTO `collaborations` (`collaboration_id`, `project_id`, `collaborator_id`, `collaboration_details`) VALUES
(1, 1, 1, 'Leading the design phase'),
(2, 2, 2, 'Assisting with testing');

-- --------------------------------------------------------

--
-- Table structure for table `contact_form_responses`
--

CREATE TABLE `contact_form_responses` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `message` text NOT NULL,
  `additional_info` text DEFAULT NULL,
  `submission_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_form_responses`
--

INSERT INTO `contact_form_responses` (`id`, `full_name`, `email`, `phone`, `message`, `additional_info`, `submission_time`, `customer_id`) VALUES
(1, 'ab', 'rahatahmed1447@gmail.com', '123', 'hello', '', '2025-01-12 19:13:40', NULL),
(0, 'Pall Starling', 'starling@gmail.com', '012560023', 'hi', '', '2025-01-24 14:48:02', NULL),
(0, 'Pall Starling', 'starling@gmail.com', '012560023', 'hmm', '', '2025-01-24 15:06:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `contact_info` text DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `contact_info`, `password`) VALUES
(1, 'Customer A', 'contact@example.com', ''),
(2, 'Customer B', 'phone:1234567890', ''),
(3, 'Rahat Ahmed', NULL, '$2y$10$RwDN/sof3xPnjd5PU76GdOwAKv1bxdyeQk5b1srntwH9rkL/P/0SG'),
(4, 'ahmed', NULL, '$2y$10$gZqH9tJsGF78R7azGmESLeTN04udEE5uqEPgQQo4KY7dsmZx6pDaW'),
(5, 'rana', NULL, '$2y$10$BA3qq9J1UfgQkEVKPpVK.OvD9HgpgOV2730aIO7TGQTwqJaPTkw5.'),
(6, 'ad', NULL, '$2y$10$P083XpNGsyVLHYH3n4iCxemytf2ORPwspUJgFHg1z18dlASPHV96C');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `manager_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`, `manager_id`) VALUES
(1, 'IT', 1),
(2, 'HR', 2),
(3, 'Finance', 3),
(8, 'CSE', 2),
(9, 'science', 2);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `document_name`, `file_path`, `uploaded_at`, `customer_id`, `admin_id`) VALUES
(1, 'picture', 'uploads/bac.png', '2025-01-23 18:22:58', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `full_name`, `email`, `phone_number`, `department_id`) VALUES
(1, 'John Doe', 'john.doe@example.com', '1234567890', 1),
(2, 'Jane Smith', 'jane.smith@example.com', '0987654321', 2),
(3, 'Alice Brown', 'alice.brown@example.com', '1122334455', 3),
(7, 'Rahat Ahmed', 'rahatahmed1447@gmail.com', '012560023', 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feedback_text` text NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `feedback_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `feedback_text`, `rating`, `feedback_date`) VALUES
(1, 1, 'Great performance!', 5, '2025-01-03 14:22:54'),
(2, 2, 'Needs improvement in time management', 3, '2025-01-03 14:22:54');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin_reply` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `message`, `is_admin`, `timestamp`, `is_admin_reply`) VALUES
(1, 6, 1, 'hi', 0, '2025-01-23 08:47:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`, `description`) VALUES
(1, 'Project Alpha', 'Development of a new product'),
(2, 'Project Beta', 'Enhancement of an existing system'),
(8, 'Project Beta	', 'Project Beta');

-- --------------------------------------------------------

--
-- Table structure for table `project_risks`
--

CREATE TABLE `project_risks` (
  `risk_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `risk_description` text NOT NULL,
  `risk_level` enum('Low','Medium','High') DEFAULT NULL,
  `mitigation_plan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_risks`
--

INSERT INTO `project_risks` (`risk_id`, `project_id`, `risk_description`, `risk_level`, `mitigation_plan`) VALUES
(1, 1, 'Scope Creep', 'High', 'Define clear project boundaries'),
(2, 2, 'Resource Availability', 'Medium', 'Ensure proper resource allocation');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `description`, `cost`, `department_id`) VALUES
(1, 'Web Domain', 'Basic Domain service', '30.99', NULL),
(3, 'Web Hosting', 'Basic Hosting service', '50.99', NULL),
(7, 'Cybersecurity', 'Cybersecurity', '10.00', NULL),
(8, 'Event', 'Event', '10.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`, `project_id`) VALUES
(1, 'DESIGN UI', 1),
(2, 'Develop Backend', 1),
(3, 'Testing', 2),
(7, 'DESIGN UI', 2);

-- --------------------------------------------------------

--
-- Table structure for table `task_history`
--

CREATE TABLE `task_history` (
  `history_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `change_description` text NOT NULL,
  `change_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_history`
--

INSERT INTO `task_history` (`history_id`, `task_id`, `change_description`, `change_date`) VALUES
(1, 1, 'Initial Design Completed', '2025-01-03 14:22:54'),
(2, 2, 'Backend API Integration Started', '2025-01-03 14:22:54');

-- --------------------------------------------------------

--
-- Table structure for table `task_timer`
--

CREATE TABLE `task_timer` (
  `timer_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_time` timestamp NULL DEFAULT NULL,
  `total_time_spent` time GENERATED ALWAYS AS (timediff(`end_time`,`start_time`)) VIRTUAL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_timer`
--

INSERT INTO `task_timer` (`timer_id`, `task_id`, `employee_id`, `start_time`, `end_time`) VALUES
(1, 1, 1, '2024-01-01 04:00:00', '2024-01-01 06:00:00'),
(2, 2, 2, '2024-01-02 05:00:00', '2024-01-02 07:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `testers`
--

CREATE TABLE `testers` (
  `tester_id` int(11) NOT NULL,
  `tester_name` varchar(255) NOT NULL,
  `assigned_task_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testers`
--

INSERT INTO `testers` (`tester_id`, `tester_name`, `assigned_task_id`) VALUES
(1, 'Tester A', 3),
(2, 'Tester B', 3);

-- --------------------------------------------------------

--
-- Table structure for table `transactions1`
--

CREATE TABLE `transactions1` (
  `transaction_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `contact_info` text DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions1`
--

INSERT INTO `transactions1` (`transaction_id`, `customer_id`, `customer_name`, `contact_info`, `service_id`, `amount`, `transaction_date`) VALUES
(1, 1, 'Customer A', 'contact@example.com', 1, '100.00', '2023-01-01 10:00:00'),
(2, 2, 'Customer B', 'phone:1234567890', 2, '200.00', '2023-01-02 11:00:00'),
(3, 3, 'Rahat Ahmed', NULL, 3, '300.00', '2023-01-03 12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_rewards`
--

CREATE TABLE `user_rewards` (
  `reward_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reward_name` varchar(255) NOT NULL,
  `reward_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_rewards`
--

INSERT INTO `user_rewards` (`reward_id`, `user_id`, `reward_name`, `reward_date`) VALUES
(1, 1, 'Employee of the Month', '2025-01-03 14:22:54'),
(2, 3, 'Top Performer Award', '2025-01-03 14:22:54');

-- --------------------------------------------------------

--
-- Table structure for table `user_skills`
--

CREATE TABLE `user_skills` (
  `skill_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `skill_name` varchar(255) NOT NULL,
  `skill_level` enum('Beginner','Intermediate','Expert') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_skills`
--

INSERT INTO `user_skills` (`skill_id`, `user_id`, `skill_name`, `skill_level`) VALUES
(1, 1, 'Python', 'Expert'),
(2, 2, 'JavaScript', 'Intermediate');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `calendar_events`
--
ALTER TABLE `calendar_events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `collaborations`
--
ALTER TABLE `collaborations`
  ADD PRIMARY KEY (`collaboration_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `collaborator_id` (`collaborator_id`);

--
-- Indexes for table `contact_form_responses`
--
ALTER TABLE `contact_form_responses`
  ADD KEY `id` (`id`),
  ADD KEY `fk_customer_id` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD KEY `feedback_id` (`feedback_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_risks`
--
ALTER TABLE `project_risks`
  ADD KEY `risk_id` (`risk_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `task_history`
--
ALTER TABLE `task_history`
  ADD KEY `history_id` (`history_id`);

--
-- Indexes for table `task_timer`
--
ALTER TABLE `task_timer`
  ADD KEY `timer_id` (`timer_id`);

--
-- Indexes for table `testers`
--
ALTER TABLE `testers`
  ADD KEY `tester_id` (`tester_id`);

--
-- Indexes for table `transactions1`
--
ALTER TABLE `transactions1`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `user_rewards`
--
ALTER TABLE `user_rewards`
  ADD KEY `reward_id` (`reward_id`);

--
-- Indexes for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD KEY `skill_id` (`skill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transactions1`
--
ALTER TABLE `transactions1`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calendar_events`
--
ALTER TABLE `calendar_events`
  ADD CONSTRAINT `calendar_events_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `collaborations`
--
ALTER TABLE `collaborations`
  ADD CONSTRAINT `collaborations_ibfk_1` FOREIGN KEY (`collaboration_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contact_form_responses`
--
ALTER TABLE `contact_form_responses`
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`admin_id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`feedback_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `departments` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `admin_users` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_risks`
--
ALTER TABLE `project_risks`
  ADD CONSTRAINT `project_risks_ibfk_1` FOREIGN KEY (`risk_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_history`
--
ALTER TABLE `task_history`
  ADD CONSTRAINT `task_history_ibfk_1` FOREIGN KEY (`history_id`) REFERENCES `tasks` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_timer`
--
ALTER TABLE `task_timer`
  ADD CONSTRAINT `task_timer_ibfk_1` FOREIGN KEY (`timer_id`) REFERENCES `tasks` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `testers`
--
ALTER TABLE `testers`
  ADD CONSTRAINT `testers_ibfk_1` FOREIGN KEY (`tester_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions1`
--
ALTER TABLE `transactions1`
  ADD CONSTRAINT `transactions1_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_rewards`
--
ALTER TABLE `user_rewards`
  ADD CONSTRAINT `user_rewards_ibfk_1` FOREIGN KEY (`reward_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD CONSTRAINT `user_skills_ibfk_1` FOREIGN KEY (`skill_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
