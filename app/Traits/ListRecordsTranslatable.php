<?php

namespace App\Traits;

use Filament\Resources\Concerns\HasActiveLocaleSwitcher;

trait ListRecordsTranslatable
{
    use HasActiveLocaleSwitcher;

    public function mountTranslatable(): void
    {
        $this->activeLocale = static::getResource()::getDefaultTranslatableLocale();
    }

    public function getTranslatableLocales(): array
    {
        return static::getResource()::getTranslatableLocales();
    }

    public function getActiveTableLocale(): ?string
    {
        if ($this->activeLocale === static::getResource()::getDefaultTranslatableLocale()){
            return  app()->getLocale();
        }
        return $this->activeLocale;
    }
}
