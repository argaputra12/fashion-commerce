<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ProductResource;
use Filament\Forms\Components\Wizard\Step;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Product updated')
            ->body('The product has been saved successfully.');
    }

    protected function getSteps(): array
    {
        return [
            Step::make('Gender')
                ->description('Select gender')
                ->schema([
                    static::getGenderOptions()
                ]),

            Step::make('Category')
                ->description('Select category')
                ->schema([
                    static::getCategoryOptions()
                ]),
        ];
    }
}