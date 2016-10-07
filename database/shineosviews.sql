-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 25, 2016 at 10:47 PM
-- Server version: 5.6.33
-- PHP Version: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `migration`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `diagnosis_view`
-- (See below for the actual view)
--
CREATE TABLE `diagnosis_view` (
`dgid` int(10) unsigned
,`hcid` int(10) unsigned
,`healthcareservice_id` varchar(60)
,`fpid` int(10) unsigned
,`facilitypatientuser_id` varchar(60)
,`facid` int(10) unsigned
,`facilityuser_id` varchar(60)
,`diagnosislist_id` text
,`facility_id` varchar(60)
,`hcstype` varchar(60)
,`hccreated` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `healthcare_view`
-- (See below for the actual view)
--
CREATE TABLE `healthcare_view` (
`hcid` int(10) unsigned
,`healthcareservice_id` varchar(60)
,`fpuid` int(10) unsigned
,`facilitypatientuser_id` varchar(60)
,`fuid` int(10) unsigned
,`facilityuser_id` varchar(60)
,`facility_id` varchar(60)
,`pid` int(10) unsigned
,`patient_id` varchar(60)
,`first_name` varchar(60)
,`last_name` varchar(60)
,`middle_name` varchar(60)
,`gender` enum('F','M','U')
,`civil_status` varchar(30)
,`birthdate` date
,`referral_notif` tinyint(1)
,`broadcast_notif` tinyint(1)
,`nonreferral_notif` tinyint(1)
,`patient_consent` tinyint(1)
,`myshine_acct` tinyint(1)
,`age` int(11)
,`photo_url` varchar(60)
,`deleted_at` timestamp
,`created_at` timestamp
,`updated_at` timestamp
,`healthcareservicetype_id` varchar(60)
,`encounter_type` varchar(60)
,`consultation_type` varchar(60)
,`parent_service_id` varchar(60)
,`seen_by` varchar(60)
,`hccreated` timestamp
,`hcdeleted` timestamp
,`encounter_datetime` datetime
,`gcid` int(10) unsigned
,`generalconsultation_id` varchar(60)
,`gchealthcareservice_id` varchar(60)
,`medicalcategory_id` varchar(60)
,`complaint` blob
,`complaint_history` blob
,`physical_examination` blob
,`remarks` blob
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `patients_view`
-- (See below for the actual view)
--
CREATE TABLE `patients_view` (
`patid` int(10) unsigned
,`pcid` int(10) unsigned
,`deadid` int(10) unsigned
,`patient_id` varchar(60)
,`first_name` varchar(60)
,`last_name` varchar(60)
,`middle_name` varchar(60)
,`maiden_lastname` varchar(60)
,`maiden_middlename` varchar(60)
,`name_suffix` varchar(15)
,`gender` enum('F','M','U')
,`civil_status` varchar(30)
,`birthdate` date
,`birthtime` time
,`birthplace` varchar(150)
,`highest_education` varchar(150)
,`highesteducation_others` varchar(150)
,`religion` varchar(30)
,`religion_others` varchar(30)
,`nationality` varchar(30)
,`blood_type` varchar(5)
,`birth_order` varchar(10)
,`referral_notif` tinyint(1)
,`broadcast_notif` tinyint(1)
,`nonreferral_notif` tinyint(1)
,`patient_consent` tinyint(1)
,`myshine_acct` tinyint(1)
,`age` int(11)
,`photo_url` varchar(60)
,`patient_contact_id` varchar(60)
,`contact_patient_id` varchar(60)
,`street_address` varchar(60)
,`barangay` varchar(30)
,`city` varchar(30)
,`province` varchar(60)
,`region` varchar(60)
,`country` varchar(30)
,`zip` int(11)
,`phone` varchar(20)
,`phone_ext` varchar(10)
,`mobile` varchar(20)
,`email` varchar(150)
,`patient_deathinfo_id` varchar(60)
,`death_patient_id` varchar(60)
,`DeathCertificate_Filename` varchar(60)
,`DeathCertificateNo` varchar(60)
,`datetime_death` datetime
,`PlaceDeath` varchar(60)
,`PlaceDeath_FacilityBased` varchar(60)
,`PlaceDeath_NID` varchar(60)
,`PlaceDeath_NID_Others_Specify` varchar(60)
,`mStageDeath` varchar(60)
,`Immediate_Cause_of_Death` varchar(60)
,`Antecedent_Cause_of_Death` varchar(60)
,`Underlying_Cause_of_Death` varchar(60)
,`Type_of_Death` varchar(60)
,`Remarks` text
,`facilitypatientuser_id` varchar(60)
,`fpu_patient_id` varchar(60)
,`fu_facilityuser_id` varchar(60)
,`id` int(10) unsigned
,`facilityuser_id` varchar(60)
,`user_id` varchar(60)
,`facility_id` varchar(60)
,`featureroleuser_id` varchar(60)
,`deleted_at` timestamp
,`created_at` timestamp
,`updated_at` timestamp
,`family_folder_name` varchar(60)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `referrals_view`
-- (See below for the actual view)
--
CREATE TABLE `referrals_view` (
`hcid` int(10) unsigned
,`fpuid` int(10) unsigned
,`facilitypatientuser_id` varchar(60)
,`fuid` int(10) unsigned
,`facilityuser_id` varchar(60)
,`faciu_id` varchar(60)
,`fid` int(10) unsigned
,`faci_id` varchar(60)
,`hcstype` varchar(60)
,`hccreated` timestamp
,`hcdeleted` timestamp
,`encounter_datetime` datetime
,`id` int(10) unsigned
,`referral_id` varchar(60)
,`facility_id` varchar(60)
,`user_id` varchar(60)
,`healthcareservice_id` varchar(60)
,`urgency` varchar(100)
,`method_transport` varchar(100)
,`transport_other` varchar(60)
,`management_done` varchar(200)
,`medical_given` varchar(200)
,`referral_remarks` varchar(200)
,`referral_status` int(11)
,`accept_date` timestamp
,`decline_date` timestamp
,`decline_reason` text
,`deleted_at` timestamp
,`created_at` timestamp
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `referral_messages_view`
-- (See below for the actual view)
--
CREATE TABLE `referral_messages_view` (
`id` int(10) unsigned
,`referralmessage_id` varchar(60)
,`referral_id` varchar(60)
,`referral_subject` varchar(100)
,`referral_message` varchar(250)
,`referral_datetime` datetime
,`referral_message_status` int(11)
,`referrer` int(11)
,`deleted_at` timestamp
,`created_at` timestamp
,`updated_at` timestamp
,`hcid` int(10) unsigned
,`fpuid` int(10) unsigned
,`facilitypatientuser_id` varchar(60)
,`fuid` int(10) unsigned
,`facilityuser_id` varchar(60)
,`referrer_id` varchar(60)
,`fid` int(10) unsigned
,`faci_id` varchar(60)
,`hcstype` varchar(60)
,`hccreated` timestamp
,`hcdeleted` timestamp
,`encounter_datetime` datetime
,`ref_id` int(10) unsigned
,`refer_id` varchar(60)
,`referree_id` varchar(60)
,`user_id` varchar(60)
,`healthcareservice_id` varchar(60)
,`urgency` varchar(100)
,`method_transport` varchar(100)
,`transport_other` varchar(60)
,`management_done` varchar(200)
,`medical_given` varchar(200)
,`referral_remarks` varchar(200)
,`referral_status` int(11)
,`accept_date` timestamp
,`decline_date` timestamp
,`decline_reason` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `visits_view`
-- (See below for the actual view)
--
CREATE TABLE `visits_view` (
`healthcareservice_id` varchar(60)
,`encounter_datetime` datetime
,`created_at` timestamp
,`seen_by` varchar(60)
,`healthcareservicetype_id` varchar(60)
,`facility_id` varchar(60)
,`remindermessage_id` varchar(100)
,`appointment_datetime` datetime
,`sent_status` varchar(10)
,`patient_id` varchar(60)
,`first_name` varchar(60)
,`last_name` varchar(60)
,`visit_date` datetime
,`deleted` timestamp
);

-- --------------------------------------------------------

--
-- Structure for view `diagnosis_view`
--
DROP TABLE IF EXISTS `diagnosis_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `diagnosis_view`  AS  select `diagnosis`.`id` AS `dgid`,`healthcare_services`.`id` AS `hcid`,`healthcare_services`.`healthcareservice_id` AS `healthcareservice_id`,`facility_patient_user`.`id` AS `fpid`,`facility_patient_user`.`facilitypatientuser_id` AS `facilitypatientuser_id`,`facility_user`.`id` AS `facid`,`facility_user`.`facilityuser_id` AS `facilityuser_id`,`diagnosis`.`diagnosislist_id` AS `diagnosislist_id`,`facility_user`.`facility_id` AS `facility_id`,`healthcare_services`.`healthcareservicetype_id` AS `hcstype`,`healthcare_services`.`created_at` AS `hccreated` from (((`diagnosis` join `healthcare_services` on((`healthcare_services`.`healthcareservice_id` = `diagnosis`.`healthcareservice_id`))) join `facility_patient_user` on((`healthcare_services`.`facilitypatientuser_id` = `facility_patient_user`.`facilitypatientuser_id`))) join `facility_user` on((`facility_patient_user`.`facilityuser_id` = `facility_user`.`facilityuser_id`))) where isnull(`healthcare_services`.`deleted_at`) ;

-- --------------------------------------------------------

--
-- Structure for view `healthcare_view`
--
DROP TABLE IF EXISTS `healthcare_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `healthcare_view`  AS  select `healthcare_services`.`id` AS `hcid`,`healthcare_services`.`healthcareservice_id` AS `healthcareservice_id`,`facility_patient_user`.`id` AS `fpuid`,`facility_patient_user`.`facilitypatientuser_id` AS `facilitypatientuser_id`,`facility_user`.`id` AS `fuid`,`facility_user`.`facilityuser_id` AS `facilityuser_id`,`facility_user`.`facility_id` AS `facility_id`,`patients`.`id` AS `pid`,`patients`.`patient_id` AS `patient_id`,`patients`.`first_name` AS `first_name`,`patients`.`last_name` AS `last_name`,`patients`.`middle_name` AS `middle_name`,`patients`.`gender` AS `gender`,`patients`.`civil_status` AS `civil_status`,`patients`.`birthdate` AS `birthdate`,`patients`.`referral_notif` AS `referral_notif`,`patients`.`broadcast_notif` AS `broadcast_notif`,`patients`.`nonreferral_notif` AS `nonreferral_notif`,`patients`.`patient_consent` AS `patient_consent`,`patients`.`myshine_acct` AS `myshine_acct`,`patients`.`age` AS `age`,`patients`.`photo_url` AS `photo_url`,`patients`.`deleted_at` AS `deleted_at`,`patients`.`created_at` AS `created_at`,`patients`.`updated_at` AS `updated_at`,`healthcare_services`.`healthcareservicetype_id` AS `healthcareservicetype_id`,`healthcare_services`.`encounter_type` AS `encounter_type`,`healthcare_services`.`consultation_type` AS `consultation_type`,`healthcare_services`.`parent_service_id` AS `parent_service_id`,`healthcare_services`.`seen_by` AS `seen_by`,`healthcare_services`.`created_at` AS `hccreated`,`healthcare_services`.`deleted_at` AS `hcdeleted`,`healthcare_services`.`encounter_datetime` AS `encounter_datetime`,`general_consultation`.`id` AS `gcid`,`general_consultation`.`generalconsultation_id` AS `generalconsultation_id`,`general_consultation`.`healthcareservice_id` AS `gchealthcareservice_id`,`general_consultation`.`medicalcategory_id` AS `medicalcategory_id`,`general_consultation`.`complaint` AS `complaint`,`general_consultation`.`complaint_history` AS `complaint_history`,`general_consultation`.`physical_examination` AS `physical_examination`,`general_consultation`.`remarks` AS `remarks` from ((((`healthcare_services` join `facility_patient_user` on((`healthcare_services`.`facilitypatientuser_id` = `facility_patient_user`.`facilitypatientuser_id`))) join `facility_user` on((`facility_patient_user`.`facilityuser_id` = `facility_user`.`facilityuser_id`))) join `patients` on((`facility_patient_user`.`patient_id` = `patients`.`patient_id`))) left join `general_consultation` on((`general_consultation`.`healthcareservice_id` = `healthcare_services`.`healthcareservice_id`))) where isnull(`healthcare_services`.`deleted_at`) ;

-- --------------------------------------------------------

--
-- Structure for view `patients_view`
--
DROP TABLE IF EXISTS `patients_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `patients_view`  AS  select `a`.`id` AS `patid`,`b`.`id` AS `pcid`,`c`.`id` AS `deadid`,`a`.`patient_id` AS `patient_id`,`a`.`first_name` AS `first_name`,`a`.`last_name` AS `last_name`,`a`.`middle_name` AS `middle_name`,`a`.`maiden_lastname` AS `maiden_lastname`,`a`.`maiden_middlename` AS `maiden_middlename`,`a`.`name_suffix` AS `name_suffix`,`a`.`gender` AS `gender`,`a`.`civil_status` AS `civil_status`,`a`.`birthdate` AS `birthdate`,`a`.`birthtime` AS `birthtime`,`a`.`birthplace` AS `birthplace`,`a`.`highest_education` AS `highest_education`,`a`.`highesteducation_others` AS `highesteducation_others`,`a`.`religion` AS `religion`,`a`.`religion_others` AS `religion_others`,`a`.`nationality` AS `nationality`,`a`.`blood_type` AS `blood_type`,`a`.`birth_order` AS `birth_order`,`a`.`referral_notif` AS `referral_notif`,`a`.`broadcast_notif` AS `broadcast_notif`,`a`.`nonreferral_notif` AS `nonreferral_notif`,`a`.`patient_consent` AS `patient_consent`,`a`.`myshine_acct` AS `myshine_acct`,`a`.`age` AS `age`,`a`.`photo_url` AS `photo_url`,`b`.`patient_contact_id` AS `patient_contact_id`,`b`.`patient_id` AS `contact_patient_id`,`b`.`street_address` AS `street_address`,`b`.`barangay` AS `barangay`,`b`.`city` AS `city`,`b`.`province` AS `province`,`b`.`region` AS `region`,`b`.`country` AS `country`,`b`.`zip` AS `zip`,`b`.`phone` AS `phone`,`b`.`phone_ext` AS `phone_ext`,`b`.`mobile` AS `mobile`,`b`.`email` AS `email`,`c`.`patient_deathinfo_id` AS `patient_deathinfo_id`,`c`.`patient_id` AS `death_patient_id`,`c`.`DeathCertificate_Filename` AS `DeathCertificate_Filename`,`c`.`DeathCertificateNo` AS `DeathCertificateNo`,`c`.`datetime_death` AS `datetime_death`,`c`.`PlaceDeath` AS `PlaceDeath`,`c`.`PlaceDeath_FacilityBased` AS `PlaceDeath_FacilityBased`,`c`.`PlaceDeath_NID` AS `PlaceDeath_NID`,`c`.`PlaceDeath_NID_Others_Specify` AS `PlaceDeath_NID_Others_Specify`,`c`.`mStageDeath` AS `mStageDeath`,`c`.`Immediate_Cause_of_Death` AS `Immediate_Cause_of_Death`,`c`.`Antecedent_Cause_of_Death` AS `Antecedent_Cause_of_Death`,`c`.`Underlying_Cause_of_Death` AS `Underlying_Cause_of_Death`,`c`.`Type_of_Death` AS `Type_of_Death`,`c`.`Remarks` AS `Remarks`,`e`.`facilitypatientuser_id` AS `facilitypatientuser_id`,`e`.`patient_id` AS `fpu_patient_id`,`e`.`facilityuser_id` AS `fu_facilityuser_id`,`f`.`user_id` AS `user_id`,`f`.`facility_id` AS `facility_id`,`f`.`featureroleuser_id` AS `featureroleuser_id`,`a`.`deleted_at` AS `deleted_at`,`a`.`created_at` AS `created_at`,`a`.`updated_at` AS `updated_at`,`g`.`family_folder_name` AS `family_folder_name` from (((((`patients` `a` left join `patient_contact` `b` on((`b`.`patient_id` = `a`.`patient_id`))) left join `patient_death_info` `c` on((`c`.`patient_id` = `a`.`patient_id`))) join `facility_patient_user` `e` on((`e`.`patient_id` = `a`.`patient_id`))) join `facility_user` `f` on((`f`.`facilityuser_id` = `e`.`facilityuser_id`))) left join `patient_familyinfo` `g` on((`g`.`patient_id` = `a`.`patient_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `referrals_view`
--
DROP TABLE IF EXISTS `referrals_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `referrals_view`  AS  select `healthcare_services`.`id` AS `hcid`,`facility_patient_user`.`id` AS `fpuid`,`facility_patient_user`.`facilitypatientuser_id` AS `facilitypatientuser_id`,`facility_user`.`id` AS `fuid`,`facility_user`.`facilityuser_id` AS `facilityuser_id`,`facility_user`.`facility_id` AS `faciu_id`,`facilities`.`id` AS `fid`,`facilities`.`facility_id` AS `faci_id`,`healthcare_services`.`healthcareservicetype_id` AS `hcstype`,`healthcare_services`.`created_at` AS `hccreated`,`healthcare_services`.`deleted_at` AS `hcdeleted`,`healthcare_services`.`encounter_datetime` AS `encounter_datetime`,`referrals`.`id` AS `id`,`referrals`.`referral_id` AS `referral_id`,`referrals`.`facility_id` AS `facility_id`,`referrals`.`user_id` AS `user_id`,`referrals`.`healthcareservice_id` AS `healthcareservice_id`,`referrals`.`urgency` AS `urgency`,`referrals`.`method_transport` AS `method_transport`,`referrals`.`transport_other` AS `transport_other`,`referrals`.`management_done` AS `management_done`,`referrals`.`medical_given` AS `medical_given`,`referrals`.`referral_remarks` AS `referral_remarks`,`referrals`.`referral_status` AS `referral_status`,`referrals`.`accept_date` AS `accept_date`,`referrals`.`decline_date` AS `decline_date`,`referrals`.`decline_reason` AS `decline_reason`,`referrals`.`deleted_at` AS `deleted_at`,`referrals`.`created_at` AS `created_at`,`referrals`.`updated_at` AS `updated_at` from ((((`healthcare_services` join `referrals` on((`healthcare_services`.`healthcareservice_id` = `referrals`.`healthcareservice_id`))) join `facility_patient_user` on((`healthcare_services`.`facilitypatientuser_id` = `facility_patient_user`.`facilitypatientuser_id`))) join `facility_user` on((`facility_patient_user`.`facilityuser_id` = `facility_user`.`facilityuser_id`))) join `facilities` on((`facilities`.`facility_id` = `referrals`.`facility_id`))) where isnull(`healthcare_services`.`deleted_at`) ;

-- --------------------------------------------------------

--
-- Structure for view `referral_messages_view`
--
DROP TABLE IF EXISTS `referral_messages_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `referral_messages_view`  AS  select `referral_messages`.`id` AS `id`,`referral_messages`.`referralmessage_id` AS `referralmessage_id`,`referral_messages`.`referral_id` AS `referral_id`,`referral_messages`.`referral_subject` AS `referral_subject`,`referral_messages`.`referral_message` AS `referral_message`,`referral_messages`.`referral_datetime` AS `referral_datetime`,`referral_messages`.`referral_message_status` AS `referral_message_status`,`referral_messages`.`referrer` AS `referrer`,`referral_messages`.`deleted_at` AS `deleted_at`,`referral_messages`.`created_at` AS `created_at`,`referral_messages`.`updated_at` AS `updated_at`,`healthcare_services`.`id` AS `hcid`,`facility_patient_user`.`id` AS `fpuid`,`facility_patient_user`.`facilitypatientuser_id` AS `facilitypatientuser_id`,`facility_user`.`id` AS `fuid`,`facility_user`.`facilityuser_id` AS `facilityuser_id`,`facility_user`.`facility_id` AS `referrer_id`,`facilities`.`id` AS `fid`,`facilities`.`facility_id` AS `faci_id`,`healthcare_services`.`healthcareservicetype_id` AS `hcstype`,`healthcare_services`.`created_at` AS `hccreated`,`healthcare_services`.`deleted_at` AS `hcdeleted`,`healthcare_services`.`encounter_datetime` AS `encounter_datetime`,`referrals`.`id` AS `ref_id`,`referrals`.`referral_id` AS `refer_id`,`referrals`.`facility_id` AS `referree_id`,`referrals`.`user_id` AS `user_id`,`referrals`.`healthcareservice_id` AS `healthcareservice_id`,`referrals`.`urgency` AS `urgency`,`referrals`.`method_transport` AS `method_transport`,`referrals`.`transport_other` AS `transport_other`,`referrals`.`management_done` AS `management_done`,`referrals`.`medical_given` AS `medical_given`,`referrals`.`referral_remarks` AS `referral_remarks`,`referrals`.`referral_status` AS `referral_status`,`referrals`.`accept_date` AS `accept_date`,`referrals`.`decline_date` AS `decline_date`,`referrals`.`decline_reason` AS `decline_reason` from (((((`healthcare_services` left join `referrals` on((`healthcare_services`.`healthcareservice_id` = `referrals`.`healthcareservice_id`))) left join `referral_messages` on((`referral_messages`.`referral_id` = `referrals`.`referral_id`))) join `facility_patient_user` on((`healthcare_services`.`facilitypatientuser_id` = `facility_patient_user`.`facilitypatientuser_id`))) join `facility_user` on((`facility_patient_user`.`facilityuser_id` = `facility_user`.`facilityuser_id`))) join `facilities` on((`facilities`.`facility_id` = `referrals`.`facility_id`))) where isnull(`healthcare_services`.`deleted_at`) ;

-- --------------------------------------------------------

--
-- Structure for view `visits_view`
--
DROP TABLE IF EXISTS `visits_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `visits_view`  AS  select `a`.`healthcareservice_id` AS `healthcareservice_id`,`a`.`encounter_datetime` AS `encounter_datetime`,`a`.`created_at` AS `created_at`,`a`.`seen_by` AS `seen_by`,`a`.`healthcareservicetype_id` AS `healthcareservicetype_id`,`g`.`facility_id` AS `facility_id`,`b`.`remindermessage_id` AS `remindermessage_id`,`c`.`appointment_datetime` AS `appointment_datetime`,`c`.`sent_status` AS `sent_status`,`f`.`patient_id` AS `patient_id`,`f`.`first_name` AS `first_name`,`f`.`last_name` AS `last_name`,ifnull(`c`.`appointment_datetime`,`a`.`encounter_datetime`) AS `visit_date`,`a`.`deleted_at` AS `deleted` from ((((((`healthcare_services` `a` join `facility_patient_user` `d` on((`d`.`facilitypatientuser_id` = `a`.`facilitypatientuser_id`))) join `facility_user` `e` on((`e`.`facilityuser_id` = `d`.`facilityuser_id`))) join `facilities` `g` on((`g`.`facility_id` = `e`.`facility_id`))) join `patients` `f` on((`f`.`patient_id` = `d`.`patient_id`))) left join `reminders` `b` on((`a`.`healthcareservice_id` = `b`.`healthcareservice_id`))) left join `reminder_message` `c` on((`b`.`remindermessage_id` = `c`.`remindermessage_id`))) where isnull(`f`.`deleted_at`) ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
