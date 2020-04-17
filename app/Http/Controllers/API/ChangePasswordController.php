<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

  
class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    } 
   

    public function store(Request $request)
    {

        $user =  auth('api')->user();


        $data =  $this->validate($request, [
            'senha_atual' => ['required', new MatchOldPassword],
            'nova_senha' => ['required','min:8','string'],
            'nova_senha_confirmada' => ['same:nova_senha'],
        ]);
   
        $data['password'] = Hash::make($request->nova_senha);
        $user->update($data);
   
    }
}