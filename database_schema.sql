CREATE DATABASE IF NOT EXISTS `lapor-revised`;
USE `lapor-revised`;

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `usertype` VARCHAR(50) NOT NULL DEFAULT 'masyarakat'
);

CREATE TABLE `laporan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `is_anonymous` TINYINT(1) DEFAULT 0,
  `user_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME,
  `status` VARCHAR(50) NOT NULL DEFAULT 'menunggu',
  `imagepath` VARCHAR(255),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

CREATE TABLE `comments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `content` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `user_id` INT NOT NULL,
  `laporan_id` INT NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`laporan_id`) REFERENCES `laporan`(`id`) ON DELETE CASCADE
);

-- Insert some dummy users for testing
INSERT INTO `users` (`name`, `email`, `password`, `usertype`) VALUES
('Admin', 'admin@example.com', 'admin123', 'admin'),
('Instansi', 'instansi@example.com', 'instansi123', 'instansi'),
('Masyarakat', 'masyarakat@example.com', 'masyarakat123', 'masyarakat');
