<?php

namespace Database\Seeders;

use App\Models\Clients;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Clients::factory()
            ->count(50)
            ->hasAppointments(1)
            ->create();

        Clients::factory()
            ->count(25)
            ->hasAppointment(2)
            ->create();

        Clients::factory()
            ->count(10)
            ->hasAppointment(5)
            ->create();

        Clients::factory()
            ->count(5)
            ->hasAppointment(0)
            ->create();
    }
}
