<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use App\Products;

class ProductController extends Controller
{
    public function addProduct(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
           $product = new Products;
           $product->name=$data['product_name'];
           $product->code=$data['product_code'];
           $product->color=$data['product_color'];
           if(!empty($data['product_description'])){
               $product->description=$data['product_description'];
           }else{
            $product->description='';
           }
           $product->price=$data['product_price'];
           //Upload image
           if($request->hasfile('image')){
               echo $img_tmp=Input::file('image');
               if($img_tmp->isValid()){
               //image path code
               $extension=$img_tmp->getClientOriginalExtension();
               $filename = rand(111,99999).'.'.$extension;
               $img_path = 'uploads/product/'.$filename;
               //image resize
               Image::make ($img_tmp)->resize(500,500)->save($img_path);
               $product->image= $filename;
            }
           }
           $product->save();
           return redirect('/admin/add-Product')->with('flash_message_success','Product has been success fully add');
        }
        return view ('admin.products.add_product');
    } 
}