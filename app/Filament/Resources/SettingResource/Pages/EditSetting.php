<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Models\Setting;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    public function mount($record = null): void
    {
        $this->record = Setting::firstOrCreate(
            ['id' => 1],
            [
                'key' => 'site_settings',
                'value' => '{}',
            ]
        );
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return ['key' => 'site_settings', 'value' => json_encode($data)];
    }
}
