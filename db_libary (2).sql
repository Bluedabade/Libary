-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2025 at 12:48 PM
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
-- Database: `db_libary`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_book`
--

CREATE TABLE `tb_book` (
  `id` int(255) NOT NULL,
  `b_id` varchar(255) NOT NULL,
  `b_name` varchar(255) NOT NULL,
  `b_writer` varchar(255) NOT NULL,
  `b_category` int(255) NOT NULL,
  `b_price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_book`
--

INSERT INTO `tb_book` (`id`, `b_id`, `b_name`, `b_writer`, `b_category`, `b_price`) VALUES
(1, 'B00001', 'คู่มือการสอบรับราชการ', 'สมศักดิ์ ตั้งใจ', 1, 299),
(2, 'B00002', 'แฮร์รี่ พอตตเตอร์', 'J.K. Rowling', 2, 359),
(3, 'B00003', 'เย็บ ปัก ถักร้อย', 'สะอาด อิ่มสุข', 3, 249),
(4, 'B00004', 'เจ้าชายน้อย', 'อ็องตวน เดอ แซ็ง', 2, 355),
(5, 'B00005', 'การเขียนโปรแกรมคอมพิวเตอร์', 'กิ่งแก้ว กลิ่่นหอม', 1, 329);

-- --------------------------------------------------------

--
-- Table structure for table `tb_borrow_book`
--

CREATE TABLE `tb_borrow_book` (
  `br_id` int(255) NOT NULL,
  `br_date_br` date NOT NULL,
  `br_date_rt` date DEFAULT NULL,
  `b_id` varchar(255) NOT NULL,
  `me_user` varchar(255) NOT NULL,
  `br_fine` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_borrow_book`
--

INSERT INTO `tb_borrow_book` (`br_id`, `br_date_br`, `br_date_rt`, `b_id`, `me_user`, `br_fine`) VALUES
(21, '2025-03-08', '2025-03-08', 'B00001', 'member01', 40),
(22, '2025-03-09', '2025-03-08', 'B00002', 'member02', 0),
(23, '2025-03-09', NULL, 'B00001', 'member01', 0),
(24, '2025-03-10', NULL, 'B00003', 'member03', 0),
(25, '2025-03-09', NULL, 'B00004', 'member04', 0),
(26, '2025-03-09', NULL, 'B00005', 'member05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_member`
--

CREATE TABLE `tb_member` (
  `m_id` int(255) NOT NULL,
  `m_user` varchar(255) NOT NULL,
  `m_pass` varchar(255) NOT NULL,
  `m_name` varchar(255) NOT NULL,
  `m_phone` varchar(255) NOT NULL,
  `m_permis` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tb_member`
--

INSERT INTO `tb_member` (`m_id`, `m_user`, `m_pass`, `m_name`, `m_phone`, `m_permis`) VALUES
(1, 'admin', '1234', 'admin', '0810000000', 'admin'),
(2, 'member01', 'abc1111', 'สมหญิง จริงใจ', '0811111111', 'user'),
(3, 'member02', 'abc2222', 'สมชาย มั่นคง', '0822222222', 'user'),
(4, 'member03', 'abc3333', 'สมเกียรติ เก่งกล้า', '0833333333', 'user'),
(5, 'member04', 'abc4444', 'สมสมร อิ่มเอม', '0844444444', 'user'),
(6, 'member05', 'abc5555', 'สมรักษ์ สะอาด', '0855555555', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_book`
--
ALTER TABLE `tb_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_borrow_book`
--
ALTER TABLE `tb_borrow_book`
  ADD PRIMARY KEY (`br_id`);

--
-- Indexes for table `tb_member`
--
ALTER TABLE `tb_member`
  ADD PRIMARY KEY (`m_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_book`
--
ALTER TABLE `tb_book`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_borrow_book`
--
ALTER TABLE `tb_borrow_book`
  MODIFY `br_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tb_member`
--
ALTER TABLE `tb_member`
  MODIFY `m_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
