<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CaseStudyResource\Pages;
use App\Models\CaseStudy;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CaseStudyResource extends Resource
{
    protected static ?string $model = CaseStudy::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Case Studies';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('category')
                ->options(CaseStudy::CATEGORIES)
                ->required(),
            TextInput::make('sector')
                ->required()
                ->maxLength(160)
                ->helperText('E.g. "Consumer fintech · Seed to Series A".'),
            TextInput::make('title')
                ->required()
                ->maxLength(160)
                ->columnSpanFull(),
            TextInput::make('metric_value')
                ->required()
                ->maxLength(40)
                ->helperText('E.g. "−38%" or "Unanimous".'),
            TextInput::make('metric_label')
                ->required()
                ->maxLength(80)
                ->helperText('E.g. "Average sales cycle".'),
            Textarea::make('outcome')
                ->required()
                ->rows(3)
                ->columnSpanFull(),
            TextInput::make('year_range')
                ->required()
                ->maxLength(20)
                ->helperText('E.g. "2025" or "2024–2025".'),
            TextInput::make('duration')
                ->required()
                ->maxLength(40)
                ->helperText('E.g. "9 months".'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('title')->searchable()->limit(50),
                TextColumn::make('sector')->searchable()->toggleable(),
                BadgeColumn::make('category')
                    ->formatStateUsing(fn (string $state): string => CaseStudy::CATEGORIES[$state] ?? $state),
                TextColumn::make('year_range')->label('Year'),
                TextColumn::make('duration'),
            ])
            ->filters([
                SelectFilter::make('category')->options(CaseStudy::CATEGORIES),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCaseStudies::route('/'),
            'create' => Pages\CreateCaseStudy::route('/create'),
            'edit' => Pages\EditCaseStudy::route('/{record}/edit'),
        ];
    }
}
