<div class="form-group text-danger">
    @foreach($errors->all() as $error)
        {{ $error }}<br>
    @endforeach
</div>
<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @method($method)
    <div class="form-group">
        <label for="title">Názov</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Názov" value="{{ old('name', @$model->title) }}">
    </div>
    <div class="form-group">
        <label for="description">Popis</label>
        <textarea class="form-control" id="description" name="description" rows="5" placeholder="Popis">{{ old('description', @$model->description) }}</textarea>
    </div>
    <div class="form-group">
        <label for="image">Obrázok</label>
        @if(@$model->image_path != null)
        <br>
        <img src="{{ url('/guides/'.@$model->image_path) }}" class="img-fluid img-thumbnail img-preview" alt="">
        @endif
        <input type="file" class="form-control" id="image" name="image">
    </div>
    <div class="form-group d-inline-flex p-2">
        <input type="submit" class="justify-content-center btn btn-primary form-control" value="Odoslať">
    </div>
</form>
