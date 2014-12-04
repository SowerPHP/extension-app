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
 * Componente para proveer una API para funciones de los controladores
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2014-12-01
 */
class Controller_Component_Api extends \sowerphp\core\Controller_Component
{

    public $method; ///< Método HTTP que se utilizó para acceder a la API
    public $headers; ///< Cabeceras HTTP de la solicitud que se hizo a la API
    public $data; ///< Datos que se han pasado a la función de la API

    /**
     * Método para inicializar la función de la API que se está ejecutando
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
     * @version 2014-12-02
     */
    private function init()
    {
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
        $this->headers = $this->controller->request->header();
        $this->data = json_decode(file_get_contents('php://input'), true);
        $this->controller->response->type('application/json');
    }

    /**
     * Método principal para ejecutar las funciones de la API. Esta buscará y
     * lanzará las funciones, obteniendo su resultado y devolvíendolos a quien
     * solicitó la ejecución. Este método es el que controla las funciones del
     * controlador que se está ejecutando.
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
     * @version 2014-12-02
     */
    public function run($resource, $args = null)
    {
        // inicializar api
        $this->init();
        // verificar que la función de la API del controlador exista
        $method = '_api_'.$resource.'_'.$this->method;
        if (!method_exists($this->controller, $method)) {
            $this->send(
                sprintf(
                    'Recurso %s a través de %s no existe en la API %s',
                    $resource,
                    $this->method,
                    get_class($this->controller)
                ), 404
            );
        }
        // verificar que a lo menos se hayan pasado los argumentos requeridos
        $n_args = func_num_args() - 1;
        $reflectionMethod = new \ReflectionMethod($this->controller, $method);
        if ($n_args<$reflectionMethod->getNumberOfRequiredParameters()) {
            $args = [];
            foreach($reflectionMethod->getParameters() as &$p) {
                $args[] = $p->isOptional() ? '['.$p->name.']' : $p->name;
            }
            $this->send(
                sprintf(
                    'Argumentos insuficientes para el recurso %s(%s) a través de %s en la API %s',
                    $resource,
                    implode(', ', $args),
                    $this->method,
                    get_class($this->controller)
                ), 400
            );
        }
        unset($reflectionMethod);
        // ejecutar función de la API
        if ($n_args)
            $data = call_user_func_array([$this->controller, $method], array_slice(func_get_args(), 1));
        else
            $data = $this->controller->$method();
        // si se llegó hasta acá es porque no se envió respuesta desde la
        // función en la API
        $this->send($data, 200);
    }

    /**
     * Método que lista los recursos disponibles de la API en el controlador
     * que se está ejecutando
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
     * @version 2014-12-02
     */
    public function resources()
    {
        $resources = [];
        foreach(get_class_methods($this->controller) as $action)
            if (substr($action, 0, 12)=='_api_' && $action!=__FUNCTION__)
                $resources[] = substr($action, 12);
        return $resources;
    }

    /**
     * Método para enviar respuestas hacia el cliente de la API
     * @param data Datos que se enviarán
     * @param status Estado HTTP de resultado de la ejecución de la funcionalidad
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
     * @version 2014-12-01
     */
    public function send($data, $status = 200)
    {
        $this->controller->response->status($status);
        $this->controller->response->send(json_encode($data));
    }

    /**
     * Método que valida las credenciales pasadas a la función de la API del
     * controlador y devuelve el usuario que se autenticó
     * @return Objeto con usuario autenticado o string con el error si hubo uno
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
     * @version 2014-12-01
     */
    public function getAuthUser()
    {
        $auth = isset($this->headers['Authorization']) ? $this->headers['Authorization'] : false;
        if ($auth===false) return $this->controller->Auth->settings['messages']['error']['invalid'];
        list($basic, $user_pass) = explode(' ', $auth);
        list($user, $pass) = explode(':', base64_decode($user_pass));
        // crear objeto del usuario
        $User = new \sowerphp\app\Sistema\Usuarios\Model_Usuario($user);
        // si el usuario no existe -> error
        if (!$User->exists())
            return $this->controller->Auth->settings['messages']['error']['invalid'];
        // si el usuario está inactivo -> error
        if (!$User->isActive())
            return $this->controller->Auth->settings['messages']['error']['inactive'];
        // solo hacer las validaciones de contraseña y auth2 si se está
        // autenticando con usuario y contraseña, si se autentica con el hash
        // ignorar estas validaciones
        if ($user != $User->hash) {
            // si el usuario tiene bloqueada su cuenta por intentos máximos -> error
            if (!$User->contrasenia_intentos)
                return $this->controller->Auth->settings['messages']['error']['login_attempts_exceeded'];
            // si la contraseña no es correcta -> error
            if (!$User->checkPassword($this->controller->Auth->hash($pass))) {
                $User->setContraseniaIntentos($User->contrasenia_intentos-1);
                if ($User->contrasenia_intentos) {
                    return $this->controller->Auth->settings['messages']['error']['invalid'];
                } else {
                    return $this->controller->Auth->settings['messages']['error']['login_attempts_exceeded'];
                }
            }
            // verificar token en sistema secundario de autorización
            if ($this->controller->Auth->settings['auth2'] !== null and !$User->checkToken())
                return $this->controller->Auth->settings['messages']['error']['token'];
            // actualizar intentos de contraseña
            $User->setContraseniaIntentos($this->controller->Auth->settings['maxLoginAttempts']);
        }
        return $User;
    }

}