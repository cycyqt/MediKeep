@extends('Backend.Layout.app')
@section('breadcrumb', 'Add Product')
@section('title', 'Staff')
@section('main-content')   
    
    <div class="container-fluid py-4">
        
        <div class="titles">
            <div class="tab-titles">
                <p class="tab-links active-link" onclick="opentab('category')">Category <span></span></p>
                <p class="tab-links" onclick="opentab('type')">Type <span></span></p> 
                <p class="tab-links" onclick="opentab('add')">Add <span></span></p>                                     
            </div>
        </div>

        <!-- Medicine Category -->
        <div class="tab-contents active-tab" id="category">
            <div class="card-body">

                <div class="row mt-3 " >
                    <div class="col-lg-4 mb-lg-0 mb-4">
                        <div class="card z-index-2">
                            <div class="card-body p-2">
                                <div class="card-header mb-2 p-2"> 
                                    <h3 class="card-title">Medicine Category </h3>
                                </div>

                                <form action="{{ route('staff.add_category') }}" method="post">
                                    @csrf
                                    <div class="row g-3 px-4 mt-4">

                                        <div class="col-md-12 mb-5">
                                            <div class="input-group">
                                                <span class="input-group-text bg-gray-200 ">Medicine Category</span>
                                                <input type="text" class="form-control" name="name" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-4 mb-4">
                                        <button type="submit"  class="btn btn-primary">
                                        Add 
                                        </button>
                                        <a href="{{ url ('staff/home')}}" class="btn btn-danger float-right"> Cancel</a>
                                    </div>

                                </form>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 mb-lg-0 mb-4">
                        <div class="card z-index-2">
                            <div class="card-body p-2">
                                <div class="card-header mb-2 p-2"> 
                                    <h3 class="card-title">Medicine Category List </h3>
                                </div>

                                <div class="table-responsive p-3">
                                    <table id="datatablesSimpleOne" class="table table-bordered table-hover">
                                    <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categories as $key => $category)
                                            <tr>
                                                <td>{{ $key + 1 }}</td> <!-- Incremental ID -->
                                                <td>{{ $category->name }}</td> <!-- Display category name -->
                                                <td> 
                                                    
                                                    <a onclick="return confirm('Are you sure you want to DELETE?')" href="{{ route('staff.delete_category', $category->id) }}" class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end -->

        <!-- Medicine Type -->
        <div class="tab-contents " id="type">
            <div class="card-body">

                <div class="row mt-3 " >
                    <div class="col-lg-4 mb-lg-0 mb-4">
                        <div class="card z-index-2">
                            <div class="card-body p-2">
                                <div class="card-header mb-2 p-2"> 
                                    <h3 class="card-title">Medicine Type </h3>
                                </div>

                                <form action="">
                                    <div class="row g-3 px-4 mt-4">

                                        <div class="col-md-12 mb-5">
                                            <div class="input-group">
                                                <span class="input-group-text bg-gray-200 ">Medicine Type</span>
                                                <input type="text" class="form-control" name="Medicine_Type" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-4 mb-4">
                                        <button type="submit"  class="btn btn-primary">
                                        Add 
                                        </button>
                                        <a href="{{ url ('staff/home')}}" class="btn btn-danger float-right"> Cancel</a>
                                    </div>

                                </form>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 mb-lg-0 mb-4">
                        <div class="card z-index-2">
                            <div class="card-body p-2">
                                <div class="card-header mb-2 p-2"> 
                                    <h3 class="card-title">Medicine Type List </h3>
                                </div>

                                <div class="table-responsive p-3">
                                    <table id="datatablesSimpleTwo" class="table table-bordered table-hover">
                                    <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Liquid</td>
                                                <td> 
                                                    <a href="" class="btn btn-primary">Edit</a>
                                                    <a onclick="return confirm('Are you sure you want to DELETE')" href="#"  class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Capsole</td>
                                                <td> 
                                                    <a href="" class="btn btn-primary">Edit</a>
                                                    <a onclick="return confirm('Are you sure you want to DELETE')" href="#"  class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Drop</td>
                                                <td> 
                                                    <a href="" class="btn btn-primary">Edit</a>
                                                    <a onclick="return confirm('Are you sure you want to DELETE')" href="#"  class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end -->
        
        <!-- Add Medicine -->
        <div class="tab-contents " id="add">
            <div class="card-body">

                <div class="row mt-3 " >
                    <div class="col-lg-12 mb-lg-0 mb-4">
                        <div class="card z-index-2">
                            <div class="card-body p-2">
                                <div class="card-header mb-2 p-2"> 
                                    <h3 class="card-title">Add Medicine</h3>
                                </div>

                                <form action="">
                                    <div class="row g-3 px-4 mt-4">

                                        <div class="col-md-6 mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text bg-gray-200">Medicine Category</span>
                                                <select class="form-select form-control p-2" name="Medicine_Category">
                                                @foreach($categories as $category)
                                                     <option value="{{ $category->name }}">{{ $category->name }}</option>
                                                 @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text bg-gray-200">Medicine Type</span>
                                                <select class="form-select form-control p-2" name="Medicine_Type">
                                                <option value="Liquid">Liquid</option>
                                                <option value="Capsole">Capsole</option>
                                                <option value="drop">drop</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text bg-gray-200 p-2">Product Name</span>
                                                <input type="text" class="form-control" name="Product_Name" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text bg-gray-200 p-2">Measurement</span>
                                                <input type="text" class="form-control" name="Measurement" required>
                                            </div>
                                        </div>

                                        <div class="col-md-8 mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text bg-gray-200 p-2">Descripion</span>
                                                <textarea class="form-control" name="Description" required></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text bg-gray-200 p-2">Price</span>
                                                <input type="number" class="form-control" name="Price" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="requiresPrescription" name="requiresPrescription">
                                                <label class="form-check-label" for="requiresPrescription">
                                                    Requires Prescription
                                                </label>
                                            </div>
                                        </div>
                                        


                                    </div>

                                    <div class="px-4 mb-4">
                                        <button type="submit"  class="btn btn-primary">
                                        Add 
                                        </button>
                                        <a href="{{ url ('staff/home')}}" class="btn btn-danger float-right"> Cancel</a>
                                    </div>

                                </form>
                                
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