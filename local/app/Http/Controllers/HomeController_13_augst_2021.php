<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Theme;
use Cart;
use Auth;
use DB;
use App\User;
use Response;
use Hash;
use session;
use App\CustomerCart;
use Illuminate\Support\Facades\Cache;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     $this->checkSales = session()->get('sales');
        //     if(!empty($this->checkSales)){
                
        //         //pr($this->checkSales);
        //         return redirect()->route('SalesDashboard');
        //     }
        //     return $next($request);
        // });
    //    $this->middleware('customerLogoutAfterSomeDays',['except' => ['login','showCustomerLoginForm','salesLoginLayout','dashboard','home']]);
        //$this->middleware('auth');//
    }

    public function salesLoginLayout()
    {
        // $check = Cache::get('salesLogoutAfterSomeDays');
        
        // if(!empty($check)){
        //     // echo $check;exit;
        //     return redirect()->route('SalesDashboard');
        // }
        return view('auth.sales_login');
    }
    

    public function addGalleryImage(Request $request, $item_id)  //item gallary uploads
    {

        
        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $filename = "img_2" .rand(10,100). "_" . date('Ymshis') . '.' . $file->getClientOriginalExtension();


            $destinationPath = ITEM_IMG_PATH;
            $file->move($destinationPath, $filename);

            
            $itemData = DB::table('tbl_item_gallery')->insert([
                'item_id' => $item_id,
                'img_name' => $filename,
                'alt_tag' => '43',
                'created_by' => 43545,
            ]);
    
        $defaultImg = DB::table('tbl_item_gallery')->where('item_id', $item_id)->first();
        DB::table('tbl_item_gallery')->where('item_id',$item_id)->where('id', $defaultImg->id)
            ->update(['default' => 1]);

        return Response::json([
            'message' => 'Image saved Successfully'
        ], 200);
            
        }

      
       
        
            
            
          
    }

    public function index()
    {
        // if(function_exists('mcrypt_encrypt')) {
        //     echo "mcrypt is loaded!";
        // } else {
        //     echo "mcrypt isn't loaded!";
        // }

        // if (extension_loaded('mcrypt')) {
        //     echo "mcrypt is loaded!";
        // } else {
        //     echo "mcrypt isn't loaded!";
        // }
        
        // Cart::add(455, 'Sample Item', 100.99, 2, array());
        // $cartTotalQuantity = Cart::getTotalQuantity();
        // print_r($cartTotalQuantity);
        // die;
        //$pdf = genratePdfItemOrderByOrderId('000039');
       
        //$pdf->download('Order.pdf');
        if(@Auth::user()){
            
            $customerCartLists = CustomerCart::where('customer_id', Auth::user()->id)
            //->groupBy('customer_id')
            ->get();
            //pr($customerCartLists);
            if(count($customerCartLists)>0){
                \Cart::clear();
                foreach($customerCartLists as $customerCartList){
                    \Cart::remove($customerCartList->item_id); 
                    $itemDataArr = DB::table('tbl_items')->where('item_id', $customerCartList->item_id)->first();
                
                    \Cart::add(array(
                        'id' => $itemDataArr->item_id, // inique row ID
                        'name' => $itemDataArr->item_name,
                        'price' =>($itemDataArr->regular_price)? $itemDataArr->regular_price:0,
                        'quantity' => ($customerCartList->qty)? $customerCartList->qty:$itemDataArr->item_invt_min_order,
                        'attributes' => array()
                    ));
                }
            }else{
                \Cart::clear();
            }
        }
        if(@Auth::user()->user_type ==2){
            return redirect()->route('SalesDashboard');
        }else{

            return $this->FrontEnd();
        }



    }
    public function FrontEnd(){
        // pr(Cache::get('AdminLogoutAfterSomeDays'));
        $theme = Theme::uses('default')->layout('layout');
        $data=["name"=>''];
        return $theme->scope('index', $data)->render();
    }

    public function dashboard(){
        
        //pr(Cache::get('logoutSomeDays'));
        $theme = Theme::uses('backend')->layout('layout');
        
        $data=["name"=>''];
       
            return $theme->scope('index', $data)->render();
       
        
    }
   

    

    public function showCustomerLoginForm(){
        //pr(Cache::get('logoutSomeDays'));
        //$theme = Theme::uses('backend')->layout('layout');
        // $check = Cache::get('logoutSomeDays');
         
        // if(!empty($check)){
        //     return redirect('/');
        // }
        return view('auth.customer_login');
    }

    public function salesLogin(Request $request){
      
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        //pr($request->all());
        $seller = User::where('email', $request->email)->first();
        //  pr($seller);
        //Auth::attempt(['email' => $request->email, 'password' => hash::make($request->password)])
        if (Hash::check($request->password, $seller->seller_password))
        {
            exit('success');
            //Auth::login($seller);
            
            return redirect()->route('SalesDashboard');
            
        }else{
            exit('fail');
            return redirect()->route('salesLoginLayout')->with('msg','Invalid Email Or Password.');
           
        }

    }

}
