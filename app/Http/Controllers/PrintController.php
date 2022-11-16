<?php

namespace App\Http\Controllers;

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function print($data){

        return 'hola';
        //dd($data);

       /* $nombreImpresora = "POS-58";
        $connector = new WindowsPrintConnector($nombreImpresora);
        $impresora = new Printer($connector);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setTextSize(2, 2);
        $impresora->text($this->empresa->nombre ."\n");
        $impresora->text("\n");
        $impresora->setTextSize(1, 1);
        $impresora->text($this->empresa->nro_documento ."\n");
        $impresora->text($this->empresa->direccion ."\n");
        $impresora->text("Tlf.".$this->empresa->telefono ."\n");
        $impresora->text("Email: ".$this->empresa->email ."\n");
        $impresora->text("--------------------------------\n");
        $impresora->text("Factura Nro. ".$venta_nro_p ."\n");
        $impresora->text("Fecha: ".date('d-m-Y') ."\n");
        $impresora->text("Cajero: ".auth()->user()->name." ".auth()->user()->apellido ."\n");
        $impresora->text("Caja: ".$this->caja_detalle->nombre ."\n");
        $impresora->text("--------------------------------\n");
        $impresora->text("Cliente: ".$this->client->nombre." ".$this->client->apellido ."\n");
        $impresora->text("Documento Nro.: ".$this->client->nro_documento ."\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("________________________________\n");
        $impresora->text(" Cant.   Descripción   Subtotal\n");
        $impresora->text("--------------------------------\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        foreach (Cart::content() as $item) {
            if($item->options['exento'] == "Si") $impresora->text(str_pad($item->qty,7).str_pad(substr($item->name,0,12), 10)."(E) ".str_pad($item->price,10)."\n"); 
            else $impresora->text(str_pad($item->qty,7).str_pad(substr($item->name,0,12), 14)." ".str_pad($item->price,10)."\n");
        } 
        $impresora->text("\n");
        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
        $impresora->text('SUBTOTAL: Bs ' . $this->subtotal - ($this->descuento_total) . "\n");
        $impresora->text('DESCUENTO: Bs ' . $this->descuento_total . "\n");
        $impresora->text('IVA('. $this->iva_empresa. '%): Bs '. $this->iva . "\n");
        $impresora->text('TOTAL: Bs ' .$this->total_venta. "\n");
        if ($this->tipo_pago == "Credito"){
            $impresora->text('PAGADO: Bs ' .$this->pago_cliente. "\n");
            $impresora->text('PENDIENTE: Bs ' .$this->total_venta - $this->pago_cliente. "\n");  
        }
        $impresora->text("\n");
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->text("¡GRACIAS POR SU COMPRA!\n");
        $impresora->feed(3);
        $impresora->close();*/

    }
}
