-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2015 at 11:41 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `htnews`
--
USE htnews;
-- --------------------------------------------------------

--
-- Table structure for table `tbl_post`
--

CREATE TABLE IF NOT EXISTS `tbl_post` (
`id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `published` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `tbl_post`
--

INSERT INTO `tbl_post` (`id`, `title`, `body`, `image_url`, `mime_type`, `published`, `user_id`) VALUES
(1, 'First Post', 'Oh boy! this is the first post.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ac placerat lorem. Fusce leo elit, varius in tincidunt sed, dapibus vitae lectus. Donec non sollicitudin lacus. Morbi sollicitudin, metus non pulvinar varius, tortor lorem pharetra neque, sed bibendum elit neque sed nibh. Nulla vel posuere lectus. Vivamus dapibus elit risus, non scelerisque dolor elementum sit amet. Sed non bibendum justo, sed rutrum est. Ut vel massa metus. Pellentesque pellentesque pellentesque laoreet. Nam dignissim auctor tortor eget sagittis. Fusce vulputate ut sapien eu rutrum. Donec id facilisis lectus.\r\n\r\nVestibulum eu urna non urna tempor imperdiet. Quisque commodo neque nec diam ultricies, vitae scelerisque nisi congue. Nulla ac enim volutpat, congue sem at, elementum ex. Proin ultrices at dolor in condimentum. In maximus, felis eleifend sollicitudin accumsan, turpis velit pulvinar velit, vel bibendum enim augue vel ipsum. Suspendisse ut urna erat. Nam tincidunt, lectus ut tincidunt lacinia, velit massa tincidunt purus, lacinia lobortis nibh risus nec arcu. Proin efficitur tincidunt molestie. Phasellus lobortis ultricies eros vitae congue. Suspendisse sollicitudin, nibh nec suscipit lobortis, magna metus scelerisque mi, eget bibendum arcu sem sed lacus. Aliquam congue gravida leo, at consectetur lacus. Aenean ultrices scelerisque metus sed dapibus.\r\n\r\nProin aliquet maximus porttitor. Donec efficitur lorem dolor, a lobortis diam hendrerit id. In hac habitasse platea dictumst. Duis ut tellus ultrices, condimentum nunc nec, vehicula nibh. Sed blandit lacus vitae feugiat cursus. Vivamus varius congue mauris quis lobortis. Etiam euismod nibh a nisi luctus, at faucibus elit hendrerit. In vel tincidunt diam. Donec blandit, ex sed cursus rhoncus, turpis felis posuere sem, lacinia interdum urna justo sed sapien. Sed tristique et diam a sodales. Vivamus ac placerat mauris, et lacinia sapien. Morbi laoreet purus sed nibh maximus ultrices.\r\n\r\nAliquam ultrices ultricies condimentum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin diam odio, fringilla id ante id, mattis ultrices tortor. Mauris ultricies risus velit, ac auctor leo blandit quis. Morbi in hendrerit erat. Ut vel dapibus nisl. Cras vel nisi id diam finibus tincidunt eu quis augue. In non est quis nisi volutpat aliquet.\r\n\r\nMauris semper sapien sed lectus semper sodales. Sed at ex dignissim, vestibulum nibh in, bibendum velit. Fusce mattis nisl et tellus lacinia, non commodo massa tempor. Nulla facilisi. Praesent sed sapien a massa sodales auctor. Etiam hendrerit posuere diam a dictum. Sed pellentesque lectus id suscipit auctor. Fusce nisl tortor, dapibus quis turpis nec, sagittis pellentesque urna. Donec eu magna neque. Ut a est eget nunc convallis facilisis. Pellentesque viverra lacus a sapien scelerisque dictum. Aenean varius justo a vestibulum aliquet. Aliquam eu ipsum condimentum, gravida risus mollis, fringilla ante. Proin pharetra egestas nisi, in tristique elit rutrum non.', '2.jpg', 'image/jpeg', '2015-06-09 08:10:09', 1)
-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
`id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) DEFAULT NULL,
  `created` datetime NOT NULL,
  `is_verified` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=not verfied, 1=verified',
  `verification_code` varchar(100) DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `email`, `password`, `created`, `is_verified`, `verification_code`) VALUES
(1, 'happyhardik@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2015-06-10 16:43:08', 1, '0'),
--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_post`
--
ALTER TABLE `tbl_post`
 ADD PRIMARY KEY (`id`), ADD KEY `FK__tbl_user` (`user_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_post`
--
ALTER TABLE `tbl_post`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_post`
--
ALTER TABLE `tbl_post`
ADD CONSTRAINT `FK__tbl_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
