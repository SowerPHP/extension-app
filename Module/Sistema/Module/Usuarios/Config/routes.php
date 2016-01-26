<?php

/**
 * SowerPHP: Minimalist Framework for PHP
 * Copyright (C) SowerPHP (http://sowerphp.org)
 *
 * Este programa es software libre: usted puede redistribuirlo y/o
 * modificarlo bajo los términos de la Licencia Pública General GNU
 * publicada por la Fundación para el Software Libre, ya sea la versión
 * 3 de la Licencia, o (a su elección) cualquier versión posterior de la
 * misma.
 *
 * Este programa se distribuye con la esperanza de que sea útil, pero
 * SIN GARANTÍA ALGUNA; ni siquiera la garantía implícita
 * MERCANTIL o de APTITUD PARA UN PROPÓSITO DETERMINADO.
 * Consulte los detalles de la Licencia Pública General GNU para obtener
 * una información más detallada.
 *
 * Debería haber recibido una copia de la Licencia Pública General GNU
 * junto a este programa.
 * En caso contrario, consulte <http://www.gnu.org/licenses/gpl.html>.
 */

\sowerphp\core\Routing_Router::connect('/usuarios/ingresar', array(
    'module' => 'Sistema.Usuarios',
    'controller' => 'usuarios',
    'action' => 'ingresar',
));

\sowerphp\core\Routing_Router::connect('/usuarios/ingresar/*', array(
    'module' => 'Sistema.Usuarios',
    'controller' => 'usuarios',
    'action' => 'ingresar',
));

\sowerphp\core\Routing_Router::connect('/usuarios/salir', array(
    'module' => 'Sistema.Usuarios',
    'controller' => 'usuarios',
    'action' => 'salir',
));

\sowerphp\core\Routing_Router::connect('/usuarios/perfil', array(
    'module' => 'Sistema.Usuarios',
    'controller' => 'usuarios',
    'action' => 'perfil',
));

\sowerphp\core\Routing_Router::connect('/usuarios/contrasenia/recuperar', array(
    'module' => 'Sistema.Usuarios',
    'controller' => 'usuarios',
    'action' => 'contrasenia_recuperar',
));

\sowerphp\core\Routing_Router::connect('/usuarios/contrasenia/recuperar/*', array(
    'module' => 'Sistema.Usuarios',
    'controller' => 'usuarios',
    'action' => 'contrasenia_recuperar',
));

\sowerphp\core\Routing_Router::connect('/usuarios/registrar', array(
    'module' => 'Sistema.Usuarios',
    'controller' => 'usuarios',
    'action' => 'registrar',
));

\sowerphp\core\Routing_Router::connect('/usuarios/preauth', array(
    'module' => 'Sistema.Usuarios',
    'controller' => 'usuarios',
    'action' => 'preauth',
));

\sowerphp\core\Routing_Router::connect('/usuarios/preauth/*', array(
    'module' => 'Sistema.Usuarios',
    'controller' => 'usuarios',
    'action' => 'preauth',
));
