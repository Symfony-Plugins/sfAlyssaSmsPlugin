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
class ProviderSms_WebService implements ProviderSms {

  protected $textMagic = null;
  protected $username  = null;
  protected $password  = null;
  protected $unicode   = null;

  public function __construct($options = array()){

    $this->username = sfConfig::get('app_sms_web_service_username');
    if (isset($options['username'])){
      $this->username = $options['username'];
    }

    $this->password = sfConfig::get('app_sms_web_service_api_key');
    if (isset($options['password'])){
      $this->password = $options['password'];
    }

    $this->unicode = sfConfig::get('app_sms_web_service_unicode');
    if (isset($options['unicode'])){
      $this->unicode = $options['unicode'];
    }

    $this->textMagic = new TextMagicAPI(array('username' => $this->username,
                                              'password' => $this->password));

  }

  public function send($remitente, $numero, $asunto){
    $salida = null;

    if (!is_string($numero) & !is_array($numero)){
      throw new Exception("Parametro numero invalido.");
    }

    if (!is_string($asunto)){
      throw new Exception("Parametro asunto invalido.");
    }

    if (!is_array($numero)){
      $numero = array($numero);
    }

    try{
      $salida = $this->textMagic->send($asunto, $numero, $this->unicode);
    }
    catch(Exception $ex){

    }

    return $salida;
  }

  public function ext(){
    return $this->textMagic;
  }
}
