<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Product Name')
                    ->required()
                    ->maxLength(255),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->required(),

                Repeater::make('links')
                    ->relationship() // usa automaticamente Product::links()
                    ->label('Links')
                    ->schema([
                        TextInput::make('url')
                            ->required()
                            ->url(),

                        Select::make('type')
                            ->options([
                                'checkout' => 'Checkout',
                                'upsell'   => 'Upsell',
                                'downsell' => 'Downsell',
                            ])
                            ->required(),
                    ])
                    ->columns(2)
                    ->addActionLabel('Adicionar link'),
            ]);
    }
}
