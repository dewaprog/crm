<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class CompanySeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 5; $i++) {
            $data = [
                'company_name' => $faker->company,
                'created_at'    => Time::createFromTimestamp($faker->unixTime),
                'updated_at'    => Time::createFromTimestamp($faker->unixTime),
                'user_id' => 1,
            ];

            // Simple Queries
            // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);
            // Using Query Builder
            $this->db->table('company')->insert($data);
        }
    }
}
