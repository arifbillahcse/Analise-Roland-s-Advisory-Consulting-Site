<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Smoke coverage for the five marketing pages.
 *
 * These are deliberately shallow — they exist to catch the failure mode this
 * conversion introduces: a Blade view that throws at render time (a bad
 * @section, a route name that no longer exists) rather than showing up as a
 * broken link. A page that 500s should never reach a deploy.
 */
class PageTest extends TestCase
{
    /**
     * @return array<string, array{string, string}>
     */
    public static function pages(): array
    {
        return [
            'home' => ['/', 'Analise Roland — Strategic Advisory'],
            'services' => ['/services', 'Services — Analise Roland'],
            'case studies' => ['/case-studies', 'Case Studies — Analise Roland'],
            'testimonials' => ['/testimonials', 'Testimonials — Analise Roland'],
            'contact' => ['/contact', 'Contact — Analise Roland'],
        ];
    }

    #[DataProvider('pages')]
    public function test_page_renders_with_its_own_title(string $path, string $title): void
    {
        $this->get($path)
            ->assertOk()
            ->assertSee("<title>{$title}</title>", false);
    }

    #[DataProvider('pages')]
    public function test_page_includes_the_shared_chrome(string $path, string $title): void
    {
        $this->get($path)
            ->assertOk()
            ->assertSee('id="nav"', false)
            ->assertSee('id="waFloat"', false)
            ->assertSee('css/styles.css', false)
            ->assertSee('js/script.js', false);
    }

    public function test_nav_marks_only_the_current_page(): void
    {
        // Desktop nav and mobile drawer each render the marker once.
        $response = $this->get('/services');

        $response->assertOk();
        $this->assertSame(
            2,
            substr_count($response->getContent(), 'aria-current="page"'),
            'Expected the current page to be marked once in the nav and once in the mobile drawer.'
        );
    }

    public function test_every_nav_route_resolves(): void
    {
        foreach (array_keys(config('site.nav')) as $name) {
            $this->get(route($name))->assertOk();
        }
    }
}
