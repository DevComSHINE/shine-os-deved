<?php
$plugin_id = 'Pediatrics';                       //plugin ID
$plugin_module = 'healthcareservices';          //module owner
$plugin_location = 'dropdown';                  //UI location where plugin will be accessible
$plugin_primaryKey = 'pediatrics_id';        //primary_key used to find data
$plugin_table = 'pediatrics_service';            //plugintable default; table_name custom table
$plugin_tabs_child = array('addservice', 'complaints', 'vitals', 'pediatrics_plugin', 'impanddiag', 'medicalorders', 'disposition'); //,
$plugin_type = 'consultation';
$plugin_age = "0-18";
$plugin_gender = "all";

$plugin_relationship = array();
$plugin_folder = 'Pediatrics'; //module owner
$plugin_title = 'Pediatrics';            //plugin title
$plugin_description = 'Pediatrics';
$plugin_version = '1.0';
$plugin_developer = 'ShineLabs';
$plugin_url = 'http://www.shine.ph';
$plugin_copy = "2016";

$plugin_tabs = [
    'addservice' => 'Basic Information',
    'complaints' => 'Complaints',
    'impanddiag' => 'Impressions & Diagnosis',
    'disposition' => 'Disposition',
    'medicalorders' => 'Medical Orders',
    'vitals' => 'Vitals & Physical',
    'pediatrics_plugin' => 'Pediatrics'
];

$plugin_tabs_models = [
    'complaints' => 'GeneralConsultation',
    'disposition' => 'Disposition',
    'medicalorders' => 'MedicalOrder',
    'vitals' => 'VitalsPhysical',
    'pediatrics_plugin' => 'PediatricsModel'
];
