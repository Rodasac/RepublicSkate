<?php
try{
    $users = Sentry::findAllUsers();
}
catch(Exception $e){
    echo $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html>
    <?php require_once dirname(__FILE__) . "/../head.php" ?>
    <body>
        <?php require_once dirname(__FILE__)."/../header.php" ?>
        <?php require_once dirname(__FILE__)."/../aside.php" ?>
        <section class="row">
            <article class="small-9 medium-9 large-9 columns">
                <div class="panel">
                    <h1 class="Titles">Lista de usuarios</h1>
                    <div class="row panel">
                    <?php if($users): ?>
                        <?php foreach($users as $user2): ?>
                            <h4 class="small-4 medium-4 large-4 columns Titles"><?php echo $user2->first_name." ".$user2->last_name; ?></h4>
                            <div class="small-8 medium-8 large-8 columns">
                                <span class="left"><?php echo $user2->email; ?></span>
                            <?php if($user->hasAccess('write') && $user->id != $user2->id): ?>
                                <form class="right inline" action="/deleteuser/" method="post">
                                    <input type="hidden" name="id" value="<?php echo $user2->id; ?>"/>
                                    <input class="button radius" type="submit" value="Borrar Usuario"/>
                                </form>
                            <?php endif; ?>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="panel alert radius">
                            <h2> No existen productos</h2>
                        </div>
                    <hr>
                    <?php endif; ?>
                    </div>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
        <?php require_once dirname(__FILE__)."/../scripts.php" ?>
    </body>
</html>