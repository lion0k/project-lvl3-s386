<div class="row justify-content-center">
    <div class="col-6">
        <p class="lead">Enter URL and press submit</p>
        <form action="{{ route('domains.store') }}" method="post">
            <div class="input-group">
                <input name="name" type="text" class="form-control" placeholder="http://example.com" aria-label="Test term"
                       aria-describedby="basic-addon" value="@isset($oldName){{ $oldName }}@endisset">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit">Submit</button>
                </div>
            </div>
        </form>

        @isset($errors)
            <p>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Errors</h4>
                        <ul>
                            @foreach ($errors as $error)
                                <li><?php echo $error; ?></li>
                            @endforeach
                        </ul>
                    <hr>
                </div>
            </p>
        @endisset
    </div>
</div>
