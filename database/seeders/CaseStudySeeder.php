<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use Illuminate\Database\Seeder;

class CaseStudySeeder extends Seeder
{
    /**
     * Seeds the same illustrative engagements the static site shipped with,
     * so the case studies page isn't empty on first migrate. Edit or
     * replace these from the admin panel — they're sample content, not
     * real client work.
     */
    public function run(): void
    {
        $rows = [
            [
                'category' => 'advisory',
                'sector' => 'Consumer fintech · Seed to Series A',
                'title' => 'From feature set to category position',
                'metric_value' => '−38%',
                'metric_label' => 'Average sales cycle',
                'outcome' => "Rebuilt the company’s positioning around a category it could credibly own, and gave the whole team one sentence they could all say the same way.",
                'year_range' => '2025',
                'duration' => '9 months',
            ],
            [
                'category' => 'project',
                'sector' => 'Real estate development · Ground-up mixed use',
                'title' => 'A development team, hired in eleven weeks',
                'metric_value' => 'On time',
                'metric_label' => 'Broke ground',
                'outcome' => 'Defined five roles, ran the search end to end, and handed over a team that broke ground on schedule.',
                'year_range' => '2025',
                'duration' => '11 weeks',
            ],
            [
                'category' => 'institutional',
                'sector' => 'University endowment · Venture allocation',
                'title' => 'A venture allocation the committee could defend',
                'metric_value' => 'Unanimous',
                'metric_label' => 'Committee approval',
                'outcome' => 'Turned an informal manager shortlist into a written selection framework the investment committee approved unanimously.',
                'year_range' => '2024',
                'duration' => '6 months',
            ],
            [
                'category' => 'advisory',
                'sector' => 'Climate hardware · Series A',
                'title' => 'A roadmap that matched the capital plan',
                'metric_value' => 'Zero',
                'metric_label' => 'Missed dates since',
                'outcome' => 'Cut the product roadmap down to what eighteen months of runway could actually ship — and the team stopped missing dates.',
                'year_range' => '2024–2025',
                'duration' => '12 months',
            ],
            [
                'category' => 'project',
                'sector' => 'DTC wellness · Retail expansion',
                'title' => 'Into retail without losing the brand',
                'metric_value' => '3 chains',
                'metric_label' => 'National retail',
                'outcome' => 'Built the wholesale playbook and packaging strategy that took the brand into national retail on its own terms.',
                'year_range' => '2024',
                'duration' => '4 months',
            ],
            [
                'category' => 'institutional',
                'sector' => 'Single-family office · First venture program',
                'title' => 'Standing up a first venture program',
                'metric_value' => 'First 6',
                'metric_label' => 'Direct investments',
                'outcome' => 'Designed the diligence process, pacing model, and reporting cadence for a family office making its first direct investments.',
                'year_range' => '2023–2024',
                'duration' => '8 months',
            ],
        ];

        foreach ($rows as $i => $row) {
            CaseStudy::create($row + ['sort_order' => $i]);
        }
    }
}
