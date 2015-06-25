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

// namespace del modelo
namespace sowerphp\app\Sistema\General;

/**
 * Clase para mapear la tabla moneda_cambio de la base de datos
 * Comentario de la tabla:
 * Esta clase permite trabajar sobre un registro de la tabla moneda_cambio
 * @author SowerPHP Code Generator
 * @version 2015-05-14 01:01:15
 */
class Model_MonedaCambio extends \Model_App
{

    // Datos para la conexión a la base de datos
    protected $_database = 'default'; ///< Base de datos del modelo
    protected $_table = 'moneda_cambio'; ///< Tabla del modelo

    // Atributos de la clase (columnas en la base de datos)
    public $desde; ///< char(3) NOT NULL DEFAULT '' PK
    public $a; ///< char(3) NOT NULL DEFAULT '' PK
    public $fecha; ///< date() NOT NULL DEFAULT '0000-00-00' PK
    public $valor; ///< float(12) NOT NULL DEFAULT ''

    // Información de las columnas de la tabla en la base de datos
    public static $columnsInfo = array(
        'desde' => array(
            'name'      => 'Desde',
            'comment'   => '',
            'type'      => 'char',
            'length'    => 3,
            'null'      => false,
            'default'   => '',
            'auto'      => false,
            'pk'        => true,
            'fk'        => null
        ),
        'a' => array(
            'name'      => 'A',
            'comment'   => '',
            'type'      => 'char',
            'length'    => 3,
            'null'      => false,
            'default'   => '',
            'auto'      => false,
            'pk'        => true,
            'fk'        => null
        ),
        'fecha' => array(
            'name'      => 'Fecha',
            'comment'   => '',
            'type'      => 'date',
            'length'    => null,
            'null'      => false,
            'default'   => '0000-00-00',
            'auto'      => false,
            'pk'        => true,
            'fk'        => null
        ),
        'valor' => array(
            'name'      => 'Valor',
            'comment'   => '',
            'type'      => 'float',
            'length'    => 12,
            'null'      => false,
            'default'   => '',
            'auto'      => false,
            'pk'        => false,
            'fk'        => null
        ),

    );

    // Comentario de la tabla en la base de datos
    public static $tableComment = '';

    public static $fkNamespace = array(); ///< Namespaces que utiliza esta clase

}