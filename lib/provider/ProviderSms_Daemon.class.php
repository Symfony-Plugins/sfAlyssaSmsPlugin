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
class ProviderSms_Daemon implements ProviderSms {

  protected $dirSalida;
  protected $user;

  public function __construct($options = array()){

    $this->dirSalida = sfConfig::get('app_sms_daemon_dir_salida');
    if (isset($options['dir_salida'])){
      $this->dirSalida = $options['dir_salida'];
    }

    $this->user = sfConfig::get('app_sms_daemon_user');
    if (isset($options['user'])){
      $this->user = $options['user'];
    }

  }

	/**
	 * Envia un sms al numero dado, con el asunto dado.
	 *
	 * En la vida real se genera un archivo que representa el sms
	 * y el cual debe ser enviado por el modem conectado con 'smstools'.
	 *
	 * @see Mensajeria::generarSms()
	 *
	 * @param string $remitente el que envia el sms
	 * @param string $numero el numero a quien va dirigido el sms
	 * @param strign $asunto el asunto del sms
	 *
	 * @return boolean retorna true si se pudo crear correctamente el sms
	 */
	public function send($remitente, $numero, $asunto){


		return $this->generarSms($remitente, $numero, $asunto);

	}

	/**
	 * genera el sms en formato archivo para ser enviado.
	 *
	 * Tiene en cuenta el tamaño del mensaje, y de ser necesario lo particiona
	 * a partir del caracter 120 de modo de ser compatible entre todas las
	 * operadoras telefonicas.
	 *
	 * @param string $remitente el que envia el sms
	 * @param integer $numero el numero de celular a quien va dirigido el sms
	 * @param string $mensaje el mensaje a incluir en el sms
	 *
	 * @return boolean retorna true si se pudo crear y escribir correctamente el archivo
	 *
	 */
	private function generarSms($remitente, $numero, $mensaje){
		$retorno = false;

    if (strlen($mensaje) > 120){
      $retorno = $this->generarArchivoSmsMultiple($remitente, $numero, $mensaje);
    }else{
      $retorno = $this->generarArchivoSms($remitente, $numero, $mensaje);
    }

		return $retorno > 0 ? true : false;
	}

	/**
	 * genera UN archivo con el formato de un sms conteniendo el mensaje
	 * deseado, destinado a un numero de celular en particular.
	 *
	 * @param string $remitente el que envia el sms
	 * @param integer $numero el numero de celular a quien va dirigido el sms
	 * @param string $mensaje el mensaje a incluir en el sms
	 *
	 * @return boolean retorna true si se pudo crear y escribir correctamente el archivo
	 */
	private function generarArchivoSms($remitente, $numero, $mensaje){
		$retorno = false;
		//creo el archivo con el nombre
		$nombreArchivo = "send_".time();

    $file = $this->dirSalida ."/". $nombreArchivo;

		//armo el formato del sms
		$formatoSms = "From: " .$remitente. "\nTo: " .$numero. "\n\n" .$mensaje. "\n";
		//escribir el archivo con el formato..
		$retorno = file_put_contents($file, $formatoSms);
    chmod($file, 0777);

		return $retorno;
	}

	/**
	 * genera MULTIPLES archivos con el formato de un sms conteniendo el mensaje
	 * deseado, destinado a un numero de celular en particular.
	 *
	 * @see Mensajeria::generarArchivoSms()
	 *
	 * @param string $remitente el que envia el sms
	 * @param integer $numero el numero de celular a quien va dirigido el sms
	 * @param string $mensaje el mensaje a incluir en el sms
	 *
	 * @return boolean retorna true si se pudo crear y escribir correctamente el archivo
	 *
	 */
	private function generarArchivoSmsMultiple($remitente, $numero, $mensaje, $dirSalida){
		$retorno = false;
		//entro a separar en dos
		$arrayMensaje = self::dividirMensaje($mensaje);
		//genero la primera parte
		$a = self::generarArchivoSms($numero, $arrayMensaje[0], $dirSalida);
		sleep(1); //para no generar conflictos con el nombre del archivo.
		//genero la segunda parte
		$b = self::generarArchivoSms($numero, $arrayMensaje[1], $dirSalida);
		$retorno = ($a & $b);

		return $retorno;
	}


	private function dividirMensaje($mensaje){

		//deseo dividir en un espacio
		//$pos = strpos($mensaje, " ", 110);
		$retorno = str_split($mensaje, 110);

		$retorno[0] = $retorno[0] . " (parte 1)";
		$retorno[1] = $retorno[1] . " (parte 2)";

		return $retorno;
	}
}
?>
