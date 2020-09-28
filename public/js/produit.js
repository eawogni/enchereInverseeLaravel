
produit = function($url) {

    return  $("#produitTab").DataTable({
         "serverSide":true,
         "processing":true,
         "select":true,
         "ajax": {
             url : $url,
             type: 'GET'
         },
         "columns": [{"data":"nom","name":"nom","title":"Nom","orderable":true,"searchable":true},
                     {"data":"description","name":"description","title":"Description","orderable":false,"searchable":true},
                     {"data":"img1","name":"image1","title":"Image 1","orderable":false,"searchable":true},
                     {"data":"img2","name":"image2","title":"Image 2","orderable":false,"searchable":true},
                     {"data":"img3","name":"image3","title":"Image 2","orderable":false,"searchable":true},
                     {"data":"categorie","name":"categorie","title":"Categorie","orderable":true,"searchable":true},
                     {"defaultContent":"","data":"action","name":"action","title":"Actions","render":null,"orderable":false,"searchable":false}]
         ,
       
     
                 });
                
          };

afficheData= function($table)
{
    console.log($table.data());
}
 