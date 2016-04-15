<?php

$plugin_module = 'patients';            //plugin parent module
$plugin_title = 'Patient Employment Information';            //plugin title
$plugin_id = 'Employment';              //plugin ID
$plugin_location = 'newdata';           //UI location where plugin will be accessible
$plugin_primaryKey = 'patient_id';      //primary_key used to find data
$plugin_table = 'patient_employmentinfo';           //plugintable default; table_name custom table
$plugin_description = 'The Patient Employment Information Plugin. Capture employment data of a patient using this plugin. This is a simple example of data capture plugins. This plugin also creates its own DB Table.';
$plugin_version = '1.0';
$plugin_developer = 'ShineLabs';
$plugin_url = 'http://www.shine.ph';
$plugin_copy = "2016";
$plugin_folder = 'ShineLab_Employment';

$dbtable = "
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
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (id),
  UNIQUE KEY `patient_employmentinfo_patient_employmentinfo_id_unique` (`patient_employmentinfo_id`)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_unicode_ci;";

DB::statement($dbtable);
