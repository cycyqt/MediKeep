@extends('Backend.Layout.app')
@section('breadcrumb', 'Order')
@section('title', 'Staff')
@section('main-content')

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>    
</head>

<style>

    .no-highlight {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
    }

    .no-interaction {
        pointer-events: none;
        user-select: none;
        caret-color: transparent;
        background-color: transparent;
        color: inherit;
    }

    .caret-block {
        caret-color: transparent;
        background-color: transparent;
        color: inherit;
    }

    .nav-tabs {
        border-bottom: 2px solid #e0e0e0;
    }

    .nav-tabs .nav-item .nav-link {
        border: none;
        margin-right: 3px;
        color: #fff;
        background-color: darkgray;
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
        background-color: gray;
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

    .btn-info {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .btn-info:hover {
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
        top: 5px;
        right: 5px;
        background-color: transparent;
        border: none;
        font-size: 14px;
        color: white;
        cursor: pointer;
        outline: none;
        z-index: 10;
        line-height: 1;
    }

    .nav-tabs .nav-item .close-btn:hover {
        color: #ff0000;
    }

    .nav-tabs .nav-item .nav-link {
        padding-right: 25px;
    }

    .modal-header {
        display: flex;
        align-items: center;
        background-color: #007bff;
        color: white;
    }

    .modal-logo {
        width: 50px;
        height: auto;
        margin-right: 15px;
    }

    .modal-title {
        font-weight: bold;
        color: white;
    }

    .modal-body {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .modal-body h5 {
        margin-top: 0;
        margin-bottom: 10px;
    }

    .modal-body ul {
        list-style-type: none;
        padding: 0;
    }

    .modal-body li {
        margin-bottom: 5px;
    }

    .modal-footer {
        display: flex;
        justify-content: space-between;
    }

</style>

<div class="container-fluid py-4 caret-block no-highlight">
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

                        <div style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                            <a href="{{ route('order.orderlist') }}" class="card-title" style="display: block; height: 100%; line-height: 1.5; padding: 10px; border-radius: 5px; text-align: right;">
                                <img src="https://i.ibb.co/zHVpKjb/toppng-com-shipping-png-512x512.png" alt="Order Items" style="height: 50px; width: auto;">
                            </a>
                        </div>

                        <!-- Order Form Starts Here -->
                        <form action="{{ route('staff.add_order') }}" method="POST">
                            @csrf
                            <div class="row p-4">
                                <!-- Left Column: Order Information -->
                                <div class="col-md-6">
                                    <div class="card-header mb-2 p-2">
                                        <h3 class="card-title no-interaction">Order Form</h3>
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
                                    <div class="form-group no-interaction" style="margin-bottom: 15px;">
                                        <input type="hidden" name="staff_id" value="{{ Auth::id() }}">
                                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly placeholder="Staff">
                                    </div>
                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <input type="date" class="form-control" id="orderDate" name="order_date">
                                    </div>
                                    <div class="form-group no-interaction" style="margin-bottom: 15px;">
                                        <input type="text" class="form-control" value="Pending" readonly placeholder="Status">
                                        <input type="hidden" name="status" value="Pending">
                                    </div>
                                    
                                    <div class="col-12 text-center">
                                        {{-- <a href="{{ route('order.orderlist') }}" class="btn btn-primary">View Order List</a> --}}
                                        <button type="submit" class="btn btn-primary" onclick="return validateOrderItems()">Submit Order</button>
                                    </div>
                                </div>

                                <!-- Right Column: Order Items with Tabs -->
                                <div class="col-md-6">
                                    <div class="card-header mb-2 p-2" style="visibility: hidden;">
                                        <h3 class="card-title" >Order Items</h3>
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
                                            <div class="form-group" style="margin-bottom: 15px; caret-color: auto; background-color: auto; color: auto;">
                                                <input type="number" class="form-control quantity" id="quantity1" name="quantity[]" oninput="calculateTotalPrice(1); checkQuantity()" required min="1" placeholder="Quantity">
                                            </div>
                                            <div class="form-group no-interaction" style="margin-bottom: 15px;">
                                                <input type="number" step="0.01" class="form-control unit-price" id="unitPrice1" name="unit_price[]" oninput="calculateTotalPrice(1)" required readonly placeholder="Unit Price">
                                            </div>
                                            <div class="form-group no-interaction" style="margin-bottom: 15px;">
                                                <input type="number" step="0.01" class="form-control total-price" id="totalPrice1" name="total_price[]" readonly placeholder="Total Price">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Buttons -->
                                    <div class="text-center">
                                        <button type="button" class="btn btn-secondary" id="addMoreItemsBtn" onclick="addOrderItem()" disabled>Add More Items</button>
                                        <button type="button" class="btn btn-info" id="orderSummaryBtn" onclick="showOrderSummary()">Order Summary</button>
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
    <!-- Order Summary Modal -->
    <div class="modal fade" id="orderSummaryModal" tabindex="-1" role="dialog" aria-labelledby="orderSummaryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="width: 800px; height: 600px; overflow: hidden; position: relative;">
                <img src="https://i.ibb.co/zSNR7Bf/Picsart-24-10-25-20-14-54-279.png" alt="Logo" 
                    style="position: absolute; top: 10px; right: 10px; height: 100px; opacity: 1; transform: rotate(-15deg); z-index: 1;">
                <div class="modal-header d-flex justify-content-center align-items-center" 
                    style="background-color: #007bff; color: white; padding: 0.5rem 1rem;">
                    <h5 class="modal-title mx-auto" id="orderSummaryModalLabel" style="margin: 0; font-weight: bold; z-index: 2;">ORDER SUMMARY</h5>
                </div>
                <div class="modal-body d-flex flex-column px-5 no-interaction" id="orderSummaryContent" style="height: calc(100% - 4rem);">
                    <div class="mb-3 no-interaction">
                        <p>A new order will be placed by <strong>{{ Auth::user()->name }}</strong> to: </p><p><strong id="supplierName"></strong></p> 
                    </div>
                    <div class="table-responsive flex-grow-1 no-interaction" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-hover table-bordered table-striped mb-0">
                            <thead class="thead-dark no-interaction">
                                <tr>
                                    <th class="text-center">Item</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Unit Price</th>
                                    <th class="text-center">Total Price</th>
                                </tr>
                            </thead>
                            <tbody id="orderItemsTableBody">
                                <!-- will be populated -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer p-0 no-interaction">
                    <table class="table mb-0 no-interaction">
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-center bg-light no-interaction">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <span class="text-right mr-2">Total Amount:<span class="opacity-0">--</span></span>
                                        <span id="totalAmount" class="ml-2">₱0.00</span>
                                    </div>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>                
            </div>
        </div>
    </div>

    @include('components.footer')
</div>



@endsection

@push('custom-scripts')
<script>
    let itemCount = 1;

    const orderDateInput = document.getElementById("orderDate");

    orderDateInput.addEventListener("mousedown", (e) => {
        e.preventDefault(); // Prevents all mouse clicks from triggering text selection
    });

    orderDateInput.addEventListener("selectstart", (e) => {
        e.preventDefault(); // Prevents the start of selection entirely
    });


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
                <div class="form-group" style="margin-bottom: 15px; caret-color: auto; background-color: auto; color: auto;">
                    <input type="number" class="form-control quantity" id="quantity${itemCount}" name="quantity[]" oninput="calculateTotalPrice(${itemCount}); checkQuantity()" required min="1" placeholder="Quantity">
                </div>
                <div class="form-group no-interaction" style="margin-bottom: 15px;">
                    <input type="number" step="0.01" class="form-control unit-price" id="unitPrice${itemCount}" name="unit_price[]" oninput="calculateTotalPrice(${itemCount})" required readonly placeholder="Unit Price">
                </div>
                <div class="form-group no-interaction" style="margin-bottom: 15px;">
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

        for (let i = tabIndex; i <= itemCount; i++) {
            const tab = document.querySelector(`#item${i}`);
            if (tab) {
                tab.id = `item${i - 1}`;
                // Update select and input IDs accordingly
                const productSelect = tab.querySelector('.product-select');
                const quantityInput = tab.querySelector(`#quantity${i}`);
                const unitPriceInput = tab.querySelector(`#unitPrice${i}`);
                const totalPriceInput = tab.querySelector(`#totalPrice${i}`);

                productSelect.id = `productSelect${i - 1}`;
                quantityInput.id = `quantity${i - 1}`;
                unitPriceInput.id = `unitPrice${i - 1}`;
                totalPriceInput.id = `totalPrice${i - 1}`;
            }
        }
    }


    function showOrderSummary() {

        const supplierName = document.getElementById('supplierSelect').selectedOptions[0].text;
        document.getElementById('supplierName').innerText = supplierName;

        const orderItemsTableBody = document.getElementById('orderItemsTableBody');
        orderItemsTableBody.innerHTML = '';

        let totalAmount = 0;

        for (let i = 1; i <= itemCount; i++) {
            const productSelect = document.querySelector(`#item${i} .product-select`);
            const quantityInput = document.querySelector(`#quantity${i}`);
            const unitPriceInput = document.querySelector(`#unitPrice${i}`);
            const totalPriceInput = document.querySelector(`#totalPrice${i}`);

            if (productSelect && quantityInput && unitPriceInput && totalPriceInput) {
                if (productSelect.value && quantityInput.value) {
                    const itemName = productSelect.options[productSelect.selectedIndex].text;
                    const quantity = quantityInput.value;
                    const unitPrice = unitPriceInput.value;
                    const totalPrice = totalPriceInput.value;

                    const row = `<tr>
                        <td class="text-center">${itemName}</td>
                        <td class="text-center">${quantity}</td>
                        <td class="text-center">₱${parseFloat(unitPrice).toFixed(2)}</td>
                        <td class="text-center">₱${parseFloat(totalPrice).toFixed(2)}</td>
                    </tr>`;
                    orderItemsTableBody.innerHTML += row;

                    totalAmount += parseFloat(totalPrice);
                }
            }
        }
        document.getElementById('totalAmount').innerText = `₱${totalAmount.toFixed(2)}`;
        $('#orderSummaryModal').modal('show');
    }

</script>
@endpush
