<?php

function getDiseases()
{
    $diseases = [
    'Acute Watery Diarrhea'=>'A09',
    'Acute Bloody Diarrhea'=>'A09',
    'Influenza-like Illness'=>'J11',
    'Influenza'=>'J11',
    'Acute Flaccid Paralysis'=>'G83.9',
    'Acute Hemorrhagic Fever Syndrome (Dengue)'=>'A91',
    'Acute Lower Respiratory Track Infection'=>'J22',
    'Pneumonia'=>'J18.9',
    'Cholera'=>'A00',
    'Diphtheria'=>'A36',
    'Filarisis'=>'B74',
    'Leprosy'=>'A30',
    'Leptospirosis'=>'A27',
    'Malaria'=>'B50-B54',
    'Measles'=>'B05',
    'Meningococcemia'=>'A39',
    'Neonatal Tetanus'=>'A33',
    'Non-neonatal Tetanus'=>'A35',
    'Paralytic Shellfish Poisoning'=>'T61.2',
    'Rabies'=>'A82',
    'Schistosomiasis'=>'B65',
    'Typhoid'=>'A01',
    'Paratyphoid'=>'A01',
    'Viral Encephalitis'=>'A83-86',
    'Acute Viral Hepatitis'=>'B15-B17',
    'Viral Meningitis'=>'A87',
    'Syphilis'=>'A50-A53',
    'Gonorrhea'=>'A54.9',
    'Urethral Discharge'=>'R36',
    'Genital Ulcer'=>'N48.5'
    ];

    return $diseases;
}

function getAgeGroups()
{
    $ageGroup = ['Under 1' => '0-1',
    '1 to 4' => '1-4',
    '5 to 9' => '5-9',
    '10 to 14' => '10-14',
    '15 to 19' => '15-19',
    '20 to 24' => '20-24',
    '25 to 29' => '25-29',
    '30 to 34' => '30-34',
    '35 to 39' => '35-39',
    '40 to 44' => '40-44',
    '45 to 49' => '45-49',
    '50 to 54' => '50-54',
    '55 to 59' => '55-59',
    '60 to 64' => '60-64',
    '65 to 59' => '65-69',
    '70+' => '70-100'
    ];

    return $ageGroup;
}
