<?php

namespace App\Filament\Widgets;

use App\Models\Producto;
use Filament\Widgets\ChartWidget;

class ProductsChart21 extends ChartWidget
{
    protected static ?string $heading = 'Products Chart';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Productos',
                    'data' => array_values($this->getProducts()),
                    'backgroundColor' => '#3182ce',
                    'borderColor' => '#3182ce',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function getProducts()
    {
        return Producto::query()
            ->select(\DB::raw('count(id) as count, substr(created_at, 4, 2) as month'))
            ->whereYear('created_at', date('Y'))
            ->groupBy(\DB::raw('month(created_at)'))
            ->pluck('count', 'month')
            ->toArray();
        }
}
