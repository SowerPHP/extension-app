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

namespace sowerphp\app;

/**
 * Clase que sirve para extender la clase Controller, este archivo
 * deberá ser sobreescrito en cada una de las aplicaciones
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2015-04-28
 */
class Controller_App extends \sowerphp\core\Controller
{

    public $components = ['Auth', 'Api', 'Log']; ///< Componentes usados por el controlador
    public $Cache; ///< Objeto para usar el caché
    public $log_facility = LOG_USER; ///< Origen por defecto de los eventos de los controladores

    /**
     * Constructor de la clase
     * @param request Objeto con la solicitud realizada
     * @param response Objeto para la respuesta que se enviará al cliente
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
     * @version 2014-10-16
     */
    public function __construct (\sowerphp\core\Network_Request $request, \sowerphp\core\Network_Response $response)
    {
        parent::__construct ($request, $response);
        $this->Cache = new \sowerphp\core\Cache();
        $this->set('_Auth', $this->Auth);
    }

    /**
     * Método para permitir el acceso a las posibles funcionalidades de la API
     * del controlador que se está ejecutando. Aquí no se validan permisos para
     * la funcionalidad, estos deberán ser validados en cada función
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
     * @version 2014-12-01
     */
    public function beforeFilter()
    {
        $this->Auth->allow('api');
        parent::beforeFilter();
    }

    /**
     * Método que lanza el servicio web que se ha solicitado
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
     * @version 2014-12-02
     */
    public function api($resource, $args = null)
    {
        call_user_func_array([$this->Api, 'run'], func_get_args());
    }

}
