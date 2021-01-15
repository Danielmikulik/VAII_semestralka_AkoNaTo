<div class="form-group text-danger">
    @foreach($errors->all() as $error)
        {{ $error }}<br>
    @endforeach
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @method($method)
    <div class="form-group">
        <label for="title">Názov</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Názov" value="{{ old('Názov', @$model->title) }}" maxlength="255" required>
    </div>
    <div class="form-group">
        <label for="description">Popis</label>
        <textarea class="form-control" id="description" name="description" rows="5" placeholder="Popis" required>{{ old('Popis', @$model->description) }}</textarea>
    </div>
    <div class="form-group">
        <label for="image">Obrázok</label>
        @if(@$model->image_path != null)
        <br>
        <img src="{{ url('/guides/'.@$model->image_path) }}" class="img-fluid img-thumbnail img-preview" alt="">
        @endif
        <input type="file" class="form-control" id="image" name="image">
    </div>
    <hr/>

    <div id="addStep" data-repeater-list="addstep">

        @foreach($steps as $step)
            <div class="form-group">
                <hr>
                <div class="form-group">
                    <label for="step">Krok{{ $loop->index + 1 }}</label>
                    <input type="text" class="form-control" id="step" name="addstep[{{ $loop->index }}][step]" placeholder="Krok" value="{{ old('Krok', @$step->step) }}" maxlength="255" required>
                </div>
                <div class="form-group">
                    <label for="procedure">Postup</label>
                    <textarea class="form-control" name="addstep[{{ $loop->index }}][procedure]" rows="5" placeholder="Postup" required>{{ old('Postup', @$step->procedure) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="image_step">Obrázok</label>
                    @if(@$model->image_path != null)
                        <br>
                        <img src="{{ url('/guide_steps/'.@$step->image_path) }}" class="img-fluid img-thumbnail img-preview" alt="">
                    @endif
                    <input type="file" class="form-control" name="addstep[{{ $loop->index }}][image_step]">
                </div>
                <div class="form-group d-inline-flex p-2">
                    <button type="button" class="justify-content-center btn btn-danger form-control" name="remove">Odstrániť krok</button>
                </div>
            </div>
        @endforeach

    </div>

    <div class="form-group d-inline-flex p-2">
        <button type="button" class="justify-content-center btn btn-primary form-control" id="add" name="add">Pridať krok</button>
    </div>
    <hr>

    <div class="form-group d-inline-flex p-2">
        <input type="submit" class="justify-content-center btn btn-primary form-control" value="Odoslať">
    </div>
</form>

<script type="text/javascript">
    var i = 0;

    $("#add").click(function(){
        $("#addStep").append(
            '<div class="form-group">\n' +
            '<hr>\n' +
            '      <div class="form-group">\n' +
            '          <label for="step">Krok '+(i + 1)+'</label>\n' +
            '          <input type="text" class="form-control" id="step" name="addstep['+i+'][step]" placeholder="Krok" value="" maxlength="255" required>\n' +
            '      </div>\n' +
            '      <div class="form-group">\n' +
            '          <label for="procedure">Postup</label>\n' +
            '          <textarea class="form-control" name="addstep['+i+'][procedure]" rows="5" placeholder="Postup" required></textarea>\n' +
            '      </div>\n' +
            '      <div class="form-group">\n' +
            '          <label for="image_step">Obrázok</label>\n' +
            '          <input type="file" class="form-control" name="addstep['+i+'][image_step]">\n' +
            '      </div>\n' +
            '      <div class="form-group d-inline-flex p-2">\n' +
            '          <button type="button" class="justify-content-center btn btn-danger form-control" name="remove">Odstrániť krok</button>\n' +
            '      </div>\n' +
            '</div>');
        ++i;
    });

    $(document).on('click', '.btn-danger', function(){
        --i;
        $(this).parent().parent().remove();
    });
</script>
