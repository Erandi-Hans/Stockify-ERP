<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Real-sounding Sri Lankan first & last names lists for realistic data
        $firstNames = ['Kamal', 'Nimal', 'Sunil', 'Chamara', 'Anura', 'Ruwan', 'Nuwan', 'Kasun', 'Pradeep', 'Saman', 'Erandi', 'Nayani', 'Sanduni', 'Kavindi', 'Dilini', 'Peshala', 'Madushani', 'Thilini', 'Chathurika', 'Udeshika'];
        $lastNames = ['Perera', 'Silva', 'Fernando', 'Bandara', 'Kumara', 'Rathnayake', 'Jayasinghe', 'Herath', 'Weerasinghe', 'Gunawardena', 'Dissanayake', 'Rajapaksha', 'Karunaratne', 'Ranasinghe', 'Abeywardena'];

        $cities = ['Colombo', 'Kandy', 'Galle', 'Gampaha', 'Kurunegala', 'Matara', 'Negombo', 'Anuradhapura', 'Ratnapura', 'Badulla'];

        for ($i = 1; $i <= 50; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $name = $firstName . ' ' . $lastName;
            $city = $cities[array_rand($cities)];

            Customer::create([
                'name' => $name,
                'email' => strtolower($firstName) . '.' . strtolower($lastName) . $i . '@gmail.com',
                'phone' => '07' . rand(0, 9) . rand(1000000, 9999999),
                'address' => 'No ' . rand(1, 150) . ', Main Street, ' . $city,
            ]);
        }
    }
}
