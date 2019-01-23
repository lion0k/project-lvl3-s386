<div class="row justify-content-center">
    <div class="col-8">
        <p class="lead">Enter URL and press submit</p>
        <form action="{{ route('domains.store') }}" method="post">
            <div class="input-group">
                <input name="name" type="text" class="form-control" placeholder="http://example.com" aria-label="Test term"
                       aria-describedby="basic-addon">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit">Submit</button>
                </div>
            </div>
        </form>

        @isset($errors)
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Errors</h4>
                    <ul>
                        @foreach ($errors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                <hr>
            </div>
        @endisset
    </div>
</div>