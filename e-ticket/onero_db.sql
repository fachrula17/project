-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 20 Sep 2020 pada 06.45
-- Versi Server: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onero_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL,
  `date` date NOT NULL,
  `is_active` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `date`, `is_active`) VALUES
(1, 'admin', '$2y$10$St0I7NA/6KA1nNrOo4aWeOUODSXu4cXijjY6Z7lp8vSq3QbZSnYSO', '2020-09-14', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `deposit`
--

CREATE TABLE `deposit` (
  `id_deposit` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` int(8) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upload` varchar(150) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `confirmed_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `deposit`
--

INSERT INTO `deposit` (`id_deposit`, `user_id`, `total`, `date`, `upload`, `status`, `confirmed_by`) VALUES
(3, 10, 500000, '2020-09-19 18:58:21', 'cindy-19092020.PNG', '1', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `event`
--

CREATE TABLE `event` (
  `id_event` int(11) NOT NULL,
  `event_name` varchar(50) NOT NULL,
  `location` text NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `price` int(7) NOT NULL,
  `is_active` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `event`
--

INSERT INTO `event` (`id_event`, `event_name`, `location`, `time`, `date`, `price`, `is_active`) VALUES
(4, 'Programming Webinar', 'Zoom', '09:00:00', '2020-09-22', 200000, '1'),
(5, 'Healthy Webinar', 'Zoom', '13:00:00', '2020-09-23', 180000, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `event_register`
--

CREATE TABLE `event_register` (
  `id_registered` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `no_ticket` varchar(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `event_register`
--

INSERT INTO `event_register` (`id_registered`, `user_id`, `event_id`, `no_ticket`, `date`, `status`) VALUES
(4, 4, 4, 'ET36681749', '2020-09-19 16:41:49', '0'),
(5, 10, 5, 'ET56945148', '2020-09-19 18:59:48', '1'),
(6, 10, 7, 'ET14287053', '2020-09-19 19:03:54', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `no_ticket` varchar(10) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `metode` enum('deposit','transfer') NOT NULL,
  `bank_name` varchar(10) DEFAULT NULL,
  `account_name` varchar(50) DEFAULT NULL,
  `total` int(8) NOT NULL,
  `upload` varchar(100) DEFAULT NULL,
  `status` enum('0','1') NOT NULL,
  `confirmed_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id_order`, `no_ticket`, `event_id`, `user_id`, `date`, `metode`, `bank_name`, `account_name`, `total`, `upload`, `status`, `confirmed_by`) VALUES
(4, 'ET07392553', 5, 4, '2020-09-17 21:48:53', 'transfer', 'BCA', 'Fachrul Ahaddin', 180000, 'FACHRUL_AHADDIN_DISC.PNG', '1', 1),
(5, 'ET36681749', 4, 4, '2020-09-19 16:41:49', 'deposit', '', '', 200000, '', '1', 1),
(6, 'ET56945148', 5, 10, '2020-09-19 18:59:48', 'deposit', NULL, NULL, 180000, NULL, '1', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(13) NOT NULL,
  `total_deposit` int(6) NOT NULL,
  `is_active` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `email`, `password`, `fullname`, `address`, `phone`, `total_deposit`, `is_active`) VALUES
(4, 'fachrul.dumet@gmail.com', '$2y$10$f7CkOtnZ.8hACCI3nuDWRuGdnTOAjt2PivQ2TDefUJDH84PDrWYxm', 'Fachrul Ahaddin', 'jl. Utan Jati Kp. Tebaci 2', '08123456789', 300000, '1'),
(10, 'info.baledemy@gmail.com', '$2y$10$A8az/xDBYbeu2r5sq3xK0eqzmysbXPHnJ6orGyL9oCu.KTIsxqGOG', 'Baledemy', 'Jl. Utan Jati Kalideres', '08123456789', 320000, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `token` varchar(128) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id_deposit`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`);

--
-- Indexes for table `event_register`
--
ALTER TABLE `event_register`
  ADD PRIMARY KEY (`id_registered`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id_deposit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `event_register`
--
ALTER TABLE `event_register`
  MODIFY `id_registered` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
