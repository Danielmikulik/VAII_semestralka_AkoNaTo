<div class="form-group text-danger">
    @foreach($errors->all() as $error)
        {{ $error }}<br>
    @endforeach
</div>
<form method="post" action="{{ $action }}">
    @csrf
    @method($method)
    <div class="form-group">
        <label for="name">Full name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Full name" value="{{ old('name', @$model->name) }}">
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Email address" value="{{ old('email', @$model->email) }}">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="password">Confirm password</label>
        <input type="password" class="form-control" id="password" name="password_confirmation" placeholder="Confirm password">
    </div>
    <div class="form-group d-inline-flex">
        <input type="submit" class="btn btn-primary form-control">
        <a href="{{ route('user.delete', [$model]) }}" name="delete" class="btn btn-danger offset-1">Zmazať</a>
    </div>
</form>
