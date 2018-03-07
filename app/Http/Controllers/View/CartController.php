<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entity\Product;
use App\Entity\CartItem;

class CartController extends Controller
{
  public function toCart(Request $request)
  {
    $cart_items = array();

    $bk_cart = $request->cookie('bk_cart');
    $bk_cart_arr = !empty($bk_cart) ? explode(',', $bk_cart) : array();

    $member = $request->session()->get('member', '');
    if(!empty($member))
    {
        //已登陆同步购物车数据
        $cart_items = $this->sysncCart($member->id, $bk_cart_arr);
        return response()->view('cart', ['cart_items' => $cart_items])->withCookie('bk_cart', null);  //最后cookie清空
    }


    $count = 1;
    foreach ($bk_cart_arr as $key => $value) 
    {
        $pindex = strpos($value, ':');

        $cart_item = new CartItem;
        $cart_item->id = $key;
        $cart_item->product_id = substr($value, 0, $pindex);
        $cart_item->count = (int)substr($value, $pindex + 1);
        $cart_item->product = Product::find($cart_item->product_id);
        if(!empty($cart_item->product))
        {
            array_push($cart_items, $cart_item);
        }
    }

    return view('cart')->with('cart_items', $cart_items);
  }


  private function sysncCart($member_id, $bk_cart_arr)
  {
    $cart_items = CartItem::where('member_id', $member_id)->get();

    $cart_items_arr = array();
    foreach ($bk_cart_arr as $value) {
      $index = strpos($value, ':');
      $product_id = substr($value, 0, $index);
      $count = (int) substr($value, $index+1);

      // 判断离线购物车中product_id 是否存在 数据库中
      $exist = false;
      foreach ($cart_items as $temp) {
        if($temp->product_id == $product_id) {
          //if($temp->count < $count) {
            $temp->count += $count;
            $temp->save();
          //}
          $exist = true;
          break;
        }
      }

      // 不存在则存储进来
      if($exist == false) {
        $cart_item = new CartItem;
        $cart_item->member_id = $member_id;
        $cart_item->product_id = $product_id;
        $cart_item->count = $count;
        $cart_item->save();
        $cart_item->product = Product::find($cart_item->product_id);
        array_push($cart_items_arr, $cart_item);
      }
    }

    // 为每个对象附加产品对象便于显示
    foreach ($cart_items as $cart_item) {
      $cart_item->product = Product::find($cart_item->product_id);
      array_push($cart_items_arr, $cart_item);
    }

    return $cart_items_arr;
  }
}
