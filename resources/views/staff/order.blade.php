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
                            <div class="p-4">
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
                            </div>
                            
                            
            
                                <!-- Order Form Starts Here -->
                                <form action="{{ route('staff.add_order') }}" method="POST">
                                    @csrf
                                    <div class="row p-4">

                                        <!-- Left Column: Order Information -->
                                        <div class="col-md-6">

                                            <div class="card-header mb-2 p-2"> 
                                                <h3 class="card-title">Order Form </h3>
                                            </div>

                                            <!-- Order Information Section -->
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
                                                <input type="text" class="form-control"  name="staff_id" value="{{ Auth::user()->name }}" readonly>
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
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" id="orderTabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" id="page-1-tab" data-bs-toggle="tab" href="#page-1" role="tab" aria-controls="page-1" aria-selected="true">Page 1</a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content" id="orderItemsTabContent">
                                                <div class="tab-pane fade show active" id="page-1" role="tabpanel" aria-labelledby="page-1-tab">
                                                    <div class="order-items" id="order-items-page-1">
                                                        <!-- Initial order item fields -->
                                                        <div class="form-group">
                                                            <label for="product">Product</label>
                                                            <select class="form-control" id="product" name="product_id[]" required onchange="updatePrice(this)">
                                                                @foreach($products as $index => $product)
                                                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ $index === 0 ? 'selected' : '' }}>
                                                                        {{ $product->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="quantity1">Quantity</label>
                                                            <input type="number" class="form-control" id="quantity1" name="quantity[]" oninput="calculateTotalPrice(1)" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="unitPrice1">Unit Price</label>
                                                            <input type="number" step="0.01" class="form-control" id="unitPrice1" name="unit_price[]" oninput="calculateTotalPrice(1)" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="totalPrice1">Total Price</label>
                                                            <input type="number" step="0.01" class="form-control" id="totalPrice1" name="total_price[]" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Button to add more items and delete buttons -->
                                            <div class="d-flex justify-content-end mt-2">
                                                <button type="button" class="btn btn-secondary" onclick="addOrderItem()">Add Another Item</button>
                                                <button type="button" class="btn btn-danger ms-2" onclick="deletePage(currentPage)">Delete Current Page</button>
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
    </div>
    <!-- end -->
         

      
        

    <!-- footer -->
    <footer class="footer pt-3  ">
        <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                for a better web.
            </div>
            </div>
            <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                <a href="https://creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                </li>
            </ul>
            </div>
        </div>
        </div>
    </footer>
</div>

    

@endsection
@push('custom-scripts')
@endpush

<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Set the initial unit price based on the first product
    const productSelect = document.getElementById('product');
    updatePrice(productSelect); // Call the function to set the price initially
});

function updatePrice(selectElement) {
    // Get the selected option
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    // Get the price from the data attribute
    var price = selectedOption.getAttribute('data-price');
    // Update the unit price input field
    document.getElementById('unitPrice1').value = price;

    // Optionally, you can call calculateTotalPrice() if needed to update total price automatically
    calculateTotalPrice(1);
}
</script>

