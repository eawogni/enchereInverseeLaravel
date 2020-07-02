$( document ).ready(function() {
    formManager.init();      
});
/**
 * Gestionnaire des fonctionnalités d'ajout et de modification d'une ressource via ajax
 */
var formManager = {
    /**
     * l'url pour ajouter une ressource
     */
    url_add : $('#sampleForm').attr('action'),
    
    /**
     * Indique s'il faut utiliser le même formulaire d'ajout pour l'édition
     */
    editing_mode: true,

    /**
     * tous les inputs propres à la ressource manipulée
     */
   inputs : $('#formModal form input.resource'),


    /**
     * Enregistrements de tous les évenements necessaires
     */
    init : function(){
        formManager.btnAddEventInitialisation();
        formManager.addingAndEditingManipulation();
        formManager.modalInitialisation();
        if(formManager.editing_mode){
            formManager.sampleFormForEditing();
        }
        
    },

    /**
     * Ajoute un évenement au boutton déclancheur de l'action d'ajout de ressource
     */
    btnAddEventInitialisation : function(){
        $('#btnAdd').on('click',function(){
            $('#formModal').modal('show');
          });  
    },

    /**
     *effectue les traitements necessaires lorsqu'on valide un formulaire d'ajout ou de modification 
     */
    addingAndEditingManipulation : function(){  
        $('#sampleForm').on('submit',function(event){
            event.preventDefault();
            var form = $(this);
            fich = form.find('input[type=file]');    

            if(fich.length>0){
                //appels ajax pour un formulaire contenant des fichiers à uploader
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    dataType: 'json',
                    //aramètres ajax permettant l'upload de fichiers
                    data: new FormData(this),
                    cache: false,
                    processData: false,
                    contentType: false,
                    //
                    success: function(data){
                        formManager.ajaxSuccessProcess(data);
                    },
                    error:function(){
                        formManager.ajaxErrorProcess();
                    } 
                });
            }else{
                formManager.ajaxForFormWithoutUpload(form);  
            }
        });
    },

    /**
     * effectue l'appel ajax pour les formulaires ne contenant pas de fichiers à upload
     */
    ajaxForFormWithoutUpload : function(form){
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            dataType: 'json',
            data: form.serialize(),     
            //En cas d'upload d'image
            success: function(data){
                formManager.ajaxSuccessProcess(data);
            },
            error:function(){
                formManager.ajaxErrorProcess();
            }
        });
    },
          
    /**
     * actions à effectuer en cas de réussite d'un appel ajax
     * @var data les données reçues du serveur
     */
    ajaxSuccessProcess: function(data){
        formManager.cleanForm();
        if(data.errors){
            formManager.errorManager(data.errors);
            $("#messages").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Veuillez corriger les erreurs ci-dessous</strong> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        
        if(data.success){
        $("#messages").html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>'+data.success+'</strong> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        $('#dataTableBuilder').DataTable().ajax.reload();
        }

        if(data.error){
        $("#messages").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>'+data.error+'</strong> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
    },

     /**
     * actions à effectuer en cas d'échèc d'un appel ajax
     * 
     */
    ajaxErrorProcess: function(data){
        alert('Une erreur est survenue');
    },

    /**
     * Affiche les messages d'erreurs liées à chaque objet du formulaire
     * @param {*} errors tableau d'erreurs enregistrées par le serveur
     */
    errorManager: function(errors){
        $.each( errors, function( key, value ) { 
            $('#'+key+'_error').html(value[0]);
            $('#'+key).addClass('is-invalid');
        });
    },

    /**
     * réinitialise tous les inputs propre à la ressource manipulé par le formulaire
     * @var restValue indique s'il faut mettre la valeur du champ à null
     */
    cleanForm: function(resetValue=false){
        $('#messages').html('');
            
        $.each(formManager.inputs, function(){
          let input_Obj = $(this);
         
          let input_id =input_Obj.attr('id');
          $('#'+input_id+'_error').html('');
          input_Obj.removeClass('is-invalid');

          if(resetValue){ input_Obj.val(null);}
       })
    },

    /**
     *adapte le formulaire pour l'édition d'une ressource 
     */
    sampleFormForEditing : function(){
        $(document).on('click','.edit_button',function(event){
            var hrefEdit= $(this).attr('hrefFormEdit');
            var hrefUpdate= $(this).attr('hrefUpdate');
            $('#messages').html('');
             $.ajax({
                  url: hrefEdit,
                  dataType:'json',
                  method:'GET',
                  success: function(data){

                    //initialisation des champs du formulaire avec les données de la ressource récuperé
                    $.each( data.result, function(key,value) {
                        var inputObject = $('#'+key);
                        if( inputObject.attr('type') != 'file' ){
                            inputObject.val(value);
                        }
                    });
                    
                    $('.modal-title').text('Modifier');
                    $('#sampleForm').attr('action',hrefUpdate);
                    $('#sampleForm').attr('method','PUT');
                    $('#btnSubmit').attr('value','Modifier');
                    $('#btnSubmit').text('Modifier');
                    $('#formModal').modal('show');
                  }
             });
        
          });
    },

     /**
     *Adapte le formulaire pour l'ajout d'une ressource 
     */
    sampleFormForAdding : function(){
        /**
         * Mise à nu des inputs pour l'ajout
         */
       
        formManager.cleanForm(true);
        /**
         * Mise à jour du formulaire
         */
        $('.modal-title').text('Ajouter');
        $('#sampleForm').attr('action',formManager.url_add);
        $('#sampleForm').attr('method','POST');
        $('#btnSubmit').attr('value','Ajouter');
        $('#btnSubmit').text('Ajouter');

    },

    /**
     * 
     */
    modalInitialisation : function(){
        $('#formModal').on('hidden.bs.modal', function () {
            formManager.sampleFormForAdding();
        });
    }
}

/**
 * btnEdit => id du boutton qui doit déclancher la visualisation du modal lors de l'ajout d'une ressource
 * .edit_button => class que possède tous les buttons générés pour une édition(il permet de lancer le modal pour le mode édition)
 * resource => les inputs liés à la ressource traité doivent avoir cette class
 * formModal => id du modal
 * sampleForm => id du formulaire
 * 
 */