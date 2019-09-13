-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2019 at 02:39 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tbnode`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients_demographic_info`
--

CREATE TABLE `clients_demographic_info` (
  `id` int(11) NOT NULL,
  `record_id` varchar(24) NOT NULL,
  `case_year` int(11) NOT NULL,
  `cluster_name` varchar(255) NOT NULL,
  `latitude` varchar(16) NOT NULL,
  `longitude` varchar(16) NOT NULL,
  `case_detected` int(11) NOT NULL,
  `sb_date` varchar(12) NOT NULL,
  `status` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `short_code` varchar(4) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `short_code`, `status`) VALUES
(1, 'Tanzania', 'TZ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `name`) VALUES
(1, 'Principle Investigator'),
(2, 'Coordinator'),
(4, 'Country Coordinator'),
(6, 'Data Clark'),
(7, 'Data Manager'),
(8, 'Country Data Manager');

-- --------------------------------------------------------

--
-- Table structure for table `prevalence_survey`
--

CREATE TABLE `prevalence_survey` (
  `id` int(11) NOT NULL,
  `record_id` varchar(24) NOT NULL,
  `case_year` int(11) NOT NULL,
  `smear_15_24` int(11) NOT NULL,
  `smear_25_34` int(11) NOT NULL,
  `smear_35_44` int(11) NOT NULL,
  `smear_45_54` int(11) NOT NULL,
  `smear_55_64` int(11) NOT NULL,
  `smear_65_above` int(11) NOT NULL,
  `smear_male` int(11) NOT NULL,
  `smear_female` int(11) NOT NULL,
  `smear_low` int(11) NOT NULL,
  `smear_middle` int(11) NOT NULL,
  `smear_high` int(11) NOT NULL,
  `bact_15_24` int(11) NOT NULL,
  `bact_25_34` int(11) NOT NULL,
  `bact_35_44` int(11) NOT NULL,
  `bact_45_54` int(11) NOT NULL,
  `bact_55_64` int(11) NOT NULL,
  `bact_65_above` int(11) NOT NULL,
  `bact_male` int(11) NOT NULL,
  `bact_female` int(11) NOT NULL,
  `bact_low` int(11) NOT NULL,
  `bact_middle` int(11) NOT NULL,
  `bact_high` int(11) NOT NULL,
  `sb_date` varchar(12) NOT NULL,
  `status` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `routine_data`
--

CREATE TABLE `routine_data` (
  `id` int(11) NOT NULL,
  `record_id` varchar(24) NOT NULL,
  `case_year` int(11) NOT NULL,
  `bact_conf_tb` int(11) NOT NULL,
  `pul_clinc_diag_tb` int(11) NOT NULL,
  `extra_pul_diag_tb` int(11) NOT NULL,
  `relapse` int(11) NOT NULL,
  `treatment_after_failure` int(11) NOT NULL,
  `return_after_lost_follow_up` int(11) NOT NULL,
  `other_previously_treated` int(11) NOT NULL,
  `hiv_no_tested` int(11) NOT NULL,
  `hiv_positive_case` int(11) NOT NULL,
  `hiv_register_for_care` int(11) NOT NULL,
  `hiv_start_art` int(11) NOT NULL,
  `hiv_started_cpt` int(11) NOT NULL,
  `nw_cured_bact_conf` int(11) NOT NULL,
  `nw_cured_relapse` int(11) NOT NULL,
  `nw_tc_bact_conf` int(11) NOT NULL,
  `nw_tc_cli_diag` int(11) NOT NULL,
  `nw_tc_cli_diag_extra` int(11) NOT NULL,
  `nw_tc_relapse` int(11) NOT NULL,
  `nw_ts_bact_conf` int(11) NOT NULL,
  `nw_ts_cli_diag` int(11) NOT NULL,
  `nw_ts_cli_diag_extra` int(11) NOT NULL,
  `nw_ts_relapse` int(11) NOT NULL,
  `nw_fl_bact_conf` int(11) NOT NULL,
  `nw_fl_relapse` int(11) NOT NULL,
  `nw_died_bact_conf` int(11) NOT NULL,
  `nw_died_cli_diag` int(11) NOT NULL,
  `nw_died_cli_diag_extra` int(11) NOT NULL,
  `nw_died_relapse` int(11) NOT NULL,
  `nw_lf_bact_conf` int(11) NOT NULL,
  `nw_lf_cli_diag` int(11) NOT NULL,
  `nw_lf_cli_diag_extra` int(11) NOT NULL,
  `nw_lf_relapse` int(11) NOT NULL,
  `prev_cure_treat_failure` int(11) NOT NULL,
  `prev_cure_treat_lst_flw` int(11) NOT NULL,
  `prev_cure_prev_treat` int(11) NOT NULL,
  `prev_tc_treat_failure` int(11) NOT NULL,
  `prev_tc_treat_lst_flw` int(11) NOT NULL,
  `prev_tc_prev_treat` int(11) NOT NULL,
  `prev_ts_treat_failure` int(11) NOT NULL,
  `prev_ts_treat_lst_flw` int(11) NOT NULL,
  `prev_ts_prev_treat` int(11) NOT NULL,
  `prev_fl_treat_failure` int(11) NOT NULL,
  `prev_fl_treat_lst_flw` int(11) NOT NULL,
  `prev_fl_prev_treat` int(11) NOT NULL,
  `prev_died_treat_failure` int(11) NOT NULL,
  `prev_died_treat_lst_flw` int(11) NOT NULL,
  `prev_died_prev_treat` int(11) NOT NULL,
  `prev_lf_treat_failure` int(11) NOT NULL,
  `prev_lf_treat_lst_flw` int(11) NOT NULL,
  `prev_lf_prev_treat` int(11) NOT NULL,
  `sb_date` varchar(12) NOT NULL,
  `c_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `position` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `access_level` int(11) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `pswd` int(11) NOT NULL,
  `token` varchar(10) NOT NULL,
  `reg_date` varchar(100) NOT NULL,
  `last_login` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `power` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `firstname`, `lastname`, `position`, `username`, `password`, `salt`, `access_level`, `phone_number`, `status`, `pswd`, `token`, `reg_date`, `last_login`, `picture`, `email_address`, `power`, `c_id`, `s_id`, `count`, `staff_id`) VALUES
(1, 'Frdrck', 'Aman', 'admin', 'FEC/337331', '2c74bce8e973e8df1bfb99621f1843dceed4852e3839c8ce76283d32163fbeb1', 'ã\0I«uK:^eý¦ûÅi{—>¡ñF;/B“~Íbx', 1, '0718652221', 1, 1, '', '', '2019-07-19', 'assets/users/National Institute for Medical Research, Muhimbili Research Center.jpg', 'frdrckaman@gmail.com', 1, 1, 2, 1, 0),
(2, 'frdrck', 'aman', 'admin', 'f.am', '80aa522f5009f790e92d8161b6ba45220b6b60ca926bfd30f0126df4eb6396e6', '2yksjlwkwhpmqi628go8u36v1xnm2blu', 1, '+255718652228', 1, 1, '', '2019-05-13', '2019-09-06', '', 'nimrdata@gmail.com', 1, 1, 2, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `suggestion`
--

CREATE TABLE `suggestion` (
  `id` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `s_date` varchar(12) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients_demographic_info`
--
ALTER TABLE `clients_demographic_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prevalence_survey`
--
ALTER TABLE `prevalence_survey`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routine_data`
--
ALTER TABLE `routine_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suggestion`
--
ALTER TABLE `suggestion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients_demographic_info`
--
ALTER TABLE `clients_demographic_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prevalence_survey`
--
ALTER TABLE `prevalence_survey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routine_data`
--
ALTER TABLE `routine_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suggestion`
--
ALTER TABLE `suggestion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
