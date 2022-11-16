<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class PrintController extends Controller
{
    public function print_ticket($data){

        $hora = now()->isoFormat('H:mm:ss');

        $ticket = json_decode($data, true);

        $nombreImpresora = "POS-58";
        $connector = new WindowsPrintConnector($nombreImpresora);
        $impresora = new Printer($connector);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setTextSize(2, 2);
        $impresora->text($ticket['empresa_nombre'] ."\n");
        $impresora->text("\n");
        $impresora->setTextSize(1, 1);
        $impresora->text($ticket['empresa_tipo_documento']." ".$ticket['empresa_documento'] ."\n");
        $impresora->text($ticket['empresa_direccion'] ."\n");
        $impresora->text("Tlf.".$ticket['empresa_telefono'] ."\n");
        $impresora->text("Email: ".$ticket['empresa_email']."\n");
        $impresora->text("--------------------------------\n");
        $impresora->text("Factura Nro. ".$ticket['nro_venta']."\n");
        $impresora->text("Fecha:".date('d-m-Y')." "."Hora:". $hora."\n");
        $impresora->text("Cajero: ".$ticket['cajero_nombre']." ".$ticket['cajero_apellido'] ."\n");
        $impresora->text("Caja: ".$ticket['caja_nombre'] ."\n");
        $impresora->text("--------------------------------\n");
        if($ticket['cliente_apellido'] == 'NA'){
            $impresora->text("Cliente: ".$ticket['cliente_nombre']."\n");
        }else{
            $impresora->setJustification(Printer::JUSTIFY_LEFT);
            $impresora->text("Cliente: ".$ticket['cliente_nombre']." ".$ticket['cliente_apellido']."\n");
            $impresora->text("Documento Nro.: ".$ticket['cliente_tipo_documento']." ".$ticket['cliente_nro_documento']."\n");
        }
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("________________________________\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        foreach ($ticket['productos'] as $item) {
            if($item['options']['exento'] == "Si") {
                $impresora->setJustification(Printer::JUSTIFY_LEFT);
               $impresora->text(str_pad($item['qty'],5). "x Bs ".$item['price']."  ". str_pad(substr($item['name'],0,12), 8)."(E)"."\n"); 
                $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                $impresora->text("Bs. ".round(($item['price']*$item['qty']),2)); 
                $impresora->text("\n");
            }
            else{
                $impresora->setJustification(Printer::JUSTIFY_LEFT);
               $impresora->text(str_pad($item['qty'],5). "x Bs ".$item['price']."  ". str_pad(substr($item['name'],0,12), 12)."\n"); 
                $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                $impresora->text("Bs. ".round(($item['price']*$item['qty']),2)); 
                $impresora->text("\n");
            } 
        }

       $impresora->text("\n");
        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
        $impresora->text('SUBTOTAL: Bs ' .round(($ticket['subtotal'] - $ticket['descuento']),2) . "\n");
        $impresora->text('DESCUENTO: Bs ' . round($ticket['descuento'],2) . "\n");
        $impresora->text('IVA('. $ticket['iva_empresa']. '%): Bs '. round(($ticket['iva']),2) . "\n");
        $impresora->text('TOTAL: Bs ' .round(($ticket['total']),2). "\n");
        if ($ticket['tipo_pago'] == 2){
            $impresora->text('PAGADO: Bs ' .round($ticket['pago_cliente'],2). "\n");
            $impresora->text('PENDIENTE: Bs ' .round(($ticket['total'] - $ticket['pago_cliente']),2). "\n");  
        }
        $impresora->text("\n");
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->text("¡GRACIAS POR SU COMPRA!\n");
        $impresora->feed(3);
        $impresora->close();
    }

    public function print_nota($data){

        $ticket = json_decode($data, true);

        $hora = now()->isoFormat('H:mm:ss');

        $nombreImpresora = "POS-58";
        $connector = new WindowsPrintConnector($nombreImpresora);
        $impresora = new Printer($connector);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setTextSize(2, 2);
        $impresora->text($ticket['empresa_nombre'] ."\n");
        $impresora->text("\n");
        $impresora->setTextSize(1, 1);
        $impresora->text($ticket['empresa_tipo_documento']." ".$ticket['empresa_documento'] ."\n");
        $impresora->text($ticket['empresa_direccion'] ."\n");
        $impresora->text("Tlf.".$ticket['empresa_telefono'] ."\n");
        $impresora->text("Email: ".$ticket['empresa_email']."\n");
        $impresora->text("--------------------------------\n");
        $impresora->text("Nota de entrega". "\n");
        $impresora->text("Fecha:".date('d-m-Y')." "."Hora:".$hora."\n");
        $impresora->text("Cajero: ".$ticket['cajero_nombre']." ".$ticket['cajero_apellido'] ."\n");
        $impresora->text("Caja: ".$ticket['caja_nombre'] ."\n");
        $impresora->text("--------------------------------\n");
        if($ticket['cliente_apellido'] == 'NA'){
            $impresora->text("Cliente: ".$ticket['cliente_nombre']."\n");
        }else{
            $impresora->text("Cliente: ".$ticket['cliente_nombre']." ".$ticket['cliente_apellido']."\n");
            $impresora->text("Documento Nro.: ".$ticket['cliente_tipo_documento']." ".$ticket['cliente_nro_documento']."\n");
        }
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("________________________________\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        foreach ($ticket['productos'] as $item) {
            if($item['options']['exento'] == "Si") {
                $impresora->setJustification(Printer::JUSTIFY_LEFT);
               $impresora->text(str_pad($item['qty'],7). "x Bs ".$item['price']."  ". str_pad(substr($item['name'],0,12), 8)."(E)"."\n"); 
                $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                $impresora->text("Bs. ".($item['price']*$item['qty']),10); 
                $impresora->text("\n");
            }
            else{
                $impresora->setJustification(Printer::JUSTIFY_LEFT);
               $impresora->text(str_pad($item['qty'],7). "x Bs ".$item['price']."  ". str_pad(substr($item['name'],0,12), 14)."\n"); 
                $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                $impresora->text("Bs. ".($item['price']*$item['qty']),10); 
                $impresora->text("\n");
            } 
        }

        $impresora->text("\n");
        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
        $impresora->text('SUBTOTAL: Bs ' .$ticket['subtotal'] - $ticket['descuento'] . "\n");
        $impresora->text('DESCUENTO: Bs ' . $ticket['descuento'] . "\n");
        $impresora->text('IVA('. $ticket['iva_empresa']. '%): Bs '. $ticket['iva'] . "\n");
        $impresora->text('TOTAL: Bs ' .$ticket['total'] - $ticket['iva']. "\n");
        if ($ticket['tipo_pago'] == 2){
            $impresora->text('PAGADO: Bs ' .$ticket['pago_cliente']. "\n");
            $impresora->text('PENDIENTE: Bs ' .$ticket['total'] - $ticket['pago_cliente']. "\n");  
        }
        $impresora->text("\n");
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->text("¡GRACIAS POR SU COMPRA!\n");
        $impresora->feed(3);
        $impresora->close();
    }

    public function print_reportex($data,$data2,$data4,$data3){

        $ticket_total_ventas = json_decode($data, true);
       $ticket_cantidad_ventas = json_decode($data2, true);
        $ticket_pagos_metodos = json_decode($data3, true);
        $ticket_dato_empresa = json_decode($data4, true);
        $cant_element_pagos = count($ticket_pagos_metodos);

        $hora = now()->isoFormat('H:mm:ss');

        $nombreImpresora = "POS-58";
        $connector = new WindowsPrintConnector($nombreImpresora);
        $impresora = new Printer($connector);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setTextSize(2, 2);
        $impresora->text($ticket_dato_empresa['empresa_nombre'] ."\n");
        $impresora->text("\n");
        $impresora->setTextSize(1, 1);
        $impresora->text($ticket_dato_empresa['empresa_tipo_documento']." ".$ticket_dato_empresa['empresa_documento'] ."\n");
        $impresora->text($ticket_dato_empresa['empresa_direccion'] ."\n");
        $impresora->text("Tlf.".$ticket_dato_empresa['empresa_telefono'] ."\n");
        $impresora->text("Email: ".$ticket_dato_empresa['empresa_email']."\n");
        $impresora->text("--------------------------------\n");
        $impresora->text("Fecha:".date('d-m-Y')." "."Hora:". $hora."\n");
        $impresora->text("\n");
        $impresora->setTextSize(1, 1);
        $impresora->text("MEDIOS DE PAGO" ."\n");
        $impresora->text("\n");
        
        for ($i=0; $i<$cant_element_pagos; $i++) {
            $impresora->setJustification(Printer::JUSTIFY_LEFT);
            $impresora->text($ticket_pagos_metodos[$i]['metodo_nombre']."\n");
            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
            $impresora->text('Bs '.$ticket_pagos_metodos[$i]['quantity']);
            $impresora->text("\n");
        }
        $impresora->text("\n");
        $impresora->text("--------------------------------\n");
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->text("VENTAS" ."\n");
        $impresora->text("\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("Cantidad de ventas"."\n");
        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
        $impresora->text($ticket_cantidad_ventas[0]['cantidad']."\n");
        $impresora->text("\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("Total del día"."\n");
        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
        $impresora->text('Bs '.$ticket_total_ventas[0]['quantity']."\n");
        $impresora->text("\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("EXENTO"."\n");
        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
        $impresora->text('Bs '.$ticket_total_ventas[0]['exento']."\n");
        $impresora->text("\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("IVA G(16 %)"."\n");
        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
        $impresora->text('Bs '.$ticket_total_ventas[0]['impuesto']."\n");

        $impresora->feed(3);
        $impresora->close();
    }
}
