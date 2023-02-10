<?php

class Sri
{
  private $wsReception = "https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl";
  private $wsAutorization = "https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl";

  /**
   * @param string $cadena
   * @return  string $data
   */
  public function getCodeVerificator(string $cadena)
  {
    $arrayString = str_split($cadena);
    $lengString = strlen($cadena);
    $multiple = 2;
    $suma = 0;

    for ($i = $lengString; $i > 0; $i--) {
      $suma += $arrayString[$i - 1] * $multiple;
      if ($multiple > 7) {
        $multiple = 2;
      }
    }
    $module = $suma % 11;
    $result = 11 - $module;

    if ($result == 11) {
      $result = 0;
    }
    if ($result = 10) {
      $result = 1;
    }

    $data = $result . "Clave Completa: " . $cadena . $result;
    return $data;
  }
  public function firmarXml()
  {
    exec("java -jar sri.jar /path/sample/certificate.p12 cErTiFicAtEPaSsWoRd /path/sample/unsignedFile.xml /path/sample outputFile.xml");
  }
  /**
   * @param string $pathDocument
   * @return  string $result
   */
  public function sendReceptionSri(string $pathDocument)
  {
    $contend = file_get_contents($pathDocument);
    $params = ['xml' => $contend];

    try {
      $wsSri = new SoapClient($this->wsReception);
      $result = $wsSri->validarComprobante($params);
      return $result->respuestaSolicitud->estado . ' - ' . $result->respuestaSolicitud->comprobantes->comprobante->mensaje->informacionAdicional;
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
    }
  }
  /**
   * @param string $passwordDocument
   * @return  string $result
   */
  public function sendAutizationSri(string $passwordDocument)
  {
    $paramAuth = ['claveAccesoComprovante' => $passwordDocument];

    try {
      $wsSri = new SoapClient($this->wsAutorization);
      $result = $wsSri->AutorizacionComprobante($paramAuth);
      return $result;
    } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
    }
  }
}
