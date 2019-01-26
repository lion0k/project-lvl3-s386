@extends('layouts.main')

@section('content')
    <div class="row justify-content-center mt-6">
        <div class="col-12">
            <h3>Analyze page <b>{{ $domain->name }}</b></h3>
            <table class="table table-bordered table-white table-sm">
                <tbody>
                    <tr class="table-active">
                        <th>ID</th><td>{{ $domain->id }}</td>
                    </tr>
                    <tr>
                        <th>URL</th><td>{{ $domain->name }}</td>
                    </tr>
                    <tr>
                        <th>StatusCode</th><td>{{ $domain->status_code }}</td>
                    </tr>
                    <tr>
                        <th>ContentLength</th><td>{{ $domain->content_length }}</td>
                    </tr>
                    <tr>
                        <th>H1</th><td>{{ $domain->h1 }}</td>
                    </tr>
                    <tr>
                        <th>Keywords</th><td>{{ $domain->keywords }}</td>
                    </tr>
                    <tr>
                        <th>Description</th><td>{{ $domain->description }}</td>
                    </tr>
                    <tr>
                        <th>CreateDate</th><td>{{ $domain->created_at }}</td>
                    </tr>
                    <tr>
                        <th>UpdateDate</th><td>{{ $domain->updated_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

