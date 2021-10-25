<?php
// Programme Annuaire

// Fonction qui permet d'entrer le nom et prénom de la personne
function NamePERS()
{
    return readline("Veuillez indiquez le Nom et Prénom : ");
}

function RechercheInArray($json_file, $search_value)
{
    foreach ($json_file as $key => $json_line) {
        if ($json_line['name'] === $search_value) {
            return $key;
            break;
        }
    }
}

// Fonction qui permet d'afficher une erreur si le Nom et Prénom de la personne est incorrect ou introuvable

function displayError($msg)
{
    echo $msg;
    exit;
}

// Fonction qui permet de rechercher le numéro la position et l'étape de la personne

function recherche(array $arr, $start, $end, $x, $step = 0)
{
    $step++;
    if ($end < $start)
        return json_encode([
            'success' => false
        ]);
    $mid = floor(($end + $start) / 2);
    if ($arr[$mid]["name"] == $x)
        return json_encode([
            'success' => true,
            'numero' => $arr[$mid]['num'],
            'position' => $mid,
            'step' => $step
        ]);
    elseif ($arr[$mid]["name"] > $x)
        return recherche($arr, $start, $mid - 1, $x, $step);
    else
        return recherche($arr, $mid + 1, $end, $x, $step);
}
$json_file = file_get_contents('annuaire.json');
$json_file = json_decode($json_file, true);

$search_value = NamePERS();

$datas = json_decode(recherche($json_file, 0, count($json_file) - 1, $search_value));

// Affichage du numéro, de la position et de l'étape

if ($datas->success == true)
    echo "Voici le numéro : "
        . PHP_EOL .
        ' Le Numéro est : ' . $datas->numero
        . PHP_EOL .
        ' La Position est : ' . $datas->position
        . PHP_EOL .
        ' L Étapes est : ' . $datas->step;

else echo displayError('Le nom recherché n existe pas');