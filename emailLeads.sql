
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('new','contacted','closed') NOT NULL,
  `source` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `leads` (`id`, `name`, `position`, `company`, `email`, `status`, `source`, `location`, `created_at`) VALUES
(6, 'John Doe', 'Manager', 'Company A', 'john@example.com', 'new', 'Referral', 'New York', '2025-03-14 02:00:09'),
(7, 'Jane Smith', 'Developer', 'Company B', 'jane@example.com', 'contacted', 'LinkedIn', 'Los Angeles', '2025-03-14 02:00:09'),
(8, 'Alice Brown', 'Designer', 'Company C', 'alice@example.com', 'closed', 'Website', 'Chicago', '2025-03-14 02:00:09'),
(9, 'Bob Johnson', 'Engineer', 'Company D', 'bob@example.com', 'new', 'Facebook', 'San Francisco', '2025-03-14 02:00:09'),
(10, 'Charlie Wilson', 'Analyst', 'Company E', 'charlie@example.com', 'contacted', 'Referral', 'Miami', '2025-03-14 02:00:09'),
(11, 'David Martinez', 'Consultant', 'Company F', 'david@example.com', 'closed', 'Instagram', 'Dallas', '2025-03-14 02:00:09'),
(12, 'Emily Clark', 'HR', 'Company G', 'emily@example.com', 'new', 'Twitter', 'Seattle', '2025-03-14 02:00:09'),
(13, 'Frank Thomas', 'CEO', 'Company H', 'frank@example.com', 'contacted', 'LinkedIn', 'Boston', '2025-03-14 02:00:09'),
(14, 'Grace L.', 'CFO', 'Company I', 'grace@example.com', 'closed', 'Referral', 'Houston', '2025-03-14 02:00:09'),
(15, 'Henry White', 'CTO', 'Company J', 'henry@example.com', 'new', 'Facebook', 'Austin', '2025-03-14 02:00:09'),
(16, 'Isabella Hall', 'Marketing', 'Company K', 'isabella@example.com', 'contacted', 'Website', 'Denver', '2025-03-14 02:00:09'),
(17, 'Jack King', 'Sales', 'Company L', 'jack@example.com', 'closed', 'Twitter', 'Las Vegas', '2025-03-14 02:00:09'),
(18, 'Katherine Scott', 'Support', 'Company M', 'katherine@example.com', 'new', 'Referral', 'Phoenix', '2025-03-14 02:00:09'),
(19, 'Liam Harris', 'Tech Lead', 'Company N', 'liam@example.com', 'contacted', 'LinkedIn', 'Atlanta', '2025-03-14 02:00:09'),
(20, 'Mia Adams', 'Recruiter', 'Company O', 'mia@example.com', 'closed', 'Facebook', 'San Diego', '2025-03-14 02:00:09'),
(21, 'Nathan Baker', 'Developer', 'Company P', 'nathan@example.com', 'new', 'Instagram', 'Philadelphia', '2025-03-14 02:00:09'),
(22, 'Olivia Green', 'Designer', 'Company Q', 'olivia@example.com', 'contacted', 'Website', 'Portland', '2025-03-14 02:00:09'),
(23, 'Patrick Young', 'Manager', 'Company R', 'patrick@example.com', 'closed', 'Twitter', 'Minneapolis', '2025-03-14 02:00:09'),
(24, 'Quinn Allen', 'Analyst', 'Company S', 'quinn@example.com', 'new', 'Referral', 'Nashville', '2025-03-14 02:00:09'),
(25, 'Rachel Wright', 'CEO', 'Company T', 'rachel@example.com', 'contacted', 'LinkedIn', 'Indianapolis', '2025-03-14 02:00:09'),
(26, 'Zacky Raechan', 'CEO', 'ZCKY Agency', 'zackyraechan@gmail.com', 'contacted', 'Instagram', 'Mataram City, Indonesia', '2025-03-14 02:05:55');

ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

