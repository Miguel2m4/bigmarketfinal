<?php
include("conexion.php");

$meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

@$pedido = $_POST['pedido'];
$sub = 0;

require_once('tcpdf.php');

      class MYPDF extends TCPDF {

          public function Header() {
              $image_file = '../images/titulo.png';
              $this->Image($image_file, 25, 5, 135, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
          }
      }

      // create new PDF document
      $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      // set default header data
      $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

      // set header and footer fonts
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

      // set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      // set margins
      $pdf->SetMargins(10, 20, 10);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

      // set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

      // set image scale factor
      $pdf->setImageScale(1.53);

      // set some language-dependent strings (optional)
      if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
          require_once(dirname(__FILE__).'/lang/eng.php');
          $pdf->setLanguageArray($l);
      }

      $html = '<style>
                  th {border: 1px solid black; text-align:center;background-color:#DBDBDB}
                  td {border: 1px solid black;}
                  .cliente {border : 0px solid #fff;}
                  .text1{border: 0px solid #fff;border-right: 1px solid #000}
                  .text2{line-height:2; font-size:18px}

              </style>';
      $bs = mysql_query("SELECT * from pedidos WHERE Id_pd = '$pedido' ");
        while($resp = mysql_fetch_array($bs))
        {
            $pdf->AddPage();
            $pdf->Write(10, '', '', 0, 'L', true, 0, false, false, 0);
            $pdf->SetFont('times', '', 9);
            $nit = $resp['comprador_pd'];
            $fechaped = $resp['realizado_pd'];
            $fechaped = explode('-',$fechaped);
            $dia = $fechaped[2];
            $mes = $fechaped[1];
            $año = $fechaped[0];

            $bus = mysql_query("SELECT * FROM compradores WHERE Nit_cp = '$nit' ");
            while($res = mysql_fetch_array($bus))
            {
              $nombre = $res['razon_cp'];
              $nit = $res['Nit_cp'];
              $telefono = $res['telefono_cp'];
              $movil = $res['movil_cp'];
              $direccion = $res['direccion_cp'];
              if($movil!='')
                $movil = ' / '.$movil;
              else
                $movil = '';
            }


            $tbl_datos  = '<table cellspacing="0" cellpadding="0" width="50%" >
                            <tr>
                              <th colspan="3" width="300px">Fecha</th>
                              <th rowspan="2"  class="text2">Pedido Nº</th>
                            </tr>
                            <tr>
                              <th>DIA</th>
                              <th>MES</th>
                              <th>AÑO</th>
                            </tr>
                            <tr>
                              <td align="center">'.$dia.'</td>
                              <td align="center">'.$meses[(int)$mes-1].'</td>
                              <td align="center">'.$año.'</td>
                              <td align="center">'.$pedido.'</td>
                            </tr>
                            </table>';
             $divisor = '<br/><br/>
                         <br/><br/>';
            $tb_info1 = '<table cellspacing="0" cellpadding="0">
                             <tr>
                                <td class="cliente" width="100px">CLIENTE:</td>
                                <td class="cliente" width="700px">'.$nombre.'</td>
                             </tr>
                             <tr>
                                <td  Class="cliente">NIT:</td>
                                <td  Class="cliente">'.$nit.'</td>
                             </tr>
                              <tr>
                                <td  class="cliente">DIRECCIÓN:</td>
                                <td  class="cliente">'.$direccion.'</td>
                             </tr>
                             <tr>
                                <td class="cliente">TELEFONO:</td>
                                <td class="cliente">'.$telefono.$movil.'</td>
                             </tr>
                          </table>';

            $tb_info2 = '<table cellspacing="0" cellpadding="4">
                              <tr>
                                <th>CANTIDAD</th>
                                <th>DESCRIPCION</th>
                                <th>PRECIO UNITARIO</th>
                                <th>TOTAL</th>
                              </tr>';

            $detalles = mysql_query("SELECT * FROM pedidos_detalles WHERE Id_ped = '$pedido' ");
            while($rdeta = mysql_fetch_array($detalles))
            {
              $tb_info2 .='<tr>
                              <td align="center">'.$rdeta['cant_pr'].'</td>
                              <td align="left">'.$rdeta['nombre_pr'].' '.$rdeta['descr_pr'].'</td>
                              <td align="center">$ '.number_format($rdeta['valoruni_pr'],0,'','.').'</td>
                              <td align="center">$ '.number_format(($rdeta['cant_pr']*$rdeta['valoruni_pr']),0,'','.').'</td>
                           </tr>';
              $sub += $rdeta['cant_pr']*$rdeta['valoruni_pr'];
            }

            $tb_info2_1 = '</table>';

            $tb_info3 = '<table class="fecha">
                              <tr>
                                 <td colspan="2" class="text1"></td>
                                 <th>SUBTOTAL</th>
                                <td align="center">$ '.number_format($sub,0,'','.').'</td>
                              </tr>
                              <tr>
                                <td colspan="2" class="text1"></td>
                                <th>VALOR SERVICIO</th>
                                <td align="center">$ 5.000</td>
                              </tr>
                              <tr>
                                <td colspan="2" class="text1"></td>
                                <th>TOTAL</th>
                                <td align="center">$ '.number_format(($sub+5000),0,'','.').'</td>
                              </tr>
                            </table>
                            ';

            $tb_info4 = '<table cellspacing="0" cellpadding="4">
                              <tr>
                                <th>FECHA DE ENTREGA</th>
                                <td align="center">'.$resp['entrega_pd'].'</td>
                                <th>HORA DE ENTREGA</th>
                                <td align="center">'.$resp['hora_pd'].'</td>
                               </tr>
                            </table>';


            $pdf->writeHTML($html.$tbl_datos.$divisor.$tb_info1.$divisor.$tb_info2.$tb_info2_1.$divisor.$tb_info3.$divisor.$tb_info4 , true, false, false, false, '');
        }

        //Close and output PDF document
        $pdf->Output('Fac.pdf', 'I');



?>