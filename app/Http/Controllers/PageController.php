<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function testimonials(): View
    {
        return view('pages.testimonials', [
            'featuredTestimonials' => Testimonial::featured()->ordered()->get(),
            'regularTestimonials' => Testimonial::regular()->ordered()->get(),
        ]);
    }

    public function caseStudies(): View
    {
        $caseStudies = CaseStudy::ordered()->get();

        return view('pages.case-studies', [
            'caseStudies' => $caseStudies,
            'caseStudyCounts' => $caseStudies->countBy('category'),
            'categories' => CaseStudy::CATEGORIES,
        ]);
    }
}
