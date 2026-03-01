<?php

class MotModel
{
    // La connexion PDO, partagée par toutes les méthodes
    private $pdo;

    // Le constructeur reçoit la connexion et la stocke
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // =============================================
    // LIRE - Récupérer tous les mots avec leur catégorie
    // =============================================
    public function getTousMots()
    {
        $sql = "SELECT d.id, d.mot_moore, d.traduction_fr, d.date_ajout,
                       c.nom_categorie
                FROM dictionnaire d
                LEFT JOIN categories c ON d.id_categorie = c.id
                ORDER BY d.mot_moore ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // =============================================
    // LIRE - Récupérer un seul mot par son id
    // =============================================
    public function getMotById($id)
    {
        $sql = "SELECT d.id, d.mot_moore, d.traduction_fr, d.date_ajout,
                       c.nom_categorie
                FROM dictionnaire d
                LEFT JOIN categories c ON d.id_categorie = c.id
                WHERE d.id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // =============================================
    // LIRE - Rechercher un mot (mooré ou français)
    // =============================================
    public function rechercherMot($recherche)
    {
        $sql = "SELECT d.id, d.mot_moore, d.traduction_fr, d.date_ajout,
                       c.nom_categorie
                FROM dictionnaire d
                LEFT JOIN categories c ON d.id_categorie = c.id
                WHERE d.mot_moore LIKE :recherche
                OR d.traduction_fr LIKE :recherche
                ORDER BY d.mot_moore ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':recherche' => '%' . $recherche . '%']);
        return $stmt->fetchAll();
    }

    // =============================================
    // LIRE - Récupérer les mots par catégorie
    // =============================================
    public function getMotsParCategorie($id_categorie)
    {
        $sql = "SELECT d.id, d.mot_moore, d.traduction_fr, d.date_ajout,
                       c.nom_categorie
                FROM dictionnaire d
                LEFT JOIN categories c ON d.id_categorie = c.id
                WHERE d.id_categorie = :id_categorie
                ORDER BY d.mot_moore ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_categorie' => $id_categorie]);
        return $stmt->fetchAll();
    }

    // =============================================
    // CRÉER - Ajouter un nouveau mot (admin seulement)
    // =============================================
    public function ajouterMot($mot_moore, $traduction_fr, $id_categorie)
    {
        $sql = "INSERT INTO dictionnaire (mot_moore, traduction_fr, id_categorie)
                VALUES (:mot_moore, :traduction_fr, :id_categorie)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':mot_moore'     => $mot_moore,
            ':traduction_fr' => $traduction_fr,
            ':id_categorie'  => $id_categorie
        ]);
        return $this->pdo->lastInsertId(); // retourne l'id du mot créé
    }

    // =============================================
    // MODIFIER - Mettre à jour un mot (admin seulement)
    // =============================================
    public function modifierMot($id, $mot_moore, $traduction_fr, $id_categorie)
    {
        $sql = "UPDATE dictionnaire
                SET mot_moore = :mot_moore,
                    traduction_fr = :traduction_fr,
                    id_categorie = :id_categorie
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id'            => $id,
            ':mot_moore'     => $mot_moore,
            ':traduction_fr' => $traduction_fr,
            ':id_categorie'  => $id_categorie
        ]);
    }

    // =============================================
    // SUPPRIMER - Supprimer un mot (admin seulement)
    // =============================================
    public function supprimerMot($id)
    {
        $sql = "DELETE FROM dictionnaire WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}