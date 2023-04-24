@extends('adminlte::page')

@section('title', '商品情報編集')

@section('content_header')
    <h1>商品情報編集</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <form method="POST" action="{{ route('update',['id'=>$item->id]) }}" onSubmit="return checkSubmit()" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">商品名</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="名前" value="{{ $item->name }}">
                        </div>

                        <div class="form-group">
                            <label for="type">種別</label>
                            <input type="number" class="form-control" id="type" name="type" placeholder="1, 2, 3, ..." value="{{ $item->type }}">
                        </div>

                        <div class="form-group">
                            <label for="image">画像</label>
                            <div>                          
                            @if ($item->image !=='')
                            <img src="{{ \Storage::url($item->image) }}" width="25%">
                            @else
                            <img src="{{ \Storage::url('items/no_image.png') }}">
                            @endif
                            </div>
                            <input type="file" class="form-control" id="image" name="image"  value="{{ $item->image }}">

                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="詳細説明" value="{{ $item->detail }}">
                        </div>
                    </div>

                <!-- バリデーションを受け取るための処理 もしnameのバリデーションがあったら最初のエラーを-->
                @if ($errors->has('name'))
                    <div class="text-danger">
                        {{ $errors->first('name') }}
                    </div>
                    @endif
                    </div>
                @if ($errors->has('detail'))
                    <div class="text-danger">
                        {{ $errors->first('detail') }}
                    </div>
                @endif
            

                    <div class="card-footer">
                    <!-- キャンセル時はitemes 一覧に戻る-->
                    <a class="btn btn-secondary" href="{{ route('items') }}">
                    キャンセル
                    </a>
                    <button type="submit" class="btn btn-primary">
                    更新する
                    </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
<script>
function checkSubmit(){
if(window.confirm('更新してよろしいですか？')){
    return true;
} else {
    return false;
}
}
</script>
