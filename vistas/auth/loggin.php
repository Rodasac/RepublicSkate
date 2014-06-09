<?php
/**
 * Página de inicio de sesión
 */
 // check for form submission
if (isset($_POST['submit'])) {
  try {
    // validate input
    $username = filter_var($_POST['username'], FILTER_SANITIZE_EMAIL);
    $password = strip_tags(trim($_POST['password']));
    
    // set login credentials
    $credentials = array(
      'email'    => $username,
      'password' => $password,
    );

    // authenticate
    $currentUser = Cartalyst\Sentry\Facades\Native\Sentry::authenticate($credentials, false);
    header("location: /");
  } catch (Exception $e) {
    header("location: /login/?error=1");
  }
}
?>
<!DOCTYPE html>
<html>
    <?php require_once dirname(__FILE__) . "/../head.php" ?>
    <body>
        <?php require_once dirname(__FILE__)."/../header.php" ?>
        <section class="row">
            <article class="large-12 columns">
                <div class="panel">
                    <form class ="row" method="POST" action="/login/" >
                        <h3 class="Titles">Acceder</h3>
                        <div id="hide" class="hide">
                            <div data-alert class="alert-box alert round">
                              Usuario o Contraseña Incorrectos.
                              <a href="#" class="close">&times;</a>
                            </div>
                        </div>
                        <label class="large-6 columns">Nombre de Usuario:
                            <input type="email" name="username" placeHolder="Escriba su email aquí"/>
                        </label>
                        <label class="large-6 columns">Contraseña:
                            <input type="password" name="password" placeHolder="Escriba su usuario aquí"/>
                        </label>
                        <input class="button round" name="submit" type="submit" value="Acceder">
                    </form>
                </div>
            </article>
        </section>
        <?php require_once dirname(__FILE__)."/../footer.php" ?>
        <?php require_once dirname(__FILE__)."/../scripts.php" ?>
        <?php if(isset($_GET["error"])):?>
        <script>
            $(document).on(function(){
                $("#hide").removeClass("hide");
            })
        </script>
        <?php endif; ?>
    </body>
</html>