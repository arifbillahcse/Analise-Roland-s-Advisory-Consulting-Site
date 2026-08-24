<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Leads';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->disabled(),
            TextInput::make('email')->disabled(),
            TextInput::make('company')->disabled(),
            TextInput::make('source')->disabled(),
            Textarea::make('message')
                ->disabled()
                ->rows(6)
                ->columnSpanFull(),
            Select::make('status')
                ->options([
                    Lead::STATUS_NEW => 'New',
                    Lead::STATUS_CONTACTED => 'Contacted',
                    Lead::STATUS_ARCHIVED => 'Archived',
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('company')->searchable()->toggleable(),
                TextColumn::make('message')->limit(60)->wrap(),
                TextColumn::make('source')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        Lead::STATUS_CONTACTED => 'success',
                        Lead::STATUS_ARCHIVED => 'gray',
                        default => 'warning',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    Lead::STATUS_NEW => 'New',
                    Lead::STATUS_CONTACTED => 'Contacted',
                    Lead::STATUS_ARCHIVED => 'Archived',
                ]),
                SelectFilter::make('source')->options([
                    'home' => 'Home',
                    'contact' => 'Contact',
                ]),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
