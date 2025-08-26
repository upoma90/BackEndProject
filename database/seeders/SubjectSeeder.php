<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'Mathematics', 'description' => 'Primary to University level mathematics'],
            ['name' => 'English', 'description' => 'English language and literature'],
            ['name' => 'Science', 'description' => 'General science and specific sciences'],
            ['name' => 'Physics', 'description' => 'Physics for secondary and JC levels'],
            ['name' => 'Chemistry', 'description' => 'Chemistry for secondary and JC levels'],
            ['name' => 'Biology', 'description' => 'Biology for secondary and JC levels'],
            ['name' => 'Chinese', 'description' => 'Chinese language and literature'],
            ['name' => 'Japanese', 'description' => 'Japanese language and culture'],
            ['name' => 'History', 'description' => 'History and social studies'],
            ['name' => 'Geography', 'description' => 'Geography and environmental studies'],
            ['name' => 'Economics', 'description' => 'Economics for JC and University levels'],
            ['name' => 'Computer Science', 'description' => 'Programming and computer studies'],
            ['name' => 'Art', 'description' => 'Visual arts and design'],
            ['name' => 'Music', 'description' => 'Music theory and practical lessons'],
            ['name' => 'Physical Education', 'description' => 'Sports and fitness training'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
} 