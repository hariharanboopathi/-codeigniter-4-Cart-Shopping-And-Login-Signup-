<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'productpage';
    protected $primaryKey = 'id';
    protected $allowedFields = ['`product_price`', 'product_image', 'product_name','product_quantity'];
    
    protected $useTimestamps = false; 
}
