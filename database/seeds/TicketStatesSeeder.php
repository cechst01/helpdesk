<?php

use Illuminate\Database\Seeder;

class TicketStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ticket_states')->insert([
            ['name' => 'Nový'],
            ['name' => 'Ke zpracování'],
            ['name' => 'Zamítnuto'],
            ['name' => 'Reklamace'],
            ['name' => 'Zpracovává se'],
            ['name' => 'Schválení rozpočtu'],
            ['name' => 'Rozpočet zamítnut'],
            ['name' => 'Rozpočet schválen'],
            ['name' => 'Kontrola zákazníkem'],
            ['name' => 'Připomínka'],
            ['name' => 'Vyřízeno'],
            ['name' => 'Smazáno']
        ]);
    }
}
