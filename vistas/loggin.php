<?php
/**
 * Página de inicio de sesión
 */
?>
<!DOCTYPE html>
<html>
    <?php require_once "head.php" ?>
    <body>
        <?php require_once "header.php" ?>
        <section>
            <article>
                <p>
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                        <label>Nombre de Usuario:</label>
                        <input type="text" name="username" placeHolder="Escriba su usuario aquí"/>
                        <label>Contraseña:</label>
                        <input type="password" name="password" placeHolder="Escriba su usuario aquí"/>
                        <input type="submit" value="Acceder">
                    </form>
                </p>
            </article>
        </section>
        <?php require_once "scripts.php" ?>
    </body>
</html>