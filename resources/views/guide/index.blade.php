@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="col-12 container-fluid content-section">
            <div class="list-group">

                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('guide.create') }}" class="btn btn-sm btn-success" role="button">Pridať návod</a>
                    </div>
                </div>

                @foreach($guides as $guide)
                    <a href="{{ route('guide.show', [$guide['id']]) }}" class="list-group-item list-group-item-action flex-column align-items-start custom-card">
                        <div class="row no-gutters">
                            <div class="col-auto">
                                <img src="{{ url('/guides/'.$guide['image_path']) }}" class="img-fluid img-thumbnail img-preview" alt="">
                            </div>
                            <div class="col card-block px-2">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1 title-preview">{{ $guide['title'] }}</h5>
                                </div>
                                <br>
                                <p class="mb-1 text-preview">{{ $guide['description'] }}</p>
                                <div class="date">
                                    <small class="date">{{ $guide['created_at'] }}</small>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
        </section>
    </div>
@endsection
