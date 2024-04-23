@extends('layout')
@section('title', 'Projects')

@section('projects')
    <div class="card rounded-0">
        <div class="card-body ">
            <table class="w-100 overflow-auto">
                <thead>
                    <tr class="">
                        <th class="bg-success border border-dark border-5 m-1 text-center"><i class="fa-solid fa-hashtag"></i>
                        </th>
                        <th class="bg-success border border-dark border-5 m-1 text-center p-2">Name</th>
                        <th class="bg-success border border-dark border-5 m-1 text-center p-2">Alias</th>
                        <th class="bg-success border border-dark border-5 m-1 text-center p-2">Date Created</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-dark border-5 text-center"><i class="fa-solid fa-building"></i></td>
                        <td class="p-2 border border-dark border-5 text-center">Aleah Recidences</td>
                        <td class="p-2 border border-dark border-5 text-center">ALR</td>
                        <td class="p-2 border border-dark border-5 text-center">112313</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
@endsection
