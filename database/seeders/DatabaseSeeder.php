<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);

        if (Testimonial::count() === 0) {
            $this->call(TestimonialSeeder::class);
        }

        if (CaseStudy::count() === 0) {
            $this->call(CaseStudySeeder::class);
        }
    }
}
