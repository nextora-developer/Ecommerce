<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    protected static ?string $title = 'Variants';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('sku')
                    ->maxLength(255),

                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('RM')
                    ->nullable(),

                Forms\Components\TextInput::make('stock')
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('is_default')
                    ->label('Default Variant')
                    ->default(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('sku')
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->money('myr')
                    ->nullable(),

                Tables\Columns\TextColumn::make('stock')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_default')
                    ->boolean()
                    ->label('Default'),
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
