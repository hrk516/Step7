<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Models\Sales;
use App\Http\Requests\ItemRequest;
use Illuminate\Database\QueryException;


class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        // 商品一覧を取得する insert処理が先 エラーになる
        $products = Product::getAllProducts();
        $companies = Company::getAllCompanies();
        return view('item_list',compact('products','companies'));
    }

    // 新規登録画面
    public function item_regist() {
        // メーカー名を取得してVに渡す
        $companies = Company::getAllCompanies();
        return view('item_regist',compact('companies'));
    }

    // 登録処理
    public function insert_item(ItemRequest $request) {
        // 送受信されたデータをすべて受け取る
        $item_list = $request -> validated();  
         // 会社IDを取得（なければ作成）
        $company_id = Company::getOrCreateCompanyId($item_list['company_id']);
        // 画像なしの初期値
        $img_path = null; 
        if ($request -> hasFile('img_path')) {
        // 画像を保存して、パスを取得
        $img_path = $request -> file('img_path') -> store('images', 'public');
        }
        $data = [
        'company_id' => $company_id,
        'product_name' => $item_list['product_name'], 
        'price' => $item_list['price'],
        'stock' => $item_list['stock'],
        'comment' => $item_list['comment'],
        'img_path' => $img_path
        ];
        try {
            $product_id = Product::createProduct($data);
            Sales::createSales($product_id -> id);
            return redirect() -> route('regist');
        } catch (QueryException $e) {
            return redirect() -> route('regist') -> with(['error' => 'データベースエラー'], 500);
        } catch (\Exception $e) {
            return redirect() -> route('regist') -> with(['error' => 'データベースエラー'], 500);
        }
    }

    // 詳細画面
    public function detail($id) {
        // クリックした商品情報を取得しVに渡す
        $detail = Product::getProduct($id);
        return view('item_detail',compact('detail'));
    }

    // 編集画面
    public function edit($id) {
        // メーカー名を取得してVに渡す
        $companies = Company::getAllCompanies();
        $item = Product::getProduct($id);
        return view('item_edit',compact('companies','id','item'));
    }
    
    // 更新処理
    public function update_item(ItemRequest $request, $id){
        $update_list = $request -> validated();
        // 既存の画像パスを取得（画像が送信されていない場合に使用する）
        $product = Product::findOrFail($id);
        $img_path = $product->img_path;
        if ($request -> hasFile('img_path')) {
            $img_path = $request -> file('img_path') -> store('images', 'public');
        }
        $update_data = [
        'company_id' => $update_list['company_id'],
        'product_name' => $update_list['product_name'], 
        'price' => $update_list['price'],
        'stock' => $update_list['stock'],
        'comment' => $update_list['comment'],
        'img_path' => $img_path
        ];
        try {
            Product::updateProduct($id, $update_data);
            return redirect() -> route('edit', [$id]);
        } catch (QueryException $e) {
            return redirect() -> route('edit', [$id]) -> with(['error' => 'データベースエラー'], 500);
        } catch (\Exception $e) {
            return redirect() -> route('edit', [$id]) -> with(['error' => '処理に失敗しました'], 500);
        }
    }

    //削除処理
    public function delete_item(Request $request) {
        $id = $request -> input('id'); 
        try {
            Product::deleteProduct($id);
            return redirect() -> route('home');
        } catch (QueryException $e) {
            return redirect() -> route('home') -> with(['error' => 'データベースエラー'], 500);
        } catch (\Exception $e) {
            return redirect() -> route('home') -> with(['error' => '処理に失敗しました'], 500);
        }
    }

    //検索処理
    public function search(Request $request) {
        $searchData = [
            'keyword' => $request -> input('keyword'),
            'company_id' => $request -> input('company_id')
        ];
            $products = Product::searchProduct($searchData);
            $CompanyName = Company::searchCompany($searchData);
        // Ajaxの場合はJSONで返す
        if ($request->ajax()) {
            return response()->json(['products' => $products, 'CompanyName' => $CompanyName]);
        }
        $companies = Company::getAllCompanies();
        return view('item_list',compact('products','companies'));
    }
}
