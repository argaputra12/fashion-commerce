<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Components\Tab;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Contracts\Support\Htmlable;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static string $resource = ProductResource::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::getDisplayNameFormField(),
                static::getGenderOptionsFormField(),
                static::getCategoryOptionsFormField(),
                static::getPriceFormField(),
                static::getStockFormField(),
                static::getIsActiveOptionsFormField(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('gender')->sortable(),
                TextColumn::make('category')->sortable(),
                TextColumn::make('display_name')->sortable(),
                TextColumn::make('price')->sortable(),
                TextColumn::make('stock')->sortable(),
                SelectColumn::make('is_active')->sortable()->options([
                    true => 'Active',
                    false => 'Inactive'
                ])->afterStateUpdated(function ($record, $state) {
                    Notification::make()
                        ->title("Data {$record->display_name} Updated")
                        ->success()->send();
                })
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string | Htmlable
    {
        return $record->display_name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['gender', 'category', 'display_name'];
    }

    public function getTabs(): array
    {
        return [
            'General' => Tab::make('General')->schema([
                Forms\Components\TextInput::make('gender')->required(),
                Forms\Components\TextInput::make('category')->required(),
                Forms\Components\TextInput::make('display_name')->required(),
                Forms\Components\TextInput::make('price')->required(),
                Forms\Components\TextInput::make('stock')->required(),
                Forms\Components\Toggle::make('is_active')->required(),
            ]),
        ];
    }


    public static function getDisplayNameFormField(): TextInput
    {
        return TextInput::make('display_name')->required();
    }

    public static function getGenderOptionsFormField(): Select
    {
        return Select::make('gender')
            ->options(static::getGenderOptions())
            ->label('Gender')
            ->required();
    }

    public static function getCategoryOptionsFormField(): Select
    {
        return Select::make('category')
            ->options(static::getCategoryOptions())
            ->label('Category')
            ->required();
    }

    public static function getPriceFormField(): TextInput
    {
        return TextInput::make('price')->required();
    }

    public static function getStockFormField(): TextInput
    {
        return TextInput::make('stock')->required();
    }

    public static function getIsActiveOptionsFormField(): Select
    {
        return Select::make('is_active')
            ->options(static::getIsActiveOptions())
            ->label('Is Active')
            ->required();
    }

    public static function getGenderOptions(): array
    {
        return [
            'Man' => 'Man',
            'Women' => 'Women',
            'Unisex' => 'Unisex',
        ];
    }

    public static function getCategoryOptions(): array
    {
        return [
            'Topwear' => 'Topwear',
            'Shoes' => 'Shoes',
            'Shoe Accessories' => 'Shoe Accessories',
            'Sandal' => 'Sandal',
            'Flip Flops' => 'Flip Flops',
            'Watches' => 'Watches',
            'Wallets' => 'Wallets',
            'Innerwear' => 'Innerwear',
            'Bags' => 'Bags',
            'Dress' => 'Dress',
        ];
    }

    public static function getIsActiveOptions(): array
    {
        return [
            true => 'Active',
            false => 'Inactive'
        ];
    }
}