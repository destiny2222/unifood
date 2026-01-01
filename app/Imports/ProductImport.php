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

        return new Product([
            'title'       => $row['title'] ?? '',
            'description' => $row['description'] ?? '',
            'price'       => $row['price'] ?? 0,
            'category_id' => $categoryId,
            'slug'        => Str::slug($row['title'] ?? Str::random(6)),
            'status'      => 1,
            'availability'=> 'in_stock',
        ]);
    }
}
