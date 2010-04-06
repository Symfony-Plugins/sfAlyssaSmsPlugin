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
Interface ProviderSms{

  /**
   * Envia el sms.
   *
   * @param string $sender el que envia el sms.
   * @param numeric $number el numero al cual se envia el sms.
   * @param string $subject el mensaje a enviar en el sms.
   *
   * @return boolean
   *
   */
  public function send($sender, $number, $subject);

}
