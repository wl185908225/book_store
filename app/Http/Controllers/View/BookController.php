<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductContent;
use App\Entity\ProductImage;
use App\Entity\CartItem;
use Log;

class BookController extends Controller
{
  public function toCatetory()
  {
    Log::info("进入书籍类别");
    $categorys = Category::whereNull('parent_id')->get();
    return view('category')->with('categorys', $categorys);
  }

  public function toProduct($category_id)
  {
    $products = Product::where('category_id', $category_id)->get();
    return view('product')->with('products', $products); 
  }

  public function toPdtContent(Request $request, $product_id)
  {
    $product = Product::find($product_id);
    $pdt_content = ProductContent::where('product_id', $product_id)->first();
    $pdt_images = ProductImage::where('product_id', $product_id)->orderBy('image_no', 'asc')->get();

    $count = 0;

    $member = $request->session()->get('member', '');
    if($member != '') {
      $cart_items = CartItem::where('member_id', $member->id)->get();

      foreach ($cart_items as $cart_item) {
        if($cart_item->product_id == $product_id) {
          $count = $cart_item->count;
          break;
        }
      }
    } else {
      $bk_cart = $request->cookie('bk_cart');
      $bk_cart_arr = !empty($bk_cart) ? explode(',', $bk_cart) : array();

      foreach ($bk_cart_arr as $value) { 
        $pindex = strpos($value, ':');
        if(substr($value, 0, $pindex) == $product_id) {
          $count = (int) substr($value, $pindex+1);
          break;
        }
      }
    }


    return view('pdt_content')->with('product', $product)
                              ->with('pdt_content', $pdt_content)
                              ->with('pdt_images', $pdt_images)
                              ->with('count', $count); 
  }
}
