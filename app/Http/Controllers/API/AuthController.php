<?php
   
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Validator;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->username, 'password' => $request->password])){ 
            $auth = Auth::user(); 
            $success['token'] =  $auth->createToken('LaravelSanctumAuth')->plainTextToken; 
            $success['id'] =  $auth->id;
            $success['email'] =  $auth->email;
            $success['name'] =  $auth->name;
   
            return $this->handleResponse($success, 'User logged-in!');
        } 
        else{ 
            return $this->handleError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
        $success['name'] =  $user->name;
        $success['email'] =  $auth->email;
   
        return $this->handleResponse($success, 'User successfully registered!');
    }

    public function changePassword(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->handleError($validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->save();

        $success['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
        $success['name'] =  $user->name;
        $success['email'] =  $auth->email;
   
        return $this->handleResponse($success, 'Password successfully updated!');
    }

    public function profile(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $auth = Auth::user(); 
            $success['token'] =  $auth->createToken('LaravelSanctumAuth')->plainTextToken; 
            $success['name'] =  $auth->name;
   
            return $this->handleResponse($success, 'User profile retrieved');
        } 
        else{ 
            return $this->handleError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function users()
    {
        $users = User::all();
   
        return $this->handleResponse($users, 'User list retrieved');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->handleResponse($user, 'User deleted!');
    }
   
}