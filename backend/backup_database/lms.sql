-- -------------------------------------------------------------
-- TablePlus 6.2.1(578)
--
-- https://tableplus.com/
--
-- Database: lms
-- Generation Time: 2025-02-14 13:29:48.2570
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE TABLE `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) DEFAULT NULL,
  `course_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`) VALUES
(1, 'baironbg', 'baironbernal263@gmail.com', '$2y$12$SUd9sIbe2kbYR74VLx4IxeY2UXnjKJHVyjRP25ri6rUx41dVRdg6e', NULL),
(3, 'bairiton', 'bbernal@qargocoffee.com', '$2y$12$r9tH/nCPJk2RCwJ.eNxas.0JB6iBao7.mSRqgvGOHi9f4dbrYhrPu', NULL),
(4, 'testuser', 'testuser@example.com', '$2y$12$dReZK3Q1yugk9iJfNdxPWOxkes1nkosWrNFVrIOdY04i8esiMEoZa', NULL),
(5, 'bababa', 'testuser22@example.com', '$2y$12$5ayMLzWEDY19XH/m9D4KJ.Bqc1EJoeEqYpAgkvZAHPs/MaKG/qGP.', NULL),
(6, 'ultras', 'ultras@example.com', '$2y$12$UpiwqvlW56/xGG5UF0Mkz.XWHVJY6YhKN1a8Dafrbd6gydZvO0Lha', NULL),
(7, 'test', 'test@example.com', '$2y$12$aL4ulafurEAVTo7IsKpjAe44JJ6kx7Io4Cy7YHXuMdoawbxh0.Y3S', NULL);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;