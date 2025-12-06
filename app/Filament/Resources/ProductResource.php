<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\VariantsRelationManager;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $navigationGroup = 'Catalog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Info')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('slug', \Str::slug($state));
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('RM')
                            ->label('Base Price')
                            ->nullable(),

                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->label('Active'),
                    ])->columns(2),

                Forms\Components\Section::make('Descriptions')
                    ->schema([
                        Forms\Components\Textarea::make('short_description')
                            ->rows(2),

                        Forms\Components\RichEditor::make('description')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Variants')
                    ->description('Add product variants such as size / color, with their own price and stock.')
                    ->schema([
                        Repeater::make('variants')
                            ->relationship()   // 使用 product->variants 关系
                            ->schema([
                                TextInput::make('name')
                                    ->label('Variant name')
                                    ->required(),

                                TextInput::make('sku')
                                    ->label('SKU')
                                    ->maxLength(255),

                                TextInput::make('price')
                                    ->numeric()
                                    ->prefix('RM')
                                    ->nullable(),

                                TextInput::make('stock')
                                    ->numeric()
                                    ->default(0),

                                Toggle::make('is_default')
                                    ->label('Default')
                                    ->default(false),
                            ])
                            ->columns(3)
                            ->defaultItems(0)
                            ->itemLabel(
                                fn(array $state): ?string =>
                                $state['name'] ?? 'New variant'
                            )
                            ->collapsed(), // 初始收起来一点干净
                    ]),

                Forms\Components\Section::make('Images')
                    ->description('Upload product images. One image can be marked as primary.')
                    ->schema([
                        Repeater::make('images')
                            ->relationship()
                            ->schema([
                                FileUpload::make('path')
                                    ->disk('public')
                                    ->label('Image')
                                    ->fetchFileInformation(false)
                                    ->image()
                                    ->directory('products')
                                    ->required(),

                                TextInput::make('alt')
                                    ->label('Alt text')
                                    ->maxLength(255)
                                    ->nullable(),

                                Toggle::make('is_primary')
                                    ->label('Primary')
                                    ->default(false),

                                TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columns(2)
                            ->defaultItems(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->money('myr')
                    ->label('Base Price')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
