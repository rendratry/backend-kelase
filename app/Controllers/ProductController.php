<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;

class ProductController extends BaseController {
    use ResponseTrait;
    public function __construct(){
        $this->product = new ProductModel();
    }
    public function insertProduct(){
        $data = [
            'nama_product' => 'Semangka',
            'description' => 'Buah - buahan',
        ];
        $this->product->insertProductORM($data);
    }

    public function insertProductApi(){
        $resquestData = $this->request->getJSON();
        $validation = $this->validate([
            'nama_product' => 'required',
            'description' => 'required',
        ]);
        if(!$validation){
            $this->response->setStatusCode(400);
            return $this->response->setJSON([
                'code' => 400,
                'status' => 'BAD REQUEST',
                'data' => 'semua harus terisi'
            ]);
        }
        $data = [
            'nama_product' => $resquestData->nama_product,
            'description' => $resquestData->description,
        ];
        $insert = $this->product->insertProductORM($data);
        if ($insert) {
            return $this->respond([
                'code' => 200,
                'status' => 'OK',
                'data' => $data
            ]);
        } else {
            $this->response->setStatusCode(500);
            return $this->response->setJSON([
                'code' => 500,
                'status' => 'INTERNAL SERVER ERROR',
                'data' => null
            ]);
        }
    }

    public function readProduct(){
        $products = $this->product->findAll();
        $data = [
            'products' => $products
        ];
        return view('product', $data);
    }

    // Restful API
    public function readProductApi(){
        $products = $this->product->findAll();
        return $this->respond([
            'code' => 200,
            'status' => 'OK',
            'data' => $products
        ]);
    }

    public function getProduct($id){
        $product = $this->product->where('id',$id)->first();
        $data = [
            'product' => $product
        ];
        return view('edit_product', $data);
    }

    public function getProductApi($id){
        $product = $this->product->where('id',$id)->first();
        if (!$product) {
            $this->response->setStatusCode(404);
            return $this->response->setJSON([
                'code' => 404,
                'status' => 'NOT FOUND',
                'data' => 'data tidak ditemukan'
            ]);
        }

        return $this->respond([
            'code' => 200,
            'status' => 'OK',
            'data' => $product
        ]);

    }

    public function updateProduct($id){
        $nama_product = $this->request->getVar('nama_product');
        $description = $this->request->getVar('description');

        $data = [
            'nama_product' => $nama_product,
            'description' => $description
        ];
        $this->product->update($id, $data);
        return redirect()->to(base_url('products'));
    }

    public function deleteProduct($id){
        $this->product->delete($id);
        return redirect()->to(base_url('products'));
    }
}