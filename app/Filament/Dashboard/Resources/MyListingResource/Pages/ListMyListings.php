<?php

namespace App\Filament\Dashboard\Resources\MyListingResource\Pages;

use App\Filament\Dashboard\Resources\MyListingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMyListings extends ListRecords
{
    protected static string $resource = MyListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
