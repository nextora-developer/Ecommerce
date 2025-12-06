<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Images';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('path')
                    ->label('Image')
                    ->image()
                    ->directory('products') // 图片会存到 storage/app/public/products
                    ->required(),

                Forms\Components\TextInput::make('alt')
                    ->maxLength(255)
                    ->label('Alt Text')
                    ->nullable(),

                Forms\Components\Toggle::make('is_primary')
                    ->label('Primary')
                    ->default(false),

                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('path')
                    ->label('Path')
                    ->limit(40),

                Tables\Columns\TextColumn::make('alt')
                    ->label('Alt'),

                Tables\Columns\IconColumn::make('is_primary')
                    ->boolean()
                    ->label('Primary'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()
                    ->label('Order'),
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
