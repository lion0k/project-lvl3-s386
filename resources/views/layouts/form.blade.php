<?php if (isset($errors)) {print_r($errors); die;}  ?>

<div class="row justify-content-center">
    <div class="col-8">
        <p class="lead">Enter URL and press submit</p>
        <form action="{{ route('domains.store') }}" method="post">
            <div class="input-group">
                <input name="name" type="text" class="form-control" placeholder="http://" aria-label="Test term"
                       aria-describedby="basic-addon">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit">Submit</button>
                </div>
            </div>
        </form>

        @isset($errors)
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endisset
    </div>
</div>