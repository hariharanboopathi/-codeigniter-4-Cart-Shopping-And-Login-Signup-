<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function add()
    {
        return view('product_view');
    }

    public function save()
    {
        $filename = $this->uploadFile('product_image', 'productimage');

        $this->productModel->insert([
            'product_name'  => $this->request->getPost('product_name'),
            'product_price' => $this->request->getPost('product_price'),
            'product_quantity' => $this->request->getPost('product_quantity'),
            'product_image' => $filename
        ]);

        return redirect()->back()->with('success', 'Product Added Successfully!');
    }

    public function edit($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) return redirect()->to('showtable')->with('error', 'Product not found!');
        return view('edit_view', ['product' => $product]);
    }

    public function  update($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) return redirect()->to('showtable')->with('error', 'Product not found!');

        $filename = $product['product_image'];
        $newFile = $this->uploadFile('product_image', 'productimage');
        if ($newFile) {
            if (!empty($filename) && file_exists('productimage/' . $filename)) unlink('productimage/' . $filename);
            $filename = $newFile;
        }

        $this->productModel->update($id, [
            'product_name' => $this->request->getPost('product_name'),
            'product_price' => $this->request->getPost('product_price'),
            'product_quantity' => $this->request->getPost('product_quantity'),
            'product_image' => $filename
        ]);

        return redirect()->to('showtable')->with('success', 'Product updated successfully!');
    }

    public function delete($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) return redirect()->to('showtable')->with('error', 'Product not found!');

        if (!empty($product['product_image']) && file_exists('productimage/' . $product['product_image'])) {
            unlink('productimage/' . $product['product_image']);
        }

        $this->productModel->delete($id);
        return redirect()->to('showtable')->with('success', 'Product deleted successfully!');
    }

   public function productPage()
{

    if (session()->get('isLoggedIn')) {
        return view('product_view', [
            'products' => $this->productModel->findAll()
        ]);
    } else {
        return redirect()->to(base_url('login'))
        ->with('error', 'Please login to access the product page.');
    }
}


    private function uploadFile($field, $folder)
    {
        $file = $this->request->getFile($field);
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $name = $file->getRandomName();
            $file->move($folder, $name);
            return $name;
        }
        return null;
    }
}
