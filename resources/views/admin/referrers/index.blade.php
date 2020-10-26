@extends('layouts.admin')

@section('breadcrumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Referrers</h1>
    </div>
    {{-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
        </ol>
    </div> --}}
</div>
@endsection


@section('content')
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add referrer</h3>
            </div>
            <div class="card-body">
                <form action="{{route('referrers.store')}}" method="post">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-5">* Name</label>
                        <div class="col-sm-7">
                            <input type="text" name="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                maxlength="255" 
                                required
                                value="{{old('name')}}"
                            >
                            @error('name')
                            <div class="invalid-feedback d-block">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Referrers</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        {{-- <th>created at</th> --}}
                        <th>deleted at</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($referrers as $referrer)
                    <tr>
                        <td>{{$referrer->id}}</td>
                        <td>{{$referrer->name}}</td>
                        {{-- <td>{{$category->created_at}}</td> --}}
                        <td>{{$referrer->deleted_at ? $referrer->deleted_at : ''}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="First group">
                                @if(!$referrer->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'referrerDestroyForm-{{$referrer->id}}',
                                        'Remove the referrer',
                                        'Do you want to remove {{$referrer->name}} from the referrers?',
                                        'question',
                                        'Delete'
                                    )"
                                >
                                    <i class="fas fa-trash"></i>
                                    <form action="{{route('referrers.destroy', $referrer->id)}}" method="post"
                                        id="referrerDestroyForm-{{$referrer->id}}"
                                    >
                                        @csrf @method('delete')
                                    </form>
                                </a>
                                @endif
                                @if($referrer->deleted_at)
                                <a href="javascript:;" type="button" class="btn btn-outline-secondary btn-sm"
                                    @click="confirm_form_before_submit(
                                        'referrerRestoreForm-{{$referrer->id}}',
                                        'Restore the referrer',
                                        'Do you want to restore the {{$referrer->name}} in the referrers?',
                                        'question',
                                        'Restore'
                                    )"
                                    title="restore"
                                >
                                    <i class="fas fa-undo"></i>
                                    <form action="{{route('referrers.restore', $referrer->id)}}" method="post"
                                        id="referrerRestoreForm-{{$referrer->id}}"
                                    >@csrf</form>
                                </a>
                                @endif
                                <a href="{{route('referrers.edit', $referrer->id)}}" type="button" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection