<?php

namespace App\Filament\Dashboard\Resources\MyListingResource\Pages;

use App\Enum\ListingStatusEnum;
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

        if (data_get($data, 'status') === ListingStatusEnum::ACTIVE->value){
            $data['expired_notification_sent_at'] = null;
        }
        $data['user_id'] = auth()->id();
        return $data;
    }
}
