<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NRUS Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .product-card {
            transition: 0.3s;
        }
        .product-card:hover {
            transform: scale(1.03);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .price {
            font-weight: bold;
            color: #198754;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

@include('components.navbar')

<div class="container mt-5">

    <h2 class="mb-4 text-center">Products</h2>

    <!-- SEARCH & FILTER -->
    <form method="GET" class="row mb-4">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Search">
        </div>
        <div class="col-md-2">
            <input type="number" name="min_price" class="form-control" placeholder="Min price">
        </div>
        <div class="col-md-2">
            <input type="number" name="max_price" class="form-control" placeholder="Max price">
        </div>
        <div class="col-md-2">
            <input type="number" name="category_id" class="form-control" placeholder="Category ID">
        </div>
        <div class="col-md-2">
            <input type="number" name="brand_id" class="form-control" placeholder="Brand ID">
        </div>
        <div class="col-md-1">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <!-- PRODUCT GRID -->
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="price">${{ number_format($product->price, 2) }}</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <button class="btn btn-success w-100">Add to Cart</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- PAGINATION -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>

</div>

</body>
</html>