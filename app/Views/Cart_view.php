<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f2f4f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .cart-header {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .popup-content {
            width: 300px;
            margin: 10% auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
        }

        .close {
            float: right;
            cursor: pointer;
            font-size: 20px;
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-summary {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .remove-btn:hover {
            opacity: 0.85;
        }

        .checkout-btn {
            background: #28a745;
            color: #fff;
        }

        .checkout-btn:hover {
            background: #218838;
        }

        .empty-cart {
            text-align: center;
            font-size: 1.2rem;
            color: #6c757d;
            margin-top: 50px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 8px;
        }

        .quantity-controls button {
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
        }

        .quantity-display {
            width: 40px;
            text-align: center;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 2px 0;
        }
    </style>
</head>

<body>
    <?= $this->include('navbar') ?>

    <div class="container mt-5">
        <h2 class="cart-header text-center">🛒 Your Shopping Cart</h2>

        <?php if (empty($cartItems)): ?>
            <p class="empty-cart">Your cart is empty! <a href="<?= base_url('productpage') ?>">Go to Products</a></p>
        <?php else: ?>
            <div class="row g-4">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <?php $total = 0; ?>
                    <?php foreach ($cartItems as $item): ?>
                        <?php $subtotal = $item['price'] * $item['qty']; ?>
                        <?php $total += $subtotal; ?>
                        <div class="card mb-3">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('productimage/' . $item['image']) ?>" class="item-image me-3">
                                    <div>
                                        <h5><?= esc($item['name']) ?></h5>
                                        <p class="mb-0 text-muted">
                                            $<?= number_format($item['price'], 2) ?> × <?= $item['qty'] ?> = <strong>$<?= number_format($subtotal, 2) ?></strong>
                                        </p>
                                        <div class="quantity-controls">
                                            <form action="<?= base_url('updateCart/' . $item['id']) ?>" method="post" class="d-flex align-items-center gap-1">
                                                <button type="submit" name="action" value="decrease" class="btn btn-outline-secondary btn-sm"><i class="bi bi-dash"></i></button>
                                                <div class="quantity-display"><?= $item['qty'] ?></div>
                                                <button type="submit" name="action" value="increase" class="btn btn-outline-secondary btn-sm"><i class="bi bi-plus"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= base_url('removeFromCart/' . $item['id']) ?>" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Remove
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>


                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h4 class="mb-3">Cart Summary</h4>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Items
                                <span class="badge bg-primary rounded-pill"><?= array_sum(array_column($cartItems, 'qty')) ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Price
                                <strong>$<?= number_format($total, 2) ?></strong>
                            </li>
                        </ul>
                        <a href="<?= base_url('login') ?>" id="ShowLogin" class="btn w-100 checkout-btn">Proceed to Checkout</a>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>