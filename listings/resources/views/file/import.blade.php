@extends('layout')
@section('title', 'Dashboard | Import File')
@section('import')
    @if (session('msg'))
        <p>{{ session('msg') }}</p>
    @endif
    <form method="POST" action="{{ url('/file/import') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" accept=".xlsx, .xls, .ods" name="excel_file">
        <button type="submit">submit</button>
    </form>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            Import()
        });

       
    </script>
@endsection
