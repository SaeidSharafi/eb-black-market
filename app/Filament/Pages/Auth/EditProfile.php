<?php

namespace App\Filament\Pages\Auth;

use App\Filament\Pages\TextInput;
use App\Providers\Filament\DashboardPanelProvider;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfileAlias;

class EditProfile extends BaseEditProfileAlias
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\TextInput::make('telegram_username')
                    ->label('Telegram Username')
                    ->required()
                    ->maxLength(255)
                ,
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ])
            ;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['telegram_username'] = str_replace('@', '', $data['telegram_username']);
        return parent::mutateFormDataBeforeSave($data);
    }

    protected function getRedirectUrl(): ?string
    {
        return '/dashboard';
    }
}
