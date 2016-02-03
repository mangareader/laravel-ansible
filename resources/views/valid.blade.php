@if($errors->has())
    <div class="alert alert-danger">
        <i class="fa fa-ban"></i>
        {{ $errors->first() }}
    </div>
@endif
@if(Session::has('success'))
    <div class="alert alert-success">
        <i class="fa fa-check"></i>
        {{ Session::get('success') }}
    </div>
@endif