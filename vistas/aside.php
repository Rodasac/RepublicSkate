        <aside>
            <div class="small-3 medium-3 large-3 columns">
                <article>
                    <div class="panel radioBordeSec">
                        <h4 class="Titles">Los últimos 3 productos</h4>
                        <ul class="side-nav" id="prod_nuevos">
                            <?php
                                $products2 = $entityManager->createQuery("SELECT p FROM Product p ORDER BY p.id DESC")
                                    ->setMaxResults(3)
                                    ->getResult();

                            foreach($products2 as $productaside):?>
                                <li class="divider"></li>
                                <li><a href="/producto/?id=<?php echo $productaside->getId(); ?>"><?php echo $productaside->getName(); ?></a></li>
                                <li class="divider"></li>
                            <?php endforeach;
                                  $products2 = null;
                            ?>
                        </ul>
                    </div>
                </article>
                <article>
                    <div class="panel radioBordeSec">
                        <h3 class="Titles">Buscar productos</h3>
                        <ul class="side-nav">
                            <li>
                                <form action="/prodsearch/" method="post">
                                    <label for="name" class="label">Por nombre</label>
                                    <input id="name" type="text" name="name" placeholder="Escribe el nombre"/>
                                    <input class="button tiny secondary" type="submit" name="submit" value="Buscar"/>
                                </form>
                            </li>
                            <li>
                                <form action="/prodsearch/" method="post">
                                    <label for="cat" class="label">Por categoria</label>
                                    <select id="cat" name="cat">
                                        <option value="">---</option>
                                        <?php
                                        $categoryRepository = $entityManager->getRepository('Category');
                                        $categories = $categoryRepository->findAll();?>
                                        <?php foreach($categories as $category): ?>
                                            <option value="<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input class="button tiny secondary" type="submit" name="submit" value="Buscar"/>
                                </form>
                            </li>
                        </ul>
                    </div>
                </article>
                <?php if($user = Sentry::getUser()):?>
                    <?php if ($user->hasAccess('write')): ?>
                        <article>
                            <div class="panel radioBordeSec">
                                <h3 class="Titles">Buscar tickets</h3>
                                <ul class="side-nav">
                                    <li>
                                        <form action="/ticket/" method="post">
                                            <label for="id" class="label">Ingresar el ID del Ticket</label>
                                            <input id="id" type="text" name="name" placeholder="Ej: 123"/>
                                            <input class="button tiny secondary" type="submit" name="submit" value="Buscar"/>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </aside>