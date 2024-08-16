<?php

namespace App\Filament\Resources\OrderProductResource\Pages;

use Filament\Actions;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\OrderProductResource;

class CreateOrderProduct extends CreateRecord
{
    protected static string $resource = OrderProductResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('order-products');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Order product created')
            ->body('Your order product has been created.');
    }
    
}