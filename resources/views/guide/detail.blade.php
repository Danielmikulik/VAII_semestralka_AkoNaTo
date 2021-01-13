@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="col-8 container-fluid content-section">
            <div class="col-auto">
                <img src="{{ url('/guides/'.$guide['image_path']) }}" class="img-fluid img-thumbnail img-detail" alt="">
            </div>
            <br>
            <div class="d-flex w-100 justify-content-between ">
                <h5 class="mb-1 title-preview"> {{ $guide['title'] }}</h5>
            </div>
            <br>
            <p class="mb-1 justify">{{ $guide['description'] }}</p>
            <br>
            <form method="post">
                <a href="{{ route('guide.edit', [$guide]) }}" name="delete" class="btn btn-primary">Upraviť</a>
                <a href="{{ route('guide.delete', [$guide]) }}" name="delete" class="btn btn-danger">Zmazať</a>
            </form>
        </section>
    </div>
@endsection
