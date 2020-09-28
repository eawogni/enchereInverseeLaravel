<?php

use App\Http\Controllers\UserController;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('fo_produit_index');
})->name('index');

Route::get('/home', 'HomeController@index')->name('home');

//Authentification
Auth::routes();
//Vérification d'un nouvel utilisateur inscrit
//Auth::routes(['verify' => true]);

//-----------------------BO et FO------------------------
Route::get('/user/editer/{user}','UserController@edit')->name('user_edit');
Route::put('/user/modifier/{user}','UserController@update')->name('user_update');
Route::get('/user/show/{user}','UserController@show')->name('user_show');




//-------------------------BO------------------------------

//User
Route::get('/user/admin/creer','UserController@create')->name('user_create');
Route::post('/user/admin/enregistrer','UserController@store')->name('user_store');
Route::get('/User/admin/home','UserController@index')->name('bo_home');

//Produits

Route::get('/produits/index','BO\ProduitController@index')->name('produit_index');
Route::get('/produit/creer','BO\ProduitController@create')->name('produit_create');
Route::post('/produit/enregistrer','BO\ProduitController@store')->name('produit_store');
Route::get('/produit/editer/{produit}','BO\ProduitController@edit')->name('produit_edit');
Route::put('/produit/modifier/{produit}','BO\ProduitController@update')->name('produit_update');
Route::delete('/produit/supprimer/{produit}','BO\ProduitController@destroy')->name('produit_destroy');

//catégories

Route::get('/categories/index','BO\CategorieController@index')->name('categorie_index');
Route::get('/categorie/creer','BO\CategorieController@create')->name('categorie_create');
Route::post('/categorie/enregistrer','BO\CategorieController@store')->name('categorie_store');
Route::get('/categorie/editer/{categorie}','BO\CategorieController@edit')->name('categorie_edit');
Route::put('/categorie/modifier/{categorie}','BO\CategorieController@update')->name('categorie_update');
Route::delete('/categorie/supprimer/{categorie}','BO\CategorieController@destroy')->name('categorie_destroy');

//enchères

Route::get('/encheres','BO\EnchereController@index')->name('enchere_index');
Route::get('/enchere/creer','BO\EnchereController@create')->name('enchere_create');
Route::post('/enchere/enregistrer','BO\EnchereController@store')->name('enchere_store');
Route::get('/enchere/editer/{enchere}','BO\EnchereController@edit')->name('enchere_edit');
Route::put('/enchere/modifier/{enchere}','BO\EnchereController@update')->name('enchere_update');
Route::delete('/enchere/supprimer/{enchere}','BO\EnchereController@destroy')->name('enchere_destroy');

//-------------------------FO------------------------------

//catégories
Route::get('/categories/','FO\CategorieController@index')->name('fo_categorie_index');

//Produits
Route::get('/produits/','FO\ProduitController@index')->name('fo_produit_index');
Route::get('/produits/categorie/{categorie}','FO\ProduitController@indexByCategorie')->name('fo_produit_by_category');
Route::get('/produits/en_cours_d_enchere','FO\ProduitController@indexByEnchere')->name('fo_produit_by_enchere_en_cours');
Route::post('/produits/rechercher','FO\ProduitController@indexBySearch')->name('fo_produit_by_search');
Route::get('/produits/show/{produit}','FO\ProduitController@show')->name('fo_produit_show');








