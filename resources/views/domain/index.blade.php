@extends('layouts.main')

@section('content')
    @isset($domains)
        <table class='table table-bordered table-white'>
            @include('domain.headTable')
            <tbody>
            @foreach ($domains as $domain)
                <tr>
                    <th scope="row">{{ $domain->id }}</th>
                    <td><a href={{ route('domains.show', ['id' => $domain->id]) }}>{{ $domain->name }}</a></td>
                    <td>{{ $domain->status_code }}</td>
                    <td>{{ $domain->content_length }}</td>
                    <td>{{ $domain->created_at }}</td>
                    <td>{{ $domain->updated_at }}</td>
                    <td>
                        <form action="{{ route('domains.destroy', ['id' => $domain->id]) }}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="submit" value="Remove">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if (count($domains) > 1)
            <div>
                <nav aria-label="Pages">
                    {{ $domains->links() }}
                </nav>
            </div>
        @endif
    @endisset
@endsection