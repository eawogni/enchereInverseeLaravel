<?php

namespace App\Http\Controllers\BO;

use App\Categorie;
use App\Core\DataManipulation;
use App\Core\MyDatatable;
use App\Enchere;
use App\Http\Controllers\Controller;
use App\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class ProduitController extends Controller
{
    /**
     * 
     */
    protected $datatableHtmlBuilder;
    private $reglesValidation = 
    [ 
        'nom' => ['required'],
        'description' =>'required',
        'image1'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'image2'=>['required','image'],
        'image3'=>['required','image'],
        'categorie' =>'required'     
    ];

    /**
     * 
     */
    public function __construct(Builder $datatableHtmlBuilder)
    {
        $this->datatableHtmlBuilder = $datatableHtmlBuilder;
        $this->middleware('auth');
        $this->middleware('check_role:admin');
        //$this->middleware('verified');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits_datatable= Produit::all();

        if(request()->ajax()){
                return DataTables::of($produits_datatable)
                ->addColumn('categorie', function($produits_datatable){
                        return $produits_datatable->categorie->libelle;
                })
                ->addColumn('img1', function($produits_datatable){
                    $src =asset('storage/produits/'.$produits_datatable->image1);
                    return MyDatatable::addImage($src);
                })
                ->addColumn('img2', function($produits_datatable){
                    $src =asset('storage/produits/'.$produits_datatable->image2);
                     return MyDatatable::addImage($src);
                })
                ->addColumn('img3', function($produits_datatable){
                    $src =asset('storage/produits/'.$produits_datatable->image3);
                    return MyDatatable::addImage($src);
                })
                ->addColumn('action', function($produits_datatable){
                    $deleteLink = route('produit_destroy',['produit'=>$produits_datatable->id]);
                    $editLink= route('produit_edit',['produit'=> $produits_datatable->id]);
                    return MyDatatable::addActionsButtons($deleteLink,$editLink);
                })
            ->rawColumns(['img1','img2','img3','action'])
            ->make(true);
        }
        $html= $this->datatableHtmlBuilder
                ->addColumn(['data' => 'nom', 'name' => 'nom', 'title' => 'Nom'])
                ->addColumn(['data' => 'description',
                             'name' => 'description', 
                             'title' => 'Description',
                             'orderable' => false
                             ])
               ->addColumn(['data' => 'img1', 'name' => 'image1', 'title' => 'Image 1','orderable' =>false])
                ->addColumn(['data' => 'img2', 'name' => 'image2', 'title' => 'Image 2','orderable' =>false])
                ->addColumn(['data' => 'img3', 'name' => 'image3', 'title' => 'Image 2','orderable' =>false])
                ->addColumn(['data' => 'categorie', 'name' => 'categorie', 'title' => 'Categorie'])
                ->addAction(['title' =>'Actions'])
                ->setTableId('produit_tab')
                ->select(true)
                ->parameters([
                    'dom' => 'Blftrp',
                    
                ])
                ->paging(true)
                ->pageLength(1)  //
                ->processing(false)
                ->language(MyDatatable::getLanguageDefinition());

                $categories = Categorie::all();

        return view('bo.produit.index',compact('html','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bo.produit.create',['categories'=> Categorie::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation ajax
        if($request->ajax()){
            $validaton = Validator::make($request->all(),$this->reglesValidation);
            if( $validaton->fails()){
                return response()->json(['errors'=> $validaton->errors()]);
            }
        }

        //Validation et formatage des données saisies par l'utilisateur
        $tabDataValides = DataManipulation::formatData($this->validateProduit());
        //vérification de la catégorie associé au produit
        if(Categorie::find($request->categorie)){
            $nbProduitMemeNom =count(Produit::where('nom',$tabDataValides['nom'])->get());
            if($nbProduitMemeNom==0){
                $produit = new Produit($tabDataValides);
                //Association de l'id de la catégorie au nouveau produits
                $produit->categorie_id = $request->categorie;
                //enregistrement des images associés au produit
                $pathImg1 = basename($request->file('image1')->store('/public/produits'));
                $pathImg2 = basename($request->file('image2')->store('/public/produits'));
                $pathImg3 = basename($request->file('image3')->store('/public/produits'));
    
                $produit->image1 =$pathImg1; 
                $produit->image2 =$pathImg2;
                $produit->image3 =$pathImg3;
                //Persistance du produit créé
                $produit->save();
                $msg=trans("Le produit :prod à bien été ajouté",['prod'=>$tabDataValides['nom']]);
                return $request->ajax()?
                response()->json(['success'=>$msg]):
                redirect(route('produit_index'))->with('success',$msg);
            }else
            return back()->with('error',trans("Le produit :prod existe déjà",['prod'=>$tabDataValides['nom']])); 
        }
        $msg=trans("La catégorie selectionné n'existe pas");
        return $request->ajax()?
        response()->json(['errors'=>$msg]):
        back()->with('error',$msg);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
        if(request()->ajax()){
            $prod= $produit->toArray();
            $prod['categorie'] =$produit->categorie_id;
            return response()->json(['result'=>$prod]);
        }

        return view(
            'bo.Produit.edit',
            [
            'produit'=>$produit,
            'categories' =>Categorie::all()
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produit $produit)
    {
    
        //Validation et formatage des données saisies par l'utilisateur
        $tabDataValides = DataManipulation::formatData($this->validateProduit(true));
        //modification de la description
        $produit->description = $tabDataValides['description'];
        //vérification de la catégorie associé au produit
        if(Categorie::find($request->categorie)){
            //Modification de l'id de la catégorie associé au produit
            $produit->categorie_id = $request->categorie;           
            if( $produit->nom != $tabDataValides['nom'] ){
                $nbProduitMemeNom =count(Produit::where('nom',$tabDataValides['nom'])->get());
                if($nbProduitMemeNom ==0){
                    //Modification des infos du produit
                $produit->nom = $tabDataValides['nom'];
                }else
                return back()->with('error',trans("Le produit :prod existe déjà",['prod'=>$tabDataValides['nom']]));   
            }
        }else
        return back()->with('error',trans("La catégorie selectionné n'existe pas"));
        $produit->update();
        return redirect(route('produit_index'))->with('success',trans("Le produit :prod à bien été modifié",['prod'=>$tabDataValides['nom']]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {

        if(count(Enchere::where('produit_id',$produit->id)->get())==0){
            $produit->delete();
            return back()->with('success',trans("Le produit :prod à bien été supprimé",['prod'=>$produit->nom]));
        }
        return back()->with('error',trans("Le produit :prod ne peut être supprimé car il est associé à une ou plusieurs enchères",['prod'=>$produit->nom]));
       
    }

    /**
     * Vérifie que les données saisies pour un produit sont correctes
     * @param boolean $modeEdition true si la vérifiaction est pour le mode edition sinon false
     */
    public function validateProduit($modeEdition=false){

        if($modeEdition){
            return request()->validate(
                [
                    'nom' => 'required',
                    'description' =>'required',
                    'categorie' =>'required'             
                ]);
        }
        return request()->validate(
            [
                'nom' => 'required',
                'description' =>'required',
                'image1'=>'required',
                'image2'=>'required',
                'image3'=>'required',  
                'categorie' =>'required'             
            ]);
    }
}
