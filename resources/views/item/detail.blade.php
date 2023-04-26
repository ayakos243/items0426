@extends('adminlte::page')
@section('title', '商品詳細情報')

@section('content_header')
    <h1>商品詳細情報</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品詳細</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-default" onclick="location.href='/items/edit/{{ $item->id }}'">編集</button>
                                <form method="POST" action="{{ route('delete', $item->id) }}" onSubmit="return checkDelete()">
                                @csrf
                                <button type="submit" class="btn btn-default" onclick=>削除</button>
                                <!-- <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr><td>ID</td><td>{{ $item->id }}</td></tr>
                            <tr><td>名前</td><td>{{ $item->name }}</td></tr>
                            <tr><td>種別</td><td>{{ $item->type }}</td></tr>
                            <tr><td>詳細</td><td style="white-space:normal;">{{ $item->detail }}</td></tr>
                            <tr><td>画像</td><td>@if ($item->image !=='')<img src="data:image/jpg;base64, {{ $item->image }}" width="25%">@else<img src="{{ \Storage::url('item/noimage.png') }}">@endif</td></tr>                            
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
