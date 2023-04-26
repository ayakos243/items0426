@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-10">
            <div class="card">
                <div class="card-header">

                <!-- 検索機能 -->
                <form method="GET" action="{{ route('items') }}"class="input-group">
                    <div class="form-group">
                        <input type="search" placeholder="商品名" name="search" value="@if (isset($search)) {{ $search }} @endif" class="form-control input-group-prepend">
                    </div>
                    <div>
                        <button type="submit" id="btn-search" class="btn btn-default" value="検索">検索</button>
                    </div>
                    <div>
                        <button class="btn btn-default"><a href="{{ route('items') }}">クリア</a></button>
                    </div>
                </form>
                <p style="color:blue">{{ session('message') }}</p>
                <div class="card-tools">
                        <div class="input-group input-group-sm">
                        <!-- ダウンロードボタン -->
                            <div class="input-group-append">
                                <a href="{{ route('download')}}" class="btn btn-default">ダウンロード</a>
                            </div>
                            <div class="input-group-append">
                                <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
                            </div>
                        </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th>種別</th>
                                <th>画像</th>
                                <th></th>
                                <th></th>                            
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td><img src="data:image/jpg;base64, {{ $item->image }}" width="25%"></td>
                                    <td><button type="button" class="btn btn-primary" onclick="location.href='/items/detail/{{ $item->id }}'">詳細</button></td>
                                </tr>
                            @endforeach
                        </tbody>
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
