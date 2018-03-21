<?php

 // Variables de connexion

$host_name = "localhost";
$database = "colyseum";
$user_name = "root";
$password = "neiluj";
$lettre = $_POST['lettre'];

// Paramètres de connexion

$connect = mysqli_connect($host_name, $user_name, $password, $database);

// Accepter les caractères spéciaux provenant de la base de donnée

$connect->query("SET NAMES UTF8");

// Procédure de connection

if(mysqli_connect_errno())
{
echo '<p id="echecConnection">La connexion à la base de donnée a échoué: '.mysqli_connect_error().'</p>';
}
else
{
echo '<p id="successConnection">Connexion à la base de donnée établie avec succès.</p>';
}

// Afficher tous les clients

$rq1 =mysqli_query($connect,'SELECT firstName,lastName FROM `clients` WHERE card=1');

// Afficher tous les types de spectacles possibles.

$rq2 =mysqli_query($connect,'SELECT type from showTypes');


// Afficher les 20 premiers clients selon leur identifiant.

$rq3 =mysqli_query($connect,'SELECT lastName, firstName from clients LIMIT 20');


// N’afficher que les clients possédant une carte de fidélité

$rq4 =mysqli_query($connect,'SELECT lastName, firstName FROM clients INNER JOIN cards ON cards.cardNumber = clients.cardNumber WHERE cards.cardTypesId=1');


// Afficher uniquement le nom et le prénom de tous les clients dont le nom commence par la lettre "M". Les afficher comme ceci : Nom : Nom du client Prénom : Prénom du client (Trier les noms par ordre alphabétique.)


$rq5 =mysqli_query($connect,"SELECT lastName, firstName from clients WHERE lastName LIKE 'm%' order by lastName ASC");


// Afficher le titre de tous les spectacles ainsi que l'artiste, la date et l'heure. Trier les titres par ordre alphabétique. Afficher les résultat comme ceci : Spectacle par artiste, le date à heure


$rq6 =mysqli_query($connect,"SELECT title, performer, date, startTime from shows order by title ASC");



$result="";
$liste="";

while ($liste = mysqli_fetch_assoc($rq1)){
$result1.= '<tr><td>'.$liste['firstName']."</td><td>".$liste['lastName'].'</td></tr>';
}

while ($liste = mysqli_fetch_assoc($rq2)){
$result2.= "<tr><td>".$liste['type']."</td></tr>";
}

while ($liste = mysqli_fetch_assoc($rq3)){
$result3.= '<tr><td>'.$liste['firstName']."</td><td>".$liste['lastName'].'</td></tr>';
}

while ($liste = mysqli_fetch_assoc($rq4)){
$result4.= '<tr><td>'.$liste['firstName']."</td><td>".$liste['lastName'].'</td></tr>';
}

while ($liste = mysqli_fetch_assoc($rq5)){
$result5.= '<tr><td>'.$liste['firstName']."</td><td>".$liste['lastName'].'</td></tr>';
}

while ($liste = mysqli_fetch_assoc($rq6)){
$result6.= '<tr><td>'.$liste['title'].'</td><td> par '.$liste['performer'].'</td><td> Le '.$liste['date'].'</td><td> à '.$liste['startTime'].'</td></tr>';
}




?>

<!DOCTYPE html>
<html>

<head>
    <title>Informations culturelles</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    

    <div class="container-fluid">
        <h1>Colyseum</h1>
        <div class="row">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-home" aria-selected="true">Liste des clients</a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-profile" aria-selected="false">Les différents types d'évènements</a>
                    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-messages" aria-selected="false">Les 20 premiers clients selon leur identifiant</a>
                    <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-4" role="tab" aria-controls="v-pills-settings" aria-selected="false">Les clients possèdant la carte de fidélité</a>
                    <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-5" role="tab" aria-controls="v-pills-settings" aria-selected="false">Clients par lettre M</a>
                    <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-6" role="tab" aria-controls="v-pills-settings" aria-selected="false">Tous les spectacles</a>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div><?php echo "<table>$result1</table>";?></div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div><?php echo "<table>$result2</table>";?></div>                    
                    </div>
                    <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <div><?php echo "<table>$result3</table>";?></div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                        <div><?php echo "<table>$result4</table>";?></div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-5" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                        <form method="POST" action="">
                        <input id="lettre">
                        <button>Rechercher</button>
                        </form>
                        <div><?php echo "<table>$result5</table>";?></div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-6" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    <div><?php echo "<table>$result6</table>";?></div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</body>

<script>
document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>