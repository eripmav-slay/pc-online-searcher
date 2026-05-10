-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-12-02 04:14:08
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `school-pcs`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `mac-address`
--

CREATE TABLE `mac-address` (
  `classroom` text NOT NULL,
  `number` int(11) NOT NULL,
  `mac-address` text NOT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `mac-address`
--

INSERT INTO `mac-address` (`classroom`, `number`, `mac-address`, `comment`) VALUES
('301A', 1, '9c-6b-00-44-25-2b', ''),
('303A', 2, '303A-2-不明', '使用不可'),

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `mac-address`
--
alter table `mac-address`
  add unique key `mac-address` (`mac-address`) using hash;
commit;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
