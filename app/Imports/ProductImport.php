<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $categoryName = trim($row['category'] ?? '');

        if (!empty($categoryName)) {
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['title' => $categoryName]
            );
            $categoryId = $category->id;
        } else {
            // fallback: assign to "Uncategorized" or skip product
            $uncategorized = Category::firstOrCreate(
                ['slug' => 'uncategorized'],
                ['title' => 'Uncategorized']
            );
            $categoryId = $uncategorized->id;
        }

        $title = $row['name'] ?? ($row['title'] ?? '');

        return Product::updateOrCreate(
            ['slug' => Str::slug($title ?: Str::random(6))],
            [
                'title'       => $title,
                'description' => $row['description'] ?? '',
                'price'       => $row['salepriceinctax'] ?? ($row['price'] ?? 0),
                'category_id' => $categoryId,
                'status'      => 1,
                'availability'=> 'in_stock',
                'is_b2b'      => 1,
            ]
        );
    }
}
