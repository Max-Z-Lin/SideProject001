<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Repository\UserRepository;
use JWTAuth;
use Maatwebsite\Excel\Facades\Excel;
use App\Export\ImageExport;
use phpDocumentor\Reflection\Types\Boolean;


class UserController extends Controller
{
    protected $userRepository;

    protected $id, $name, $email, $password, $gender;

    //Repository建構子
    public function __construct(UserRepository $userRepository, Request $request)
    {
        $this->userRepository = $userRepository;

    }

    //登入驗證
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password'); //取出request的email及password
        //$expire = JWTAuth::factory()->setTTL(120);
        $token = JWTAuth::attempt($credentials);    //透過JWTAuth::attempt來驗證email及password
        try {
            if (!$token) {    //如果驗證失敗，回傳顯示無效
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (\JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json([
            'token' => $token,
        ]);
    }

    //註冊資料
    public function register(Request $request)
    {
        //驗證資料是否符合規範
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'gender' => 'boolean'
        ]);

        //如果輸入的資料不符合規範，則印出error message
        if ($validator->fails()) {
            return response()->json([
                'error message' => $validator->errors(),
                'erroe code' => 400]);
        }
        $user = $this->userRepository->createUser($request);

        //將使用者資料透過JWTAuth::fromUser產生token
        $token = JWTAuth::fromUser($user);


        return response()->json([
            'data' => $user,
            'token' => $token,
            'error code' => 201]);
    }

    //利用token讀取資料
    public function getAuthUser()
    {
        try {

            $data = $this->jwtAuth();

            return response()->json([
                'data' => $data,
                'massage' => 'success'
            ]);

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token absent'], $e->getStatusCode());

        }

    }

    //更新資料
    public function updateAuthUser(Request $request)
    {
        if ($this->jwtAuth()) {
            $data = $this->userRepository
                ->updateUser($request);
            return response()->json([
                'data' => $data,
                'message' => null]);
        } else {
            return response()->json([
                'data' => null,
                'message' => 'error']);
        }
    }

    //刪除資料
    public function softDelete(Request $request)
    {
        if ($this->jwtAuth()) {
            $data = $this->userRepository
                ->deleteUser($request);
            if ($data == true) {
                return response()->json([
                    'message' => 'has been deleted']);
            } else {
                return response()->json([
                    'message' => 'error']);
            }

        }
    }

    //jwt驗證
    public function jwtAuth()
    {
        if ($user = JWTAuth::parseToken()->authenticate()) {
            return $user;
        } else {
            return null;
        }
    }

    public function sendMail()
    {
//        Mail::raw('測試使用Laravel寄信', function ($massage) {
//            $massage->to('max_lin@owlting.com', 'test')->subject('success');
//        });
        $view = 'email.confirm';
        $data = '寄送電子郵件訊息會大幅延長應用程式的回應時間，因此許多開發者選擇將郵件訊息加入隊列並於背景發送。 Laravel 使用內建 統一的 queue API ，讓您輕鬆地完成此工作。';
        $from = 'bronzii.max@gmail.com';
        $name = 'Max';
        $to = 'max_lin@owlting.com';
        $subject = 'test';


//        Mail::send($view,$data,function($message) use ($from,$name,$to,$subject) {
//            $message->from($from, $name)->to($to)->subject($subject);
//        });

        Mail::raw($data, function($message)
        {

            $message->from('bronzii.max@gmail.com');

            $message->to('max_lin@owlting.com')->subject('test2')->cc('justice8105@owlting.com');
        });
    }

    public function exportData()
    {
        return Excel::download(new ImageExport,'image_export.xlsx');
    }

}
