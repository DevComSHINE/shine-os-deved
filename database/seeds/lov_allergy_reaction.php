<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_allergy_reaction extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Model::unguard();
        //// lov_allergy_reaction
		DB::table('lov_allergy_reaction')->insert(array(
			array('allergyreaction_id' => '1', 'allergyreaction_name' => 'Hives'),
			array('allergyreaction_id' => '2', 'allergyreaction_name' => 'Itching'),
			array('allergyreaction_id' => '3', 'allergyreaction_name' => 'Nasal congestion'),
			array('allergyreaction_id' => '4', 'allergyreaction_name' => 'Rashes'),
			array('allergyreaction_id' => '5', 'allergyreaction_name' => 'Watery, red eyes'),
			array('allergyreaction_id' => '6', 'allergyreaction_name' => 'Abdominal pain'),
			array('allergyreaction_id' => '7', 'allergyreaction_name' => 'Abnormal (high-pitched) breathing sounds'),
			array('allergyreaction_id' => '8', 'allergyreaction_name' => 'Anxiety'),
			array('allergyreaction_id' => '9', 'allergyreaction_name' => 'Chest discomfort or tightness'),
			array('allergyreaction_id' => '10', 'allergyreaction_name' => 'Cough'),
			array('allergyreaction_id' => '11', 'allergyreaction_name' => 'Diarrhea'),
			array('allergyreaction_id' => '12', 'allergyreaction_name' => 'Difficulty breathing'),
			array('allergyreaction_id' => '13', 'allergyreaction_name' => 'Difficulty swallowing'),
			array('allergyreaction_id' => '14', 'allergyreaction_name' => 'Dizziness or light-headedness'),
			array('allergyreaction_id' => '15', 'allergyreaction_name' => 'Flushing or redness of the face'),
			array('allergyreaction_id' => '16', 'allergyreaction_name' => 'Nausea or vomiting'),
			array('allergyreaction_id' => '17', 'allergyreaction_name' => 'Palpitations'),
			array('allergyreaction_id' => '18', 'allergyreaction_name' => 'Swelling of the face, eyes, or tongue'),
			array('allergyreaction_id' => '19', 'allergyreaction_name' => 'Uncinsciousness'),
			array('allergyreaction_id' => '20', 'allergyreaction_name' => 'Weezing'),
			array('allergyreaction_id' => '21', 'allergyreaction_name' => 'Unknown'),
			));
		Model::reguard();
    }
}
