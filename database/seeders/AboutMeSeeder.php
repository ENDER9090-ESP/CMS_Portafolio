<?php

namespace Database\Seeders;

use App\Models\AboutMe;
use Illuminate\Database\Seeder;

class AboutMeSeeder extends Seeder
{
    public function run()
    {
        AboutMe::create([
            'name' => 'Jose Antonio',
            'title' => 'Desarrollador Full Stack',
            'bio' => 'Apasionado desarrollador web con experiencia en tecnologías modernas.',
            'email' => 'joseantonio@gmail.com',
            'location' => 'México',
            'social_links' => [
                'github' => 'https://github.com/joseantonio',
                'linkedin' => 'https://linkedin.com/in/joseantonio'
            ]
        ]);
    }
}