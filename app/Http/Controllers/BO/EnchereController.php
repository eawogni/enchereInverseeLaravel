<?php

namespace App\Http\Controllers\BO;

use App\Core\DataManipulation;
use App\Core\MyDatatable;
use App\Enchere;
use App\Http\Controllers\Controller;
use App\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class EnchereController extends Controller
{   /**
     */
    protected $datatableBuilder;

    /**
     * 
     */
 
    private $reglesValidation = [
        'date_debut' => ['bail','required', 'date','after:jour_precedent','before_or_equal:date_fin',],
        'date_fin' =>['required', 'date', 'after:date_debut'],
        'cout_mise' =>'required',
        'prix_indicatif' =>'required',
        'produit' =>'required'
    ];

    /**
     * 
     */
    public function __construct(Builder $datatableBuilder)
    {
        $this->middleware('auth');
        $this->middleware('check_role:admin');
        //$this->middleware('verified');
        $this->datatableBuilder = $datatableBuilder;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allEncheres = Enchere::latest()->paginate(50);
        $encheres = $allEncheres->items();
        if(request()->ajax()){
            return DataTables::of($encheres)
                    ->addColumn('produit',function($encheres){
                        return $encheres->produit->nom;
                    })
                    ->addColumn('libelle',function($encheres){
                        return $encheres->libelle();
                    })
                    ->addColumn('date_debut',function($encheres){
                        return date('d-m-Y-H:i:s', strtotime($encheres->date_debut));
                    })
                    ->addColumn('date_fin',function($encheres){
                        return date('d-m-Y-H:i:s', strtotime($encheres->date_fin));
                    })
                    ->addColumn('produit',function($encheres){
                        return $encheres->produit->nom;
                    })
                    ->addColumn('action',function($encheres){
                        $editLink = route('enchere_edit',['enchere'=>$encheres->id]);
                        $edithref = route('enchere_update',['enchere'=>$encheres->id]);
                        $deleteLink = route('enchere_destroy',['enchere'=>$encheres->id]);
                        return MyDatatable::addActionsButtons($deleteLink,$editLink,$edithref);
                    })
                    ->make(true);

        }
        $html = $this->datatableBuilder
                ->addColumn(['data' =>'libelle', 'name'=>'libelle', 'title' =>'Libelle'])
                ->addColumn(['data' =>'date_debut', 'name'=>'date_debut', 'title' =>'Début enchère','orderable'=>false])
                ->addColumn(['data' =>'date_fin', 'name'=>'date_fin', 'title' =>'Fin enchère','orderable'=>false])
                ->addColumn(['data' =>'cout_mise', 'name'=>'cout_mise', 'title' =>'Coût','orderable'=>false])
                ->addColumn(['data' =>'prix_indicatif', 'name'=>'prix_indicatif', 'title' =>'Prix Indicatif','orderable'=>false])
                ->addColumn(['data' =>'produit', 'name'=>'produit', 'title' =>'Produit'])
                ->addAction(['title' =>'Actions'])
                ->parameters([
                    'dom' => 'lftrp'
                ])
                ->language(MyDatatable::getLanguageDefinition());
        $produits = Produit::all();
        $hier =date('d-m-Y',strtotime('yesterday'));
        return view('bo.enchere.index',compact('html','allEncheres','produits','hier'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hier =date('d-m-Y',strtotime('yesterday'));
        return view('bo.enchere.create',['produits'=>Produit::all(),'today'=>$hier]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            $validaton = Validator::make($request->all(),$this->reglesValidation);
            if($validaton->fails()){
                return response()->json(['errors'=>$validaton->errors()]);
            }
        }
        $tabDonneesValides = $this->validateAndFormatEnchere();
        if($produit = Produit::find($tabDonneesValides['produit'])){
            $enchere = new Enchere($tabDonneesValides);
            $enchere->produit_id= $tabDonneesValides['produit'];
            $enchere->save();

            $msg= trans("L'enchère sur le produit :prod à bien été ajouté",['prod'=>$produit->nom]);
            return $request->ajax()?
            response()->json(['success'=>$msg]):
            redirect(route('enchere_index'))->with('success',$msg);
        }
        $msg=trans("Le produit selectionné n'existe pas");
        return $request->ajax()?
        response()->json(['success'=>$msg]):
        back()->with('error',$msg);   
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Enchere  $enchere
     * @return \Illuminate\Http\Response
     */
    public function show(Enchere $enchere)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Enchere  $enchere
     * @return \Illuminate\Http\Response
     */
    public function edit(Enchere $enchere)
    {
        if(request()->ajax()){
            $enchereArray =$enchere->toArray();
            $enchereArray['produit'] = $enchere->produit_id;
            $enchereArray['date_debut'] = date('Y-m-d', strtotime($enchere->date_debut));
            $enchereArray['date_fin'] = date('Y-m-d', strtotime($enchere->date_fin));
            return response()->json(['result'=>$enchereArray]);
        }
       
        return view('Enchere.edit',[
            'enchere' => $enchere,
            'produits' =>Produit::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Enchere  $enchere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enchere $enchere)
    {
        if($request->ajax()){
            $validaton = Validator::make($request->all(),$this->reglesValidation);
            if($validaton->fails()){
                return response()->json(['errors'=>$validaton->errors()]);
            }
        }
        $tabDataRequest = $this->validateAndFormatEnchere();
        if($produit = Produit::find($tabDataRequest['produit'])){
            $enchereClone = new Enchere($tabDataRequest);

            $enchere->produit_id= $tabDataRequest['produit'];
            $enchere->date_debut =$enchereClone->date_debut;
            $enchere->date_fin =$enchereClone->date_fin;
            $enchere->cout_mise =$enchereClone->cout_mise;
            $enchere->prix_indicatif =$enchereClone->prix_indicatif;
            $enchere->update();

            $msg=trans("L'enchère sur le produit :nom_produit à bien été modifié",['nom_produit'=>$produit->nom]);
            return $request->ajax()?
            response()->json(['success'=>$msg]):
            redirect(route('enchere_index'))->with('success',$msg);
        }else
            $msg=trans("Le produit selectionné n'existe pas");
            return $request->ajax()?
            response()->json(['error'=>$msg]):
            back()->with('error',$msg);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Enchere  $enchere
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enchere $enchere)
    {
        $libelleEnchere = $enchere->libelle();
        $enchere->delete();
        return back()->with('success',trans("Enchère :libelle_enchere supprimée",['libelle_enchere' =>$libelleEnchere]));
    }

    /**
     * Vérifie que les données saisies pour un produit sont correctes puis le retourne le tableau de données après 
     * formatage
     * @param boolean $modeEdition true si la vérifiaction est pour le mode edition sinon false
     * @return array 
     */
    public function validateAndFormatEnchere(){
        $tabDataValidee = request()->validate($this->reglesValidation);
            return DataManipulation::formatData($tabDataValidee);
    }
}
