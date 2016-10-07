<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Shine\Libraries\IdGenerator;

class lov_examination extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();

        $lov_examination = array(
          array('id' => '1','examination_id' => '5603736161609090606055722','examination_name' => 'Pallor','examination_code' => 'pallor','examination_type' => 'Skin','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '2','examination_id' => '6892628161609090606055723','examination_name' => 'Rashes','examination_code' => 'rashes','examination_type' => 'Skin','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '3','examination_id' => '6578547161609090606055723','examination_name' => 'Jaundice','examination_code' => 'jaundice','examination_type' => 'Skin','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '4','examination_id' => '9376971161609090606055724','examination_name' => 'Good Skin Turgor','examination_code' => 'good_skin_turgor','examination_type' => 'Skin','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '5','examination_id' => '7864139161609090606055724','examination_name' => 'Others','examination_code' => 'skin_others','examination_type' => 'Skin','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '6','examination_id' => '6805717161609090606055724','examination_name' => 'Anicteric Sclerae','examination_code' => 'anicteric_sclerae','examination_type' => 'HEENT','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '7','examination_id' => '0675187161609090606055725','examination_name' => 'Pupils','examination_code' => 'pupils','examination_type' => 'HEENT','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '8','examination_id' => '5261251161609090606055725','examination_name' => 'Aural Discharge','examination_code' => 'aural_discharge','examination_type' => 'HEENT','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '9','examination_id' => '7265767161609090606055725','examination_name' => 'Intact Tympanic Membrane','examination_code' => 'intact_tympanic_membrane','examination_type' => 'HEENT','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '10','examination_id' => '5779842161609090606055725','examination_name' => 'Nasal Discharge','examination_code' => 'nasal_discharge','examination_type' => 'HEENT','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '11','examination_id' => '4120080161609090606055725','examination_name' => 'Tonsillopharyngeal Congestion','examination_code' => 'tonsillopharyngeal_congestion','examination_type' => 'HEENT','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '12','examination_id' => '5207092161609090606055726','examination_name' => 'Hypertrophic Tonsils','examination_code' => 'hypertrophic_tonsils','examination_type' => 'HEENT','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '13','examination_id' => '9420746161609090606055726','examination_name' => 'Palpable Mass','examination_code' => 'palpable_mass','examination_type' => 'HEENT','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '14','examination_id' => '7470753161609090606055726','examination_name' => 'Exudates','examination_code' => 'exudates','examination_type' => 'HEENT','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '15','examination_id' => '3025876161609090606055726','examination_name' => 'Others','examination_code' => 'heent_others','examination_type' => 'HEENT','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '16','examination_id' => '5319026161609090606055726','examination_name' => 'Symmetrical Chest Expansion','examination_code' => 'symmetrical_chest_expansion','examination_type' => 'Chest/Lungs','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '17','examination_id' => '1617828161609090606055726','examination_name' => 'Clear Breathsounds','examination_code' => 'clear_breathsounds','examination_type' => 'Chest/Lungs','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '18','examination_id' => '6662717161609090606055726','examination_name' => 'Crackles Rales','examination_code' => 'crackles_rales','examination_type' => 'Chest/Lungs','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '19','examination_id' => '7167385161609090606055726','examination_name' => 'Wheezes','examination_code' => 'wheezes','examination_type' => 'Chest/Lungs','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '20','examination_id' => '9903631161609090606055726','examination_name' => 'Others','examination_code' => 'chest_others','examination_type' => 'Chest/Lungs','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '21','examination_id' => '7243267161609090606055726','examination_name' => 'Adynamic Precordium','examination_code' => 'adynami_precordium','examination_type' => 'Heart','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '22','examination_id' => '9682825161609090606055727','examination_name' => 'Rhythm','examination_code' => 'rhythm','examination_type' => 'Heart','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '23','examination_id' => '1257789161609090606055727','examination_name' => 'Heaves','examination_code' => 'heaves','examination_type' => 'Heart','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '24','examination_id' => '7533838161609090606055727','examination_name' => 'Murmurs','examination_code' => 'murmurs','examination_type' => 'Heart','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '25','examination_id' => '8253901161609090606055727','examination_name' => 'Others','examination_code' => 'heart_others','examination_type' => 'Heart','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '26','examination_id' => '1621467161609090606055727','examination_name' => 'Flat','examination_code' => 'flat','examination_type' => 'Abdomen','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '27','examination_id' => '1888674161609090606055727','examination_name' => 'Globular','examination_code' => 'globular','examination_type' => 'Abdomen','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '28','examination_id' => '5281295161609090606055727','examination_name' => 'Flabby','examination_code' => 'flabby','examination_type' => 'Abdomen','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '29','examination_id' => '2843863161609090606055727','examination_name' => 'Muscle Guarding','examination_code' => 'muscle_guarding','examination_type' => 'Abdomen','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '30','examination_id' => '9397960161609090606055728','examination_name' => 'Tenderness','examination_code' => 'tenderness','examination_type' => 'Abdomen','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '31','examination_id' => '5458612161609090606055728','examination_name' => 'Palpable Mass','examination_code' => 'palpable_mass','examination_type' => 'Abdomen','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '32','examination_id' => '1534067161609090606055728','examination_name' => 'Others','examination_code' => 'abdomen_others','examination_type' => 'Abdomen','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '33','examination_id' => '3129042161609090606055728','examination_name' => 'Normal Gait','examination_code' => 'normal_gait','examination_type' => 'Extremities','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '34','examination_id' => '3386992161609090606055728','examination_name' => 'Full Equal Pulses','examination_code' => 'full_equal_pulses','examination_type' => 'Extremities','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
          array('id' => '35','examination_id' => '3949221161609090606055728','examination_name' => 'Others','examination_code' => 'extreme_others','examination_type' => 'Extremities','deleted_at' => NULL,'created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00')
        );

        DB::table('lov_examination')->insert($lov_examination);
	    
		Model::reguard();
    }
}
