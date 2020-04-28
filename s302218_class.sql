-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2020 at 07:56 AM
-- Server version: 10.1.44-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s302218_class`
--

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `h1` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `navBarText` varchar(100) NOT NULL,
  `navBarDisplay` varchar(1) NOT NULL DEFAULT 'n',
  `navBarOrder` int(3) NOT NULL,
  `content` text NOT NULL,
  `includes` varchar(255) NOT NULL,
  `dtg` int(16) NOT NULL,
  `priv` int(1) NOT NULL DEFAULT '0',
  `active` varchar(1) NOT NULL DEFAULT 'n'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `title`, `h1`, `link`, `navBarText`, `navBarDisplay`, `navBarOrder`, `content`, `includes`, `dtg`, `priv`, `active`) VALUES
(3, 'Services', 'Services', 'services', 'Services', 'y', 2, 'bla bla bla', '', 1505608175, 0, 'y'),
(4, 'Contact', 'Contact', 'contact', 'Contact', 'y', 3, 'Contact fgdsgfdsfg', '', 1510794872, 0, 'y'),
(8, 'trewt', 't3', 'we', 'te', 'n', 0, '1136', 'sd', 1507967606, 0, 'y'),
(9, 'mod', 'rty', 'test5', 'modified', 'n', 0, 'more content', '', 1508989162, 0, 'n'),
(11, 'sdf', 'sdf', 'sdfsd', 'sdfs', 'y', 4, 'sdf', '', 1508389248, 0, 'n'),
(12, 'Home', 'Welcome to our page', 'home', 'Home', 'y', 0, '     <section class=\"content\">\r\n             <h2 class=\"spacing\">Big Title</h2>\r\n             <article>\r\n                <p class=\"dropCap\">Cras ultrices nibh at odio ullamcorper, a commodo erat interdum. Aliquam ac elit at arcu viverra consectetur vel eu lectus. Quisque nec justo in mauris mattis venenatis at non orci. Integer dignissim aliquet nunc vitae posuere. Morbi accumsan, magna vel sodales vestibulum, justo metus aliquam erat, ut tempor diam justo ut dui. Donec pharetra urna at purus tristique interdum. Integer pellentesque molestie erat. Pellentesque eu elementum diam, at vulputate purus. Integer in lobortis urna. Vestibulum sodales est vitae magna pellentesque, sollicitudin feugiat nisi molestie. Vivamus tempus nunc eget diam molestie porta. Quisque vitae libero magna. Etiam quis pellentesque arcu. Proin elementum posuere mattis.</p>\r\n                <p class=\"dropCap\">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n             </article>\r\n\r\n         </section>\r\n\r\n         <aside class=\"sidebar\">\r\n          \r\n             <article>\r\n                <p class=\"dropCap\">Praesent tempus, magna ac rutrum porttitor, lectus eros finibus erat, ac imperdiet ipsum purus sit amet lectus. Morbi id erat sagittis, hendrerit est at, dictum arcu. Suspendisse tincidunt leo quis purus aliquet pellentesque. Nunc vel porttitor urna. Quisque in feugiat libero, eget finibus ipsum. Aliquam tristique id lectus vitae condimentum. Nam ut posuere neque. Cras id tellus urna. Donec eu efficitur nisl. Fusce mauris risus, condimentum eget maximus eu, tincidunt tincidunt velit.</p>\r\n\r\n\r\n             </article>\r\n\r\n\r\n         </aside>', '', 1510795404, 0, 'y');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pw` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `sname` varchar(255) NOT NULL,
  `priv` int(1) NOT NULL DEFAULT '0',
  `active` varchar(1) NOT NULL DEFAULT 'n'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `pw`, `fname`, `sname`, `priv`, `active`) VALUES
