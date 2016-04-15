<?php
$plugin_id = 'Dengue';                       //plugin ID
$plugin_module = 'healthcareservices';          //module owner
$plugin_location = 'dropdown';                  //UI location where plugin will be accessible
$plugin_primaryKey = 'dengue_id';        //primary_key used to find data
$plugin_table = 'dengue_record';            //plugintable default; table_name custom table
$plugin_tabs_child = array('addservice', 'vitals', 'dengue_plugin', 'medicalorders', 'disposition'); //,

$plugin_relationship = array();
$plugin_folder = 'Dengue'; //module owner
$plugin_title = 'Dengue';            //plugin title
$plugin_description = 'Dengue';
$plugin_version = '1.0';
$plugin_developer = 'ShineLabs';
$plugin_url = 'http://www.shine.ph';
$plugin_copy = "2016";


$plugin_tabs = [
    'addservice' => 'Basic Information',
    'disposition' => 'Disposition',
    'medicalorders' => 'Medical Orders',
    'vitals' => 'Vitals & Physical',
    'dengue_plugin' => 'Dengue Status'
];

$plugin_tabs_models = [
    'disposition' => 'Disposition',
    'medicalorders' => 'MedicalOrder',
    'vitals' => 'VitalsPhysical',
    'dengue_plugin' => 'DengueModel'
];

$dbtable = "CREATE TABLE IF NOT EXISTS `dengue_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `dengue_id` (`dengue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";


DB::statement($dbtable);

//============
// DB Table definition
//
/*
CREATE TABLE IF NOT EXISTS `dengue_record` (
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
  `created_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `dengue_record`
  ADD PRIMARY KEY (`dengue_id`),
  ADD UNIQUE KEY `healthcareservice_id` (`healthcareservice_id`);
*/
