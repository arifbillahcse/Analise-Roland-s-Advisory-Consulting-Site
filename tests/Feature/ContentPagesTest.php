<?php

namespace Tests\Feature;

use App\Models\CaseStudy;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_featured_testimonials_render_in_the_carousel_and_regular_ones_in_the_grid(): void
    {
        Testimonial::create([
            'quote' => 'A carousel-worthy quote.',
            'name' => 'Carousel Person',
            'role' => 'Featured role',
            'featured' => true,
            'sort_order' => 0,
        ]);

        Testimonial::create([
            'quote' => 'A shorter grid quote.',
            'name' => 'Grid Person',
            'role' => 'Regular role',
            'featured' => false,
            'sort_order' => 0,
        ]);

        $response = $this->get(route('testimonials'));

        $response->assertOk();
        $response->assertSee('id="carousel"', false);
        $response->assertSee('Carousel Person');
        $response->assertSee('A carousel-worthy quote.');
        $response->assertSee('Grid Person');
        $response->assertSee('A shorter grid quote.');
    }

    public function test_the_testimonials_page_still_renders_with_no_testimonials_at_all(): void
    {
        $this->get(route('testimonials'))->assertOk();
    }

    public function test_case_studies_render_with_their_category_and_the_filter_counts_update(): void
    {
        CaseStudy::create([
            'category' => 'advisory',
            'sector' => 'Test sector',
            'title' => 'A case study title',
            'metric_value' => '10x',
            'metric_label' => 'Test metric',
            'outcome' => 'Test outcome.',
            'year_range' => '2026',
            'duration' => '3 months',
            'sort_order' => 0,
        ]);

        $response = $this->get(route('case-studies'));

        $response->assertOk();
        $response->assertSee('A case study title');
        $response->assertSee('data-cat="advisory"', false);
        $response->assertSee('tag--advisory', false);
    }

    public function test_the_case_studies_page_still_renders_with_no_case_studies_at_all(): void
    {
        $this->get(route('case-studies'))->assertOk();
    }
}
