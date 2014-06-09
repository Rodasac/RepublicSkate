<nav class="top-bar" data-topbar data-options="is_hover: false">
    <ul class="title-area">
        <li class="name">
            <h1><a class="linksNav" href="/?page=1">Inicio</a></h1>
        </li>
        <li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
    </ul>
    <section class="top-bar-section">
        <ul class="left">
            <li class="divider hide-for-small"></li>
            <li>
                <a class="links" href="/productos/?page=1" title="Lista de Productos">Productos</a>
            </li>
            <li>
                <a class="links" href="/categorias/?page=1" title="Lista de Categorias">Categorias</a>
            </li>
            <li>
                <a class="links" href="/acerca">Acerca de...</a>
            </li>
        </ul>
        <?php if( !Sentry::check()):?>
            <ul class="right button-group">
                <li><a href="/login" class="button [tiny small large]">Acceder</a></li>
                <li><a href="/registrarse/" class="button [tiny small large]">Registrarse</a></li>
            </ul>
        <?php else:?>
            <ul class="left">
                <li class="car">
                    <a href="#" data-reveal-id="Modal" class="radius button">
                        <img src="/static/img/ext/bag.png" width="25px"/>
                        <h6 class="secondary radius label"><?php
                                if(isset($_SESSION['carrito'])){
                                    echo count($_SESSION['carrito']);
                                }
                                else{
                                    echo 0;
                                }
                            ?></h6>
                    </a>
                </li>
            </ul>
            <ul class="right">
                <?php if($user = Sentry::getUser()): ?>
                        <?php if ($user->hasAccess('write')): ?>
                            <li class="has-dropdown">
                                <a>Administar</a>
                                <ul class="dropdown">
                                  <li><a href="/addCategory/">Agregar Categoria</a></li>
                                  <li><a href="/addProduct/">Agregar Producto</a></li>
                                  <li><a href="/addNovedad/">Agregar Novedad</a></li>
                                  <li class="divider"></li>
                                  <li><a href="/userlist/">Lista de Usuarios</a></li>
                                  <li class="has-dropdown">
                                      <a data-dropdown="hover1" data-options="is_hover:true; align: left;">Reportes</a>
                                      <ul id="hover1" class="f-dropdown drop2" data-dropdown-content>
                                          <li><a href="/tickets/?page=1">Ver tickets</a></li>
                                          <li><a href="/reportes/?tipo=1" target="_blank">Reporte de ventas</a></li>
                                          <li><a href="/reportes/?tipo=2" target="_blank">Reporte de este mes en curso</a></li>
                                      </ul>
                                  </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li class="has-dropdown">
                            <a class="button round"><?php echo $user->first_name; ?></a>
                            <ul class="dropdown">
                                <li><a href="/update/">Modificar datos</a></li>
                                <li><a href="/perfil/">Ver perfil</a></li>
                                <li><a href="/logout/">Salir</a></li>
                            </ul>
                        </li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </section>
</nav>
<?php require_once dirname(__FILE__)."/../modulos/Carrito/carrito.php";?>
<div id="Modal" class="reveal-modal" data-reveal style="background-attachment: scroll;">
    <h2 class="lead">Carrito de compras</h2>
    <hr/>
    <div class="contained">
        <?php
        $total = 0;
        if(!isset($errorCar)):
            ?>
            <?php

            foreach($datos as $carrito):
            ?>
            <div class="left">
            <p class="lead"><strong><?php echo $carrito['nombre']; ?></strong></p>
            <p><img class="th radius" width="100px" title="Imagen del producto" src="/uploads<?php echo $carrito['imagen']; ?>"/></p>
            <p>Precio: Bs. <?php echo $carrito['precio']; ?></p>
            <p>Cantidad ordenada: <?php echo $carrito['cantidad']; ?></p>
            </div>
            <div class="right">
                <form action="/carrito/" method="post">
                    <input name="idprod" type="hidden" value="<?php echo $carrito['idprod'];?>">
                    <input id="cant" name="act" type="number" min="0" placeholder="Agregar más">
                    <input class="button tiny success round" name="submitcar" type="submit" value="Agregar al carrito">
                </form>
                <form action="/carrito/" method="post">
                    <input name="idprod" type="hidden" value="<?php echo $carrito['idprod'];?>">
                    <input id="cant" name="dis" type="number" min="0" placeholder="Disminuir cantidad">
                    <input class="button tiny success round" name="submitcar" type="submit" value="Disminuir">
                </form>
                <form action="/carrito/" method="post">
                    <input name="idprod" type="hidden" value="<?php echo $carrito['idprod'];?>">
                    <input name="quitar" type="hidden" value="1">
                    <input class="button tiny alert round" name="submitcar" type="submit" value="Quitar del carrito">
                </form>
            </div>
            <hr/>
            <?php
                $subtotal = (int)$carrito['precio'] * (int)$carrito['cantidad'];
                $total += (int)$subtotal;
            endforeach;
            ?>
            <p><strong>Total: </strong>Bs. <?php echo $total; ?></p>
            <div>
                <form class="left" action="/comprar/" method="post">
                    <?php
                    foreach($datos as $car):
                        ?>
                        <input name="id[]" type="hidden" value="<?php echo $car['idprod'];?>">
                        <input name="cantOrd[]" type="hidden" value="<?php echo $car['cantidad'];?>">
                    <?php
                    endforeach;
                    ?>
                    <input name="total" type="hidden" value="<?php echo $total;?>">
                    <input class="button medium success round" name="submit" type="submit" value="Comprar">
                </form>
                <form class="right" action="/carrito/" method="post">
                    <input name="vaciar" value="1" type="hidden">
                    <input class="button medium success round" name="submitcar" type="submit" value="Vaciar carrito">
                </form>
            </div>
        <?php
        else:
            ?>
            <p class="car">
                <?php echo $errorCar; ?>
            </p>
        <?php
        endif;
        ?>
    </div>
    <a class="close-reveal-modal">&#215;</a>
</div>
<div id="ModalProductos" class="reveal-modal" data-reveal>
    <h2 class="lead">Info</h2>
    <hr/>
    <div class="panel callout radius">
        <p>Producto(s) agregado(s) correctamente</p>
    </div>
    <a class="close-reveal-modal">&#215;</a>
</div>
<div id="ModalVaciar" class="reveal-modal" data-reveal>
    <h2 class="lead">Info</h2>
    <hr/>
    <div class="panel callout radius">
        <p>El carrito ha sido vaciado completamente</p>
    </div>
    <a class="close-reveal-modal">&#215;</a>
</div>
<header class="panel radioBorde backgd">
    <div class="row">
        <div class="large-12 columns">
            <h1 class="HeaderTitle">Republic Skate S.R.L.
                <small class="smallHead">Tienda Online</small></h1>
        </div>
    </div>
</header>
