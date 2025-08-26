<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@tutionlink.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create sample students
        User::create([
            'name' => 'John Student',
            'email' => 'student@tutionlink.com',
            'password' => bcrypt('password'),
            'role' => 'student',
            'phone' => '+65 9123 4567',
            'address' => 'Dhanmondi, Dhaka',
        ]);

        User::create([
            'name' => 'Sarah Student',
            'email' => 'sarah@tutionlink.com',
            'password' => bcrypt('password'),
            'role' => 'student',
            'phone' => '+65 9234 5678',
            'address' => 'Chittagong, Bangladesh',
        ]);

        // Create sample tutors
        User::create([
            'name' => 'Roronoa Zoro',
            'email' => 'tutor@tutionlink.com',
            'password' => bcrypt('roronazoro'),
            'role' => 'tutor',
            'phone' => '01723648937',
            'address' => 'Gulshan, Dhaka',
            'bio' => 'Experienced mathematics tutor with 10+ years of teaching experience.',
            'rating' => 4.8,
            'total_reviews' => 25,
        ]);

        User::create([
            'name' => 'Ms. Lisa Chen',
            'email' => 'lisa@tutionlink.com',
            'password' => bcrypt('password'),
            'role' => 'tutor',
            'phone' => '+65 9456 7890',
            'address' => 'Sylhet, Bangladesh',
            'bio' => 'English language specialist with expertise in literature and creative writing. Available for all levels.',
            'rating' => 4.6,
            'total_reviews' => 18,
        ]);

        // Seed subjects
        $this->call([
            SubjectSeeder::class,
        ]);
    }
}
