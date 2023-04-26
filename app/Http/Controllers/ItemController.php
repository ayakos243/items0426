<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use League\Csv\Writer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


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

    //商品一覧を表示する
    public function index(Request $request)
    {
        // 検索機能追加
            // 検索フォームで入力された値を取得する
            $search = $request->input('search');

            // クエリビルダ
            $query = Item::query();

        // もし検索フォームにキーワードが入力されたら
            if (!empty($search)) {

                // 全角スペースを半角に変換
                $spaceConversion = mb_convert_kana($search, 's');

                // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
                $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);

                // 単語をループで回し、商品名と部分一致するものがあれば、$queryとして保持される
                foreach($wordArraySearched as $value) {
                    $query->where('name', 'like', "%{$value}%");
                }
            }
            
        // 商品一覧取得        
            $items = $query->get();
            
        // ビューにitemsとsearchを変数として渡す
            return view('item.index',compact('items', 'search'));
    }

        //ダウンロード機能
        public function download()
        {
            $csv = Writer::createFromString('');
            $csv->insertOne(['ID', 'name','type']); // ヘッダーの設定

            $items = Item::all();
            foreach ($items as $item) {
                $csv->insertOne([$item->id, $item->name,$item->type]);
            }

            $csvName = 'items.csv';
            Storage::put($csvName, (string) $csv);
            $csvPath = Storage::path($csvName);

            return response()
                ->download($csvPath, $csvName)
                ->deleteFileAfterSend(true); // ダウンロード後、ファイルを削除
        }


    /**
     * 商品の詳細を表示
     */
    public function show($id)
    {
        $item =Item::find($id);
                if (is_null($item)){
            \Session::flash('err_msg','データがありません');
            return redirect(route('items'));
        }

        return view('item.detail',['item' => $item]);
    }

    /**
     * 商品情報編集フォームを表示する
     * @param int $id
     * @return view
     */
    public function edit($id)
    {
        $item = Item::find($id);

        if (is_null($item)){
            \Session::flash('err_msg','データがありません');
            return redirect(route('items'));
        }

        return view('item.edit',['item' => $item]);
    }

    /**
     * 商品詳細を更新する
     * 
     * @return view
     */
    public function update(Request $request, $id){

        $image = $request->file('image');

        $item = Item::find($id);
        $path = $item->image;

        // 現在の画像ファイルの削除
        if(!is_null($image)){
        \Storage::disk('public')->delete($path);
        
        // 選択された画像ファイルを保存してパスをセット
        $path = $image->store('image', 'public');
        // dd($path);        
        }
        
        $item->update([
            'name' => $request ->name,
            'type' => $request ->type,
            'detail' => $request -> detail,
            'image' => $path,
        ]);

        return redirect(route('items'))->with('message', '更新しました');
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
        $image = null;
        if(!is_null($request->file('image'))){
            $image = base64_encode(file_get_contents($request->file('image')));
        }
        // 画像フォームでリクエストした画像情報を取得


        //ファイルの保存とパスの取得
        // $path = isset($image)?$image->store('image','public'):"";
    
        // データベースに登録する処理
        Item::create([
            'user_id' =>Auth::user()->id,
            'name' => $request ->name,
            'type' => $request ->type,
            'detail' => $request -> detail,
            'image' => $image,
        ]);
    
    // 一覧へリダイレクト
    return redirect()->route('items')->with('message', '登録しました');
    }

    /**
     * 商品削除
     * @param int $id
     * @return view
     */
            public function delete($id)
        {
            //もしデータ（id）がなかったらMSG
            if (empty($id)){
                \Session::flash('err_msg','データがありません');
                return redirect(route('items'));
            }
            //データがあれdestroy実行
            try {
                // 商品を削除
                Item::destroy($id);
            } catch(\Throwable $e) {
                abort(500);
            }
            //MSGを出力して商品一覧へリダイレクト
            \Session::flash('err_msg','商品を削除しました');
            return redirect(route('items'));
        }   
}
