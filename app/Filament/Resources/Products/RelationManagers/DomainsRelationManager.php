<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Filament\Resources\Products\ProductResource;
use App\Models\Domain;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DomainsRelationManager extends RelationManager
{
    protected static string $relationship = 'Domains';

    protected static ?string $relatedResource = ProductResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('checkout_url')
                ->label('Checkout URL')
                ->required()
                ->url(),

            Toggle::make('is_active')
                ->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Domain'),

                TextColumn::make('pivot.checkout_url')
                    ->label('Checkout'),

                IconColumn::make('pivot.is_active')
                    ->boolean(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->form([
                        Select::make('recordId')
                            ->label('Domain')
                            ->options(
                                Domain::query()->pluck('name', 'id')
                            )
                            ->required(),

                        TextInput::make('checkout_url')
                            ->required()
                            ->url(),

                        Toggle::make('is_active')
                            ->default(true),
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DetachAction::make(),
            ]);
    }
}
