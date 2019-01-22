@extends('layouts.main')

@section('content')
    <table class='table table-bordered table-white'>
        @include('domain.headTable')
        <tbody>
        @foreach ($domains as $domain)
            <tr>
                <th scope="row">{{ $domain->id }}</th>
                <td><a href={{ route('domains.show', ['id' => $domain->id]) }}>{{ $domain->name }}</a></td>
                <td>{{ $domain->created_at }}</td>
                <td>{{ $domain->updated_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection