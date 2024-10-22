<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the user with ID 1
        $user = User::find(1);

        // Check if the user exists before updating
        if ($user) {
            $user->update([
                'first_name' => 'Ahmad', // Example first name
                'last_name' => 'Bin Ali', // Example last name
                'phone' => '012-3456789', // Example phone number
                'birthdate' => '1990-05-20', // Example birthdate
                'gender' => 'Male', // Example gender
                'location1' => 'Kuala Lumpur', // Example location
                'location2' => 'Batu Caves', // Example location
                'suburb' => 'Gombak', // Example suburb
                'state' => 'Selangor', // Example state
                'job_status' => 1, // Example job status
                'position' => 'Software Developer', // Example position
                'work_email' => 'ahmad.ali@example.com', // Example work email
                'work_phone' => '03-12345678', // Example work phone
                'emergency_firstname' => 'Fatimah', // Example emergency contact name
                'emergency_relation' => 'Wife', // Example relationship
                'emergency_phone' => '012-9876543', // Example emergency phone
                'started_work' => '2022-01-01', // Example start date
                'home_lat' => '3.2465410699058705', // Example latitude
                'home_lng' => '101.42413574611773', // Example longitude
            ]);
        } else {
            // Optionally handle the case where the user does not exist
            echo "User with ID 1 not found.\n";
        }
    }
}
