<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Producto;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductoResource\RelationManagers;
use App\Filament\Resources\ProductoResource\RelationManagers\PricesRelationManager;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Entidades';
    protected static ?int $navigationSort = 0;

    protected static ?string $title = 'Productos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\Select::make('currency_id')
                ->relationship('currency', 'name')
                    ->required()
                    ->native(false)
                    ->createOptionForm(function ($form) {
                        return $form
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required(),
                                Forms\Components\TextInput::make('symbol')
                                    ->required(),
                                Forms\Components\TextInput::make('exchange_rate')
                                    ->required()
                                    ->numeric(),
                            ]);
                    })
                    ->default('1'),
                Forms\Components\TextInput::make('tax_cost')
                    ->required()
                    ->prefix('$')
                    ->numeric(),
                Forms\Components\TextInput::make('manufacturing_cost')
                    ->required()
                    ->prefix('$')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tax_cost')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('manufacturing_cost')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('currency_id')
                    ->label('Por Tipo de Divisa')
                    ->relationship('currency', 'name'),
                Tables\Filters\SelectFilter::make('price')
                    ->label('Por Precio')
                    ->options([
                        '0' => '0%',
                        '0.05' => '5%',
                        '0.1' => '10%',
                        '0.15' => '15%',
                        '0.2' => '20%',
                    ]),
                Tables\Filters\SelectFilter::make('tax_cost')
                    ->label('Por Impuesto')
                    ->options([
                        '0' => '0%',
                        '0.05' => '5%',
                        '0.1' => '10%',
                        '0.15' => '15%',
                        '0.2' => '20%',
                    ]),
                Tables\Filters\SelectFilter::make('manufacturing_cost')
                    ->label('Por Costo de Fabricación')
                    ->options([
                        '0' => '0%',
                        '0.05' => '5%',
                        '0.1' => '10%',
                        '0.15' => '15%',
                        '0.2' => '20%',
                    ]),
                ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PricesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}
