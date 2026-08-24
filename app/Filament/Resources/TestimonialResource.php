<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Testimonials';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(120),
            TextInput::make('role')
                ->required()
                ->maxLength(160)
                ->helperText('E.g. "Founder & CEO — Consumer fintech · Seed to Series A".'),
            Textarea::make('quote')
                ->required()
                ->rows(4)
                ->columnSpanFull(),
            Toggle::make('featured')
                ->label('Show in the featured carousel')
                ->helperText('Off shows it in the quote grid below instead.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('role')->searchable(),
                TextColumn::make('quote')->limit(60)->wrap(),
                IconColumn::make('featured')->boolean()->label('In carousel'),
            ])
            ->filters([
                TernaryFilter::make('featured')
                    ->label('Carousel')
                    ->placeholder('All testimonials')
                    ->trueLabel('In the carousel')
                    ->falseLabel('In the quote grid'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
