<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VisitorStressTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Flooding database with 5,000 optimized student rows for stress testing...');

        $purposes = ['Clearance', 'Registrar Submission', 'Dean Office Meeting', 'Library Access', 'Shuttle Terminal', 'Department Event'];
        $offices  = ['Dean Office', 'Registrar Office', 'Accounting Room 102', 'College of Engineering', 'Main Gymnasium'];
        $statuses = ['checked_in', 'checked_out', 'pending'];
        
        $batch = [];
        $batchSize = 1000; // Chunk operations to prevent memory bottlenecks

        for ($i = 1; $i <= 5000; $i++) {
            $yearPrefix = rand(2023, 2026);
            $studentNumber = rand(10000, 99999);
            $status = $statuses[array_rand($statuses)];
            
            // 🏆 FIX: Never pass null to current_location to satisfy table constraints
            $currentLocation = $status !== 'pending' ? 'Main Gate' : 'Registration Desk';
            $checkedInTime   = $status !== 'pending' ? now()->subMinutes(rand(10, 240)) : null;
            
            $batch[] = [
                'full_name'        => 'Test Student #' . $i,
                'id_number'        => "{$yearPrefix}-{$studentNumber}",
                'contact_number'   => '09' . rand(100000000, 999999999),
                'purpose_of_visit' => $purposes[array_rand($purposes)],
                'person_to_visit'  => $offices[array_rand($offices)],
                'qr_code_token'    => Str::uuid()->toString(),
                'status'           => $status,
                'current_location' => $currentLocation, // 🏆 FIXED
                'checked_in_at'    => $checkedInTime,
                'checked_out_at'   => $status === 'checked_out' ? now() : null,
                'created_at'       => now()->subDays(rand(0, 7)),
                'updated_at'       => now(),
            ];

            // When chunk size matches, flash directly to the SQLite tables
            if ($i % $batchSize === 0) {
                DB::table('visitors')->insert($batch);
                $batch = []; // Clear current RAM stack allocation array
            }
        }

        $this->command->info('Stress-test successfully completed! 5,000 logs injected.');
    }
}
