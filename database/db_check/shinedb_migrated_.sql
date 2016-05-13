-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2016 at 06:10 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shinedb_migrated`
--

-- --------------------------------------------------------

--
-- Table structure for table `allergy_patient`
--

CREATE TABLE IF NOT EXISTS `allergy_patient` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `allergy_patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `old_patient_id` int(11) DEFAULT NULL,
  `old_facility_id` int(11) DEFAULT NULL,
  `patient_alert_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `allergy_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `allergy_reaction_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `allergy_severity` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `allergy_patient_allergy_patient_id_unique` (`allergy_patient_id`),
  KEY `allergy_patient_patient_alert_id_foreign` (`patient_alert_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `api_user_account`
--

CREATE TABLE `api_user_account` (
  `id` int(10) UNSIGNED NOT NULL,
  `apiuseraccount_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('F','M','U') COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `api_purpose` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `api_key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `api_secret` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `api_user_account_apiuseraccount_id_unique` (`apiuseraccount_id`),
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `calendar_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `allday` varchar(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `textcolor` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facility_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `calendar_calendar_id_unique` (`calendar_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `chest_xray`
--

CREATE TABLE IF NOT EXISTS `chest_xray` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chestxray_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `healthcareservice_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `scheduled_date` datetime NOT NULL,
  `actual_date` datetime NOT NULL,
  `xray_result` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `notes_remarks` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chest_xray_chestxray_id_unique` (`chestxray_id`),
  KEY `chest_xray_healthcareservice_id_foreign` (`healthcareservice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dengue_record`
--

CREATE TABLE IF NOT EXISTS `dengue_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dengue_id` varchar(32) NOT NULL,
  `healthcareservice_id` varchar(32) NOT NULL,
  `fever_lasting` enum('Y','N','U') DEFAULT 'U',
  `fever_now` enum('Y','N','U') DEFAULT 'U',
  `platelets_critical` enum('Y','N','U') DEFAULT 'U',
  `platelet_count` int(10) DEFAULT NULL,
  `rapid_weak_pulse` enum('Y','N','U') DEFAULT 'U',
  `pallor_cool_skin` enum('Y','N','U') DEFAULT 'U',
  `chills` enum('Y','N','U') DEFAULT 'U',
  `rash` enum('Y','N','U') DEFAULT 'U',
  `headache` enum('Y','N','U') DEFAULT 'U',
  `eye_pain` enum('Y','N','U') DEFAULT 'U',
  `body_pain` enum('Y','N','U') DEFAULT 'U',
  `joint_pain` enum('Y','N','U') DEFAULT 'U',
  `anorexia` enum('Y','N','U') DEFAULT 'U',
  `tourniquet_test` enum('Y','N','U') DEFAULT 'U',
  `petechiae` enum('Y','N','U') DEFAULT 'U',
  `purpura_ecchymosis` enum('Y','N','U') DEFAULT 'U',
  `vomit_with_blood` enum('Y','N','U') DEFAULT 'U',
  `blood_in_stool` enum('Y','N','U') DEFAULT 'U',
  `nasal_bleeding` enum('Y','N','U') DEFAULT 'U',
  `vaginal_bleeding` enum('Y','N','U') DEFAULT 'U',
  `positive_urinalysis` enum('Y','N','U') DEFAULT 'U',
  `lowest_hematocrit` int(11) DEFAULT NULL,
  `highest_hematocrit` int(11) DEFAULT NULL,
  `lowest_serum_albumin` int(11) DEFAULT NULL,
  `lowest_serum_protein` int(11) DEFAULT NULL,
  `lowest_pulse_pressure` int(11) DEFAULT NULL,
  `lowest_wbc_count` int(11) DEFAULT NULL,
  `persistent_vomiting` enum('Y','N','U') DEFAULT 'U',
  `abdominal_pain_tenderness` enum('Y','N','U') DEFAULT 'U',
  `mucosal_bleeding` enum('Y','N','U') DEFAULT 'U',
  `lethargy_restlessness` enum('Y','N','U') DEFAULT 'U',
  `liver_enlargement` enum('Y','N','U') DEFAULT 'U',
  `pleural_or_abdominal_effusion` enum('Y','N','U') DEFAULT 'U',
  `diarrhea` enum('Y','N','U') DEFAULT 'U',
  `cough` enum('Y','N','U') DEFAULT 'U',
  `conjunctivitis` enum('Y','N','U') DEFAULT 'U',
  `nasal_congestion` enum('Y','N','U') DEFAULT 'U',
  `sore_throat` enum('Y','N','U') DEFAULT 'U',
  `jaundice` enum('Y','N','U') DEFAULT 'U',
  `convulsion_or_coma` enum('Y','N','U') DEFAULT 'U',
  `nausea_and_vomiting` enum('Y','N','U') DEFAULT 'U',
  `arthritis` enum('Y','N','U') DEFAULT 'U',
  `is_submitted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dengue_record_dengue_id_unique` (`dengue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE IF NOT EXISTS `diagnosis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `diagnosis_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `healthcareservice_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `old_consultation_id` int(11) DEFAULT NULL,
  `diagnosislist_id` text COLLATE utf8_unicode_ci,
  `diagnosislist_other` text COLLATE utf8_unicode_ci,
  `diagnosis_type` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diagnosis_notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `diagnosis_diagnosis_id_unique` (`diagnosis_id`),
  KEY `diagnosis_healthcareservice_id_foreign` (`healthcareservice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis_icd10`
--

CREATE TABLE IF NOT EXISTS `diagnosis_icd10` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `diagnosisicd10_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `diagnosis_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icd10_classifications` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icd10_subClassifications` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icd10_type` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icd10_code` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `diagnosis_icd10_diagnosisicd10_id_unique` (`diagnosisicd10_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `disability_patient`
--

CREATE TABLE IF NOT EXISTS `disability_patient` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `disability_patient_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patient_alert_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disability_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disability_others` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `disability_patient_disability_patient_id_unique` (`disability_patient_id`),
  KEY `disability_patient_patient_alert_id_foreign` (`patient_alert_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `disposition`
--

CREATE TABLE IF NOT EXISTS `disposition` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `disposition_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `healthcareservice_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disposition` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discharge_condition` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discharge_datetime` datetime DEFAULT NULL,
  `discharge_notes` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `disposition_disposition_id_unique` (`disposition_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `examination`
--

CREATE TABLE IF NOT EXISTS `examination` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `examination_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `healthcareservice_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `Pallor` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Rashes` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Jaundice` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Good_Skin_Turgor` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skin_others` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Anicteric_Sclerae` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Pupils` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Aural_Discharge` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Intact_Tympanic_Membrane` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Nasal_Discharge` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tonsillopharyngeal_Congestion` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Hypertrophic_Tonsils` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Palpable_Mass_B` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Exudates` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `heent_others` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Symmetrical_Chest_Expansion` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Clear_Breathsounds` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Crackles_Rales` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Wheezes` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `chest_others` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Adynamic_Precordium` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Rhythm` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Heaves` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Murmurs` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `heart_others` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `anatomy_heart_Others` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Flat` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Globular` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Flabby` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Muscle_Guarding` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tenderness` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Palpable_Mass` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `abdomen_others` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Normal_Gait` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Full_Equal_Pulses` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extreme_others` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `examination_examination_id_unique` (`examination_id`),
  KEY `examination_healthcareservice_id_foreign` (`healthcareservice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE IF NOT EXISTS `facilities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `old_facility_id` int(11) DEFAULT NULL,
  `facility_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `facility_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `DOH_facility_code` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phic_accr_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phic_accr_date` date DEFAULT NULL,
  `phic_benefit_package` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phic_benefit_package_date` date DEFAULT NULL,
  `ownership_type` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `facility_type` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `provider_type` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `bmonc_cmonc` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hospital_license_number` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flag_allow_referral` varchar(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `specializations` text COLLATE utf8_unicode_ci,
  `services` text COLLATE utf8_unicode_ci,
  `equipment` text COLLATE utf8_unicode_ci,
  `enabled_modules` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled_plugins` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facilities_facility_id_unique` (`facility_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `facility_contact`
--

CREATE TABLE IF NOT EXISTS `facility_contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `facilitycontact_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `facility_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `house_no` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `building_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `village` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barangay` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `province` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `zip` int(11) NOT NULL,
  `phone` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_address` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flag_allow_referral` varchar(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `bmonc_cmonc` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hospital_license_number` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facility_contact_facilitycontact_id_unique` (`facilitycontact_id`),
  KEY `facility_contact_facility_id_foreign` (`facility_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `facility_patient_user`
--

CREATE TABLE IF NOT EXISTS `facility_patient_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `facilitypatientuser_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `facilityuser_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facility_patient_user_facilitypatientuser_id_unique` (`facilitypatientuser_id`),
  KEY `facility_patient_user_patient_id_foreign` (`patient_id`),
  KEY `facility_patient_user_facilityuser_id_foreign` (`facilityuser_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `facility_user`
--

CREATE TABLE IF NOT EXISTS `facility_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `facilityuser_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `old_user_id` int(11) DEFAULT NULL,
  `facility_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `old_facility_id` int(11) DEFAULT NULL,
  `featureroleuser_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facility_user_facilityuser_id_unique` (`facilityuser_id`),
  KEY `facility_user_user_id_foreign` (`user_id`),
  KEY `facility_user_facility_id_foreign` (`facility_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `familyplanning_service`
--

CREATE TABLE IF NOT EXISTS `familyplanning_service` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `familyplanning_id` varchar(32) NOT NULL,
  `healthcareservice_id` varchar(32) NOT NULL,
  `conjunctiva` varchar(60) DEFAULT NULL,
  `neck` varchar(60) DEFAULT NULL,
  `breast` varchar(60) DEFAULT NULL,
  `thorax` varchar(60) DEFAULT NULL,
  `abdomen` varchar(60) DEFAULT NULL,
  `extremities` varchar(60) DEFAULT NULL,
  `perineum` varchar(60) DEFAULT NULL,
  `vagina` varchar(60) DEFAULT NULL,
  `cervix` varchar(60) DEFAULT NULL,
  `consistency` varchar(60) DEFAULT NULL,
  `uterus_position` varchar(60) DEFAULT NULL,
  `uterus_size` varchar(60) DEFAULT NULL,
  `uterus_depth` varchar(60) DEFAULT NULL,
  `adnexa` varchar(60) DEFAULT NULL,
  `full_term` varchar(60) DEFAULT NULL,
  `abortions` varchar(60) DEFAULT NULL,
  `premature` varchar(60) DEFAULT NULL,
  `living_children` varchar(60) DEFAULT NULL,
  `date_of_last_delivery` varchar(60) DEFAULT NULL,
  `type_of_last_delivery` varchar(60) DEFAULT NULL,
  `past_menstrual_period` varchar(60) DEFAULT NULL,
  `last_menstrual_period` varchar(60) DEFAULT NULL,
  `number_of_days_menses` varchar(60) DEFAULT NULL,
  `character_of_menses` varchar(60) DEFAULT NULL,
  `history_of_following` text,
  `with_history_of_multiple_partners` varchar(15) DEFAULT NULL,
  `sti_risks_women` text,
  `sti_risks_men` text,
  `violence_against_women` text,
  `referred_to` text,
  `referred_to_others` text,
  `planning_start` varchar(60) DEFAULT NULL,
  `no_of_living_children` varchar(60) DEFAULT NULL,
  `plan_more_children` varchar(15) DEFAULT NULL,
  `reason_for_practicing_fp` text,
  `client_type` varchar(60) DEFAULT NULL,
  `client_sub_type` varchar(60) DEFAULT NULL,
  `dropout_date` date DEFAULT NULL,
  `dropout_reason` text,
  `previous_method` varchar(60) DEFAULT NULL,
  `current_method` varchar(60) DEFAULT NULL,
  `remarks` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `familyplanning_id` (`familyplanning_id`),
  UNIQUE KEY `healthcareservice_id` (`healthcareservice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE IF NOT EXISTS `features` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `feature_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `feature_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `feature_description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `features_feature_id_unique` (`feature_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feature_role`
--

CREATE TABLE IF NOT EXISTS `feature_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `featureroleuser_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `feature_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `feature_role_featureroleuser_id_unique` (`featureroleuser_id`),
  KEY `feature_role_role_id_foreign` (`role_id`),
  KEY `feature_role_feature_id_foreign` (`feature_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password`
--

CREATE TABLE IF NOT EXISTS `forgot_password` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `forgot_password_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forgot_password_code` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `general_consultation`
--

CREATE TABLE IF NOT EXISTS `general_consultation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `generalconsultation_id` varchar(60) NOT NULL,
  `healthcareservice_id` varchar(60) NOT NULL,
  `medicalcategory_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `complaint` blob,
  `complaint_history` blob,
  `physical_examination` blob,
  `remarks` blob,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `general_consultation_generalconsultation_id_unique` (`generalconsultation_id`),
  KEY `general_consultation_healthcareservice_id_foreign` (`healthcareservice_id`),
  KEY `general_consultation_medicalcategory_id_foreign` (`medicalcategory_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `healthcare_addendum`
--

CREATE TABLE IF NOT EXISTS `healthcare_addendum` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `addendum_id` varchar(60) NOT NULL,
  `healthcareservice_id` varchar(60) NOT NULL,
  `user_id` varchar(60) NOT NULL,
  `addendum_notes` blob NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `healthcare_addendum_addendum_id_unique` (`addendum_id`),
  KEY `healthcare_services_healthcareservice_id_foreign` (`healthcareservice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `healthcare_services`
--

CREATE TABLE IF NOT EXISTS `healthcare_services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `old_consultation_id` int(11) DEFAULT NULL,
  `old_patient_id` int(11) DEFAULT NULL,
  `old_facility_id` int(11) DEFAULT NULL,
  `old_user_id` int(11) DEFAULT NULL,
  `healthcareservice_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facilitypatientuser_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `healthcareservicetype_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `consultation_type` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `encounter_type` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_service_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source_referrer_type` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source_referrer` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `encounter_datetime` datetime DEFAULT NULL,
  `seen_by` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `healthcare_services_healthcareservice_id_unique` (`healthcareservice_id`),
  KEY `healthcare_services_facilitypatientuser_id_foreign` (`facilitypatientuser_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lab_results`
--

CREATE TABLE IF NOT EXISTS `lab_results` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `labresults_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `healthcareservice_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `labresult_type` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_allergy_reaction`
--

CREATE TABLE IF NOT EXISTS `lov_allergy_reaction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `allergyreaction_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `allergyreaction_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_allergy_reaction_allergyreaction_id_unique` (`allergyreaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_barangays`
--

CREATE TABLE IF NOT EXISTS `lov_barangays` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `barangay_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `region_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `province_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `city_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `barangay_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `barangay_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `nscb_barangaycode` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `nscb_barangayname` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `barangay_long` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `barangay_lat` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `userLevel_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `barangay_status` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_barangays_barangay_id_unique` (`barangay_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_citymunicipalities`
--

CREATE TABLE IF NOT EXISTS `lov_citymunicipalities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `citymunicipality_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `region_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `province_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `city_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `city_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `nscb_citycode` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `nscb_cityname` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `userLevel_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `citymun_status` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_citymunicipalities_citymunicipality_id_unique` (`citymunicipality_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_diagnosis`
--

CREATE TABLE IF NOT EXISTS `lov_diagnosis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `diagnosis_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `diagnosis_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `diagnosis_desc` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `sequence_num` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `diagnosis_type` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_diagnosis_diagnosis_id_unique` (`diagnosis_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_disabilities`
--

CREATE TABLE IF NOT EXISTS `lov_disabilities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `disability_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `disability_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_disabilities_disability_id_unique` (`disability_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_diseases`
--

CREATE TABLE IF NOT EXISTS `lov_diseases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `disease_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disease_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disease_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `disease_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phie_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `disease_input_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `disease_radio_values` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sex_limit` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `min_age_limit` int(11) DEFAULT NULL,
  `max_age_limit` int(11) DEFAULT NULL,
  `block_width` smallint(6) DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_diseases_disease_id_unique` (`disease_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_doh_facility_codes`
--

CREATE TABLE IF NOT EXISTS `lov_doh_facility_codes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `barangay` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `province` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `landline` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cellphone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email2` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `ownership` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_doh_facility_codes_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_drugs`
--

CREATE TABLE IF NOT EXISTS `lov_drugs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `drugs_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `drug_specification` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_drugs_drugs_id_unique` (`drugs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_enumerations`
--

CREATE TABLE IF NOT EXISTS `lov_enumerations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `enum_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `sequence_number` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `enum_type_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_enumerations_enum_id_unique` (`enum_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_forms`
--

CREATE TABLE IF NOT EXISTS `lov_forms` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(100) NOT NULL,
  `facility` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_icd10`
--

CREATE TABLE IF NOT EXISTS `lov_icd10` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `icd10_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `icd10_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `icd10_category` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `icd10_subcategory` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `icd10_tricategory` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `icd10_title` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_icd10_icd10_id_unique` (`icd10_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_immunizations`
--

CREATE TABLE IF NOT EXISTS `lov_immunizations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `immunization_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `immunization_short_desc` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `immunization_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `cvx_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_laboratories`
--

CREATE TABLE IF NOT EXISTS `lov_laboratories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `laboratory_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `laboratorycode` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `laboratorydescription` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_laboratories_laboratory_id_unique` (`laboratory_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_loincs`
--

CREATE TABLE IF NOT EXISTS `lov_loincs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `loinc_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `test_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `test_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `result_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `result` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `loinc_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `loinc_attribute` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `updated` date NOT NULL,
  `method` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_loincs_loinc_id_unique` (`loinc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_medicalcategory`
--

CREATE TABLE IF NOT EXISTS `lov_medicalcategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `medicalcategory_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `medicalcategory_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `medicalcategory_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_medicalcategory_medicalcategory_id_unique` (`medicalcategory_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_medicalprocedures`
--

CREATE TABLE IF NOT EXISTS `lov_medicalprocedures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `medicalprocedure_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `procedure_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `procedure_description` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_medicalprocedures_procedure_code_unique` (`procedure_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_modules`
--

CREATE TABLE IF NOT EXISTS `lov_modules` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `menu_show` tinyint(1) NOT NULL,
  `menu_order` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_province`
--

CREATE TABLE IF NOT EXISTS `lov_province` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `region_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `province_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `province_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `province_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `nscb_provincecode` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `nscb_provincename` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `userLevel_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `province_status` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_province_province_id_unique` (`province_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_referral_reasons`
--

CREATE TABLE IF NOT EXISTS `lov_referral_reasons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lovreferralreason_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `referral_reason` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_referral_reasons_lovreferralreason_id_unique` (`lovreferralreason_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_region`
--

CREATE TABLE IF NOT EXISTS `lov_region` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `region_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `region_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `region_short` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `region_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `region_abbreviation` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `nscb_regioncode` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `nscb_regionname` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `userLevel_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `region_status` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lov_region_region_id_unique` (`region_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lov_roles_access`
--

CREATE TABLE IF NOT EXISTS `lov_roles_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `module_id` int(50) NOT NULL,
  `module_access` enum('1','2','3','4') NOT NULL,
  `form_id` int(50) NOT NULL,
  `form_access` enum('1','2','3','4') NOT NULL,
  `status` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `maternalcare`
--

CREATE TABLE IF NOT EXISTS `maternalcare` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maternalcare_id` varchar(60) NOT NULL,
  `healthcareservice_id` varchar(60) DEFAULT NULL,
  `old_consultation_id` int(11) DEFAULT NULL,
  `old_patient_id` int(11) DEFAULT NULL,
  `old_facility_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `maternalcare_id` (`maternalcare_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `maternalcare_delivery`
--

CREATE TABLE IF NOT EXISTS `maternalcare_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maternaldelivery_id` varchar(60) NOT NULL,
  `maternalcare_id` varchar(60) NOT NULL,
  `termination_datetime` datetime DEFAULT NULL,
  `child_gender` enum('F','M','U') DEFAULT NULL,
  `livebirth_weight` int(11) DEFAULT NULL,
  `termination_outcome` varchar(60) DEFAULT NULL,
  `delivered_type` varchar(60) DEFAULT NULL,
  `delivery_type_mode` varchar(60) DEFAULT NULL,
  `delivery_place_type` varchar(60) DEFAULT NULL,
  `delivery_place` varchar(60) DEFAULT NULL,
  `attendant` varchar(60) DEFAULT NULL,
  `birth_multiplicity` varchar(60) DEFAULT NULL,
  `multiple_births` varchar(60) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `maternaldelivery_id` (`maternaldelivery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `maternalcare_partograph`
--

CREATE TABLE IF NOT EXISTS `maternalcare_partograph` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `old_consultation_id` varchar(50) DEFAULT NULL,
  `old_patient_id` int(11) DEFAULT NULL,
  `old_facility_id` int(11) DEFAULT NULL,
  `partograph_id` varchar(60) NOT NULL,
  `maternalcare_id` varchar(60) NOT NULL,
  `date_examined` datetime DEFAULT NULL,
  `ruptured_membranes` varchar(100) DEFAULT NULL,
  `rapid_assessment_result` varchar(100) DEFAULT NULL,
  `time_taken` time DEFAULT NULL,
  `cervical_dilation` varchar(100) DEFAULT NULL,
  `fetal_station` varchar(100) DEFAULT NULL,
  `amount_bleeding` int(11) DEFAULT NULL,
  `no_contractions` int(11) DEFAULT NULL,
  `fetal_heart_rate_per_min` int(11) DEFAULT NULL,
  `bloodpressure_systolic` int(11) DEFAULT NULL,
  `bloodpressure_diastolic` int(11) DEFAULT NULL,
  `bloodpressure_assessment` varchar(100) DEFAULT NULL,
  `pulse` varchar(100) DEFAULT NULL,
  `placenta_delivered` varchar(100) DEFAULT NULL,
  `amniotic_fluid_characteristic` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `partograph_id` (`partograph_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `maternalcare_postpartum`
--

CREATE TABLE IF NOT EXISTS `maternalcare_postpartum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `old_postpartum_id` int(11) DEFAULT NULL,
  `old_consultation_id` varchar(50) DEFAULT NULL,
  `old_patient_id` int(11) DEFAULT NULL,
  `old_facility_id` int(11) DEFAULT NULL,
  `postpartum_id` varchar(60) NOT NULL,
  `maternalcare_id` varchar(60) NOT NULL,
  `breastfeeding_date` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `postpartum_id` (`postpartum_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `maternalcare_prenatal`
--

CREATE TABLE IF NOT EXISTS `maternalcare_prenatal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `old_prenatal_id` int(11) DEFAULT NULL,
  `prenatal_id` varchar(60) NOT NULL,
  `maternalcare_id` varchar(60) NOT NULL,
  `last_menstruation_period` datetime DEFAULT NULL,
  `expected_date_delivery` datetime DEFAULT NULL,
  `gravidity` int(11) DEFAULT NULL,
  `parity` int(11) DEFAULT NULL,
  `term` int(11) DEFAULT NULL,
  `pre_term` int(11) DEFAULT NULL,
  `abortion` int(11) DEFAULT NULL,
  `living` int(11) DEFAULT NULL,
  `old_consultation_id` varchar(50) DEFAULT NULL,
  `old_patient_id` int(11) DEFAULT NULL,
  `old_facility_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prenatal_id` (`prenatal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `maternalcare_supplements`
--

CREATE TABLE IF NOT EXISTS `maternalcare_supplements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maternalsupplement_id` varchar(60) NOT NULL,
  `prenatal_id` varchar(60) DEFAULT NULL,
  `postpartum_id` varchar(60) DEFAULT NULL,
  `pregnancy_type` int(11) DEFAULT NULL,
  `supplement_type` int(11) DEFAULT NULL,
  `scheduled_date` datetime DEFAULT NULL,
  `actual_date` datetime DEFAULT NULL,
  `quantity_dispensed` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `maternalsupplement_id` (`maternalsupplement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `maternalcare_visits`
--

CREATE TABLE IF NOT EXISTS `maternalcare_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maternalvisits_id` varchar(60) NOT NULL,
  `prenatal_id` varchar(60) DEFAULT NULL,
  `postpartum_id` varchar(60) DEFAULT NULL,
  `trimester_period` int(11) DEFAULT NULL,
  `scheduled_visit` datetime DEFAULT NULL,
  `actual_visit` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `maternalvisits_id` (`maternalvisits_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `medicalorder`
--

CREATE TABLE IF NOT EXISTS `medicalorder` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `medicalorder_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `healthcareservice_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `medicalorder_type` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_instructions` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medicalorder_others` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `medicalorder_medicalorder_id_unique` (`medicalorder_id`),
  KEY `medicalorder_healthcareservice_id_foreign` (`healthcareservice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `medicalorder_laboratoryexam`
--

CREATE TABLE IF NOT EXISTS `medicalorder_laboratoryexam` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `medicalorderlaboratoryexam_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medicalorder_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `laboratory_test_type` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `laboratory_test_type_others` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `laboratorytest_result` text COLLATE utf8_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `medicalorder_laboratoryexam_medicalorderlaboratoryexam_id_unique` (`medicalorderlaboratoryexam_id`),
  KEY `medicalorder_laboratoryexam_medicalorder_id_foreign` (`medicalorder_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `medicalorder_prescription`
--

CREATE TABLE IF NOT EXISTS `medicalorder_prescription` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `medicalorderprescription_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medicalorder_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `generic_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `brand_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dose_quantity` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_quantity` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dosage_regimen` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dosage_regimen_others` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duration_of_intake` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regimen_startdate` date DEFAULT NULL,
  `regimen_enddate` date DEFAULT NULL,
  `prescription_remarks` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `medicalorder_prescription_medicalorderprescription_id_unique` (`medicalorderprescription_id`),
  KEY `medicalorder_prescription_medicalorder_id_foreign` (`medicalorder_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `medicalorder_procedure`
--

CREATE TABLE IF NOT EXISTS `medicalorder_procedure` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `medicalorderprocedure_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medicalorder_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `procedure_order` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `procedure_date` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `medicalorder_procedure_medicalorderprocedure_id_unique` (`medicalorderprocedure_id`),
  KEY `medicalorder_procedure_medicalorder_id_foreign` (`medicalorder_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE IF NOT EXISTS `patients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `old_patient_id` int(11) DEFAULT NULL,
  `old_facility_id` int(11) DEFAULT NULL,
  `first_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `maiden_lastname` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `maiden_middlename` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_suffix` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` enum('F','M','U') COLLATE utf8_unicode_ci DEFAULT 'U',
  `civil_status` varchar(30) COLLATE utf8_unicode_ci DEFAULT '9',
  `birthdate` date DEFAULT NULL,
  `birthtime` time DEFAULT NULL,
  `birthplace` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `highest_education` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `highesteducation_others` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `religion` varchar(30) COLLATE utf8_unicode_ci DEFAULT 'UNKNO',
  `religion_others` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nationality` varchar(30) COLLATE utf8_unicode_ci DEFAULT 'Filipino',
  `blood_type` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_order` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referral_notif` tinyint(1) DEFAULT '1',
  `broadcast_notif` tinyint(1) DEFAULT '1',
  `nonreferral_notif` tinyint(1) DEFAULT '1',
  `patient_consent` tinyint(1) DEFAULT '0',
  `myshine_acct` tinyint(1) DEFAULT '0',
  `age` int(11) DEFAULT NULL,
  `photo_url` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patients_patient_id_unique` (`patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_alert`
--

CREATE TABLE IF NOT EXISTS `patient_alert` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_alert_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `alert_type` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alert_type_other` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_alert_patient_alert_id_unique` (`patient_alert_id`),
  KEY `patient_alert_patient_id_foreign` (`patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_childimmunizationhistory`
--

CREATE TABLE IF NOT EXISTS `patient_childimmunizationhistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_immunization_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `disease_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `immunization_code` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disease_status` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_immuhistory_patient_immuhistory_id_unique` (`patient_immunization_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_contact`
--

CREATE TABLE IF NOT EXISTS `patient_contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_contact_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `street_address` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barangay` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_ext` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_contact_patient_contact_id_unique` (`patient_contact_id`),
  KEY `patient_contact_patient_id_foreign` (`patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_death_info`
--
CREATE TABLE IF NOT EXISTS `patient_death_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_deathinfo_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `DeathCertificate_Filename` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DeathCertificateNo` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_death` datetime DEFAULT NULL,
  `PlaceDeath` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PlaceDeath_FacilityBased` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PlaceDeath_NID` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `PlaceDeath_NID_Others_Specify` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `mStageDeath` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `Immediate_Cause_of_Death` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `Antecedent_Cause_of_Death` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `Underlying_Cause_of_Death` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `Type_of_Death` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `Remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_death_info_patient_deathinfo_id_unique` (`patient_deathinfo_id`),
  KEY `patient_death_info_patient_id_foreign` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_elderlyimmunizationhistory`
--

CREATE TABLE IF NOT EXISTS `patient_elderlyimmunizationhistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_immunization_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disease_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `immunization_code` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disease_status` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actual_date` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_immunization_patient_immunization_id_unique` (`patient_immunization_id`),
  KEY `patient_immunization_patient_id_foreign` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_emergencyinfo`
--

CREATE TABLE IF NOT EXISTS `patient_emergencyinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_emergencyinfo_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emergency_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emergency_relationship` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emergency_phone` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emergency_mobile` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emergency_address` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_emergencyinfo_patient_emergencyinfo_id_unique` (`patient_emergencyinfo_id`),
  KEY `patient_emergencyinfo_patient_id_foreign` (`patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_employmentinfo`
--

CREATE TABLE IF NOT EXISTS `patient_employmentinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_employmentinfo_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `occupation` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_unitno` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_address` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_region` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_province` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_citymun` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_barangay` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_zip` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_country` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_employmentinfo_patient_employmentinfo_id_unique` (`patient_employmentinfo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_familyinfo`
--

CREATE TABLE IF NOT EXISTS `patient_familyinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_familyinfo_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `father_firstname` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `father_middlename` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `father_lastname` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `suffix` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `father_alive` tinyint(1) DEFAULT NULL,
  `mother_firstname` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mother_middlename` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mother_lastname` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mother_alive` tinyint(1) DEFAULT NULL,
  `ctr_householdmembers_lt10yrs` int(11) DEFAULT NULL,
  `ctr_householdmembers_gt10yrs` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_familyinfo_patient_familyinfo_id_unique` (`patient_familyinfo_id`),
  KEY `patient_familyinfo_patient_id_foreign` (`patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_familymedicalhistory`
--

CREATE TABLE IF NOT EXISTS `patient_familymedicalhistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_fmedicalhistory_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `disease_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `disease_date` text COLLATE utf8_unicode_ci,
  `disease_status` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_fmedicalhistory_patient_fmedicalhistory_id_unique` (`patient_fmedicalhistory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_family_group`
--

CREATE TABLE IF NOT EXISTS `patient_family_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_familygroup_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `familygroup_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_family_group_patient_familygroup_id_unique` (`patient_familygroup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_family_group_members`
--

CREATE TABLE IF NOT EXISTS `patient_family_group_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_familygroupmember_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_familygroup_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patient_relationship` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_family_group_members_patient_familygroupmember_id_unique` (`patient_familygroupmember_id`),
  KEY `patient_family_group_members_patient_familygroup_id_foreign` (`patient_familygroup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_fpcounseling`
--

CREATE TABLE IF NOT EXISTS `patient_fpcounseling` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_fpcounseling_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `disease_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `counseling_date` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `counseling_status` text COLLATE utf8_unicode_ci,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_fpcounseling_patient_fpcounseling_id_unique` (`patient_fpcounseling_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_medicalhistory`
--

CREATE TABLE IF NOT EXISTS `patient_medicalhistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_medicalhistory_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `disease_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `disease_date` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `disease_status` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remarks` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_medicalhistory_patient_medicalhistory_id_unique` (`patient_medicalhistory_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_menstrualhistory`
--

CREATE TABLE IF NOT EXISTS `patient_menstrualhistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_menstrualhistory_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `disease_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `menarche` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_period_date` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_period_duration` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `interval` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_of_pads` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `onset_intercourse` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthcontrol_method` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menopause` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menopause_age` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_menstrualhistory_patient_menstrualhistory_id_unique` (`patient_menstrualhistory_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_monitoring`
--

CREATE TABLE IF NOT EXISTS `patient_monitoring` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `monitoring_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `bloodpressure_systolic` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bloodpressure_diastolic` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bloodpressure_assessment` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `monitoring_id` (`monitoring_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_personalhistory`
--

CREATE TABLE IF NOT EXISTS `patient_personalhistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_personalhistory_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `smoking` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `packs` int(11) DEFAULT NULL,
  `bottles` int(11) DEFAULT NULL,
  `drinking` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `taking_drugs` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_personalhistory_patient_personalhistory_id_unique` (`patient_personalhistory_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_philhealthinfo`
--

CREATE TABLE IF NOT EXISTS `patient_philhealthinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_philhealthinfo_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider_account_id` int(11) DEFAULT NULL,
  `philhealth_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `philheath_category` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `member_type` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ccash_transfer` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `benefit_type` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pamilya_pantawid_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `indigenous_group` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_philhealthinfo_patient_philhealthinfo_id_unique` (`patient_philhealthinfo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_pregnancyhistory`
--

CREATE TABLE IF NOT EXISTS `patient_pregnancyhistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_pregnancyhistory_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `gravidity` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parity` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_of_delivery` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_of_term` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_of_premature` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_of_abortion` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `no_of_children` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pre-eclampsia` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_pregnancyhistory_patient_pregnancyhistory_id_unique` (`patient_pregnancyhistory_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_pregnancyimmunizationhistory`
--

CREATE TABLE IF NOT EXISTS `patient_pregnancyimmunizationhistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_immunization_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `disease_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `immunization_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `scheduled_date` datetime NOT NULL,
  `actual_date` datetime NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_immunization_patient_immunization_id_unique` (`patient_immunization_id`),
  KEY `patient_immunization_patient_id_foreign` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_surgicalhistory`
--

CREATE TABLE IF NOT EXISTS `patient_surgicalhistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_surgicalhistory_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `surgery` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surgery_date` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_surgicalhistory_patient_surgicalhistory_id_unique` (`patient_surgicalhistory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_womenimmunizationhistory`
--

CREATE TABLE IF NOT EXISTS `patient_womenimmunizationhistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patient_immunization_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `disease_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `immunization_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `disease_status` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actual_date` datetime NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patient_immunization_patient_immunization_id_unique` (`patient_immunization_id`),
  KEY `patient_immunization_patient_id_foreign` (`patient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pedia_record`
--

CREATE TABLE IF NOT EXISTS `pedia_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pedia_id` int(11) NOT NULL,
  `healthcareservice_id` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `case_status` varchar(30) DEFAULT NULL,
  `newborn_screening_referral_date` datetime DEFAULT NULL,
  `newborn_screening_actual_date` datetime DEFAULT NULL,
  `child_protection_date` datetime DEFAULT NULL,
  `tt_status` varchar(20) DEFAULT NULL,
  `birth_weight` double DEFAULT NULL,
  `vit_a_supp_first_date` datetime DEFAULT NULL,
  `vit_a_first_age` int(11) DEFAULT NULL,
  `vit_a_supp_second_date` datetime DEFAULT NULL,
  `vit_a_second_age` int(11) DEFAULT NULL,
  `iron_supp_start_date` datetime DEFAULT NULL,
  `iron_supp_end_date` datetime DEFAULT NULL,
  `bcg_recommended_date` datetime DEFAULT NULL,
  `bcg_actual_date` datetime DEFAULT NULL,
  `dpt1_recommended_date` datetime DEFAULT NULL,
  `dpt1_actual_date` datetime DEFAULT NULL,
  `dpt2_recommended_date` datetime DEFAULT NULL,
  `dpt2_actual_date` datetime DEFAULT NULL,
  `dpt3_recommended_date` datetime DEFAULT NULL,
  `dpt3_actual_date` datetime DEFAULT NULL,
  `hepa_b1_recommended_date` datetime DEFAULT NULL,
  `hepa_b1_actual_date` datetime DEFAULT NULL,
  `hepa_b2_recommended_date` datetime DEFAULT NULL,
  `hepa_b2_actual_date` datetime DEFAULT NULL,
  `hepa_b3_recommended_date` datetime DEFAULT NULL,
  `hepa_b3_actual_date` datetime DEFAULT NULL,
  `measles_recommended_date` datetime DEFAULT NULL,
  `measles_actual_date` datetime DEFAULT NULL,
  `opv1_recommended_date` datetime DEFAULT NULL,
  `opv1_actual_date` datetime DEFAULT NULL,
  `opv2_recommended_date` datetime DEFAULT NULL,
  `opv2_actual_date` datetime DEFAULT NULL,
  `opv3_recommended_date` datetime DEFAULT NULL,
  `opv3_actual_date` datetime DEFAULT NULL,
  `is_breastfed_first_month` tinyint(1) DEFAULT NULL,
  `is_breastfed_second_month` tinyint(1) DEFAULT NULL,
  `is_breastfed_third_month` tinyint(1) DEFAULT NULL,
  `is_breastfed_fourth_month` tinyint(1) DEFAULT NULL,
  `is_breastfed_fifth_month` tinyint(1) DEFAULT NULL,
  `is_breastfed_sixth_month` tinyint(1) DEFAULT NULL,
  `breastfeed_sixth_month` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pedia_record_pedia_id_unique` (`pedia_id`),
  KEY `pedia_record_healthcareservice_id_foreign` (`healthcareservice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `phie_sync`
--

CREATE TABLE `phie_sync` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sync_id` varchar(60) NOT NULL,
  `facilityuser_id` varchar(60) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phie_sync_sync_id_unique` (`sync_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `facility_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `plugin_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `plugin_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `values` blob NOT NULL,
  `primary_key` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `primary_key_value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE IF NOT EXISTS `referrals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `referral_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facility_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `healthcareservice_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `urgency` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `method_transport` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `transport_other` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `management_done` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `medical_given` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referral_remarks` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referral_status` int(11) DEFAULT NULL,
  `accept_date` timestamp NULL DEFAULT NULL,
  `decline_date` timestamp NULL DEFAULT NULL,
  `decline_reason` text COLLATE utf8_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `referrals_referral_id_unique` (`referral_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `referral_messages`
--

CREATE TABLE IF NOT EXISTS `referral_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `referralmessage_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referral_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referral_subject` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referral_message` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referral_datetime` datetime DEFAULT NULL,
  `referral_message_status` int(11) DEFAULT NULL,
  `referrer` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `referral_messages_referralmessage_id_unique` (`referralmessage_id`),
  KEY `referral_messages_referral_id_foreign` (`referral_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `referral_reasons`
--

CREATE TABLE IF NOT EXISTS `referral_reasons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `referralreason_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referral_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lovreferralreason_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `referral_reasons_referralreason_id_unique` (`referralreason_id`),
  KEY `referral_reasons_referral_id_foreign` (`referral_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE IF NOT EXISTS `reminders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reminder_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `facilityuser_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `patient_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `remindermessage_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reminders_reminder_id_unique` (`reminder_id`),
  KEY `reminders_remindermessage_id_foreign` (`remindermessage_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reminder_message`
--

CREATE TABLE IF NOT EXISTS `reminder_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `remindermessage_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `reminder_subject` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `reminder_message` text COLLATE utf8_unicode_ci NOT NULL,
  `appointment_datetime` datetime NOT NULL,
  `daysbeforesending` int(11) NOT NULL,
  `remindermessage_type` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `sent_status` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('1','2','3') COLLATE utf8_unicode_ci NOT NULL,
  `reminder_type` enum('1','2','3','4') COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reminder_message_remindermessage_id_unique` (`remindermessage_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `access_level` tinyint(4) NOT NULL,
  `role_create` tinyint(1) NOT NULL,
  `role_read` tinyint(1) NOT NULL,
  `role_update` tinyint(1) NOT NULL,
  `role_delete` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_role_id_unique` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles_access`
--

CREATE TABLE IF NOT EXISTS `roles_access` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `role_id` varchar(100) NOT NULL,
  `facilityuser_id` varchar(100) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tuberculosis_clinical_history_record`
--

CREATE TABLE IF NOT EXISTS `tuberculosis_clinical_history_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tuberculosis_clinical_history_id` varchar(60) NOT NULL,
  `tuberculosis_id` varchar(60) NOT NULL,
  `weight_in_kg` int(4) NOT NULL,
  `unexplained_fever` enum('Y','N','U') NOT NULL DEFAULT 'U',
  `unexplained_cough` enum('Y','N','U') NOT NULL DEFAULT 'U',
  `unimproved_well_being` enum('Y','N','U') NOT NULL DEFAULT 'U',
  `poor_appetite` enum('Y','N','U') NOT NULL DEFAULT 'U',
  `positive_pe_findings` enum('Y','N','U') NOT NULL DEFAULT 'U',
  `side_effects` varchar(50) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tuberculosis_clinical_history_id` (`tuberculosis_clinical_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tuberculosis_dosages_preparations_record`
--

CREATE TABLE IF NOT EXISTS `tuberculosis_dosages_preparations_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tuberculosis_dosages_preparations_id` varchar(60) NOT NULL,
  `tuberculosis_id` varchar(60) NOT NULL,
  `child_isoniazid` int(5) NOT NULL,
  `child_rifampicin` int(5) NOT NULL,
  `child_pyrazinamide` int(5) NOT NULL,
  `child_ethambutol` int(5) NOT NULL,
  `child_streptomycin` int(5) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tuberculosis_dosages_preparations_id` (`tuberculosis_dosages_preparations_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tuberculosis_drug_intake_record`
--

CREATE TABLE IF NOT EXISTS `tuberculosis_drug_intake_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tuberculosis_drug_intake_id` varchar(60) NOT NULL,
  `tuberculosis_id` varchar(60) NOT NULL,
  `adult_date_of_administration` datetime NOT NULL,
  `adult_drug_administrator` enum('TP','SLF','MISS') NOT NULL DEFAULT 'MISS',
  `adult_intake_type` enum('I','C') NOT NULL DEFAULT 'I',
  `adult_drug_intake_remarks` varchar(200) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tuberculosis_drug_intake_id` (`tuberculosis_drug_intake_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tuberculosis_dssm_record`
--

CREATE TABLE IF NOT EXISTS `tuberculosis_dssm_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tuberculosis_dssm_id` varchar(60) NOT NULL,
  `tuberculosis_id` varchar(60) NOT NULL,
  `month` int(11) NOT NULL,
  `due_date` datetime NOT NULL,
  `date_examined` datetime NOT NULL,
  `result` varchar(40) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tuberculosis_dssm_id` (`tuberculosis_dssm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tuberculosis_record`
--

CREATE TABLE IF NOT EXISTS `tuberculosis_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tuberculosis_id` varchar(60) NOT NULL,
  `healthcareservice_id` varchar(60) NOT NULL,
  `tuberculin_result` int(11) NOT NULL,
  `tuberculin_date_read` datetime NOT NULL,
  `cxr_findings` varchar(200) NOT NULL,
  `cxr_date_of_exam` datetime NOT NULL,
  `cxr_tbdc` int(11) NOT NULL,
  `other_exam_exam_conducted` int(11) NOT NULL,
  `other_exam_date_of_exam` datetime NOT NULL,
  `bcg_scar` enum('Y','N','D') NOT NULL DEFAULT 'D',
  `category_of_treatment` enum('I','II','III') NOT NULL DEFAULT 'I',
  `xpert_results` varchar(40) NOT NULL,
  `xpert_date_of_collection` datetime NOT NULL,
  `pict_done` enum('Y','N','U') NOT NULL DEFAULT 'U',
  `pict_date_administered` datetime NOT NULL,
  `diagnosis_tuberculosis_type` enum('TB','TBI','TBE','NTB') NOT NULL DEFAULT 'NTB',
  `diagnosis_remarks` int(11) NOT NULL,
  `tb_drugs_before` enum('Y','N','U') NOT NULL DEFAULT 'U',
  `tb_drugs_date_administered` datetime NOT NULL,
  `tb_drugs_duration` enum('L','M') NOT NULL DEFAULT 'L',
  `tb_drugs_taken` varchar(40) NOT NULL,
  `bacteriological_status` enum('BC','CD','ND') NOT NULL DEFAULT 'ND',
  `anatomical_site` enum('P','EP') NOT NULL DEFAULT 'EP',
  `anatomical_site_specify` varchar(40) NOT NULL,
  `bacteriology_registration_group` enum('N','R','TAF','TALF','PTOU','OTH') NOT NULL DEFAULT 'OTH',
  `bacteriology_registration_group_specify` varchar(40) NOT NULL,
  `treatment_outcome_date_started` datetime NOT NULL,
  `treatment_outcome_date_last_intake` datetime NOT NULL,
  `treatment_outcome_result` enum('C','TC','D','F','LTF','NE','EFC') NOT NULL DEFAULT 'EFC',
  `treatment_outcome_additional_remarks` varchar(200) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tuberculosis_id` (`tuberculosis_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `old_user_id` int(11) DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `activation_code` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `suffix` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `civil_status` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('F','M','U') COLLATE utf8_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `user_type` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_picture` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `prescription_header` text COLLATE utf8_unicode_ci,
  `qrcode` varchar(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `status` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `old_profile` tinyint(1) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_user_id_unique` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_contact`
--

CREATE TABLE IF NOT EXISTS `user_contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usercontact_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `street_address` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `barangay` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `province` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `zip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `house_no` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `building_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `street_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `village` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_contact_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_md`
--

CREATE TABLE IF NOT EXISTS `user_md` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usermd_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `profession` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `professional_type_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `professional_license_number` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `med_school` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `med_school_grad_yr` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `residency_trn_inst` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `residency_grad_yr` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_md_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_usage_stat`
--

CREATE TABLE IF NOT EXISTS `user_usage_stat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userusagestat_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `login_datetime` datetime NOT NULL,
  `logout_datetime` datetime NOT NULL,
  `device` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_usage_stat_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vital_physical`
--

CREATE TABLE IF NOT EXISTS `vital_physical` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vitalphysical_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `healthcareservice_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `bloodpressure_systolic` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bloodpressure_diastolic` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bloodpressure_assessment` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `heart_rate` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pulse_rate` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `respiratory_rate` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `temperature` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `height` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `weight` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BMI_category` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `waist` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pregnant` tinyint(1) DEFAULT NULL,
  `weight_loss` tinyint(1) DEFAULT NULL,
  `with_intact_uterus` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `vital_physical_vitalphysical_id_unique` (`vitalphysical_id`),
  KEY `vital_physical_healthcareservice_id_foreign` (`healthcareservice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
