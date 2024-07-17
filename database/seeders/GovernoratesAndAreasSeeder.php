<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernoratesAndAreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert Governorates
        $governorates = [
            ['title_en' => 'Capital Governorate', 'title_ar' => 'محافظة العاصمة', 'status' => 1],
            ['title_en' => 'Hawalli Governorate', 'title_ar' => 'محافظة حولي', 'status' => 1],
            ['title_en' => 'Mubarak al-Kabeer Governorate', 'title_ar' => 'محافظة مبارك الكبير', 'status' => 1],
            ['title_en' => 'Ahmadi Governorate', 'title_ar' => 'محافظة الأحمدي', 'status' => 1],
        ];

        DB::table('governorates')->insert($governorates);

        // Insert Areas
        $areas = [
            ['governorate_id' => 1, 'area_en' => 'Abdullah as-Salim suburb', 'area_ar' => 'ضاحية عبد الله السالم', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Adiliya', 'area_ar' => 'العديلية', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Bneid il-Gār', 'area_ar' => 'بنيد القار', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Da\'iya', 'area_ar' => 'الدعية', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Dasma', 'area_ar' => 'الدسمة', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Dasmān', 'area_ar' => 'دسمان', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Doha', 'area_ar' => 'الدوحة', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Faiha\'', 'area_ar' => 'الفيحاء', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Ghirnata', 'area_ar' => 'غرناطة', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Jabir al-Ahmad City', 'area_ar' => 'مدينة جابر الأحمد', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Jibla', 'area_ar' => 'جبلة', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Kaifan', 'area_ar' => 'كيفان', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Khaldiya', 'area_ar' => 'الخالدية', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Mansūriya', 'area_ar' => 'المنصورية', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Mirgāb', 'area_ar' => 'المرقاب', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Nahdha', 'area_ar' => 'النهضة', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Nuzha', 'area_ar' => 'النزهة', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Qadsiya', 'area_ar' => 'القادسية', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Qairawān', 'area_ar' => 'القيروان', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Qurtuba', 'area_ar' => 'قرطبة', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Rai', 'area_ar' => 'الري', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Rawda', 'area_ar' => 'الروضة', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Salhiya', 'area_ar' => 'الصالحية', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Sawābir', 'area_ar' => 'الصوابر', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Shamiya', 'area_ar' => 'الشامية', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Sharq', 'area_ar' => 'شرق', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Shuwaikh', 'area_ar' => 'الشويخ', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Sulaibikhat', 'area_ar' => 'الصليبخات', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Surra', 'area_ar' => 'السرة', 'status' => 1],
            ['governorate_id' => 1, 'area_en' => 'Yarmūk', 'area_ar' => 'اليرموك', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'Bayān', 'area_ar' => 'بيان', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'Bi\'di\'', 'area_ar' => 'البدع', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'Hawally', 'area_ar' => 'حولي', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'Hittin', 'area_ar' => 'حطين', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'Jabriya', 'area_ar' => 'الجابرية', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'Maidan Hawalli', 'area_ar' => 'ميدان حولي', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'Mishrif', 'area_ar' => 'مشرف', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'Mubarak aj-Jabir suburb', 'area_ar' => 'ضاحية مبارك الجابر', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'Nigra', 'area_ar' => 'النقرة', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'Rumaithiya', 'area_ar' => 'الرميثية', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'Salmiya', 'area_ar' => 'السالمية', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'Salwa', 'area_ar' => 'سلوى', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'Sha\'ab', 'area_ar' => 'الشعب', 'status' => 1],
            ['governorate_id' => 2, 'area_en' => 'South Surra', 'area_ar' => 'جنوب السرة', 'status' => 1],
            ['governorate_id' => 3, 'area_en' => 'Abu \'Fteira', 'area_ar' => 'أبو فطيرة', 'status' => 1],
            ['governorate_id' => 3, 'area_en' => 'Adān', 'area_ar' => 'العدان', 'status' => 1],
            ['governorate_id' => 3, 'area_en' => 'Fintās', 'area_ar' => 'الفنطاس', 'status' => 1],
            ['governorate_id' => 3, 'area_en' => 'Funaitīs', 'area_ar' => 'الفنيطيس', 'status' => 1],
            ['governorate_id' => 3, 'area_en' => 'Misīla', 'area_ar' => 'المسيلة', 'status' => 1],
            ['governorate_id' => 3, 'area_en' => 'Mubarak al-Kabeer', 'area_ar' => 'مبارك الكبير', 'status' => 1],
            ['governorate_id' => 3, 'area_en' => 'Qurain', 'area_ar' => 'القرين', 'status' => 1],
            ['governorate_id' => 3, 'area_en' => 'Qusūr', 'area_ar' => 'القصور', 'status' => 1],
            ['governorate_id' => 3, 'area_en' => 'Sabah as-Salim suburb', 'area_ar' => 'ضاحية صباح السالم', 'status' => 1],
            ['governorate_id' => 3, 'area_en' => 'Sabhān', 'area_ar' => 'صبحان', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Abdullah Port', 'area_ar' => 'ميناء عبد الله', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Abu Hulaifa', 'area_ar' => 'أبو حليفة', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Agricultural Wafra', 'area_ar' => 'الوفرة الزراعية', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Ahmadi', 'area_ar' => 'الأحمدي', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Ali as-Salim suburb', 'area_ar' => 'ضاحية علي صباح السالم', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Aqila', 'area_ar' => 'العقيلة', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Bneidar', 'area_ar' => 'بنيدر', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Fahaheel', 'area_ar' => 'الفحيحيل', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Fahd al-Ahmad Suburb', 'area_ar' => 'ضاحية فهد الأحمد', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Hadiya', 'area_ar' => 'هدية', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Jabir al-Ali Suburb', 'area_ar' => 'ضاحية جابر العلي', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Jilei\'a', 'area_ar' => 'الجليعة', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Khairan', 'area_ar' => 'الخيران', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Khairan City', 'area_ar' => 'مدينة الخيران', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Mahbula', 'area_ar' => 'المهبولة', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Mangaf', 'area_ar' => 'المنقف', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Miqwa\'', 'area_ar' => 'المقوع', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Nuwaiseeb', 'area_ar' => 'النويصيب', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Rigga', 'area_ar' => 'الرقة', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Sabah al-Ahmad City', 'area_ar' => 'مدينة صباح الأحمد', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Sabah al-Ahmad Nautical City', 'area_ar' => 'مدينة صباح الأحمد البحرية', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Sabahiya', 'area_ar' => 'الصباحية', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Shu\'aiba', 'area_ar' => 'الشعيبة', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Wafra', 'area_ar' => 'الوفرة', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Zoor', 'area_ar' => 'الزور', 'status' => 1],
            ['governorate_id' => 4, 'area_en' => 'Zuhar', 'area_ar' => 'الظهر', 'status' => 1],
        ];

        DB::table('areas')->insert($areas);
    }
}
