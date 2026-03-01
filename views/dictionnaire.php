<?php require_once __DIR__ . '/layout/header.php'; ?>

    <div class="container">

        <h1>📖 Dictionnaire Mooré</h1>

        <!-- Barre de recherche -->
        <form action="/ApprendreMoore/public/index.php" method="GET">
            <input type="hidden" name="page" value="dictionnaire">
            <input type="hidden" name="action" value="rechercher">
            <div class="search-bar">
                <input
                    type="text"
                    name="q"
                    placeholder="Rechercher un mot en mooré ou en français..."
                    value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                >
                <button type="submit">🔍 Rechercher</button>
            </div>
        </form>

        <!-- Message si aucun résultat -->
        <?php if (empty($mots)): ?>
            <p class="no-result">Aucun mot trouvé.</p>

        <?php else: ?>

            <!-- Tableau des mots -->
            <table>
                <thead>
                <tr>
                    <th>Mot en Mooré</th>
                    <th>Traduction (Français)</th>
                    <th>Catégorie</th>
                    <th>Date d'ajout</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($mots as $mot): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($mot['mot_moore']) ?></strong></td>
                        <td><?= htmlspecialchars($mot['traduction_fr']) ?></td>
                        <td>
                            <?= $mot['nom_categorie']
                                ? htmlspecialchars($mot['nom_categorie'])
                                : '<span class="no-cat">Non classé</span>'
                            ?>
                        </td>
                        <td><?= date('d/m/Y', strtotime($mot['date_ajout'])) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>

    </div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>