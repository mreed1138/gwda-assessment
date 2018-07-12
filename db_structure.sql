-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 12, 2018 at 04:32 PM
-- Server version: 5.6.32-78.1
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


-- --------------------------------------------------------

--
-- Table structure for table `course_new`
--

CREATE TABLE `course_new` (
  `c_id` varchar(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `points` varchar(11) NOT NULL,
  `a` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_new`
--

INSERT INTO `course_new` (`c_id`, `title`, `points`, `a`) VALUES
('GWDA123', 'Programming Logic', '1;2;3;5', 0),
('GWDA202', 'Interface Design', '1;2;3;4', 1),
('GWDA203', 'Pre-Press &amp Production', '1;2;3;4', 0),
('GWDA209', 'Portfolio I', '1;2;3;4;5', 0),
('GWDA222', 'Intermediate Layout Design', '1;2;3;4', 0),
('GWDA262', 'Package Design', '1;2;3;4', 0),
('GWDA273', 'Intermediate Web Design', '1;2;3;5', 1),
('GWDA382', 'Design for Mobile Devices', '1;2;3;5', 0),
('GWDA419', 'Portfolio II', '1;2;3;5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `degree`
--

CREATE TABLE `degree` (
  `d_id` int(11) NOT NULL,
  `degree` varchar(6) NOT NULL,
  `full` varchar(80) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `degree`
--

INSERT INTO `degree` (`d_id`, `degree`, `full`) VALUES
(1, 'GWDA-B', 'Graphic and Web Design: Web Concentration Bachelors '),
(2, 'WDD', 'Web Design and Development'),
(3, 'WC', 'Web Design and Interactive Communication'),
(4, 'WDIM-B', 'Web Design and Interactive Media Bachelors '),
(5, 'WDIM-A', 'Web Design and Interactive Media Associate'),
(6, 'GWDB-G', 'Graphic and Web Design: Graphic Concentration Bachelors '),
(7, 'GWDA-G', 'Graphic and Web Design: Graphic Concentration Associate');

-- --------------------------------------------------------

--
-- Table structure for table `main_new`
--

CREATE TABLE `main_new` (
  `m_id` int(11) NOT NULL,
  `m_topic` varchar(125) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `main_new`
--

INSERT INTO `main_new` (`m_id`, `m_topic`, `description`) VALUES
(1, 'Design', 'Graduates demonstrate versatile aesthetic layout and design solutions, utilizing Design Elements and Principles including: effective usage of space, line, color, shape, texture, form, balance and value; typographic and photographic hierarchy structures. Concepts and design principles applied with a unity and freshness that enhances the messages. Tone creates a compelling message for the identified target audience. Presented in a cohesive & meaningful visual manner in which relationship among parts is established by striking conceptual and visual means '),
(2, 'Conceptual', 'Graduates demonstrate conceptual and critical thinking through work that reflects historical and contemporary trends, answering design problems with creative visual and writing elements. Innovative/original concept that is cohesive and surpasses expectations to meet project objectives. A high level of conceptual thinking and understanding of theory is demonstrated in this project. '),
(3, 'Communication & Professional Presentation', 'Graduates demonstrate the interdependence of content and visual expression; evaluate and critique their design concept; through oral and written communication graduates articulate the vision behind their creative work, and defend their design solutions by: communicating mastery of graphic or web design, problem solving, ethics, and industry standards in visual presentations.  '),
(4, 'Graphic Design Specific Outcomes - Technical', 'Graduates demonstrate and apply competencies in industry-specific computer software programs. These include preparation and presentation of work, technical aspects of prepress, output, color space, resolution, paper choices, craftsmanship, and quality reproduction'),
(5, 'Web Design Specific Outcomes - Technical', 'Graduates demonstrate knowledge of interactive design & development using industry software, authoring systems and/or web scripting. HTML/CSS are semantically correct and validation. Excellent connection between needs of audience and usability; conforms to excellence in professional usability standards. ');

-- --------------------------------------------------------

--
-- Table structure for table `points_new`
--

CREATE TABLE `points_new` (
  `p_id` int(11) NOT NULL,
  `m_id` int(11) NOT NULL,
  `topic` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `points_new`
--

INSERT INTO `points_new` (`p_id`, `m_id`, `topic`) VALUES
(1, 1, 'Layout'),
(2, 1, 'Elements and Principles of Des'),
(3, 1, 'Typography'),
(4, 2, 'Innovative/Originality'),
(5, 2, 'Reflect Current Styles/Trends'),
(6, 2, 'Social, cultural, and historic'),
(7, 3, 'Professional Appearance'),
(8, 3, 'Self confidence in presentatio'),
(9, 3, 'Product/Project Knowledge'),
(10, 4, 'Prepress'),
(11, 4, 'Production'),
(12, 5, 'Scripting [Client/Server-Side]'),
(13, 5, 'Motion Graphics'),
(14, 5, 'User-Centered Design');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_new`
--
ALTER TABLE `course_new`
  ADD UNIQUE KEY `c_id` (`c_id`);

--
-- Indexes for table `degree`
--
ALTER TABLE `degree`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `main_new`
--
ALTER TABLE `main_new`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `points_new`
--
ALTER TABLE `points_new`
  ADD PRIMARY KEY (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `degree`
--
ALTER TABLE `degree`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `main_new`
--
ALTER TABLE `main_new`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `points_new`
--
ALTER TABLE `points_new`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
