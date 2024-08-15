<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use App\Models\Product;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProductResource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;


class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('products');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()->success()->title('Product created')->body('Product created successfully');
    }

}