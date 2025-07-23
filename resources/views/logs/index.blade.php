@extends('adminlte::page')

@section('title', 'System Logs')

@section('content_header')
    <h1>System Logs</h1>
    {{ Breadcrumbs::render('logs.index') }}
@stop

@section('content')
    <div class="log card shadow-sm">
        <div class="card-body p-0">
            <table id="logs-table" class="table table-hover mb-0">
                <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>IP</th>
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $log->user->name ?? 'System' }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->ip_address }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endsection

@section('js')
    {{-- DataTables JS --}}
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('#logs-table').DataTable({
                pageLength: 10,
                order: [[0, 'desc']],
                responsive: true
            });
        });
    </script>
@endsection
