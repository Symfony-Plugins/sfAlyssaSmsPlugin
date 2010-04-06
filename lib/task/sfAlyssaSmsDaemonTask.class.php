<?php

/*
 * (c) 2010 - Cooperativa de Trabajo Alyssa Limitada
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    plugin
 * @subpackage task
 * @author     Sergio Fabian Vier <sergio.vier@alyssa-it.com>
 */
class sfAlyssaSmsDaemonTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    //$this->addArguments(array(
    //  new sfCommandArgument('username', sfCommandArgument::OPTIONAL, 'The user name'),
    //  new sfCommandArgument('group', sfCommandArgument::OPTIONAL, 'The group name'),
    //));
    //
    //$this->addOptions(array(
    //  new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
    //  new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    //  new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
    //));

    $this->namespace = 'alyssa';
    $this->name = 'daemon';
    $this->briefDescription = 'Ejecuta un daemon para recibir los sms con \'smstools\'';

    $this->detailedDescription = <<<EOF
La tarea [alyssa:daemon|INFO] ejecuta un recorrido por los directorios, enviando
los archivos recibidos como sms por medio de 'smstools'.

La sintaxis es como sigue:

  [./symfony alyssa:daemon |INFO]

El daemon debe estar propiamente configurado en el archivo app.yml.
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {

  }
}