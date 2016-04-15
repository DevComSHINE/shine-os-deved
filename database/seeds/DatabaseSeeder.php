<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(lov_immunizations::class);
        $this->call(lov_diagnosis::class);
        $this->call(lov_medicalprocedures::class);
        $this->call(lov_diseases::class);
        $this->call(lov_allergy_reaction::class);
        $this->call(lov_disabilities::class);
        $this->call(lov_enumerations::class);
        $this->call(lov_medicalcategory::class);
        $this->call(lov_referral_reasons::class);
        $this->call(lov_laboratories::class);
        $this->call(lov_loincs::class);
        $this->call(lov_icd10::class);
        $this->call(lov_doh_facility_codes::class);
        $this->call(lov_drugs::class);
        $this->call(lov_address::class);
        $this->call(lov_modules::class);
        $this->call(roles::class);
        Model::reguard();
    }
}
