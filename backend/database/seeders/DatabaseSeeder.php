<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Contact;
use App\Models\PhoneNumber;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $users = [
            [
                "name" => "Lucas Pires",
                "email" => "lucas@pires.dev.br",
                "password" => Hash::make("lucas")
            ],
            [
                "name" => "Caique Cohros",
                "email" => "caique@pires.dev.br",
                "password" => Hash::make("caique")
            ]

        ];       


        // GERANDO CONTATOS E NÚMEROS COM RESPECTIVOS RELACIONAMENTOS
        // foreach($users as $user)
        // {
        //     \App\Models\Contact::factory(10)
        //     ->has(\App\Models\PhoneNumber::factory(2),'PhoneNumbers')
        //     ->for(\App\Models\User::factory()->create($user))->create();
        // }

        
        // Gerando usuários DEFAULT para o sistema
        foreach($users as $user)
        {
            \App\Models\User::factory()->create($user);
        }

    
    }
}
