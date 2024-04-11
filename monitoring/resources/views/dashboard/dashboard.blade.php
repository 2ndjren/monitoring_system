@extends('layout')
@section('title', 'Monitoring | Dashboard')
@section('dashboard')
    <div class="container-fluid">
        <p class="h3"><span><i class="fa-solid fa-chart-simple me-4"></i></span>Dashboard</p>
    </div>
    @if (Session::exists('admin'))
        {{ Session::get('admin')['status'] }}
    @elseif(Session::exists('user'))
        {{ Session::get('user')['status'] }}
    @endif

    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
