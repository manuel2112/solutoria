<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use Illuminate\Http\Request;

class ApiGraficoController extends Controller
{
    public function getIndicadores(){
        
        $indicadores = Indicator::where([ 'flag' => TRUE ])->orderBy('fechaIndicador', 'desc')->limit(30)->get();

        return response()->json([
            'indicadores' => $indicadores
        ], 200);
	}
    
    public function search(Request $request){

        $desde = $request->desde;
        $hasta = $request->hasta;
        $error = '';
        
        $indicadores = Indicator::where([ 'flag' => TRUE ])->whereBetween('fechaIndicador', [$desde, $hasta])->orderBy('fechaIndicador', 'desc')->get();

        $error = count($indicadores) > 0 ? TRUE :FALSE;

        return response()->json([
            'error'         => $error,
            'indicadores'   => $indicadores
        ], 200);
	}
}
