<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <style>
        body {
            background-color: #f5f6f8;
            font-family: Arial, Helvetica, sans-serif;
        }

        .product-item {
            cursor: pointer;
        }

        .product-card {
            border: none;
            border-radius: 15px;
            transition: 0.2s;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.10);
        }

        .product-image {
            height: 130px;
            display: flex;
            justify-content: center;
        }

        .product-image img {
            object-fit: cover;
            width: 100%;
        }

        .price {
            color: #6f4e37;
            font-weight: bold;
        }

        .cart-box {
            position: sticky;
            top: 20px;
        }

        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 12px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            padding: 0;
            border-radius: 50%;
        }

        .total-price {
            font-size: 25px;
            font-weight: bold;
            color: #6f4e37;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .payment-card {
            transition: 0.2s;
        }

        .payment-card:hover {
            border-color: #6f4e37 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
    </style>
    <title>Kopi PPKD Jakarta Pusat</title>
</head>

<body>
    <div class="container-fluid">
        <main class="col-lg-12 p-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Point of Sales</h3>
                    <p class="text-muted">POS - Toko Kopi PPKD Jakarta Pusat</p>
                </div>
                <button class="btn btn-dark" onclick="emptyCart()">Empty Cart</button>
            </div>
            <div class="row g-5 mb-5">
                {{-- Card 1: Today's Transaction --}}
                <div class="col-md-4">
                    <div class="card shadow p-3">
                        <div class="d-flex align-items-center gap-3">
                            <div>
                                <i class="bi bi-cart" style="font-size: 2rem"></i>
                            </div>
                            <div>
                                <small class="text-muted">Today's Transaction</small>
                                <h4 class="mb-0 fw-bold">{{ $todayTransactions }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Today's Sales --}}
                <div class="col-md-4">
                    <div class="card shadow p-3">
                        <div class="d-flex align-items-center gap-3">
                            <div>
                                <i class="bi bi-cash-stack" style="font-size: 2rem"></i>
                            </div>
                            <div>
                                <small class="text-muted">Today's Sales</small>
                                <h4 class="mb-0 fw-bold">Rp. {{ number_format($todaySales, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Product Sold --}}
                <div class="col-md-4">
                    <div class="card shadow p-3">
                        <div class="d-flex align-items-center gap-3">
                            <div>
                                <i class="bi bi-box-seam" style="font-size: 2rem"></i>
                            </div>
                            <div>
                                <small class="text-muted">Product Sold</small>
                                <h4 class="mb-0 fw-bold">{{ $productSold }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-7">
                                    <h5 class="fw-bold">Select Product</h5>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" id="searchProduct" class="form-control"
                                        placeholder="Search Product..." onkeyup="searchProduct()">
                                </div>
                            </div>
                            <div class="mb-4">
                                <button class="btn btn-dark btn-sm me-1 category-btn active"
                                    onclick="filterCategory('all', this)">Semua</button>
                                @foreach ($categories as $category)
                                <button class="btn btn-outline-dark btn-sm me-1 category-btn"
                                    onclick="filterCategory('{{ $category->id }}', this)">{{ $category->category_name ?? '' }}</button>
                                @endforeach
                            </div>
                            <div class="row g-3" id="productList">
                                @foreach ($products as $product)
                                <div class="col-md-4 col-sm-6 product-item"
                                    data-category="{{ $product->category_id }}"
                                    onclick="addToCart('{{ $product->id }}')"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->product_name }}"
                                    data-price="{{ $product->product_price }}">
                                    <div class="card product-card shadow h-100">
                                        <div class="product-image">
                                            @if($product->product_photo)
                                            <img src="{{ asset('storage/' . $product->product_photo) }}" alt="{{ $product->product_name }}">
                                            @else
                                            <img src="https://via.placeholder.com/300x200?text=No+Image" alt="No Image">
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <span class="badge bg-light text-dark mb-2">
                                                {{ $product->product_description ?? '' }}
                                            </span>
                                            <h6 class="fw-bold">{{ $product->product_name ?? '' }}</h6>
                                            <span class="price">Rp. {{ number_format($product->product_price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-0 shadow cart-box p-3">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-cart"></i> Cart
                            </h5>
                            <span class="badge bg-dark" id="cartCount">0</span>
                        </div>
                        <div class="mb-3" id="cartItems">
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-cart4"></i>
                                <p>Cart Still Empty</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Sub Total</span>
                            <strong id="subtotal">Rp. 0</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pajak (10%)</span>
                            <strong id="tax">Rp. 0</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Total</span>
                            <span class="total-price" id="total">Rp. 0</span>
                        </div>
                        <button id="btnOpenPaymentModal" onclick="btnOpenModalPayment()" class="btn btn-success w-100 py-3">Payment</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Pembayaran -->
    <div class="modal fade" id="paymentMethod" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="paymentMethodLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="paymentMethodLabel">Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Customer Name</label>
                        <input type="text" id="customer_name" class="form-control" placeholder="Masukkan nama pelanggan...">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <strong class="bg-success p-2 text-white rounded d-inline-block" id="total-paid">Harga : Rp. 0</strong>
                        </div>
                    </div>
                    <div class="row only-cash d-none align-items-center my-3">
                        <div class="col-md-6">
                            <label for="cash_paid" class="form-label fw-bold">Pembayaran Cash :</label>
                            <input type="number" id="cash_paid" step="any" min="0" class="form-control mb-2" oninput="calculateChange()">
                        </div>
                        <div class="col-md-6">
                            <strong class="bg-primary p-2 text-white rounded d-inline-block" id="change-paid">Kembalian : Rp. 0</strong>
                        </div>
                    </div>

                    <h5 class="mb-3 fw-bold">Pilih Metode Pembayaran</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="w-100 cursor-pointer">
                                <input type="radio" name="payment_method" value="cash" class="d-none payment_option">
                                <div class="card p-3 shadow-sm border payment-card text-center h-100">
                                    <h4 class="text-success fw-bold"><i class="bi bi-cash-stack"></i> Cash</h4>
                                    <p class="text-muted small mb-0">Bayar Langsung di Kasir Secara Tunai.</p>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="w-100 cursor-pointer">
                                <input type="radio" name="payment_method" value="midtrans" class="d-none payment_option">
                                <div class="card p-3 shadow-sm border payment-card text-center h-100">
                                    <h4 class="text-primary fw-bold"><i class="bi bi-qr-code-scan"></i> Midtrans</h4>
                                    <p class="text-muted small mb-0">Pembayaran Online via QRIS/E-Wallet</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="processPayment()" class="btn btn-primary" id="btnPayNow">Pay Now</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script>
        let cart = [];
        let currentTotalWithTax = 0;
        let isProcessingPayment = false;

        document.querySelectorAll('.payment_option').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.payment-card').forEach(card => card.classList.remove(
                    'border-success', 'border-primary', 'bg-light'));
                if (this.checked) {
                    const card = this.nextElementSibling;
                    card.classList.add(this.value === 'cash' ? 'border-success' : 'border-primary', 'bg-light');
                }

                const onlyCashBox = document.querySelector('.only-cash');
                const cashInput = document.getElementById('cash_paid');
                if (this.value === 'cash') {
                    onlyCashBox.classList.remove('d-none');
                    if (cashInput) cashInput.focus();
                } else {
                    onlyCashBox.classList.add('d-none');
                    if (cashInput) cashInput.value = '';
                    document.getElementById('change-paid').innerText = 'Kembalian : Rp. 0';
                }
            });
        });

        function btnOpenModalPayment() {
            if (cart.length === 0) {
                alert('Cart is Empty');
                return;
            }
            const modalElement = document.getElementById('paymentMethod');
            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

            document.querySelectorAll('input[name="payment_method"]').forEach(el => el.checked = false);
            document.querySelectorAll('.payment-card').forEach(card => card.classList.remove('border-success', 'border-primary', 'bg-light'));
            document.querySelector('.only-cash').classList.add('d-none');

            const cashInput = document.getElementById('cash_paid');
            if (cashInput) cashInput.value = '';

            modal.show();
        }

        function filterCategory(categoryId, button) {
            const items = document.querySelectorAll('.product-item');
            items.forEach((product) => {
                const categoryName = product.dataset.category;
                if (categoryId === "all" || categoryName === String(categoryId)) {
                    product.style.display = "";
                } else {
                    product.style.display = "none";
                }
            });

            document.querySelectorAll('.category-btn').forEach((btn) => {
                btn.classList.remove('btn-dark', 'active');
                btn.classList.add('btn-outline-dark');
            });

            button.classList.remove('btn-outline-dark');
            button.classList.add('btn-dark', 'active');
        }

        function addToCart(productId) {
            const product = document.querySelector(`.product-item[data-id="${productId}"]`);
            if (!product) {
                alert('Product not found');
                return;
            }

            const productName = product.dataset.name;
            const productPrice = Number(product.dataset.price);

            const existingItem = cart.find((item) => Number(item.id) === Number(productId));

            if (existingItem) {
                existingItem.qty++;
            } else {
                cart.push({
                    id: Number(productId),
                    name: productName,
                    price: productPrice,
                    qty: 1
                });
            }

            displayCart();
        }

        function increaseQty(productId) {
            const item = cart.find((item) => Number(item.id) === Number(productId));
            if (item) item.qty++;
            displayCart();
        }

        function decreaseQty(productId) {
            const item = cart.find((item) => Number(item.id) === Number(productId));
            if (item) {
                item.qty--;
                if (item.qty <= 0) {
                    cart = cart.filter((i) => Number(i.id) !== Number(productId));
                }
            }
            displayCart();
        }

        function removeFromCart(productId) {
            cart = cart.filter((item) => Number(item.id) !== Number(productId));
            displayCart();
        }

        function emptyCart() {
            cart = [];
            displayCart();
        }


        function formatRupiah(number) {
            return new window.Intl.NumberFormat('id-ID').format(number);
        }


        function displayCart() {
            const cartItems = document.getElementById('cartItems');
            const cartCount = document.getElementById('cartCount');
            const subtotalEl = document.getElementById('subtotal');
            const taxEl = document.getElementById('tax');
            const totalEl = document.getElementById('total');
            const totalPaidEl = document.getElementById('total-paid');

            let itemCount = 0;
            let subtotal = 0;
            let html = '';

            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-cart4"></i>
                        <p>Cart Still Empty</p>
                    </div>
                `;
                subtotalEl.textContent = 'Rp. 0';
                taxEl.textContent = 'Rp. 0';
                totalEl.textContent = 'Rp. 0';
                cartCount.textContent = '0';
                totalPaidEl.innerText = 'Harga : Rp. 0';
                currentTotalWithTax = 0;
                return;
            }

            cart.forEach(function(item) {
                const lineTotal = Number(item.price) * Number(item.qty);
                subtotal += lineTotal;
                itemCount += Number(item.qty);

                html += `
                    <div class="cart-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>${item.name}</strong>
                                <div class="small text-muted">Rp. ${formatRupiah(item.price)}</div>
                            </div>
                            <strong>Rp. ${formatRupiah(lineTotal)}</strong>
                        </div>
                        <div class="d-flex align-items-center mt-2">
                            <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="increaseQty(${item.id})">+</button>
                            <span class="mx-2">${item.qty}</span>
                            <button type="button" class="btn btn-outline-secondary quantity-btn" onclick="decreaseQty(${item.id})">-</button>
                            <button type="button" class="btn btn-sm btn-outline-danger ms-auto" onclick="removeFromCart(${item.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
            });

            cartItems.innerHTML = html;

            const tax = subtotal * 0.10;
            currentTotalWithTax = subtotal + tax;

            subtotalEl.innerText = `Rp. ${formatRupiah(subtotal)}`;
            taxEl.innerText = `Rp. ${formatRupiah(tax)}`;
            totalEl.innerText = `Rp. ${formatRupiah(currentTotalWithTax)}`;
            totalPaidEl.innerText = `Harga : Rp. ${formatRupiah(currentTotalWithTax)}`;
            cartCount.innerText = itemCount;

            calculateChange();
        }

        function calculateChange() {
            const cashInput = document.getElementById('cash_paid');
            if (!cashInput) return;

            const cashPaidInput = parseFloat(cashInput.value) || 0;
            const changeMoney = cashPaidInput - currentTotalWithTax;
            const changeElement = document.getElementById('change-paid');

            if (changeMoney < 0) {
                changeElement.innerText = `Kurang Rp. ${formatRupiah(Math.abs(changeMoney))}`;
                changeElement.classList.add('bg-danger');
                changeElement.classList.remove('bg-primary');
            } else {
                changeElement.innerText = `Kembalian : Rp. ${formatRupiah(changeMoney)}`;
                changeElement.classList.add('bg-primary');
                changeElement.classList.remove('bg-danger');
            }
        }

        function searchProduct() {
            const search = document.getElementById('searchProduct').value.toLowerCase().trim();
            const products = document.querySelectorAll('.product-item');

            products.forEach(function(product) {
                const productName = product.dataset.name.toLowerCase();
                if (productName.includes(search)) {
                    product.style.display = "";
                } else {
                    product.style.display = "none";
                }
            });
        }

        async function processPayment() {
            if (isProcessingPayment) return;

            if (cart.length === 0) {
                alert('Cart is Empty');
                return;
            }

            const customerName = document.getElementById('customer_name').value;
            if (!customerName.trim()) {
                alert('Nama Customer wajib diisi!');
                return;
            }

            const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
            if (!selectedPayment) {
                alert('PILIH DAHULU METODE PEMBAYARAN');
                return;
            }

            const paymentMethod = selectedPayment.value;
            let changeMoney = 0;

            if (paymentMethod === 'cash') {
                const cashPayInput = document.getElementById('cash_paid');
                const cashPaidValue = parseFloat(cashPayInput?.value) || 0;

                if (!cashPaidValue || cashPaidValue < currentTotalWithTax) {
                    alert('Uang pembayaran cash kurang!');
                    if (cashPayInput) cashPayInput.focus();
                    return;
                }
                changeMoney = cashPaidValue - currentTotalWithTax;
            }

            isProcessingPayment = true;
            const payButton = document.getElementById('btnPayNow');
            if (payButton) {
                payButton.disabled = true;
                payButton.innerText = 'Processing...';
            }

            const payloadItems = cart.map(item => ({
                id: Number(item.id),
                qty: Number(item.qty)
            }));

            try {
                const response = await fetch("{{ route('order.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        items: payloadItems,
                        payment_method: paymentMethod,
                        customer_name: customerName,
                        order_change: changeMoney
                    })
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Terjadi Kesalahan Sistem');
                }

                // =========================
                // PEMBAYARAN CASH
                // =========================
                if (result.payment_method !== "midtrans") {
                    isProcessingPayment = false;
                    alert('Transaksi Cash Berhasil!');

                    // Format URL Cetak Struk
                    window.open(`/order/${result.order_id}/print`, '_blank');

                    cart = [];
                    location.reload();
                    return;
                }

                // =========================
                // PEMBAYARAN MIDTRANS
                // =========================
                if (!result.snap_token) {
                    throw new Error('Snap Token Midtrans tidak ditemukan.');
                }

                if (typeof window.snap === 'undefined' || typeof window.snap.pay !== 'function') {
                    throw new Error('Midtrans Snap belum berhasil dimuat.');
                }

                const modalElement = document.getElementById('paymentMethod');
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) {
                    modalInstance.hide();
                }

                await new Promise(resolve => setTimeout(resolve, 300));

                window.snap.pay(result.snap_token, {
                    onSuccess: function(snapResult) {
                        if (sessionStorage.getItem('midtrans_paid_' + result.order_id)) {
                            return;
                        }
                        sessionStorage.setItem('midtrans_paid_' + result.order_id, 'true');

                        isProcessingPayment = false;

                        window.open(`/order/${result.order_id}/print`, '_blank');

                        cart = [];
                        emptyCart();

                        setTimeout(function() {
                            alert('Pembayaran Midtrans Berhasil!');
                            window.location.assign("{{ route('order.create') }}");
                        }, 500);
                    },
                    onPending: function(snapResult) {
                        isProcessingPayment = false;
                        alert('Menunggu Pembayaran!');
                        location.reload();
                    },
                    onError: function(snapResult) {
                        isProcessingPayment = false;
                        if (payButton) {
                            payButton.disabled = false;
                            payButton.innerText = 'Pay Now';
                        }
                        alert('Pembayaran Gagal!');
                    },
                    onClose: function() {
                        isProcessingPayment = false;
                        if (payButton) {
                            payButton.disabled = false;
                            payButton.innerText = 'Pay Now';
                        }
                        alert('Popup pembayaran ditutup.');
                    }
                });
            } catch (error) {
                console.error('Payment Error:', error);
                isProcessingPayment = false;
                if (payButton) {
                    payButton.disabled = false;
                    payButton.innerText = 'Pay Now';
                }
                alert('Gagal Memproses Transaksi: ' + error.message);
            }
        }
    </script>
</body>

</html>
