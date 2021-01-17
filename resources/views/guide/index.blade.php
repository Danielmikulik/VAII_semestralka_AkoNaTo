@extends('layouts.app')

@section('content')
    <div class="container">
        <section class="col-12 container-fluid content-section">
            <div class="list-group">

                @auth
                    @if(empty($author_id) || $author_id == \Illuminate\Support\Facades\Auth::id())
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('guide.create') }}" class="btn btn-sm btn-success" role="button">Pridať návod</a>
                        </div>
                    </div>
                    @endif
                @endauth

                <div class="col-md-12" id="data">
                    @include('guide.data')
                </div>
                <br>

                <div class="d-flex justify-content-center">
                    @for($i = 0; $i < 3; $i++)
                    <p class="ajax-load text-center spinner-grow" role="status" style="display: none"></p>
                    @endfor
                </div>
                <br>
                <br>
                <br>

            </div>
        </section>
    </div>

    <script>
        var allLoaded = false;
        function loadMoreGuides(page)
        {
            $.ajax({
                url:'?page=' + page,
                type: 'get',
                beforeSend: function ()
                {
                    $(".ajax-load").show();
                }
            })
                .done(function (data){
                    if (data.html == ""){
                        allLoaded = true;
                        //$('.ajax-load').removeClass('.spinner-grow');
                        //$('.ajax-load').html('Žiadne ďalšie návody neboli nájdené.')
                    }
                    $('.ajax-load').hide();
                    $("#data").append(data.html);
                })
                .fail(function (jqXHR, ajaxOption, thrownError){
                    alert("Server neodpovedá...");
                });
        }

        var page = 1;
        $(window).scroll(function(){
            if (!allLoaded && $(window).scrollTop() + $(window).height() >= $(document).height() - 1){
                page++;
                loadMoreGuides(page);
            }
        });
    </script>
@endsection
