<?php

namespace App\Core;
/**
 * Gère la personnalisation des données dans la datatble
 */
class MyDatatable{

    /**
     * Renvoie le code html pour afficher une image
     * @var $src la source de l'image
     * @var $class la classe css à appliquer à l'image
     * @return string correspondant au code html 
     */
    public static function addImage($src='', $class='img-thumbnail'){
        ob_start();
        echo view('Core.MyDatatable.layout_image', compact('src','class'));
        return ob_get_clean();
    }

    
    /**
     * Renvoie le code html pour un boutton de suppression
     * @var $action string l'url de suppression
     * @return string
     */
    public static function addButttonDelete($action="#"){
        ob_start();
        echo view('Core.MyDatatable.layout_button_delete', compact('action'));
        return ob_get_clean();
    }

     /**
     * Renvoie le code html pour un boutton de suppression sous forme de lien
     * @var $href string l'url d'édition
     * @return string
     */
    public static function addButtonEditLink($href="#"){
        ob_start();
        echo view('Core.MyDatatable.layout_button_edit_link', compact('href'));
        return ob_get_clean();
    }


      /**
     * Renvoie le code html pour un boutton de suppression et d'édition
     * @var $editHref string l'url pour obtenir les infos d'édition de la ressource
     * @var $deleteAction string l'url pour la suppression de la ressource
     * @var $hrefUpdate string l'url pour appliquer les modification sur la ressource
     * @return string
     */
    public static function addActionsButtons($deleteAction="#",$editHref="#",$hrefUpdate="#"){
        ob_start();
        echo view('Core.MyDatatable.layout_actions_buttons', compact('deleteAction','editHref','hrefUpdate'));
        return ob_get_clean();
    }

    public static function getLanguageDefinition(){
        return [
            "lengthMenu"    =>   "Nombre par page _MENU_",
            "processing"    =>   "Chargement en cours",
            "search"        =>   "Rechercher",
                "emptyTable"    =>    "Pas de données disponnible",
            "paginate" => [
                "first"    =>     "Premier",
                "last"     =>     "Dernier",
                "next"     =>     "Suivant",
                "previous" =>     "Précédent"
            ],
        ];
    }

}