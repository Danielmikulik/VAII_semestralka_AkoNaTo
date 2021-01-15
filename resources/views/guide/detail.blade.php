@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="col-8 container-fluid content-section">
            <div class="col-auto">
                <img src="{{ url('/guides/'.$guide['image_path']) }}" class="img-fluid img-thumbnail img-detail" alt="">
            </div>
            <br>
            <div class="d-flex w-100 justify-content-between ">
                <h3 class="mb-1 title-preview"> {{ $guide['title'] }}</h3>
            </div>
            <br>
            <p class="mb-1 justify"><h5>Popis:</h5> {{ $guide['description'] }}</p>
            <hr>

            @foreach($steps as $step)
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 title-preview">Krok {{ $loop->index + 1 }}: {{ $step->step }}</h5>
                </div>
                <div class="col-auto">
                    <img src="{{ url('/guide_steps/'.$step->image_path) }}" class="img-fluid img-thumbnail img-detail" alt="">
                </div>
                <br>
                <p class="mb-1 text-preview">{{ $step->procedure }}</p>
                <br>
            @endforeach

            <hr>
                <a href="{{ route('guide.edit', [$guide]) }}" name="delete" class="btn btn-primary">Upraviť</a>
                <a href="{{ route('guide.delete', [$guide]) }}" name="delete" class="btn btn-danger">Zmazať</a>
        </section>
    </div>
@endsection
