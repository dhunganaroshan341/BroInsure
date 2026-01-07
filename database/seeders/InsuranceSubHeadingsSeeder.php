<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsuranceSubHeadingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subHeadings = [
            // जीवन बीमा Sub-categories
            [
                'heading_id' => 1, // जीवन बीमा
                'name' => 'टर्म लाइफ',
                'code' => 'TERM_LIFE',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'heading_id' => 1, // जीवन बीमा
                'name' => 'होल लाइफ',
                'code' => 'WHOLE_LIFE',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'heading_id' => 1, // जीवन बीमा
                'name' => 'एन्डुवमेन्ट प्लान',
                'code' => 'ENDOWMENT',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // स्वास्थ्य बीमा Sub-categories
            [
                'heading_id' => 2, // स्वास्थ्य बीमा
                'name' => 'व्यक्तिगत स्वास्थ्य',
                'code' => 'INDIVIDUAL_HEALTH',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'heading_id' => 2, // स्वास्थ्य बीमा
                'name' => 'पारिवारिक स्वास्थ्य',
                'code' => 'FAMILY_HEALTH',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'heading_id' => 2, // स्वास्थ्य बीमा
                'name' => 'कोभिड बीमा',
                'code' => 'COVID_INSURANCE',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // वाहन बीमा Sub-categories
            [
                'heading_id' => 3, // वाहन बीमा
                'name' => 'दुई पाङ्ग्रे बीमा',
                'code' => 'TWO_WHEELER',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'heading_id' => 3, // वाहन बीमा
                'name' => 'चार पाङ्ग्रे बीमा',
                'code' => 'FOUR_WHEELER',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'heading_id' => 3, // वाहन बीमा
                'name' => 'ट्रक/बस बीमा',
                'code' => 'COMMERCIAL_VEHICLE',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // घर बीमा Sub-categories
            [
                'heading_id' => 4, // घर बीमा
                'name' => 'आवासीय घर बीमा',
                'code' => 'RESIDENTIAL_HOME',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'heading_id' => 4, // घर बीमा
                'name' => 'व्यावसायिक घर बीमा',
                'code' => 'COMMERCIAL_HOME',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // यात्रा बीमा Sub-categories
            [
                'heading_id' => 5, // यात्रा बीमा
                'name' => 'घरेलु यात्रा बीमा',
                'code' => 'DOMESTIC_TRAVEL',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'heading_id' => 5, // यात्रा बीमा
                'name' => 'अन्तर्राष्ट्रिय यात्रा बीमा',
                'code' => 'INTERNATIONAL_TRAVEL',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // दुर्घटना बीमा Sub-categories
            [
                'heading_id' => 6, // दुर्घटना बीमा
                'name' => 'व्यक्तिगत दुर्घटना',
                'code' => 'PERSONAL_ACCIDENT',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'heading_id' => 6, // दुर्घटना बीमा
                'name' => 'समूह दुर्घटना',
                'code' => 'GROUP_ACCIDENT',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // सम्पत्ति बीमा Sub-categories
            [
                'heading_id' => 7, // सम्पत्ति बीमा
                'name' => 'फ्याक्ट्री बीमा',
                'code' => 'FACTORY_INSURANCE',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'heading_id' => 7, // सम्पत्ति बीमा
                'name' => 'दोकान बीमा',
                'code' => 'SHOP_INSURANCE',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // शिक्षा बीमा Sub-categories
            [
                'heading_id' => 8, // शिक्षा बीमा
                'name' => 'उच्च शिक्षा बीमा',
                'code' => 'HIGHER_EDUCATION',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'heading_id' => 8, // शिक्षा बीमा
                'name' => 'विदेश अध्ययन बीमा',
                'code' => 'ABROAD_STUDY',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // कृषि बीमा Sub-categories
            [
                'heading_id' => 9, // कृषि बीमा
                'name' => 'बाली बीमा',
                'code' => 'CROP_INSURANCE',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'heading_id' => 9, // कृषि बीमा
                'name' => 'पशु बीमा',
                'code' => 'LIVESTOCK_INSURANCE',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // व्यापार बीमा Sub-categories
            [
                'heading_id' => 10, // व्यापार बीमा
                'name' => 'व्यापार सम्पत्ति बीमा',
                'code' => 'BUSINESS_PROPERTY',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'heading_id' => 10, // व्यापार बीमा
                'name' => 'व्यापार दायित्व बीमा',
                'code' => 'BUSINESS_LIABILITY',
                'status' => 'Y',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('insurance_sub_headings')->insert($subHeadings);
    }
}
