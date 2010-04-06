<?

/*
 * (c) 2010 - Cooperativa de Trabajo Alyssa Limitada
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    plugin
 * @subpackage provider
 * @author     Sergio Fabian Vier <sergio.vier@alyssa-it.com>
 */
class ProviderSms_Null implements ProviderSms{



  public function __construct($options = array()){

    $this->dir = sfConfig::get('app_sms_null_output_dir');
    if (isset($options['output_dir'])){
      $this->dir = $options['output_dir'];
    }

  }

  /**
   * Envia el sms.
   *
   * El sms no es creado en realidad, solo se hace salida en el archivo de log
   * sms.log del sms teorico a enviar.
   *
   * @param string $sender el que envia el sms.
   * @param numeric $number el numero al cual se envia el sms.
   * @param string $subject el mensaje a enviar en el sms.
   *
   * @return boolean
   *
   */
  public function send($sender, $number, $subject){
    $dispatcher = sfContext::getInstance()->getEventDispatcher();
    $configuration = sfContext::getInstance()->getConfiguration();
    $file_logger = new sfFileLogger($dispatcher, array('file' => $configuration->getRootDir().'/log/sms.log'));

    $salida = "sender: '".$sender."' number: '".$number."' subject '".$subject."'";
    $file_logger->log($salida);

    return true;
  }

}
