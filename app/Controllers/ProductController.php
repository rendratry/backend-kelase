<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ProductModel;


class ProductController extends BaseController {

    public function __construct(){
        $this->product = new ProductModel();
    }
    public function insertProduct(){
        $data = [
            'nama_product' => 'Semangka',
            'description' => 'Buah - buahan'
        ];

        $this->product->insertProductORM($data);
    }

    public function readProduct(){
        $products = $this->product->findAll();
        $data = [
            'products' => $products
        ];
        return view('product', $data);
    }
}