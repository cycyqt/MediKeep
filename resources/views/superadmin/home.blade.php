@extends('superadmin.Backend.Layout.app')
@section('breadcrumb', 'Home')
@section('title', 'SuperAdmin')

@section('main-content')  
    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4"> 
                <!-- Card for Total Users -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="text-blue-500">
                            <i class="fas fa-users fa-3x"></i> 
                        </div>
                        <div class="ml-3 text-center">
                            <h3 class="text-sm font-semibold">Total Users</h3>
                            <p class="text-lg">{{ $totalUsers }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
<!-- If you're using Font Awesome or another icon library, make sure it's included -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush
