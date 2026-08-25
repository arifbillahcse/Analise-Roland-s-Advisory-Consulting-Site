<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            // Machine key used for the page's filter buttons (data-filter /
            // data-cat) — keep in sync with CaseStudy::CATEGORIES.
            $table->string('category');
            $table->string('sector');
            $table->string('title');
            $table->string('metric_value');
            $table->string('metric_label');
            $table->text('outcome');
            $table->string('year_range');
            $table->string('duration');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['category', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_studies');
    }
};
