@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Users') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @can('create', \App\Models\User::class)
                            <div class="mb-3">
                                <a href="{{ route('user.create') }}" class="btn btn-sm btn-success" role="button">Add new user</a>
                            </div>
                        @endcan

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Meno</th>
                                        <th scope="col">email</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr id="uid{{$user->id}}">
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <a href="{{ route('user.edit', [$user->id]) }}" title="Upraviť" class="btn btn-sm btn-primary">Editovať</a>
                                            <a href="javascript:void(0)" title="Zmazať" data-method="DELETE"
                                               class="btn btn-sm btn-danger" onclick="deleteUser({{$user->id}})" data-confirm="Are you sure">Zmazať</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {!! $users->links() !!}
                            </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function deleteUser(id)
    {
        if (confirm("Naozaj chcete zmazať používateľa?"))
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: 'user/' + id + '/delete',
                type: 'DELETE',
                data: {
                    token: $("input[name=csrf-token]").val()
                },
                success:function (response)
                {
                    $("#uid"+id).remove();
                }
            })
        }
    }
</script>
