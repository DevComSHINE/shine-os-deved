<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_referral_reasons extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        // lov_referral_reasons
    	DB::table('lov_referral_reasons')->insert(array(
			array('lovreferralreason_id' => 'NODOC',
					'referral_reason' => 'No available doctor'),
			array('lovreferralreason_id' => 'NOEQP',
					'referral_reason' => 'No equipment available'),
			array('lovreferralreason_id' => 'NOLAB',
					'referral_reason' => 'No laboratory available'),
			array('lovreferralreason_id' => 'NOPRO',
					'referral_reason' => 'No procedure available'),
			array('lovreferralreason_id' => 'NOROM',
					'referral_reason' => 'No room available'),
			array('lovreferralreason_id' => 'PPREF',
					'referral_reason' => 'Patient preference'),
			array('lovreferralreason_id' => 'SEASO',
					'referral_reason' => 'Seek advise/second opinion'),
			array('lovreferralreason_id' => 'SEFTA',
					'referral_reason' => 'Seek further treatment appropriate to the case'),
			array('lovreferralreason_id' => 'WLOAD',
					'referral_reason' => 'Cannot accommodate due to work load'),
			array('lovreferralreason_id' => 'SESPE',
					'referral_reason' => 'Seek specialized evaluation'),
			array('lovreferralreason_id' => 'NOTAP',
					'referral_reason' => 'Not Applicable'),
			array('lovreferralreason_id' => 'OTHER',
					'referral_reason' => 'Others')
		));

        Model::reguard();
    }
}
