<!DOCTYPE html>
<html>
    <?php require_once dirname(__FILE__)."/head.php" ?>
    <body>
        <?php require_once dirname(__FILE__)."/header.php" ?>
        <?php require_once dirname(__FILE__)."/aside.php" ?>
        </aside>
        <section class="row">
            <article class="small-9 medium-9 large-9 columns">
                <div class="panel">
                    <h1>Página no encontrada</h1>
                    <p><?php print_r($_GET); print_r($_POST); ?></p>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/footer.php" ?>
        <?php require_once dirname(__FILE__)."/scripts.php" ?>
    </body>
</html>