<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Character;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class application_controller extends Controller
{
    //

    function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:8',
        ]);
    
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        event(new Registered($user));
    
        Auth::login($user); 
    
        //return redirect('/email/verify');

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Please check your email for verification.'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:50',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if (!$user->hasVerifiedEmail()) {
                Auth::logout();

                return response()->json([
                    'success' => false,
                    'message' => 'Your email is not verified. Please check your inbox or resend the verification email.'
                ], 401);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login successful'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->json([
                'success' => true,
                'message' => 'You have been successfully logged out.'
            ]);
        }

        redirect('/login');
    }

    public function checkCharacter(Request $request)
    {
        $request->validate([
            'url' => 'required|string|max:255',
        ]);

        $characterUrl = $request->url;

        $userId = auth()->id();

        $characterExists = Character::where('user_id', $userId)
                                    ->where('character_url', $characterUrl)
                                    ->exists();

        if ($characterExists) {
            return response()->json([
                'success' => true,
                'exists' => true,
            ], 200);
        }

        return response()->json([
            'success' => true,
            'exists' => false,
        ], 200);
    }

    public function saveCharacter(Request $request)
    {
        $request->validate([
            'character_url' => 'required|string|max:50|unique:characters',
            'character_name' => 'required|string|max:50',
            'character_gender' => 'required|string|max:50',
            'character_height' => 'required|string|max:50',
            'character_hair_color' => 'required|string|max:50',
        ]);
    
        $userId = auth()->id();
    
        $character = new Character([
            'character_url' => $request->character_url,
            'character_name' => $request->character_name,
            'character_gender' => $request->character_gender,
            'character_height' => $request->character_height,
            'character_hair_color' => $request->character_hair_color,
            'user_id' => $userId,
        ]);
    
        try {
            $character->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Character saved successfully!',
                'character' => $character
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving character: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteCharacter(Request $request)
    {
        $request->validate([
            'character_url' => 'required|string|max:50',
        ]);
    
        $character = Character::where('character_url', $request->character_url)
                              ->where('user_id', auth()->id())
                              ->first();
    
        if (!$character) {
            return response()->json([
                'success' => false,
                'message' => 'Character not found or you do not have permission to delete it.'
            ], 404);
        }
    
        $character->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Character deleted successfully.'
        ], 200);
    }

    public function getCharacters(Request $request)
    {
        $userId = auth()->id();
    
        $characters = Character::where('user_id', $userId)
                               ->paginate(10);
    
        return response()->json([
            'data' => $characters->items(),
            'next' => $characters->nextPageUrl(),
        ]);
    }
    
    public function getCharacterInfo(Request $request)
    {
        $request->validate([
            'character_url' => 'required|string|max:50',
        ]);
    
        $userId = auth()->id();
    
        $character = Character::where('character_url', $request->character_url)
                              ->where('user_id', $userId)
                              ->first();
    
        if (!$character) {
            return response()->json([
                'success' => false,
                'message' => 'Character not found or you do not have permission to view it.'
            ], 404);
        }
    
        return response()->json([
            'success' => true,
            'data' => $character
        ], 200);
    }
}
