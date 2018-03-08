<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\M3Result;
use App\Entity\Member;
use App\Entity\TempPhone;
use App\Entity\TempEmail;
use App\Models\M3Email;
use App\Tool\UUID;
use Mail;
use Log;
use Session;

class MemberController extends Controller
{
  public function register(Request $request)
  {
    $email = $request->input('email', '');
    $phone = $request->input('phone', '');
    $password = $request->input('password', '');
    $confirm = $request->input('confirm', '');
    $phone_code = $request->input('phone_code', '');
    $validate_code = $request->input('validate_code', '');

    $m3_result = new M3Result;

    if($email == '' && $phone == '') {
      $m3_result->status = 1;
      $m3_result->message = '手机号或邮箱不能为空';
      return $m3_result->toJson();
    }
    if($password == '' || strlen($password) < 6) {
      $m3_result->status = 2;
      $m3_result->message = '密码不少于6位';
      return $m3_result->toJson();
    }
    if($confirm == '' || strlen($confirm) < 6) {
      $m3_result->status = 3;
      $m3_result->message = '确认密码不少于6位';
      return $m3_result->toJson();
    }
    if($password != $confirm) {
      $m3_result->status = 4;
      $m3_result->message = '两次密码不相同';
      return $m3_result->toJson();
    }

    // 手机号注册
    if($phone != '') {
      if($phone_code == '' || strlen($phone_code) != 6) {
        $m3_result->status = 5;
        $m3_result->message = '手机验证码为6位';
        return $m3_result->toJson();
      }

      $tempPhone = TempPhone::where('phone', $phone)->first();
      if(empty($tempPhone))
      {
        //不在测试号码中，无法获取短信验证码，无法生成temp_phone记录
        $m3_result->status = 10;
        $m3_result->message = '手机号码不在测试序列中';
        return $m3_result->toJson();
      }

      if($tempPhone->code == $phone_code) {
        if(time() > strtotime($tempPhone->deadline)) {
          $m3_result->status = 7;
          $m3_result->message = '手机验证码不正确';
          return $m3_result->toJson();
        }

        $member = Member::where('phone', $phone)->first();
        if(!empty($member))
        {
          $m3_result->status = 9;
          $m3_result->message = '手机号已存在';
          return $m3_result->toJson();
        }

        $member = new Member;
        $member->phone = $phone;
        $member->password = md5('bk' . $password);
        $member->save();

        $m3_result->status = 0;
        $m3_result->message = '注册成功';
        return $m3_result->toJson();
      } else {
        $m3_result->status = 7;
        $m3_result->message = '手机验证码不正确';
        return $m3_result->toJson();
      }

    // 邮箱注册
    } else {
      if($validate_code == '' || strlen($validate_code) != 4) {
        $m3_result->status = 6;
        $m3_result->message = '验证码为4位';
        return $m3_result->toJson();
      }

      $validate_code_session = \Request::get('validate_code', '');
      Log::info('campare:$validate_code_session:' . $validate_code_session . '||$validate_code:' . $validate_code);
      if($validate_code_session !== $validate_code) {
        $m3_result->status = 8;
        $m3_result->message = '验证码不正确';
        return $m3_result->toJson();
      }


      $member = Member::where('email', $email)->first();
      if(!empty($member))
      {
        $m3_result->status = 9;
        $m3_result->message = '邮箱已存在';
        return $m3_result->toJson();
      }

      $member = new Member;
      $member->email = $email;
      $member->password = md5('bk' . $password);
      $member->save();

      $uuid = UUID::create();
      $m3_email = new M3Email;
      $m3_email->to = $email;
      $m3_email->cc = '185908225@qq.com';
      $m3_email->subject = '威廉书店验证';
      $m3_email->content = '请于24小时点击该链接完成验证. ' . env('server_name') . '/service/validate_email'
                        . '?member_id=' . $member->id
                        . '&code=' . $uuid;

      $tempEmail = new TempEmail;
      $tempEmail->member_id = $member->id;
      $tempEmail->code = $uuid;
      $tempEmail->deadline = date('Y-m-d H-i-s', time() + 24*60*60);
      $tempEmail->save();

      Mail::send('email_register', ['m3_email' => $m3_email], function ($m) use ($m3_email) {
          // $m->from('hello@app.com', 'Your Application');
          $m->to($m3_email->to, '尊敬的用户')
            ->cc($m3_email->cc)
            ->subject($m3_email->subject);
      });

      $m3_result->status = 0;
      $m3_result->message = '注册成功';
      return $m3_result->toJson();
    }
  }

  public function validateEmail(Request $request)
  {
    $member_id = $request->input('member_id', '');
    $code = $request->input('code', '');
    if($member_id == '' || $code == '') {
      return '验证异常';
    }

    $tempEmail = TempEmail::where('member_id', $member_id)->first();
    if($tempEmail == null) {
      return '验证异常';
    }

    if($tempEmail->code == $code) {
      if(time() > strtotime($tempEmail->deadline)) {
        return '该链接已失效';
      }

      $member = Member::find($member_id);
      $member->active = 1;
      $member->save();

      return redirect('/login');
    } else {
      return '该链接已失效';
    }
  }


  public function login(Request $request)
  {
    $username = $request->input('username', '');
    $password = $request->input('password', '');
    $validate_code = $request->input('validate_code', '');

    $m3_result = new M3Result;
    //检验
    //...

    //判断
    if(empty($username))
    {
      $m3_result->status = -1;
      $m3_result->message = '账号不可为空';
      return $m3_result->toJson();
    }

    if(empty($password))
    {
      $m3_result->status = -2;
      $m3_result->message = '密码不可为空';
      return $m3_result->toJson();
    }


    $validate_code_session = \Request::get('validate_code', '');
    if($validate_code != $validate_code_session)
    {
      $m3_result->status = 1;
      $m3_result->message = '验证码不正确';
      return $m3_result->toJson();
    }


    if(strpos($username, '@'))
    {
      $member = Member::where('email', $username)->first();
    } else 
    {
      $member = Member::where('phone', $username)->first();
    }

    if(empty($member))
    {
      $m3_result->status = 2;
      $m3_result->message = '该用户不存在';
      return $m3_result->toJson();
    } else 
    {
      if(md5('bk' . $password) != $member->password)
      {
        $m3_result->status = 3;
        $m3_result->message = '密码不正确';
        return $m3_result->toJson();
      }
    }

    Session::put('member', $member);

    $m3_result->status = 0;
    $m3_result->message = '登录成功';
    return $m3_result->toJson();
  }
}
