<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index()
    {
        // 商品一覧取得
        $items = Item
            ::where('items.status', 'active')
            ->select()
            ->get();

        return view('item.index', compact('items'));
    }

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ]);

    //     //商品のデータを受け取る
    //     $inputs = $request->all();

        // \DB::beginTransaction();
        // // try {
        // //商品を登録
        // // $item = Item::find($inputs['id']); 
        // $item->fill([
        //     'id' => $inputs['id'],
        //     'name' => $inputs['name'],
        //     'detail' => $inputs['detail'],
        //     'type' => $inputs['type'],
        //     'image' => $inputs['image'],
        // ]);

        // $item->save();
        // \DB::commit();
        // } catch(\Throwable $e) {
        //     \DB::rollback();
        //     abort(500);
        // }
        return redirect(route('items'));
    }


    /**
     * 商品登録画面を表示
     */
    public function create(){
        return view('item.add');
    }

    // 画像をリクエストして保存する
    public function store(Request $request)
    {

        // 画像フォームでリクエストした画像情報を取得
        $image = $request->file('image');

        //ファイルの保存とパスの取得
        $path = isset($image)?$image->store('image','public'):"";
    
        // データベースに登録する処理
        Item::update([
            'user_id' => 1, // TODO
            'name' => $request ->name,
            'type' => $request ->type,
            'detail' => $request -> detail,
            'image' => $path,
        ]);
    
            return redirect('/items');
        }

        return view('item.add');
    }
}
