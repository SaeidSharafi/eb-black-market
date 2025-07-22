<?php

namespace App\Filament\Dashboard\Resources\MyListingResource\Pages;

use App\Filament\Dashboard\Resources\MyListingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMyListing extends EditRecord
{
    protected static string $resource = MyListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
