<?php require_once('config/config.php');

// Onrécupère l'$id de l'annonce depuis la page précédente
$id = $_GET['id'];

// Formulaire pour envoyer un commentaire
if(!empty($_POST['commentaire']))
{
    if (!isset($_SESSION["user"])) {
        echo "<script type='text/javascript'>alert('Connectez vous pour envoyer un commentaire !');</script>";
    }
    else
    {
    $commentaire = trim($_POST['commentaire']);

   
    $test = $_SESSION["user"];
    $envoie = $pdo->prepare("INSERT INTO commentaire (membre_id, annonce_id, commentaire, date_enregistrement) VALUE (:membre_id, :annonce_id, :commentaire, NOW()) ");
    $envoie->bindParam('membre_id', $test, PDO::PARAM_STR);
    $envoie->bindParam('annonce_id', $id, PDO::PARAM_STR);
    $envoie->bindParam('commentaire', $commentaire, PDO::PARAM_STR);
    $envoie->execute();
   
}}

// Formulaire pour envoyer un avis
if (!empty($_POST['avis']) && !empty($_POST['note'])) {
    if (!isset($_SESSION["user"])) {
        echo "<script type='text/javascript'>alert('Connectez vous pour envoyer un avis !');</script>";
    }else{
    $id_acheteur = $_SESSION["user"];
    $avis = trim($_POST['avis']);
    $note = trim($_POST['note']);

    $reponse4 = $pdo->prepare("SELECT * FROM annonce WHERE id_annonce = :id");
    $reponse4->bindParam(':id', $id, PDO::PARAM_STR);
    $reponse4->execute();
    $donneesAnnonce1 = $reponse4->fetch(PDO::FETCH_ASSOC);

    $id_vendeur = $donneesAnnonce1['membre_id'];

    $envoie3 = $pdo->prepare("INSERT INTO note (membre_id1, membre_id2, note, avis, date_enregistrement) VALUE (:membre_id1, :membre_id2, :note, :avis, NOW())");
    $envoie3->bindParam(':membre_id1', $id_acheteur, PDO::PARAM_STR);
    $envoie3->bindParam(':membre_id2', $id_vendeur, PDO::PARAM_STR);
    $envoie3->bindParam(':note', $note, PDO::PARAM_STR);
    $envoie3->bindParam(':avis', $avis, PDO::PARAM_STR);
    $envoie3->execute();

}
}

require_once('header/header.php');

?>

