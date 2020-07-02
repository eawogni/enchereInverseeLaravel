<?php

namespace App\Http\Controllers;

use App\Administrateur;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bo.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('administrer');  //On vérifie que l'utilisateur à l'autaurisation(est il un admin?) --Gate définit dans App\Providers\AuthServiceProvider
        $roles = Role::all();
        return view('user.register',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('administrer');  //On vérifie que l'utilisateur à l'autaurisation(est il un admin?) --Gate définit dans App\Providers\AuthServiceProvider
        $request->validate([
            'login' => ['required', 'string', 'max:255','unique:users'],
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'date_de_naissance' => ['required', 'date', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $request->merge(['password' => Hash::make($request->password)]);

        $userAdmin =User::create($request->all());

        //Ajout du rôle "admin au nouvel utilisateur créé
        $role = Role::where('nom','admin')->first();
        $userAdmin->roles()->attach($role);

        return redirect()->route('home');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
        {
        return view('user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'login' => ['required', 'string', 'max:255',],
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'date_de_naissance' => ['required', 'date', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        //Vérifiaction que l'email saisit n'existe pas déjà dans la base de donnée
        if($user->email != $request->input('email')){
            $emailExist = User::where('email',$request->email)->first();
            if ($emailExist != null){
                return back()->with('error',trans("L'email  $request->email est déjà utilisé" ));
            }
        }

        //Vérifiaction que le login saisit n'existe pas déjà dans la base de donnée
        if($user->login != $request->input('login')){
            $loginExist = User::where('login',$request->login)->first();
            if ($loginExist != null){
                return back()->with('error',trans("Le login $request->login est déjà utilisé" ));
            }
        }
        $user->update($request->all());
        $user->date_de_naissance = $request->date_de_naissance;
        $user->save();
        
        return $this->show($user);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize("administrer");
        //
    }
}
