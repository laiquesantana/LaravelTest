<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return User::latest()->paginate(5);
    }


    public function search(Request $request){

        $search = $request->only('query');
        if (!is_null($search['query'])) {
            $users = User::where(function($query) use ($search){
                $query->where('name','like','%'.$search['query'].'%')
                ->orWhere('email','like','%'.$search['query'].'%')
                ->orWhere('tipo','like','%'.$search['query'].'%');
              
            })->paginate(5);
        }else{
            $users = User::latest()->paginate(5);
        }

        return $users;

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        $data = $request->validated();

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'tipo' => $data['tipo'],
            'cpf' => $data['cpf'],
            'orgao_id' => Auth::user()->orgao_id,
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        dd($user);
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);


            $request['cpf'] = str_replace(['.','-'], '', $request->input('cpf'));

            $data = $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'tipo' => 'sometimes',
                'password' => 'sometimes|string|min:8',
                'cpf' => 'required|cpf|unique:users,cpf,'.$user->id
            ]);

            
            if(!empty($data['password'])){
                $data['password'] = Hash::make($data['password']);
            }

            $user->update($data);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

     
        try {
            $user->delete();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
