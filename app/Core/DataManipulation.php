<?php

namespace App\Core;

use Illuminate\Support\Facades\Validator;

/**
 * Classe de manipulation des données entrées par l'utilisateur
 */
class DataManipulation{
      /**
     * Format les données de type string dans un format spécifique
     * @param array $data le tableau de donnée
     * @return array $data le tableau de données avec les donnés formatées
     */
    public static function formatData($data=[]){
        foreach($data as $key =>$value){
            $data[$key] = ucfirst(strtolower($data[$key])); 
        }
        return $data;
    }
    
}