<?

/*
 * (c) 2010 - Cooperativa de Trabajo Alyssa Limitada
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Sergio Fabian Vier <sergio.vier@alyssa-it.com>
 * @version    SVN: $Id$
 */
class sfAlyssaSms{

  protected $provider;
  protected $number;
  protected $subject;
  protected $sender;


  /**
   * Crea una instancia para el envio de sms.
   *
   * @param ProviderSms $provider el proveedor del servicio de envio de sms
   * @param arrya $data opcional, datos para el envio del sms, en la forma:
   *  - "number"    => "value"
   *  - "subject"   => "value"
   *  - "sender" => "value"
   *
   */
  public function __construct(ProviderSms $provider, $data = array()){

    $this->provider = $provider;

    $this->number   = sfConfig::get('app_sms_number');
    $this->subject  = sfConfig::get('app_sms_subject');
    $this->sender   = sfConfig::get('app_sms_sender');

    if (isset($data['sender'])){
      $this->sender = $data['sender'];
    }
    if (isset($data['number'])){
      $this->number = $data['number'];
    }
    if (isset($data['subject'])){
      $this->subject = $data['subject'];
    }
  }

  /**
   * Envia el sms.
   *
   * La recepcion por parte del destinatario no es asegurado.
   *
   * @return boolean retorna true si pudo generarse el sms.
   */
  public function send(){
    return $this->provider->send($this->sender, $this->number, $this->subject);
  }

  /**
   * Notifica el evento enviando el sms.
   *
   */
  static public function notify(sfEvent $event){
    $data = array();

    if (isset($event['number'])){
      $data['number'] = $event['number'];
    }
    if (isset($event['subject'])){
      $data['subject'] = $event['subject'];
    }
    if (isset($event['sender'])){
      $data['sender'] = $event['sender'];
    }

    $who   = sfConfig::get('app_sms_number');
    if (isset($event['provider'])){
      $who = $event['provider'];
    }

    switch($who){
      case 'daemon':
        $provider = new ProviderSms_Daemon();
        break;
      case 'web_service':
        $provider = new ProviderSms_WebService();
        break;
      default:
        $provider = new ProviderSms_Null();
        break;
    }

    $sender = new sfAlyssaSms($provider, $data);

    $sender->send();
  }
}
?>
