<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Order Items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product_name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('variant_name')
                    ->maxLength(255)
                    ->nullable(),

                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('unit_price')
                    ->numeric()
                    ->prefix('RM')
                    ->required(),

                Forms\Components\TextInput::make('line_total')
                    ->numeric()
                    ->prefix('RM')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('variant_name')
                    ->label('Variant'),

                Tables\Columns\TextColumn::make('quantity'),

                Tables\Columns\TextColumn::make('unit_price')
                    ->money('myr'),

                Tables\Columns\TextColumn::make('line_total')
                    ->money('myr'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
