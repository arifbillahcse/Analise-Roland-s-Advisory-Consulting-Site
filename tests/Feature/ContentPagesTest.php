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

    public function test_the_carousel_is_omitted_when_nothing_is_featured(): void
    {
        Testimonial::create([
            'quote' => 'A shorter grid quote.',
            'name' => 'Grid Person',
            'role' => 'Regular role',
            'featured' => false,
            'sort_order' => 0,
        ]);

        $response = $this->get(route('testimonials'));

        $response->assertOk();
        $response->assertDontSee('id="carousel"', false);
        $response->assertSee('Grid Person');
    }

    public function test_the_quote_grid_heading_is_omitted_when_everything_is_featured(): void
    {
        Testimonial::create([
            'quote' => 'A carousel-worthy quote.',
            'name' => 'Carousel Person',
            'role' => 'Featured role',
            'featured' => true,
            'sort_order' => 0,
        ]);

        $response = $this->get(route('testimonials'));

        $response->assertOk();
        $response->assertSee('id="carousel"', false);
        // The heading must not sit above an empty grid.
        $response->assertDontSee('The shorter version.');
    }

    public function test_testimonials_render_in_sort_order(): void
    {
        foreach ([['Third', 2], ['First', 0], ['Second', 1]] as [$name, $order]) {
            Testimonial::create([
                'quote' => "Quote from {$name}.",
                'name' => $name,
                'role' => 'Role',
                'featured' => false,
                'sort_order' => $order,
            ]);
        }

        $body = $this->get(route('testimonials'))->assertOk()->getContent();

        $this->assertLessThan(strpos($body, 'Quote from Second.'), strpos($body, 'Quote from First.'));
        $this->assertLessThan(strpos($body, 'Quote from Third.'), strpos($body, 'Quote from Second.'));
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

    public function test_the_filter_counts_match_the_case_studies_in_each_category(): void
    {
        foreach (['advisory', 'advisory', 'project'] as $i => $category) {
            CaseStudy::create([
                'category' => $category,
                'sector' => 'Sector',
                'title' => "Study {$i}",
                'metric_value' => '1x',
                'metric_label' => 'Metric',
                'outcome' => 'Outcome.',
                'year_range' => '2026',
                'duration' => '1 month',
                'sort_order' => $i,
            ]);
        }

        $body = $this->get(route('case-studies'))->assertOk()->getContent();

        // "All" is 3, Advisory 2, Custom Project 1, Institutional 0.
        $this->assertStringContainsString('data-filter="all"', $body);
        $this->assertSame(1, substr_count($body, '<span class="filter__count">3</span>'));
        $this->assertSame(1, substr_count($body, '<span class="filter__count">2</span>'));
        $this->assertSame(1, substr_count($body, '<span class="filter__count">0</span>'));
    }
}
