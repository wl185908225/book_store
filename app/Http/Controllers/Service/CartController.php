<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M3Result;
use App\Entity\CartItem;

class CartController extends Controller
{
  public function addCart(Request $request,$product_id)
  {
    $bk_cart = $request->cookie('bk_cart');
    $bk_cart_arr = !empty($bk_cart) ? explode(',', $bk_cart) : array();

    $count = 1;
    foreach ($bk_cart_arr as &$value)   //&引用，此处需要传引用
    {
        $pindex = strpos($value, ':');
        if(substr($value, 0, $pindex) == $product_id) 
        {
            $count = ((int)substr($value, $pindex + 1)) + 1;
            $value = $product_id . ':' . $count;
            break;
        }
    }


    if($count == 1) 
    {
        //没有找到，追加
        array_push($bk_cart_arr, $product_id . ':' . $count);
    }


    $m3_result = new M3Result;
    $m3_result->status = 0;
    $m3_result->message = '添加成功';
    return response($m3_result->toJson())->withCookie('bk_cart', implode(',', $bk_cart_arr));
  }

  public function deleteCart(Request $request)
  {
    $m3_result = new M3Result;
    $m3_result->status = 0;
    $m3_result->message = '删除成功';

    $product_ids = $request->input('product_ids', '');
    if(empty($product_ids)) 
    {
        $m3_result->status = 1;
        $m3_result->message = '书籍ID为空';
        return $m3_result->toJson();
    }

    $product_ids_arr = explode(',', $product_ids);

    $member = $request->session()->get('member', '');
    if(!empty($member))
    {
        //已登录
        CartItem::where('member_id', $member->id)->whereIn('product_id', $product_ids_arr)->delete();
        return $m3_result->toJson();
    }

    $bk_cart = $request->cookie('bk_cart');
    $bk_cart_arr = !empty($bk_cart) ? explode(',', $bk_cart) : array();
    foreach ($bk_cart_arr as $key => $value) {
        $index = strpos($value, ':');
        $product_id = substr($value, 0, $index);
        
        //存在，删除
        if(in_array($product_id, $product_ids_arr))
        {
            unset($bk_cart_arr[$key]);
            continue;
        }
    }

    return response($m3_result->toJson())->withCookie('bk_cart', implode(',', $bk_cart_arr));
  }

}
