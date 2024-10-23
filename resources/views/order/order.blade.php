@extends('Backend.Layout.app')
@section('breadcrumb', 'Order')
@section('title', 'Staff')
@section('main-content')

<div class="container-fluid py-4">
    <div class="card-body">
        <div class="row mt-3">
            <div class="col-lg-12 mb-lg-0 mb-4 mx-auto">
                <div class="card z-index-2">
                    <div class="card-body p-2">

                        @include('message')
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Order Form Starts Here -->
                        <form action="{{ route('staff.add_order') }}" method="POST">
                            @csrf
                            <div class="row p-4">

                                <!-- Left Column: Order Information -->
                                <div class="col-md-6">
                                    <div class="card-header mb-2 p-2">
                                        <h3 class="card-title">Order Form</h3>
                                    </div>

                                    <div class="form-group">
                                        <label for="supplier_id">Supplier</label>
                                        <select class="form-control" name="supplier_id" required>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="staff_id">Staff</label>
                                        <input type="text" class="form-control" name="staff_id" value="{{ Auth::user()->name }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="orderDate">Order Date</label>
                                        <input type="date" class="form-control" id="orderDate" name="order_date" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Order Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="Pending">Pending</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Right Column: Order Items -->
                                <div class="col-md-6">
                                    <div class="card-header mb-2 p-2">
                                        <h3 class="card-title">Order Items</h3>
                                    </div>

                                    <div class="tab-content" id="orderItemsTabContent">
                                        <div class="order-items" id="orderItemsContainer">
                                            <div class="form-group">
                                                <label for="product">Product</label>
                                                <select class="form-control product-select" name="product_id[]" required onchange="updatePrice(this)">
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="quantity1">Quantity</label>
                                                <input type="number" class="form-control quantity" id="quantity1" name="quantity[]" oninput="calculateTotalPrice(1)" required min="1">
                                            </div>
                                            <div class="form-group">
                                                <label for="unitPrice1">Unit Price</label>
                                                <input type="number" step="0.01" class="form-control unit-price" id="unitPrice1" name="unit_price[]" oninput="calculateTotalPrice(1)" required readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="totalPrice1">Total Price</label>
                                                <input type="number" step="0.01" class="form-control total-price" id="totalPrice1" name="total_price[]" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Button to Add More Items -->
                                    <div class="text-center">
                                        <button type="button" class="btn btn-secondary" onclick="addOrderItem()">Add More Items</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row">
                                <div class="col-12 text-center mt-2">
                                    <button type="submit" class="btn btn-primary mt-4">Submit Order</button>
                                </div>
                            </div>
                        </form>
                        <!-- Order Form Ends Here -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    @include('components.footer')
</div>
<!-- end -->

@endsection

@push('custom-scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const productSelect = document.querySelectorAll('.product-select');
        productSelect.forEach(select => updatePrice(select));
    });

    function updatePrice(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        var unitPriceInput = selectElement.closest('.order-items').querySelector('.unit-price');
        unitPriceInput.value = price;
        calculateTotalPrice(1);
    }

    function calculateTotalPrice(index) {
        var quantity = document.getElementById('quantity' + index).value;
        var unitPrice = document.getElementById('unitPrice' + index).value;

        if (quantity && unitPrice) {
            var totalPrice = quantity * unitPrice;
            document.getElementById('totalPrice' + index).value = totalPrice.toFixed(2);
        } else {
            document.getElementById('totalPrice' + index).value = '';
        }
    }

    function addOrderItem() {
        var container = document.getElementById('orderItemsContainer');
        var itemCount = container.getElementsByClassName('order-items').length + 1;
        var index = itemCount + 1;

        var separator = '<hr class="my-4" style="border: 3px solid #007bff;">';

        var newItemHtml = `
            ${separator} <!-- Separator before new item -->
            <div class="order-items">
                <div class="form-group">
                    <label for="product">Product ${index}</label> <!-- Incrementing product label -->
                    <select class="form-control product-select" name="product_id[]" required onchange="updatePrice(this)">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity${index}">Quantity</label>
                    <input type="number" class="form-control quantity" id="quantity${index}" name="quantity[]" oninput="calculateTotalPrice(${index})" required min="1">
                </div>
                <div class="form-group">
                    <label for="unitPrice${index}">Unit Price</label>
                    <input type="number" step="0.01" class="form-control unit-price" id="unitPrice${index}" name="unit_price[]" oninput="calculateTotalPrice(${index})" required readonly>
                </div>
                <div class="form-group">
                    <label for="totalPrice${index}">Total Price</label>
                    <input type="number" step="0.01" class="form-control total-price" id="totalPrice${index}" name="total_price[]" readonly>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newItemHtml);
    }

</script>
@endpush
