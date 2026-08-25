<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?int $navigationSort = 99;

    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Contact Information')
                ->schema([
                    TextInput::make('phone')
                        ->label('Phone Number')
                        ->helperText('Format: +X XXXXX XXXXXX (e.g., +880 1779 440297)')
                        ->default(fn () => Setting::get('phone', '+8801779440297'))
                        ->required(),
                    TextInput::make('whatsapp')
                        ->label('WhatsApp Number')
                        ->helperText('International format, digits only. No +, spaces, or dashes (e.g., 15550000000)')
                        ->default(fn () => Setting::get('whatsapp', '15550000000'))
                        ->required(),
                    TextInput::make('email')
                        ->label('Email Address')
                        ->email()
                        ->default(fn () => Setting::get('email', 'hello@analiseroland.com'))
                        ->required(),
                    TextInput::make('city_state')
                        ->label('City, State')
                        ->helperText('Location displayed in footer and contact page')
                        ->default(fn () => Setting::get('city_state', '[City, State]'))
                        ->required(),
                ])
                ->columns(2),

            Section::make('Site Information')
                ->schema([
                    TextInput::make('site_name')
                        ->label('Site Name')
                        ->default(fn () => Setting::get('site_name', 'Analise Roland'))
                        ->required(),
                ])
                ->columns(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('value')
                    ->limit(60)
                    ->wrap(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
