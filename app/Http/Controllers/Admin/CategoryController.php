<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Entity\Category;
use Illuminate\Http\Request;
use App\Models\M3Result;


class CategoryController extends Controller
{
    public function toCategory()
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            if(!empty($category->parent_id))
            {
                $category->parent = Category::find($category->parent_id);
            } else 
            {
                $category->parent = null;
            }
        }
        return view('admin.category')->with('categories', $categories);
    }


    public function toCategoryAdd()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.category_add')->with('categories', $categories);
    }

    public function toCategoryEdit(Request $request) {
        $id = $request->input('id', '');
        $category = Category::find($id);
        $categories = Category::whereNull('parent_id')->get();

        return view('admin/category_edit')->with('category', $category)
                                          ->with('categories', $categories);
    }


    /******************Service*****************/
    public function categoryAdd(Request $request)
    {
        $name = $request->input('name', '');
        $category_no = $request->input('category_no', '');
        $parent_id = $request->input('parent_id', '');
        $preview = $request->input('preview', '');


        $m3_result = new M3Result;
        if(empty($name))
        {
            $m3_result->status = -1;
            $m3_result->message = '类别名称不可为空';
            return $m3_result->toJson();
        }
        if($category_no == null)
        {
            $m3_result->status = -2;
            $m3_result->message = '类别编号不可为空';
            return $m3_result->toJson();
        }

        // if(empty($parent_id))
        // {
        //     $m3_result->status = -3;
        //     $m3_result->message = '父类别不可为空';
        //     return $m3_result->toJson();
        // }

        $category = new Category;
        $category->name = $name;
        $category->category_no = $category_no;
        if(!empty($parent_id))
        {
            $category->parent_id = $parent_id;
        }
        $category->preview = $preview;
        $category->save();

        $m3_result->status = 0;
        $m3_result->message = '添加成功';
        return $m3_result->toJson();
    }


    public function categoryDel(Request $request) {
        $id = $request->input('id', '');
        Category::find($id)->delete();

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '删除成功';

        return $m3_result->toJson();
    }

    public function categoryEdit(Request $request) {
        $id = $request->input('id', '');
        $category = Category::find($id);

        $name = $request->input('name', '');
        $category_no = $request->input('category_no', '');
        $parent_id = $request->input('parent_id', '');
        $preview = $request->input('preview', '');

        $m3_result = new M3Result;
        
        if(empty($category))
        {
            $m3_result->status = -1;
            $m3_result->message = '类别id不存在';
            return $m3_result->toJson();
        }

        if(empty($name))
        {
            $m3_result->status = -2;
            $m3_result->message = '类别名称不可为空';
            return $m3_result->toJson();
        }
        if($category_no == null)
        {
            $m3_result->status = -3;
            $m3_result->message = '类别编号不可为空';
            return $m3_result->toJson();
        }


        $category->name = $name;
        $category->category_no = $category_no;
        if($parent_id != '') {
          $category->parent_id = $parent_id;
        }
        $category->preview = $preview;
        $category->save();

        $m3_result->status = 0;
        $m3_result->message = '添加成功';

        return $m3_result->toJson();
    }
}
