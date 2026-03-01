<?php

// On charge la connexion et le Model
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/MotModel.php';

// On crée une instance du Model en lui passant la connexion PDO
$motModel = new MotModel($pdo);

// On récupère l'action demandée dans l'URL, par défaut c'est 'index'
$action = $_GET['action'] ?? 'index';

switch ($action) {

    // =============================================
    // Afficher tous les mots
    // URL : index.php?page=dictionnaire
    // =============================================
    case 'index':
        $mots = $motModel->getTousMots();
        require_once '../views/dictionnaire.php';
        break;

    // =============================================
    // Afficher le détail d'un mot
    // URL : index.php?page=dictionnaire&action=detail&id=5
    // =============================================
    case 'detail':
        $id = $_GET['id'] ?? null;

        // Sécurité : si pas d'id, on redirige vers le dictionnaire
        if (!$id) {
            header('Location: index.php?page=dictionnaire');
            exit;
        }

        $mot = $motModel->getMotById($id);
        require_once '../views/public/detail.php';
        break;

    // =============================================
    // Rechercher un mot
    // URL : index.php?page=dictionnaire&action=rechercher
    // =============================================
    case 'rechercher':
        $recherche = $_GET['q'] ?? '';

        if (empty($recherche)) {
            header('Location: index.php?page=dictionnaire');
            exit;
        }

        $mots = $motModel->rechercherMot($recherche);
        require_once '../views/dictionnaire.php';
        break;

    // =============================================
    // Filtrer par catégorie
    // URL : index.php?page=dictionnaire&action=categorie&id=3
    // =============================================
    case 'categorie':
        $id_categorie = $_GET['id'] ?? null;

        if (!$id_categorie) {
            header('Location: index.php?page=dictionnaire');
            exit;
        }

        $mots = $motModel->getMotsParCategorie($id_categorie);
        require_once '../views/dictionnaire.php';
        break;

    // Si l'action n'existe pas, on redirige vers le dictionnaire
    default:
        header('Location: index.php?page=dictionnaire');
        exit;
}
