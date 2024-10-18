@extends('admin.Backend.Layout.app')

@section('breadcrumb', 'Activity Logs')
@section('title', 'Activity Logs')

@section('main-content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-xl font-bold">Activity Logs</h1>

                    <table id="activity-logs-table" class="min-w-full mt-4 bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">User</th>
                                <th class="px-4 py-2 border">Role</th>
                                <th class="px-4 py-2 border">Action</th>
                                <th class="px-4 py-2 border">URL</th>
                                <th class="px-4 py-2 border">Method</th>
                                <th class="px-4 py-2 border">IP Address</th>
                                <th class="px-4 py-2 border">User Agent</th>
                                <th class="px-4 py-2 border">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $log->user->name }}</td>
                                    <td class="px-4 py-2 border">{{ $log->user_role }}</td>
                                    <td class="px-4 py-2 border">{{ $log->action }}</td>
                                    <td class="px-4 py-2 border">{{ $log->url }}</td>
                                    <td class="px-4 py-2 border">{{ $log->method }}</td>
                                    <td class="px-4 py-2 border">{{ $log->ip_address }}</td>
                                    <td class="px-4 py-2 border">{{ $log->user_agent }}</td>
                                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
<script>
    $(document).ready(function() {
        $('#activity-logs-table').DataTable({
            "order": [[ 7, "desc" ]], // Order by the Date column (index 7)
            "pageLength": 10 // Set the default page length
        });
    });
</script>
@endpush
