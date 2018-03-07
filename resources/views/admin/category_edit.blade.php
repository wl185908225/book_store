@extends('admin.master')

@section('content')
<form action="" method="post" class="form form-horizontal" id="form-category-edit">
  {{ csrf_field() }}
  <div class="row cl">
    <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>名称：</label>
    <div class="formControls col-xs-5 col-sm-5">
      <input type="text" class="input-text" value="{{$category->name}}" placeholder="" name="name" datatype="*" nullmsg="名称不能为空">
    </div>
    <div class="col-xs-4 col-sm-4"> </div>
  </div>
  <div class="row cl">
    <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>序号：</label>
    <div class="formControls col-xs-5 col-sm-5">
      <input type="number" class="input-text" value="{{$category->category_no}}" placeholder="" name="category_no"  datatype="*" nullmsg="序号不能为空">
    </div>
    <div class="col-xs-4 col-sm-4"> </div>
  </div>
  <div class="row cl">
    <label class="form-label col-xs-3 col-sm-3">父类别：</label>
    <div class="formControls col-xs-5 col-sm-5"> <span class="select-box" style="width:150px;">
      <select class="select" name="parent_id" size="1">
        <option value="">无</option>
        @foreach($categories as $temp)
          @if($category->parent_id == $temp->id)
            <option selected value="{{$temp->id}}">{{$temp->name}}</option>
          @else if($category->id != $temp->id)
            <option value="{{$temp->id}}">{{$temp->name}}</option>
          @endif
        @endforeach
      </select>
      </span>
    </div>
  </div>
  <div class="row cl">
    <label class="form-label col-xs-3 col-sm-3">预览图：</label>
    <div class="formControls col-xs-5 col-sm-5">
      @if(!empty($category->preview))
        <img id="preview_id" src="{{$category->preview}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;cursor: pointer;" onclick="$('#input_id').click()" />
      @else
        <img id="preview_id" src="/admin/images/icon-add.png" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;cursor: pointer;" onclick="$('#input_id').click()" />
      @endif
      <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','images', 'preview_id');" />
    </div>
  </div>
  <div class="row cl">
    <div class="col-xs-9 col-sm-9 col-offset-3">
      <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
    </div>
  </div>
</form>
@endsection

@section('my-js')
<script type="text/javascript">
  //表单验证
  $("#form-category-edit").validate({
      rules:{
          name:{
              required:true,
          },
          category_no:{
              required:true,
          },
          // parent_id:{
          //     required:true,
          // },
      },
      messages: {
          name: "请输入类别名称",
          category_no: "请输入类别编号",
          //parent_id: "请选择类别",
      },
      errorElement: "span",    
      onkeyup:false,
      focusCleanup:true,
      success:"valid",
      submitHandler:function(form){
          $('#form-category-edit').ajaxSubmit({
              type: 'post', // 提交方式 get/post
              url: '/admin/service/category/edit', // 需要提交的 url
              dataType: 'json',
              data: {
                  id: "{{$category->id}}",
                  name: $('input[name=name]').val(),
                  category_no: $('input[name=category_no]').val(),
                  parent_id: $('select[name=parent_id] option:selected').val(),
                  preview: ($('#preview_id').attr('src')!='/admin/images/icon-add.png'?$('#preview_id').attr('src'):''),
                  _token: "{{csrf_token()}}"
              },
              success: function(data) {
                  if(data == null) {
                    layer.msg('服务端错误', {icon:2, time:2000});
                    return;
                  }
                  if(data.status != 0) {
                    layer.msg(data.message, {icon:2, time:2000});
                    return;
                  }

                  layer.msg(data.message, {icon:1, time:2000});
                  parent.location.reload();
              },
              error: function(xhr, status, error) {
                  console.log(xhr);
                  console.log(status);
                  console.log(error);
                  layer.msg('ajax error', {icon:2, time:2000});
              },
              beforeSend: function(xhr){
                  layer.load(0, {shade: false});
              },
          });

          return false;
      }
  });
</script>
@endsection
