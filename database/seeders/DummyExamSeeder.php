<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class DummyExamSeeder extends Seeder
{
    public function run()
    {
        // Create 5 dummy users
        $users = User::get();

        // Create 10 dummy questions
        $questions = [];
        for ($i = 1; $i <= 10; $i++) {
            $questions[] = DB::table('questions')->insertGetId([
                'question'     => "Sample question number $i?",
                'option_a'     => "Option A $i",
                'option_b'     => "Option B $i",
                'option_c'     => "Option C $i",
                'option_d'     => "Option D $i",
                'correct_option' => ['a', 'b', 'c', 'd'][rand(0, 3)],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        foreach ($users as $user) {
            // Create exam session for each user
            $sessionId = DB::table('exam_sessions')->insertGetId([
                'user_id'    => $user->id,
                'start_time' => now()->subMinutes(rand(10, 60)),
                'end_time'   => now(),
                'status'     => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create answers for some questions
            foreach ($questions as $questionId) {
                DB::table('answers')->insert([
                    'user_id'        => $user->id,
                    'question_id'    => $questionId,
                    'selected_option'=> ['a', 'b', 'c', 'd'][rand(0, 3)],
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }
    }
}
