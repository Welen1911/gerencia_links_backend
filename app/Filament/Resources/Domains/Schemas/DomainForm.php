<?php

namespace App\Filament\Resources\Domains\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DomainForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('api_key')
                    ->disabled(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
