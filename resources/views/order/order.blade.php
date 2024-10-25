@extends('Backend.Layout.app')
@section('breadcrumb', 'Order')
@section('title', 'Staff')
@section('main-content')

<head>
    <<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>    
</head>

<style>
    .nav-tabs {
        border-bottom: 2px solid #e0e0e0;
    }

    .nav-tabs .nav-item .nav-link {
        border: none;
        margin-right: 3px;
        color: #333;
        transition: background-color 0.3s, color 0.3s;
        border-radius: 10px 10px 0 0;
    }

    .nav-tabs .nav-item:first-child .nav-link {
        border-radius: 10px 10px 0 0;
    }

    .nav-tabs .nav-item .nav-link.active {
        background-color: #007bff;
        color: #fff;
        border-radius: 10px 10px 0 0;
    }

    .nav-tabs .nav-item .nav-link:hover {
        background-color: grey;
        color: #fff;
        border-radius: 10px 10px 0 0;
    }

    .nav-tabs .nav-item .nav-link.active:hover {
        background-color: #007bff;
        color: #fff;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .form-control:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: none;
    }

    .nav-tabs .nav-item {
        position: relative;
    }

    .nav-tabs .nav-item .close-btn {
        position: absolute;
        right: 10px;
        top: 5px;
        background-color: transparent;
        border: none;
        font-size: 12px;
        color: white;
        cursor: pointer;
        outline: none;
    }

    .nav-tabs .nav-item .close-btn:hover {
        color: #ff0000;
    }

    .nav-tabs .nav-item .nav-link {
        padding-right: 25px;
    }
