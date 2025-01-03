<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\QueueController;

class UserController extends Controller
{
    public function login(Request $request){
        $incomingFields = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(auth()->attempt(['name'=> $incomingFields['username'], 'password' => $incomingFields['password']])){
            $request->session()->regenerate();
            $user = auth()->user();

            $tellerName = null;
        switch ($user->role) {
            case 'frontDesk':
                // Do nothing or handle as needed
                break;
            case 'table1':
                $tellerName = 'Table 1';
                break;
            case 'table2':
                $tellerName = 'Table 2';
                break;
            case 'table3':
                $tellerName = 'Table 3';
                break;
            case 'table4':
                $tellerName = 'Table 4';
                break;
            default:
                // Handle unknown role or error
                break;
        }

        if ($tellerName !== null) {
            // Update the teller_db table with the new operator and status
            DB::table('teller_db')
                ->where('teller_name', '=', $tellerName)
                ->update(['status' => 'ACTIVE', 'operator' => $user->name]);
        }

            return $this->home();
        } else{
            return back()->withErrors(['username' => 'Invalid credentials']);
        }
    }

    //Logging Out
    public function logout(){
        $user = Auth::user();

        if ($user->role !== 'frontDesk') {
            $tableName = 'Table ' . substr($user->role, -1);
            DB::table('teller_db')
                ->where('teller_name', $tableName)
                ->update(['status' => 'INACTIVE', 'operator' => null, 'current_customer_id' => null]);
        }

        auth()->logout();
        return redirect('/');
    }

    //Registering new Account
    public function register(Request $request){ 
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:20', Rule::unique('users', 'name')],
            'password' => ['required'], 
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'role' => 'required' 
        ]);

        //hashing password
        $incomingFields['password'] = bcrypt($incomingFields['password']);
        $user = User::create($incomingFields);
        
        auth()->login($user);
        return $this->home();
    }

    //Update User Profile
    public function updateProfile(Request $request){ 
            $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'name')->ignore(Auth::id())],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(Auth::id())],
        ]);

        $user = Auth::user();

        $user->name = $incomingFields['username'];
        $user->email = $incomingFields['email'];
        $user->save();

        $request->session()->flash('success', 'Profile updated successfully.');
        
        return redirect('/userProfile');
    }

    //Update password function
    public function updatePass(Request $request) { 
        $incomingFields = $request->validate([
            'old_pass' => ['required', 'string'],
            'new_pass' => ['required', 'string', 'confirmed'],
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($incomingFields['old_pass'], $user->password)) {
            return redirect('/changePass')->with('error', 'Old password is incorrect.');
        }
         
        $user->password = bcrypt($incomingFields['new_pass']);
        $user->save();
        
        return redirect('/changePass')->with('success', 'Password changed successfully.');
    }

    //returning to homepage function
    public function home(){
        $user = auth()->user();

        if ($user->role === 'frontDesk') {
            return app(QueueController::class)->frontDeskDisplay();
        } else {
            return redirect()->route('table');
        }
    }
}
