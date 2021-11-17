<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;
use Validator;

class PropertiesController extends Controller
{
    // public function __construct() {
    //     $this->middleware('auth:api');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Properties::all();
            
            return response()->json([
                'message' => 'Listagem de Imóveis',
                'data' => $data
            ], 200);

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function listById ($id) {
        try {
            $data = Properties::find($id);
            
            return response()->json([
                'message' => 'Listagem de dados do imóvel',
                'data' => $data
            ], 200);

        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email',
                'street' => 'required',
                'district' => 'required',
                'state' => 'required',
                'city' => 'required'
            ];
    
            $message = [
                'email.required' => 'O campo e-mail é obrigatório',
                'email.email' => 'O formato de e-mail é inválido',
                'street.required' => 'O campo Rua é obrigatório',
                'district.required' => 'O campo Bairro é obrigatório',
                'state.required' => 'O campo Estado é obrigatório',
                'city.required' => 'O campo Cidade é obrigatório',
            ];
    
            $validator = Validator::make($request->all(), $rules, $message);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Não foi possível validar os campos enviados.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $propertie = new Properties;
            $propertie->email = $request->input('email');
            $propertie->street = $request->input('street');
            $propertie->number = $request->input('number');
            $propertie->complement = $request->input('complement');
            $propertie->district = $request->input('district');
            $propertie->state = $request->input('state');
            $propertie->city = $request->input('city');
            $propertie->status = 0;
            $propertie->save();

            return response()->json([
                'message' => 'Cadastrado com sucesso!'
            ], 200);

        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Properties  $properties
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email',
                'street' => 'required',
                'district' => 'required',
                'state' => 'required',
                'city' => 'required'
            ];
    
            $message = [
                'email.required' => 'O campo e-mail é obrigatório',
                'email.email' => 'O formato de e-mail é inválido',
                'street.required' => 'O campo Rua é obrigatório',
                'district.required' => 'O campo Bairro é obrigatório',
                'state.required' => 'O campo Estado é obrigatório',
                'city.required' => 'O campo Cidade é obrigatório',
            ];
    
            $validator = Validator::make($request->all(), $rules, $message);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Não foi possível validar os campos enviados.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $propertie = Properties::find($request->input('id'));
            $propertie->email = $request->input('email');
            $propertie->street = $request->input('street');
            $propertie->number = $request->input('number');
            $propertie->complement = $request->input('complement');
            $propertie->district = $request->input('district');
            $propertie->state = $request->input('state');
            $propertie->city = $request->input('city');
            $propertie->save();

            return response()->json([
                'message' => 'Alterado com sucesso!'
            ], 200);

        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Properties  $properties
     * @return \Illuminate\Http\Response
     */
    public function destroy(Properties $properties, $id)
    {
        try {
            $propertie = Properties::find($id);
            $propertie->delete();

            return response()->json([
                'message' => 'Deletado com sucesso!'
            ], 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
