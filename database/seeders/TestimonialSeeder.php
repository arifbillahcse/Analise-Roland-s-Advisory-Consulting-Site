<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Seeds the same illustrative quotes the static site shipped with, so
     * the testimonials page isn't empty on first migrate. Edit or replace
     * these from the admin panel — they're sample content, not real quotes.
     */
    public function run(): void
    {
        $featured = [
            [
                'quote' => "She made us say the hard thing out loud, then made us say it in one sentence. Six months later that sentence is our homepage. I'd worked with three other advisors before her and none of them got us there.",
                'name' => 'Founder & CEO',
                'role' => 'Consumer fintech · Seed to Series A',
            ],
            [
                'quote' => "We needed something the committee could actually approve, not a recommendation we'd have to defend line by line. Analise wrote the framework, sat through the questions, and it passed unanimously the first time.",
                'name' => 'Director of Investments',
                'role' => 'University endowment program',
            ],
            [
                'quote' => "I've hired a lot of people. Analise is the only one who told me which of my roles shouldn't exist before she started filling them. We broke ground on schedule because of it.",
                'name' => 'Managing Partner',
                'role' => 'Real estate development',
            ],
        ];

        $regular = [
            [
                'quote' => "The 72-hour rule sounds like a small thing until you're in the middle of something and someone actually answers.",
                'name' => 'Co-founder',
                'role' => 'Climate hardware · Series A',
            ],
            [
                'quote' => "She's the rare advisor who has actually run something. You can tell inside ten minutes, and it changes what you're willing to ask her.",
                'name' => 'Chief Executive',
                'role' => 'DTC wellness',
            ],
            [
                'quote' => 'Half of what I was paying for was the network. The other half was her telling me not to use it yet.',
                'name' => 'Founder',
                'role' => 'Marketplace startup',
            ],
            [
                'quote' => 'Our first venture program could have been an expensive education. She made it a process instead.',
                'name' => 'Principal',
                'role' => 'Single-family office',
            ],
            [
                'quote' => 'She is kind about people and ruthless about ideas. That combination is harder to find than it sounds.',
                'name' => 'Founder & CEO',
                'role' => 'B2B software',
            ],
            [
                'quote' => 'Six months in, our board meetings got boring. That was the whole goal.',
                'name' => 'Founder',
                'role' => 'Consumer fintech',
            ],
        ];

        foreach ($featured as $i => $row) {
            Testimonial::create($row + ['featured' => true, 'sort_order' => $i]);
        }

        foreach ($regular as $i => $row) {
            Testimonial::create($row + ['featured' => false, 'sort_order' => $i]);
        }
    }
}