</style>



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

                                    <div class="form-group" style="margin-bottom: 15px; margin-top: 51px;">
                                        <select class="form-control" name="supplier_id" id="supplierSelect" required onchange="checkQuantity()">
                                            <option value="" disabled selected hidden style="color: lightgray;">Select Supplier</option>
                                            @if($suppliers->isEmpty())
                                                <option value="" disabled>No suppliers available</option>
                                            @else
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <input type="hidden" name="staff_id" value="{{ Auth::id() }}">
                                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly placeholder="Staff">
                                    </div>

                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <input type="date" class="form-control" id="orderDate" name="order_date" required placeholder="Order Date">
                                    </div>

                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <input type="text" class="form-control" value="Pending" readonly placeholder="Status">
                                        <input type="hidden" name="status" value="Pending">
                                    </div>
                                </div>

                                <!-- Right Column: Order Items with Tabs -->
                                <div class="col-md-6">
                                    <div class="card-header mb-2 p-2">
                                        <h3 class="card-title">Order Items</h3>
                                    </div>

                                    <!-- Tabs for Order Items -->
                                    <ul class="nav nav-tabs" id="orderItemsTabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="item1-tab" data-toggle="tab" href="#item1" role="tab" aria-controls="item1" aria-selected="true">
                                                New Item
                                                <button type="button" class="close-btn" onclick="removeTab(1)">&times;</button>
                                            </a>
                                        </li>
                                    </ul>                                    

                                    <div class="tab-content" id="orderItemsTabContent">
                                        <div class="tab-pane fade show active order-items" id="item1" role="tabpanel" aria-labelledby="item1-tab">
                                            <div class="form-group" style="margin-bottom: 15px;">
                                                <select class="form-control product-select" name="product_id[]" required onchange="updatePrice(this)">
                                                    <option value="" disabled selected hidden style="color: lightgray;">Select Product</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group" style="margin-bottom: 15px;">
                                                <input type="number" class="form-control quantity" id="quantity1" name="quantity[]" oninput="calculateTotalPrice(1); checkQuantity()" required min="1" placeholder="Quantity">
                                            </div>
                                            <div class="form-group" style="margin-bottom: 15px;">
                                                <input type="number" step="0.01" class="form-control unit-price" id="unitPrice1" name="unit_price[]" oninput="calculateTotalPrice(1)" required readonly placeholder="Unit Price">
                                            </div>
                                            <div class="form-group" style="margin-bottom: 15px;">
                                                <input type="number" step="0.01" class="form-control total-price" id="totalPrice1" name="total_price[]" readonly placeholder="Total Price">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Button to Add More Items -->
                                    <div class="text-center">
                                        <button type="button" class="btn btn-secondary" id="addMoreItemsBtn" onclick="addOrderItem()" disabled>Add More Items</button>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row">
                                    <div class="col-12 text-center mt-2">
                                        <button type="submit" class="btn btn-primary mt-4" onclick="return validateOrderItems()">Submit Order</button>
                                    </div>
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
    let itemCount = 1;

    document.addEventListener("DOMContentLoaded", function() {
        const productSelect = document.querySelectorAll('.product-select');
        productSelect.forEach(select => updatePrice(select));
        checkQuantity();
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
        checkQuantity();
    }

    function checkQuantity() {
        const quantityInputs = document.querySelectorAll('.quantity');
        const productSelects = document.querySelectorAll('.product-select');
        const supplierSelect = document.getElementById('supplierSelect');
        const addMoreItemsBtn = document.getElementById('addMoreItemsBtn');

        const allValidQuantities = Array.from(quantityInputs).every(input => input.value > 0);

        const allProductsSelected = Array.from(productSelects).every(select => select.value !== "");

        const supplierSelected = supplierSelect.value !== "";

        const isEnabled = allValidQuantities && allProductsSelected && supplierSelected;
        addMoreItemsBtn.disabled = !isEnabled;

        if (isEnabled) {
            addMoreItemsBtn.classList.remove('btn-secondary');
            addMoreItemsBtn.classList.add('btn-primary');
        } else {
            addMoreItemsBtn.classList.remove('btn-primary');
            addMoreItemsBtn.classList.add('btn-secondary');
        }
    }

document.getElementById('orderItemsTabContent').addEventListener('change', function(event) {
    if (event.target.classList.contains('product-select')) {
        updateTabName(event.target);
    }
});

function addOrderItem() {
    itemCount++;

    var newItemTab = `
        <li class="nav-item">
            <a class="nav-link" id="item${itemCount}-tab" data-toggle="tab" href="#item${itemCount}" role="tab" aria-controls="item${itemCount}" aria-selected="false">
                New Item
                <button type="button" class="close-btn" onclick="removeTab(${itemCount})">&times;</button>
            </a>
        </li>
    `;

    var newItemContent = `
        <div class="tab-pane fade order-items" id="item${itemCount}" role="tabpanel" aria-labelledby="item${itemCount}-tab">
            <div class="form-group" style="margin-bottom: 15px;">
                <select class="form-control product-select" name="product_id[]" required onchange="updatePrice(this)">
                    <option value="" disabled selected hidden style="color: lightgray;">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <input type="number" class="form-control quantity" id="quantity${itemCount}" name="quantity[]" oninput="calculateTotalPrice(${itemCount}); checkQuantity()" required min="1" placeholder="Quantity">
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <input type="number" step="0.01" class="form-control unit-price" id="unitPrice${itemCount}" name="unit_price[]" oninput="calculateTotalPrice(${itemCount})" required readonly placeholder="Unit Price">
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <input type="number" step="0.01" class="form-control total-price" id="totalPrice${itemCount}" name="total_price[]" readonly placeholder="Total Price">
            </div>
        </div>
    `;

    document.getElementById('orderItemsTabs').insertAdjacentHTML('beforeend', newItemTab);
    document.getElementById('orderItemsTabContent').insertAdjacentHTML('beforeend', newItemContent);

    $('#orderItemsTabs .nav-link').removeClass('active');
    $('.tab-pane').removeClass('show active');

    $(`#item${itemCount}-tab`).addClass('active');
    $(`#item${itemCount}`).addClass('show active');

    checkQuantity();
}

function updateTabName(selectElement) {
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var productName = selectedOption.text;
    var tabId = selectElement.closest('.tab-pane').id;

    document.querySelector(`a[href='#${tabId}']`).innerHTML = `
        ${productName}
        <button type="button" class="close-btn" onclick="removeTab(${itemCount})">&times;</button>
    `;
}

    function removeTab(index) {
        
        const tabCount = document.querySelectorAll('#orderItemsTabs .nav-item').length;

        if (tabCount === 1) {
            alert("You cannot remove the last tab.");
            return;
        }

        $(`#item${index}-tab`).parent().remove();
        $(`#item${index}`).remove();

        const remainingTabs = $('#orderItemsTabs .nav-link');
        
        if (remainingTabs.length > 0) {
            const activeTab = remainingTabs.filter('.active');
            
            if (activeTab.length === 0) {
                $(remainingTabs[0]).addClass('active');
                const firstTabId = $(remainingTabs[0]).attr('href');
                $(firstTabId).addClass('show active');
            }
        }
    }


</script>

@endpush
