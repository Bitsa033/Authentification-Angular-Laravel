<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as ResourcesUser;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Connexion à l'application.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            // $request->session()->regenerate();
            $user = Auth::user();
            $user['message'] = "Connexion réussie";

            /**
             * @var User $user
             */
            $user['token'] = $user->createToken($user->name)->plainTextToken;
            return new ResourcesUser($user);
            // return redirect()->intended('dashboard');
        }

        return $user['message'] = "Connexion impossible, vérifiez vos identifiants";
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request) {
        
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Utilisateur déconnecté'], 200);
    }

    /**
     * On affiche le formulaire de reinitialisation du mot de passe
     */
    public function recoverPassword(Request $request)
    {
        return "recover password";
    }


    /**
     * On affiche la liste des users
     */
    public function index()
    {
        $user = User::all();
        return new ResourcesUser($user);
    }

    /**
     * On créé un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $user['message'] = "Données enregistrées avec succès";

        return new ResourcesUser($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrfail($id);
        return new ResourcesUser($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        $user = User::findOrfail($id);
        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $user['message'] = "Donnée modifiée avec succès";

        return new ResourcesUser($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrfail($id);
        $user->destroy($id);
        $user['message'] = "Donnée supprimée avec succès";
        return new ResourcesUser($user);
    }
}
