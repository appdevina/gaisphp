<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with(['category','unit_type'])->orderBy('product')->get();
    }

    public function headings(): array
    {
        return [
            'nama barang',
            'kategori',
            'stok',
            'tipe unit',
            'harga',
            'deskripsi',
        ];
    }

    public function map($product) : array
    {
        return [
            $product->product,
            $product->category->category,
            $product->stock,
            $product->unit_type->unit_type,
            $product->price,
            $product->description,
        ];
    }
}
