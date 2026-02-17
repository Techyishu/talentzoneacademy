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
            'email' => 'admin@talentzoneacademy.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'school_id' => null,
        ]);

        // Create 2 Schools
        $schools = [
            [
                'name' => 'Talent Zone Academy Karnal',
                'code' => 'TAK',
                'address' => 'Karnal, Haryana 132001',
                'phone' => '+91 184 225 6789',
                'email' => 'karnal@talentzoneacademy.edu',
                'receipt_prefix' => 'TAK-',
                'primary_color' => '#E31E24',
            ],
            [
                'name' => 'Talent Zone Academy Kurukshetra',
                'code' => 'TAKK',
                'address' => 'Kurukshetra, Haryana 136118',
                'phone' => '+91 174 423 7890',
                'email' => 'kurukshetra@talentzoneacademy.edu',
                'receipt_prefix' => 'TAKK-',
                'primary_color' => '#003B71',
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
        $this->command->info('Super Admin: admin@talentzoneacademy.com / password');
        $this->command->info('School Admin 1: admin@tak.com / password');
        $this->command->info('School Admin 2: admin@takk.com / password');
    }
}
