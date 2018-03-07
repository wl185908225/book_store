<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\OrderItem;

use Log;

class OrderController extends Controller
{
    public function toOrderCommit(Request $request, $product_ids)
    {
        $product_ids_arr = !empty($product_ids) ? explode(',', $product_ids) : array();
        $member = $request->session()->get('member', '');
        $cart_items = CartItem::where('member_id', $member->id)->whereIn('product_id', $product_ids_arr)->get();

        $cart_items_arr = array();
        $total_price = 0;
        $name = '';
        foreach ($cart_items as $cart_item) {
            $cart_item->product = Product::find($cart_item->product_id);
            if(!empty($cart_item->product))
            {
                $total_price += $cart_item->product->price * $cart_item->count;
                $name .= "<<" . $cart_item->product->name . ">>";
                array_push($cart_items_arr, $cart_item);
            }
        }


        $order = new Order();
        $order->name = $name;
        $order->total_price = $total_price;
        $order->member_id = $member->id;
        $order->save(); //新建
        $order->order_no = "E" . time() . $order->id;
        $order->save(); //更新


        foreach ($cart_items_arr as $cart_item) {
            $order_item = new OrderItem;
            $order_item->order_id = $order->id;
            $order_item->product_id = $cart_item->product_id;
            $order_item->count = $cart_item->count;
            $order_item->pdt_snapshot = json_encode($cart_item->product);
            $order_item->save();
        }

        return view('order_commit')->with('cart_items', $cart_items_arr)
                                   ->with('total_price', $total_price);
    }


    public function toOrderList(Request $request)
    {
        $member = $request->session()->get('member', '');
        $orders = Order::where('member_id', $member->id)->get();
        foreach ($orders as $order) {
            $order_items = OrderItem::where('order_id', $order->id)->get();
            $order->order_items = $order_items;

            foreach ($order_items as $key => $order_item) {
                $order_item->product = json_decode($order_item->pdt_snapshot);
            }
        }

        //删除购物车中的数据, 数据已生成订单了
        CartItem::where('member_id', $member->id)->delete();

        return view('order_list')->with('orders', $orders);
    }
}
