<?php

namespace Database\Seeders;

use App\Models\FeeHead;
use App\Models\School;
use Illuminate\Database\Seeder;

class FeeHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Common fee heads to create for all schools
        $commonFeeHeads = [
            ['name' => 'Tuition Fee', 'code' => 'TF', 'description' => 'Monthly tuition fees'],
            ['name' => 'Admission Fee', 'code' => 'AF', 'description' => 'One-time admission fee'],
            ['name' => 'Transport Fee', 'code' => 'TR', 'description' => 'Monthly bus/transport charges'],
            ['name' => 'Lab Fee', 'code' => 'LF', 'description' => 'Laboratory and practical charges'],
            ['name' => 'Sports Fee', 'code' => 'SF', 'description' => 'Sports and physical education fee'],
            ['name' => 'Library Fee', 'code' => 'LIB', 'description' => 'Library usage and book maintenance'],
            ['name' => 'Exam Fee', 'code' => 'EF', 'description' => 'Examination and assessment charges'],
            ['name' => 'Annual Charges', 'code' => 'AC', 'description' => 'Annual maintenance and development charges'],
            ['name' => 'Computer Fee', 'code' => 'CF', 'description' => 'Computer lab and digital learning fee'],
            ['name' => 'Activity Fee', 'code' => 'ACT', 'description' => 'Co-curricular and extra-curricular activities'],
        ];

        // Get all schools
        $schools = School::all();

        foreach ($schools as $school) {
            foreach ($commonFeeHeads as $feeHeadData) {
                FeeHead::firstOrCreate(
                    [
                        'school_id' => $school->id,
                        'name' => $feeHeadData['name'],
                    ],
                    [
                        'code' => $feeHeadData['code'],
                        'description' => $feeHeadData['description'],
                        'is_active' => true,
                    ]
                );
            }
        }

        $this->command->info('Fee heads seeded successfully for all schools.');
    }
}
