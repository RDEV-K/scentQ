@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>@lang('Success!')</strong> {{ session('success') }}
    </div>
@endif
@if(session()->has('status'))
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>@lang('Info!')</strong> {{ session('status') }}
    </div>
@endif

@if(session()->has('alert'))
    <div class="alert alert-warning alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>@lang('Alert!')</strong> {{ session('alert') }}
    </div>
@endif

@if(!isset($form))
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>@lang('Error!')</strong> {{ $error }}
            </div>
        @endforeach
    @endif
@endif
