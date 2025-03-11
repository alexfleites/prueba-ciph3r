<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ProductoResource;
use Filament\Tables;
use App\Models\Producto;
use Filament\Actions\Action;
use Filament\Tables\Table;
use Filament\Tables\Actions;
use Filament\Tables\Actions\ViewAction;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestProducts extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Producto::query()
                    ->latest()
                    ->limit(5)
            )
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
            ])->headerActions([
                Tables\Actions\Action::make('view')
                    ->label('Crear tu primer Producto')
                    ->visible(fn () => Producto::count() == 0)
                    ->url(ProductoResource::getUrl('create'))
            ]);
    }
}
