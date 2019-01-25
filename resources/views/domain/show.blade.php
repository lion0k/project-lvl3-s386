@extends('layouts.main')

@section('content')
    <table class="table table-bordered table-white">
        @include('domain.headTable')
        <tbody>
        <tr>
            <td>{{ $domain->id }}</td>
            <td>{{ $domain->name }}</td>
            <td>{{ $domain->status_code }}</td>
            <td>{{ $domain->content_length }}</td>
            <td>{{ $domain->created_at }}</td>
            <td>{{ $domain->updated_at }}</td>
        </tr>
        </tbody>
    </table>
@endsection