(1, 'fredbfhdfhdfh', '663b8d72dc84c87f87dabd1302c57da7035ba27f', 'Fred', 'Bloggs', 3, 'y'),
(2, 'dauld@test.com', '$2y$10$ct/qXJvCwvbi29QmbbSjveFbQ/oj7jtW63wZrsmPcj76ZwmDp8dI2', 'David', 'Auld', 3, 'y'),
(3, 'test@test.com', '55c3b5386c486feb662a0785f340938f518d547f', 'Test', 'Tester', 1, 'y'),
(4, 'mike@f.cd', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', 'mike', 'Smiff', 1, 'y'),
(5, 'mm', '4028a0e356acc947fcd2bfbf00cef11e128d484a', 'test', 'test', 2, 'y'),
(6, 'a', '6f9b0a55df8ac28564cb9f63a10be8af6ab3f7c2', 'a', 'a', 1, 'y'),
(7, 'Gene.Simmons@genes.com', 'ff232d7a7cf4235c667fbcdd5798aa7c56535963', 'Gene', 'Simmons', 1, 'y'),
(8, 'Michael.Jordan@nba.com', 'bac55382cdfd2db38eba4332483623121c155dc5', 'Michael', 'Jordan', 3, 'y'),
(9, 'Fred.Nerk@fred.com', '8a472bb4018913e0badffe4b0e4594795e4f2764', 'Fred', 'Nerk', 2, 'y'),
(10, 'brad@b.com', '4028a0e356acc947fcd2bfbf00cef11e128d484a', 'Brad', 'Brown', 2, ''),
(11, 't@t.t', '$2y$10$n78LnLq/Vtns1nHqq8Y8XujYSL4nmX7e8ArO3ijWoGl6Mio0oH.Rm', 'John', 'Doe', 1, ''),
(12, 'Joe.Bloggs@cdu.au', '6a1910ff509708b4198d8a16632a127213a30e72', 'Joe', 'Bloggs', 1, 'y'),
(13, 'megan.louse@test.com', '479578d84f5facb5a875ecf245aae41ea2de38d8', 'Megan', 'Louise', 1, ''),
(17, 'fred@DF.DS', '663b8d72dc84c87f87dabd1302c57da7035ba27f', 'fred1', 'fred1', 2, ''),
(18, 'fred@fred.com', '663b8d72dc84c87f87dabd1302c57da7035ba27f', 'fred@fred.com', 'Bloggs', 2, ''),
(19, '2@43.com', 'cb711f6c34b4568a3b356d03aa677ec0fc904e19', 'Jane', 'Bloggs', 1, ''),
(20, 'brad@hotmail.com', '5b2e050bbec5ed7d6223039f19d86df3b90419b1', 'brad', 'brown', 2, ''),
(44, 'w@w.w', '$2y$10$c5k35EPfnrNqWsGTQS.PauQzf.pa9ZE2iuMCwNxVBTuWb7orOStFe', 'dsf', 'sdfs', 1, 'n'),
(22, 'g', '48e1a46fea43b7d6e21fcd2ac996415053dbb3b2', 'g', 'g', 1, 'y'),
(23, 'ddds@d.com', '6af77af68f4dfd2bad990772bd3e5e6534feb5fa', 'dssd', 'sddsds', 1, 'n'),
(25, 'bradb', 'bf9f464311af70de6109a5694d40a678e356a102', 'gangster g bradb', 'bradb', 1, 'y'),
(26, 'Louise.drill@tester.com', 'f8e11177a7e34f34595ba2088bf2d0dce3b745fd', 'Louise', 'Mcmill', 1, 'y'),
(27, '1@1.com.au', '3cb657eb357e1a0eba46e9d00745c11d090fbd01', 'ew', 'efrf', 2, 'y'),
(28, 'peter@peters.com.au', '63982e54a7aeb0d89910475ba6dbd3ca6dd4e5a1', 'Peter', 'Peters', 2, 'y'),
(29, 'liv', 'pass', 'Liv', 'S', 3, 'y'),
(41, 'd@d.d', '$2y$10$TZawo.v9gtHhmQtWIzS79erNmJSwLEjZx1OepNvXfxBVX3a.cd80K', 'test', 'ing', 2, 'n'),
(42, 'low@l.com', '$2y$10$laLzgBb7v5awSPIl38wQl.8wctrBo.16PXX06Ds7bUQmAdImZhMxm', 'priv2', 'priv', 0, ''),
(43, 'priv1@p.com', '$2y$10$tRwAAHhSOgTpqyES8Yw2NeHA.UR5THIOyIvWDcM3ZWSb1G8A4FESC', 'priv1', 'priv1', 1, ''),
(38, 'q@q.qa', '$2y$10$/5JBC/wcx5wPZYg1I1lxNOCW95Ya9jKnfrtx8pYo5Y/.B4tuD8YQW', 'q', 'q', 0, 'y'),
(39, 'e@e.ee', '$2y$10$d/g.PWPhb1AYs8GG.liyq.AWkX/gLfoSLTkTLyjyGdSSfssi8tIa6', '1', '1', 0, 'n'),
(40, 'liv@l.com', '$2y$10$n8OnGNkwl/M4yniP9mpBC./RvcPceq4MD8xNPoYOTS1j2A0Rp7Rxu', 'liv', 's', 3, 'n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `link` (`link`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