<script>
    let itemIndex = 1; // Track number of items added
    let currentPage = 1; // Track current page number
    let maxItemsPerPage = 1; // Set maximum items per page
    
    function addOrderItem() {
        itemIndex++; // Increment item index
    
        // Create a new order item
        const newItem = document.createElement('div');
        newItem.classList.add('form-group');
        newItem.innerHTML = `
            <label for="product${itemIndex}">Product</label>
            <select class="form-control" id="product${itemIndex}" name="product_id[]" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
            <label for="quantity${itemIndex}">Quantity</label>
            <input type="number" class="form-control" id="quantity${itemIndex}" name="quantity[]" oninput="calculateTotalPrice(${itemIndex})" required>
            <label for="unitPrice${itemIndex}">Unit Price</label>
            <input type="number" step="0.01" class="form-control" id="unitPrice${itemIndex}" name="unit_price[]" oninput="calculateTotalPrice(${itemIndex})" required>
            <label for="totalPrice${itemIndex}">Total Price</label>
            <input type="number" step="0.01" class="form-control" id="totalPrice${itemIndex}" name="total_price[]" readonly>
        `;
    
        const currentPageDiv = document.getElementById(`order-items-page-${currentPage}`);
        
        // Add new item to current page if the page isn't full
        if (currentPageDiv.childElementCount < maxItemsPerPage) {
            currentPageDiv.appendChild(newItem);
        } else {
            // If the current page is full, create a new page
            currentPage++;
            addNewPage(newItem);
        }
    }
    
    // Function to create a new page dynamically
    function addNewPage(newItem) {
        // Create new tab
        const newTab = document.createElement('li');
        newTab.classList.add('nav-item');
        newTab.innerHTML = `
            <a class="nav-link" id="page-${currentPage}-tab" data-bs-toggle="tab" href="#page-${currentPage}" role="tab" aria-controls="page-${currentPage}" aria-selected="false">Page ${currentPage}</a>
        `;
        document.getElementById('orderTabs').appendChild(newTab);
    
        // Create new tab pane for the new page
        const newTabPane = document.createElement('div');
        newTabPane.classList.add('tab-pane', 'fade');
        newTabPane.id = `page-${currentPage}`;
        newTabPane.setAttribute('role', 'tabpanel');
        newTabPane.setAttribute('aria-labelledby', `page-${currentPage}-tab`);
        
        // Add the new order item to the new page
        const orderItemsDiv = document.createElement('div');
        orderItemsDiv.classList.add('order-items');
        orderItemsDiv.id = `order-items-page-${currentPage}`;
        orderItemsDiv.appendChild(newItem);
        
        newTabPane.appendChild(orderItemsDiv);
        document.getElementById('orderItemsTabContent').appendChild(newTabPane);
    
        // Activate the new tab
        document.querySelector(`#page-${currentPage}-tab`).click();
    }
    
    function deletePage(pageNumber) {
    // Prevent deletion if there's only one page
    if (currentPage === 1) {
        alert("You cannot delete the only page.");
        return;
    }

    // Remove the corresponding tab and tab content
    const tabToRemove = document.getElementById(`page-${pageNumber}-tab`);
    const tabContentToRemove = document.getElementById(`page-${pageNumber}`);
    const itemsToMove = document.querySelector(`#order-items-page-${pageNumber}`);

    // Get the items from the page to be deleted
    const items = itemsToMove.querySelectorAll('.form-group');
    
    // If not deleting the last page, move items to the previous page
    if (pageNumber < currentPage) {
        const targetItemsDiv = document.getElementById(`order-items-page-${pageNumber}`);
        items.forEach(item => {
            targetItemsDiv.appendChild(item);
        });
    }

    // Remove the tab
    if (tabToRemove) {
        tabToRemove.parentNode.removeChild(tabToRemove);
    }
    // Remove the tab content
    if (tabContentToRemove) {
        tabContentToRemove.parentNode.removeChild(tabContentToRemove);
    }

    // Decrement currentPage
    const previousPage = currentPage; // Store the current page number
    currentPage--;

    // If the current page was deleted, go back to the last page
    if (currentPage > 0) {
        document.querySelector(`#page-${currentPage}-tab`).click();
    }

    // Renumber IDs for items in the remaining pages
    renumberItems(previousPage);
}
    
    // Function to renumber items in remaining pages
    function renumberItems(deletedPage) {
        const allItems = document.querySelectorAll('.order-items');
        let newIndex = 1; // Start renumbering from 1
    
        allItems.forEach((page) => {
            const items = page.querySelectorAll('.form-group');
            items.forEach((item, index) => {
                // Update IDs and attributes for each item in the page
                const newId = newIndex;
                item.querySelector('label[for^="product"]').setAttribute('for', `product${newId}`);
                item.querySelector('input[id^="quantity"]').setAttribute('id', `quantity${newId}`);
                item.querySelector('input[id^="unitPrice"]').setAttribute('id', `unitPrice${newId}`);
                item.querySelector('input[id^="totalPrice"]').setAttribute('id', `totalPrice${newId}`);
                item.querySelector('input[id^="quantity"]').setAttribute('oninput', `calculateTotalPrice(${newId})`);
                item.querySelector('input[id^="unitPrice"]').setAttribute('oninput', `calculateTotalPrice(${newId})`);
                newIndex++;
            });
        });
    }
    
    // Function to calculate total price
    function calculateTotalPrice(index) {
        const quantity = document.getElementById(`quantity${index}`).value || 0;
        const unitPrice = document.getElementById(`unitPrice${index}`).value || 0;
        const totalPrice = quantity * unitPrice;
    
        document.getElementById(`totalPrice${index}`).value = totalPrice.toFixed(2);
    }
</script>

<script>
    function openEditCategoryModal(id, name) {
        // Set the values in the modal form for categories
        document.getElementById('editCategoryId').value = id;
        document.getElementById('editCategoryName').value = name;

        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editCategoryModal'), {});
        editModal.show();
    }

    function openEditSubcategoryModal(id, name) {
        // Set the values in the modal form for subcategories
        document.getElementById('editSubcategoryId').value = id;
        document.getElementById('editSubcategoryName').value = name;

        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editSubcategoryModal'), {});
        editModal.show();
    }

</script>

<script>
    function calculateTotalPrice(index) {
        // Get the quantity and unit price by their IDs
        var quantity = document.getElementById('quantity' + index).value;
        var unitPrice = document.getElementById('unitPrice' + index).value;

        // Calculate total price if both quantity and unit price are provided
        if (quantity && unitPrice) {
            var totalPrice = quantity * unitPrice;
            document.getElementById('totalPrice' + index).value = totalPrice.toFixed(2);  // Set total price and round to 2 decimals
        } else {
            document.getElementById('totalPrice' + index).value = '';  // Clear total price if inputs are invalid
        }
    }
</script>