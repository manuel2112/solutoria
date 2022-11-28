<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $apiURL = 'https://postulaciones.solutoria.cl/api/acceso';
        $postInput = [
            'userName' => 'mavargaszenm24dm_pwd@indeedemail.com',
            'flagJson' => true
        ];
        $headers = [
            'Content-Type' => 'application/json'
        ];
        $response       = Http::withHeaders($headers)->post($apiURL, $postInput); 
        $responseBody   = json_decode($response->getBody(), true);     

        $token = $responseBody['token'];
        
        $indicadores = $this->indicadores($token);

        return view('home', [
            'indicadores' => $indicadores
        ]);
    }

    public function indicadores($token)
    {
        $existe = Indicator::count();
        if( $existe == 0 ){
            set_time_limit(0);
            ini_set('memory_limit', '256M');

            $apiURL = 'https://postulaciones.solutoria.cl/api/indicadores';
            
            $indicadores =  Http::withHeaders([
                                'accept' => 'application/json'
                            ])
                            ->withToken($token)
                            ->get($apiURL)
                            ->json();

            foreach( $indicadores as $indicador ){

                if( $indicador['codigoIndicador'] == 'UF' ){
                    Indicator::create([
                        'valorIndicador'        => $indicador['valorIndicador'],
                        'fechaIndicador'        => $indicador['fechaIndicador']
                    ]);
                }

            }

        }

        return Indicator::where([ 'flag' => TRUE ])->orderBy('fechaIndicador', 'desc')->paginate(20);

    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'valor' => 'required | numeric',
            'fecha' => 'required',
        ]);
        
        if ($validator->fails()){
            return response()->json(['ok'=> FALSE, 'errors'=>$validator->errors()->all()]);
        }

        $valor = $request->valor;
        $fecha = $request->fecha;

        Indicator::create([
            'valorIndicador'        => $valor,
            'fechaIndicador'        => $fecha
        ]);

        return response()->json(['ok'=> TRUE ]);

    }

    public function destroy($id){   

        Indicator::where( 'id' , $id)->update([ 'flag'  => FALSE ]);

        return response()->json([
            'ok'=> TRUE 
        ]);
    
    }

    public function update(Request $request, $id){  

        $validator = Validator::make($request->all(), [
            'valor' => 'required | numeric',
            'fecha' => 'required',
        ]);
        
        if ($validator->fails()){
            return response()->json(['ok'=> FALSE, 'errors'=>$validator->errors()->all()]);
        } 

        $valor = $request->valor;
        $fecha = $request->fecha;

        Indicator::where( 'id' , $id)->update([ 'valorIndicador'  => $request->valor , 'fechaIndicador'  => $request->fecha ]);

        return response()->json([
            'ok'=> TRUE 
        ]);
    
    }
}
