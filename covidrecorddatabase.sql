-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2026 at 05:50 PM
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
-- Database: `covidrecorddatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctor_activity`
--

CREATE TABLE `doctor_activity` (
  `iD` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `age` bigint(255) NOT NULL,
  `test_status` varchar(255) NOT NULL,
  `covid_type` varchar(255) NOT NULL,
  `admission_date` varchar(255) NOT NULL,
  `vaccine_name` varchar(255) NOT NULL,
  `vaccine_dose` bigint(255) NOT NULL,
  `vaccination_date` varchar(255) NOT NULL,
  `discharge_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_activity`
--

INSERT INTO `doctor_activity` (`iD`, `name`, `email`, `age`, `test_status`, `covid_type`, `admission_date`, `vaccine_name`, `vaccine_dose`, `vaccination_date`, `discharge_date`) VALUES
(2, 'Amir', 'Amir@gmail.com', 22, '+ve', 'SARS-CoV-2', '10-12-2021', 'AZ-SKBio', 2, '15-12-2021', '18-12-2021'),
(3, 'Asad', 'Asad@gmail.com', 30, '+ve', 'SARS-CoV-2', '10-10-2020', 'AstraZeneca-SKB', 1, '15-10-2020', '20-10-2020'),
(4, 'Arshad', 'Arshad@gmail.com', 35, '+ve', 'SARS-CoV-2', '13-06-2026', 'Pfizer', 0, '17-06-2026', '19-06-2026');

-- --------------------------------------------------------

--
-- Table structure for table `labtechnician_activity`
--

CREATE TABLE `labtechnician_activity` (
  `ID` int(255) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_email` varchar(255) NOT NULL,
  `p_age` bigint(255) NOT NULL,
  `test_status` varchar(255) NOT NULL,
  `covid_type` varchar(255) NOT NULL,
  `test_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `labtechnician_activity`
--

INSERT INTO `labtechnician_activity` (`ID`, `p_name`, `p_email`, `p_age`, `test_status`, `covid_type`, `test_date`) VALUES
(1, 'Amir', 'Amir@gmail.com', 25, '+ve', 'SARS-CoV-2', '12-10-2021'),
(2, 'Aslam', 'Aslam@gmail.com', 25, '+ve', 'SARS-CoV-2', '15-10-2022');

-- --------------------------------------------------------

--
-- Table structure for table `receptionist_activity`
--

CREATE TABLE `receptionist_activity` (
  `Id` int(255) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `patientemail` varchar(255) NOT NULL,
  `patientage` bigint(255) NOT NULL,
  `patient_address` varchar(255) NOT NULL,
  `patient_mobileno` bigint(255) NOT NULL,
  `patient_visitingdate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receptionist_activity`
--

INSERT INTO `receptionist_activity` (`Id`, `patient_name`, `patientemail`, `patientage`, `patient_address`, `patient_mobileno`, `patient_visitingdate`) VALUES
(5, 'Amir', 'Amir@gmail.com', 22, 'Kot Lakhpat, Lahore', 2147483647, '02-04-2020'),
(6, 'Asad', 'Asad@gmail.com', 30, 'Kot Lakhpat, Lahore', 3024875623, '04-05-2021'),
(7, 'Zafar', 'Zafar@gmail.com', 36, 'Karachi', 3041512469, '12-12-2020'),
(8, 'Asad', 'Asad@gmail.com', 30, 'Kot Lakhpat, Lahore', 3024875623, '04-05-2021'),
(9, 'Aslam', 'Aslam@gmail.com', 25, 'Lahore', 304852525, '12-10-2020'),
(10, 'Asif', 'Asif@gmail.com', 32, '123 Gulberg , Lahore', 3004562137, '13-06-2026');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `name`, `email`, `password`, `usertype`) VALUES
(1, 'Ali', 'receptionist@gmail.com', '$2a$12$MTzvlSe0OekHTKVqPMgmh.DyRcKyqOnamfvqrHjlAwUzfCKH.8IfS', 'Receptionist'),
(7, 'Admin', 'admin@gmail.com', '$2a$12$aBPC/2RY25NjS1dhkp7SUOFbl7YYVraH2QBSRzu7iJd88U7wSGj4m', 'Admin'),
(15, 'John', 'labtechnician@gmail.com', '$2y$10$LRnUiL1oyZOnVb6p.XbBBePZ9QQukx9lf7bfu9rq92V0zcd5XetEq', 'Lab Technician'),
(16, 'David', 'doctor@gmail.com', '$2y$10$Y27rFZRTD2aPO9C2pJ5.4e0tiqvwJ4W5pABvV2xV.spCVNbiKHgk2', 'Doctor'),
(17, 'Mickal', 'hospitalhead@gmail.com', '$2y$10$4QQySuoQlnRSHLF/ajQrwuUl/PB564uVFErK7OnIE90lJMFNX7TxK', 'Hospital Head'),
(18, 'Muhsin', 'cityhead@gmail.com', '$2y$10$gdfposjX/xTSCDh/2TCsTuM8I0QVlygd0hwhNAVx2z1JI8pDHl6Qi', 'City Head'),
(19, 'Ikram', 'countryhead@gmail.com', '$2y$10$UBAwdyyiv19uOLm31KvKYeMZvw.vQxApLjoKOe/kdovbXakodbZmu', 'Country Head');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctor_activity`
--
ALTER TABLE `doctor_activity`
  ADD PRIMARY KEY (`iD`);

--
-- Indexes for table `labtechnician_activity`
--
ALTER TABLE `labtechnician_activity`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `receptionist_activity`
--
ALTER TABLE `receptionist_activity`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctor_activity`
--
ALTER TABLE `doctor_activity`
  MODIFY `iD` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `labtechnician_activity`
--
ALTER TABLE `labtechnician_activity`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `receptionist_activity`
--
ALTER TABLE `receptionist_activity`
  MODIFY `Id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