<main>

    <div class="container mt-5 mb-5">
        <?php
        
        // Toutes les requetes dont j'ai besoin pour afficher les infos de la page produit de façon dynamique
        $reponse = $pdo->prepare("SELECT * FROM annonce WHERE id_annonce = :id");
        $reponse->bindParam(':id', $id, PDO::PARAM_STR);
        $reponse->execute();
        $donneesAnnonce = $reponse->fetch(PDO::FETCH_ASSOC);

        $reponsePhoto = $pdo->prepare("SELECT * FROM photo WHERE photo_id = :id");
        $reponsePhoto->bindParam(':id', $donneesAnnonce['photo_id'], PDO::PARAM_STR);
        $reponsePhoto->execute();
        $donneesPhoto = $reponsePhoto->fetch(PDO::FETCH_ASSOC);

        $reponseMembre = $pdo->prepare("SELECT * FROM membre WHERE id_membre = :id");
        $reponseMembre->bindParam(':id', $donneesAnnonce['membre_id'], PDO::PARAM_STR);
        $reponseMembre->execute();
        $donneesMembre = $reponseMembre->fetch(PDO::FETCH_ASSOC);

        $reponseCommentaire = $pdo->prepare("SELECT * FROM commentaire WHERE annonce_id = :id ORDER BY date_enregistrement DESC");
        $reponseCommentaire->bindParam(':id', $id, PDO::PARAM_STR);
        $reponseCommentaire->execute();

        $reponseNote = $pdo->prepare("SELECT round(AVG(note),1) FROM note WHERE membre_id2 = :id");
        $reponseNote->bindParam(':id', $donneesAnnonce['membre_id'], PDO::PARAM_STR);
        $reponseNote->execute();
        $donneesNote = $reponseNote->fetch(PDO::FETCH_ASSOC);
      
        echo "
        <div class='card'>
            <div class='row g-0 '>
                <div class='col-md-6 border-end border-bottom'>
                    <div class='d-flex flex-column justify-content-center '>
                        <div class='main_image'> 
                        <div id='carouselExampleIndicators' class='carousel carousel-fade carousel-dark slide col-10' data-bs-ride='carousel'>
                            <div class='carousel-indicators'>
                            <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='0' class='active' aria-current='true' aria-label='Slide 1'></button>
                            <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='1' aria-label='Slide 2'></button>
                            <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='2' aria-label='Slide 3'></button>
                            <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='3' aria-label='Slide 3'></button>
                            <button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='4' aria-label='Slide 3'></button>
                            </div>
                            <div class='carousel-inner' >
                            <div class='carousel-item active' data-bs-interval='500000000'>
                                <img src='upload/$donneesPhoto[photo1]' style='max-width:100%; object-fit:cover; aspect-ratio: 1;' class='d-block w-100' alt='...'>
                            </div>
                            <div class='carousel-item' data-bs-interval='500000000'>
                                <img src='upload/$donneesPhoto[photo2]' style='max-width:100%; object-fit:cover; aspect-ratio: 1;' class='d-block w-100' alt='...'>
                            </div>
                            <div class='carousel-item' data-bs-interval='500000000'>
                                <img src='upload/$donneesPhoto[photo3]' style='max-width:100%; object-fit:cover; aspect-ratio: 1;' class='d-block w-100' alt='...'>
                            </div>
                            <div class='carousel-item' data-bs-interval='500000000'>
                                <img src='upload/$donneesPhoto[photo4]' style='max-width:100%; object-fit:cover; aspect-ratio: 1;' class='d-block w-100' alt='...'>
                            </div>
                            <div class='carousel-item' data-bs-interval='500000000'>
                                <img src='upload/$donneesPhoto[photo5]' style='max-width:100%; object-fit:cover; aspect-ratio: 1;' class='d-block w-100' alt='...'>
                            </div>
                            <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide='prev'>
                            <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                            <span class='visually-hidden'>Previous</span>
                            </button>
                            <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide='next'>
                            <span class='carousel-control-next-icon' aria-hidden='true'></span>
                            <span class='visually-hidden'>Contacter</span>
                            </button>
                    
                            </div>
                        
                        </div>
                        </div>
            
                    </div>
                </div>
                <div class='col-md-6 border-bottom'>
                    <div class='p-3 right-side'>
                        <div class='d-flex justify-content-between align-items-center'>
                            <h3>$donneesAnnonce[titre]</h3> 
                        </div>
                        <div class='mt-2 pr-3 content'>
                            <p>$donneesAnnonce[description_longue]</p>
                        </div>
                        <h3>$donneesAnnonce[prix] €</h3>
                        <div class='ratings d-flex flex-row align-items-center mb-5'>
                            <div class='d-flex flex-row mb-5'> <i class='bx bxs-star'></i> <i class='bx bxs-star'></i> <i class='bx bxs-star'></i> <i class='bx bxs-star'></i> <i class='bx bx-star'></i> </div> <span>" .  $donneesNote['round(AVG(note),1)'];  echo "/5</span>
                        </div>
                        <div class='mt-5 mb-5'> 
                            <span class='fw-bold'></span>
            
                        </div>
                        <div class='buttons d-flex flex-row mt-5 gap-3'> <button type='button' class='btn-lg  btn-outline-dark' data-bs-toggle='modal' data-bs-target='#modalContacter' >Contacter $donneesMembre[prenom]</button> </div>
                        <div class='row'>
                            <div class='col-12 mt-5'></div>
                            <div class='col-6 mt-5  text-start'><i class='fa fa-calendar' aria-hidden='true'></i>
                             Date de publication : " . DATE('d/m/Y ' , strtotime($donneesAnnonce['date_enregistrement']) );  echo " 
                            </div>
                            <div class='col-6 mt-5  text-end'><i class='fa-solid fa-thumbtack'></i> 
                            Adresse : " . $donneesAnnonce['adresse'];  echo " 
                            </div>
                        </div>
                        </div>
                    </div>
                   <div class='row'>
                        <div class='row mt-3'>
                            <h4 class='col-6 text-center mt-2'>Commentaires sur le vendeur</h4> 
                            <a class='col-5 text-end mt-2 ' href='#Modal' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#Modal'>Déposer un commentaire ou un avis</a>
                            
                            <!-- Modal pour les avis et commentaire -->
                            <div class='modal fade'  id='Modal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered'>
                                  <div class='modal-content'>
                                    <div class='modal-header'>
                                      <h5 class='modal-title' id='exampleModalLabel'>Evaluer le vendeur</h5>
                                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <form method='POST'>
                                            <label for='commentaire'>Votre avis sur le vendeur</label>
                                            <input type='text' class='form-control mt-2 mb-2' id='avis' name='avis' placeholder=''>
                                            <label for='pseudo'>Notez le vendeur</label>
                                            <select class='form-select mt-2 mb-3' id='note' name='note'>
                                                <option selected>Choisissez la note</option>
                                                <option value='1'>1/5</option>
                                                <option value='2'>2/5</option>
                                                <option value='3'>3/5</option>
                                                <option value='4'>4/5</option>
                                                <option value='5'>5/5</option>
                                            </select>
                                            <div class='col-12 border-top mt-4'>
                                            <label for='commentaire' class='mt-3'>Vous avez une question ?</label>
                                            <input type='text' class='form-control mt-2 mb-2' id='commentaire' name='commentaire' placeholder='Entrez votre commentaire'>
                                            </div>
                                    </div>
                                    <div class='modal-footer'>
                                      <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fermer</button>
                                      <button type='submit' class='btn btn-primary' data-bs-dismiss='modal'>Envoyer</button></form>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            <!-- Modal pour contacter le vendeur -->
                            <div class='modal fade'  id='modalContacter' tabindex='-1' aria-labelledby='modalContacterVendeur' aria-hidden='true'>
                              <div class='modal-dialog modal-dialog-centered'>
                                <div class='modal-content'>
                                  <div class='modal-header'>
                                    <h5 class='modal-title' id='modalContacterVendeur'>Contacter le vendeur</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                  </div>
                                  <div class='modal-body'>
                                      <form method='POST'>
                                          <label for='commentaire'>Votre nom</label>
                                          <input type='text' class='form-control mt-2 mb-2' id='nomDemandeur' name='nomDemandeur' placeholder=''>
                                          <label for='commentaire'>Votre message</label>
                                          <input type='text' class='form-control mt-2 mb-2' id='messageVendeur' name='messageVendeur' placeholder=''>
                                          <label for='commentaire'>Votre mail</label>
                                          <input type='email' class='form-control mt-2 mb-2' id='mailDemandeur' name='mailDemandeur' placeholder=''>
                                  </div>
                                  <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fermer</button>
                                    <button type='submit' class='btn btn-primary' data-bs-dismiss='modal'>Envoyer</button></form>
                                  </div>
                                </div>
                              </div>
                            </div>

                      
                            <div class='container mt-3 mb-3'>";

                            
                            // Boucle pour afficher les commentaires
                            while ($donneesCommentaire = $reponseCommentaire->fetch(PDO::FETCH_ASSOC))
                            {   
                                
                                echo "

                                <div class='row  d-flex justify-content-center'>
                    
                                    <div class='col-md-8'>
                    
                                        <div class='headings d-flex justify-content-between align-items-center mb-3'>
                        
                    
                                            
                                        </div>
                    
                    
                    
                                        <div class='card p-3'>
                    
                                            <div class='d-flex justify-content-between align-items-center'>
                    
                                          <div class='user d-flex flex-row align-items-center'>
                                        
                                       
                                            <span><small class='font-weight-bold text-primary'>"; 
                                            $demande = $pdo->prepare("SELECT prenom FROM membre WHERE id_membre = :id_membre");
                                            $demande->bindParam(':id_membre', $donneesCommentaire['membre_id'], PDO::PARAM_STR);
                                            $demande->execute();
                                            $donees = $demande->fetch(PDO::FETCH_ASSOC);
                                            echo $donees['prenom'];

                                            echo "</small> </span>
                                              
                                          </div>
                    
                    
                                          <small>$donneesCommentaire[date_enregistrement]</small>
                
                                          </div>
                    
                    
                                          <div class='action d-flex justify-content-between mt-2 align-items-center'>
                    
                                            <div class='px-4'>
                                            
                                                <small>$donneesCommentaire[commentaire]</small>
                                          
                                               
                                            </div>
                    
                                            <div class='icons align-items-center'>
                    
                                                
                                                
                                            </div>
                                              
                                          </div>
                                                    
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                


                                ";
                            }

                            echo "

                            </div>
                        
                   </div>
                </div>
            </div>
          
        </div>
        ";
        ?>
    </div>

</main>


<?php

require_once('footer/footer.php')


?>