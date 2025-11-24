<?php

namespace App\Controllers;

use App\Models\ProductModel;

class CartController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function add($id)
    {
        $session = session();
        $product = $this->productModel->find($id);
        if (!$product) return redirect()->back()->with('error', 'Product not found');

        $cart = $session->get('cart') ?? [];
        $cart[$id] = $cart[$id] ?? [
            'id' => $product['id'],
            'name' => $product['product_name'],
            'price' => $product['product_price'],
            'qty' => 0,
            'image' => $product['product_image']
        ];
        $cart[$id]['qty'] += 1;

        $session->set('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function view()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        return view('cart_view', [
            'cartItems' => $cart,
            'cart_count' => array_sum(array_column($cart, 'qty'))
        ]);
    }

    public function remove($id)
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        unset($cart[$id]);
        $session->set('cart', $cart);
        return redirect()->back();
    }

    public function update($id)
    {
        $action = $this->request->getPost('action');
        $session = session();
        $cart = $session->get('cart') ?? [];

        if (isset($cart[$id])) {
            if ($action === 'increase') $cart[$id]['qty'] += 1;
            if ($action === 'decrease' && $cart[$id]['qty'] > 1) $cart[$id]['qty'] -= 1;
        }

        $session->set('cart', $cart);
        return redirect()->to(base_url('viewCart'));
    }
    
}
