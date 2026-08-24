<?php

namespace App\Filament\Resources\CaseStudyResource\Pages;

use App\Filament\Resources\CaseStudyResource;
use App\Models\CaseStudy;
use Filament\Resources\Pages\CreateRecord;

class CreateCaseStudy extends CreateRecord
{
    protected static string $resource = CaseStudyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['sort_order'] = (CaseStudy::max('sort_order') ?? -1) + 1;

        return $data;
    }
}
