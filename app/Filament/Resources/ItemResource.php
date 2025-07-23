<?php

namespace App\Filament\Resources;

use App\Enum\ItemTypeEnum;
use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class ItemResource extends Resource
{
    use Translatable;
    protected static ?string $model = Item::class;
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('resources.items.fields.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label(__('resources.items.fields.type'))
                    ->options(ItemTypeEnum::getKeyValuePairs())
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->label(__('resources.items.fields.image')),
                Forms\Components\Textarea::make('description')
                    ->label(__('resources.items.fields.description'))
                    ->nullable()
                    ->maxLength(500),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('resources.items.fields.image'))
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('resources.items.fields.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('resources.items.fields.type'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('resources.items.fields.description'))
                    ->limit(50)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('resources.items.fields.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('resources.items.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources.items.plural_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources.items.navigation');
    }

    public static function getLabel(): string
    {
        return __('resources.items.label');
    }

    public static function getPluralLabel(): string
    {
        return __('resources.items.plural_label');
    }
}
