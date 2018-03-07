@extends('admin.master')

@section('content')

  <style>
    .row.cl {
      margin: 20px 0;
    }
  </style>

<form class="form form-horizontal" action="" method="post">
  <div class="row cl">
    <label class="form-label col-xs-3 col-sm-3"><span class="c-red"></span>名称：</label>
    <div class="formControls col-xs-5 col-sm-5">
      {{$product->name}}
    </div>
    <div class="col-xs-4 col-sm-4"> </div>
  </div>
  <div class="row cl">
    <label class="form-label col-xs-3 col-sm-3"><span class="c-red"></span>简介：</label>
    <div class="formControls col-xs-5 col-sm-5">
      {{$product->summary}}
    </div>
    <div class="col-xs-4 col-sm-4"> </div>
  </div>
  <div class="row cl">
    <label class="form-label col-xs-3 col-sm-3"><span class="c-red"></span>价格：</label>
    <div class="formControls col-xs-5 col-sm-5">
      {{$product->price}}
    </div>
    <div class="col-xs-4 col-sm-4"> </div>
  </div>
  <div class="row cl">
    <label class="form-label col-xs-3 col-sm-3"><span class="c-red"></span>类别：</label>
    <div class="formControls col-xs-5 col-sm-5">
      {{$product->category->name}}
    </div>
  </div>
  <div class="row cl">
    <label class="form-label col-xs-3 col-sm-3">预览图：</label>
    <div class="formControls col-xs-5 col-sm-5">
      @if($product->preview != null)
        <img id="preview_id" src="{{$product->preview}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;"/>
      @endif
    </div>
  </div>
  <div class="row cl">
    <label class="form-label col-xs-3 col-sm-3">详细内容：</label>
    <div class="formControls col-xs-8 col-sm-8">
      {{$pdt_content->content}}
    </div>
  </div>
  <div class="row cl">
    <label class="form-label col-xs-3 col-sm-3">产品图片：</label>
    <div class="formControls col-xs-8 col-sm-8">
      @foreach($pdt_images as $pdt_image)
        <img src="{{$pdt_image->image_path}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" />
      @endforeach
    </div>
  </div>
</div>
@endsection
