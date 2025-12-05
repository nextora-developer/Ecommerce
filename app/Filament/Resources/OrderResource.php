<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\ItemsRelationManager;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $navigationGroup = 'Sales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Info')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->disabled()
                            ->dehydrated(false), // 订单编号通常自动生成

                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Customer')
                            ->nullable(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'processing' => 'Processing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),

                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'unpaid' => 'Unpaid',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                                'refunded' => 'Refunded',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('payment_method')
                            ->maxLength(255)
                            ->nullable(),

                        Forms\Components\TextInput::make('payment_reference')
                            ->maxLength(255)
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Customer & Shipping')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->required(),

                        Forms\Components\TextInput::make('customer_email')
                            ->email()
                            ->required(),

                        Forms\Components\TextInput::make('customer_phone')
                            ->nullable(),

                        Forms\Components\TextInput::make('shipping_address_line1')
                            ->label('Address Line 1'),

                        Forms\Components\TextInput::make('shipping_address_line2')
                            ->label('Address Line 2'),

                        Forms\Components\TextInput::make('shipping_city'),
                        Forms\Components\TextInput::make('shipping_state'),
                        Forms\Components\TextInput::make('shipping_postcode'),
                        Forms\Components\TextInput::make('shipping_country'),
                    ])->columns(2),

                Forms\Components\Section::make('Amount')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->prefix('RM'),

                        Forms\Components\TextInput::make('shipping_fee')
                            ->numeric()
                            ->prefix('RM'),

                        Forms\Components\TextInput::make('discount_amount')
                            ->numeric()
                            ->prefix('RM'),

                        Forms\Components\TextInput::make('total')
                            ->numeric()
                            ->prefix('RM')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer_email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('total')
                    ->money('myr')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'completed',
                        'info' => 'processing',
                        'danger' => 'cancelled',
                    ]),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->colors([
                        'secondary' => 'unpaid',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'warning' => 'refunded',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
