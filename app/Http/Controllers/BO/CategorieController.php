<?php

namespace App\Http\Controllers\BO;

use App\Categorie;
use App\Core\DataManipulation;
use App\Core\MyDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class CategorieController extends Controller
{
    /**
     * 
     */
    protected $datatableHtmlBuilder;
    private $reglesValidations= ['libelle' => 'min:6'];

    /**
     * 
     */
    public function __construct(Builder  $datatableHtmlBuilder)
    {
        $this->middleware('auth');
        $this->middleware('check_role:admin');
        //$this->middleware('verified');
        $this->datatableHtmlBuilder =$datatableHtmlBuilder;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCategories = Categorie::latest()->paginate(50);
        $categories = $allCategories->items();
        //reqûete ajax de la datatable pour lecture des données
        if(request()->ajax()){
            //$categories = Categorie::latest();
            return DataTables::of($categories)
                ->addColumn('action', function($categories){
                    $editLink = route('categorie_edit',['categorie'=>$categories->id]);
                    $updateLink = route('categorie_update',['categorie'=>$categories->id]);
                    $deleteLink = route('categorie_destroy',['categorie'=>$categories->id]);
                    return MyDatatable::addActionsButtons($deleteLink,$editLink,$updateLink);
                })
                ->make(true);
        }
        //Construction du tableau pour la datatable
        $html = $this->datatableHtmlBuilder
                ->addColumn(['data' =>'libelle', 'name' =>'libelle', 'title' =>'Libelle'])
                ->addAction(['title'=>'Actions'])
                ->select(true)
                ->parameters([
                    'dom' => 'Blftrp'
                ])
                ->processing(false)
                ->setTableId('categorieTab')
                ->language(MyDatatable::getLanguageDefinition());

        return  view('bo.categorie.index',compact('html','allCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){ return view('bo.categorie.create');}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation ajax
        if($request->ajax()){
            $validaton = Validator::make(request()->all(),$this->reglesValidations);
            if( $validaton->fails()){
                return response()->json(['errors' =>  $validaton->errors()]);
            }  
        } 

        //validation et mise en forme des données
        $tabDataValides = DataManipulation::formatData( $this->validateCategorie());
        // Vérification si existance de catégorie avec le même libelle saisie
        $tabMemeLibelleEnBase = Categorie::where('libelle', $tabDataValides['libelle'])->get();
        //création et enregistrement de la catégorie si le libille n'existe pas en base
        if(count($tabMemeLibelleEnBase)==0){
            Categorie::create($tabDataValides);
            $msg = trans("La catégorie :categ à bien été ajouté",['categ'=>$tabDataValides['libelle']]);
            return $request->ajax()?
            response()->json(['success' => $msg]):
            redirect(route('categorie_index'))->with('success',$msg);
        }
        $msg= trans("La catégorie :categ existe déjà",['categ'=>$tabDataValides['libelle']]);
        return $request->ajax()?
        response()->json(['error' =>$msg ]):
        back()->with('error',$msg);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $categorie)
    {
        if(request()->ajax()){
            return response()->json(['result' => $categorie]);
        }
        return view('bo.categorie.edit',['categorie'=>$categorie]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categorie $categorie)
    {
        //Validation ajax
        if($request->ajax()){
            $validaton = Validator::make(request()->all(),$this->reglesValidations);
            if( $validaton->fails()){
                return response()->json(['errors' =>  $validaton->errors()]);
            }  
        }

        //mise en forme du libelle sous la forme : Libelle
        $tabDataValides = DataManipulation::formatData($this->validateCategorie());
        // Vérification si existance de catégorie avec le même libelle saisie
        if($categorie->libelle != $tabDataValides['libelle']){
            $tabMemeLibelleEnBase = Categorie::where('libelle', $tabDataValides['libelle'])->get();
            //modification et enregistrement de la catégorie si le libille n'existe pas en base
            if(count($tabMemeLibelleEnBase)==0){
                $categorie->update($tabDataValides);
            }else{
                $msg= trans("La catégorie :categ existe déjà",['categ'=>$tabDataValides['libelle']]);
                return $request->ajax()? response()->json(['error' => $msg]):
                back()->with(['error' => $msg]);
            }
        }
        $message =trans('Modification effectuée avec succès');
        return $request->ajax()? response()->json(['success' => $message]):redirect(route('categorie_index'))
        ->with(['success'=>$message]);     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
      if(count($categorie->produits)==0){
          $categorie->delete();
          return back()->with('success',trans("La catégorie :categ à bien été supprimé",['categ'=>$categorie->libelle]));
      }
      return back()->with('error',trans("Impossible de supprimé la
       catégorie :categ, car elle est associé à des produits",['categ'=>$categorie->libelle]));
      
    }

    /**
     * Validateur des informations d'une categorie sasie via un formulaire
     * @return array tableau des input 
     */
    public function validateCategorie(){
        return request()->validate($this->reglesValidations);     
    }
}
