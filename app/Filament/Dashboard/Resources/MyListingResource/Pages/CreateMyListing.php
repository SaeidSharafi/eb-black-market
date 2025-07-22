<?php

namespace App\Filament\Dashboard\Resources\MyListingResource\Pages;

use App\Filament\Dashboard\Resources\MyListingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMyListing extends CreateRecord
{
    protected static string $resource = MyListingResource::class;
    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
