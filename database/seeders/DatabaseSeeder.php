<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@schoolsuite.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'school_id' => null,
        ]);

        // Create 3 Schools
        $schools = [
            [
                'name' => 'Green Valley International School',
                'code' => 'SCH001',
                'address' => '123 Education Street, City',
                'phone' => '+1-234-567-8901',
                'email' => 'info@greenvalley.edu',
                'receipt_prefix' => 'GVIS-',
                'primary_color' => '#10B981',
            ],
            [
                'name' => 'Sunshine Academy',
                'code' => 'SCH002',
                'address' => '456 Learning Ave, Town',
                'phone' => '+1-234-567-8902',
                'email' => 'contact@sunshine.edu',
                'receipt_prefix' => 'SA-',
                'primary_color' => '#F59E0B',
            ],
            [
                'name' => 'Royal Public School',
                'code' => 'SCH003',
                'address' => '789 Knowledge Blvd, Village',
                'phone' => '+1-234-567-8903',
                'email' => 'admin@royalpublic.edu',
                'receipt_prefix' => 'RPS-',
                'primary_color' => '#8B5CF6',
            ],
        ];

        foreach ($schools as $index => $schoolData) {
            $school = School::create($schoolData);

            // Create School Admin for each school
            User::create([
                'name' => $schoolData['name'] . ' Admin',
                'email' => 'admin@' . strtolower(str_replace(' ', '', $schoolData['code'])) . '.com',
                'password' => Hash::make('password'),
                'role' => 'school_admin',
                'school_id' => $school->id,
            ]);

            // Create sample pages for each school
            $pages = [
                [
                    'slug' => 'home',
                    'title' => 'Welcome to ' . $school->name,
                    'content' => '<h1>Welcome to our school</h1><p>We provide quality education for all students.</p>',
                    'meta_title' => $school->name . ' - Home',
                    'meta_description' => 'Welcome to ' . $school->name,
                ],
                [
                    'slug' => 'about',
                    'title' => 'About Us',
                    'content' => '<h1>About ' . $school->name . '</h1><p>Established with a vision to provide excellent education.</p>',
                    'meta_title' => 'About - ' . $school->name,
                    'meta_description' => 'Learn more about ' . $school->name,
                ],
                [
                    'slug' => 'contact',
                    'title' => 'Contact Us',
                    'content' => '<h1>Contact Information</h1><p>Address: ' . $school->address . '</p><p>Phone: ' . $school->phone . '</p>',
                    'meta_title' => 'Contact - ' . $school->name,
                    'meta_description' => 'Get in touch with ' . $school->name,
                ],
            ];

            foreach ($pages as $pageData) {
                Page::create(array_merge($pageData, ['school_id' => $school->id]));
            }

            // Create 5 sample students for each school
            for ($i = 1; $i <= 5; $i++) {
                Student::create([
                    'school_id' => $school->id,
                    'admission_no' => 'ADM' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'name' => 'Student ' . $i . ' - ' . $school->code,
                    'gender' => $i % 2 == 0 ? 'male' : 'female',
                    'dob' => now()->subYears(rand(10, 15))->format('Y-m-d'),
                    'class' => 'Class ' . rand(1, 10),
                    'section' => chr(64 + rand(1, 3)), // A, B, or C
                    'roll_no' => (string) $i,
                    'guardian_name' => 'Guardian ' . $i,
                    'guardian_phone' => '+1-234-567-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'address' => $i . ' Student Street, City',
                    'status' => 'active',
                ]);
            }

            // Create 3 sample staff for each school
            for ($i = 1; $i <= 3; $i++) {
                Staff::create([
                    'school_id' => $school->id,
                    'staff_code' => 'STAFF' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'name' => 'Teacher ' . $i . ' - ' . $school->code,
                    'designation' => ['Principal', 'Vice Principal', 'Teacher'][$i - 1],
                    'phone' => '+1-234-567-9' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'joining_date' => now()->subYears(rand(1, 5))->format('Y-m-d'),
                    'salary' => rand(30000, 80000),
                    'status' => 'active',
                ]);
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Super Admin: admin@schoolsuite.com / password');
        $this->command->info('School Admin 1: admin@sch001.com / password');
        $this->command->info('School Admin 2: admin@sch002.com / password');
        $this->command->info('School Admin 3: admin@sch003.com / password');
    }
}
