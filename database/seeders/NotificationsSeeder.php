<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'user_id' => 2, // राजेश शर्मा
                'message' => 'तपाईंको जीवन बीमा प्रिमियम भुक्तानीको अन्तिम मिति आउँदैछ। कृपया समयमै भुक्तानी गर्नुहोस्।',
                'type' => 'premium_reminder',
                'is_seen' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // राजेश शर्मा
                'message' => 'तपाईंको दावी सफलतापूर्वक स्वीकृत भयो। रकम ४,५०,००० तपाईंको खातामा पठाउने प्रक्रियामा छ।',
                'type' => 'claim_approved',
                'is_seen' => 1,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'user_id' => 3, // सनिमा श्रेष्ठ
                'message' => 'तपाईंको स्वास्थ्य बीमा पोलिसीको अवधि सकिँदैछ। कृपया नवीकरण गर्नुहोस्।',
                'type' => 'policy_renewal',
                'is_seen' => 0,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'user_id' => 4, // सारा गुरुङ
                'message' => 'हाम्रो नयाँ स्वास्थ्य बीमा योजनामा थप फाइदाहरू छन्। विस्तृत जानकारीको लागि सम्पर्क गर्नुहोस्।',
                'type' => 'new_policy',
                'is_seen' => 1,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'user_id' => 5, // बिकास खड्का
                'message' => 'तपाईंको दावी अहिले समीक्षामा छ। थप कागजातहरू आवश्यक परेमा सम्पर्क गरिनेछ।',
                'type' => 'claim_update',
                'is_seen' => 0,
                'created_at' => now()->subHours(6),
                'updated_at' => now()->subHours(6),
            ],
            [
                'user_id' => 1, // एडमिन
                'message' => '३ नयाँ दावीहरू दर्ता भएका छन्। कृपया समीक्षा गर्नुहोस्।',
                'type' => 'admin_notification',
                'is_seen' => 1,
                'created_at' => now()->subHours(12),
                'updated_at' => now()->subHours(12),
            ],
            [
                'user_id' => 1, // एडमिन
                'message' => 'आइतबारे मासिक बीमा रिपोर्ट तयार भएको छ। ड्यासबोर्डमा हेर्नुहोस्।',
                'type' => 'monthly_report',
                'is_seen' => 0,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'user_id' => 2, // राजेश शर्मा
                'message' => 'तपाईंको मासिक खाता विवरण उपलब्ध छ। लगइन गरेर हेर्नुहोस्।',
                'type' => 'account_statement',
                'is_seen' => 1,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ],
        ];

        DB::table('notifications')->insert($notifications);
    }
}
