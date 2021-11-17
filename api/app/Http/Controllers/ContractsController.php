<?php

namespace App\Http\Controllers;

use App\Models\Contracts;
use App\Models\Properties;
use Illuminate\Http\Request;
use Validator;

class ContractsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Contracts::all();
            
            return response()->json([
                'message' => 'Listagem de Contratos',
                'data' => $data
            ], 200);

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function listById ($id) {
        try {
            $data = Contracts::find($id);
            
            return response()->json([
                'message' => 'Listagem de dados do contrato',
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
                'propertie' => 'required',
                'profile_type' => 'required',
                'document' => 'required',
                'full_name' => 'required'
            ];
    
            $message = [
                'email.required' => 'O campo e-mail é obrigatório',
                'email.email' => 'O formato de e-mail é inválido',
                'propertie.required' => 'O campo Imóvel é obrigatório',
                'profile_type.required' => 'O campo Tipo de documento é obrigatório',
                'document.required' => 'O campo Documento é obrigatório',
                'full_name.required' => 'O campo Nome Completo é obrigatório',
            ];
    
            $validator = Validator::make($request->all(), $rules, $message);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Não foi possível validar os campos enviados.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $checkPropertie = Properties::where('id', $request->input('propertie'))->first();

            if ($checkPropertie->status == 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Não foi possível validar os campos enviados.',
                    'errors' => array('msg' => 'Imóvel já contratado')
                ], 422);
            }

            $contract = new Contracts;
            $contract->email = $request->input('email');
            $contract->propertie = $request->input('propertie');
            $contract->profile_type = $request->input('profile_type');
            $contract->document = $request->input('document');
            $contract->full_name = $request->input('full_name');
            $contract->save();

            $propertie = Properties::find($request->input('propertie'));
            $propertie->status = 1;
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
     * @param  \App\Models\Contracts  $contracts
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email',
                'propertie' => 'required',
                'profile_type' => 'required',
                'document' => 'required',
                'full_name' => 'required'
            ];
    
            $message = [
                'email.required' => 'O campo e-mail é obrigatório',
                'email.email' => 'O formato de e-mail é inválido',
                'propertie.required' => 'O campo Imóvel é obrigatório',
                'profile_type.required' => 'O campo Tipo de documento é obrigatório',
                'document.required' => 'O campo Documento é obrigatório',
                'full_name.required' => 'O campo Nome Completo é obrigatório',
            ];
    
            $validator = Validator::make($request->all(), $rules, $message);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Não foi possível validar os campos enviados.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $contract = Contracts::find($request->input('id'));

            // UPDATE PROPERTIE
            $updatePropertie = Properties::where('id', $contract->propertie)->first();
            
            if ($updatePropertie->count() > 0 && $updatePropertie->id != $request->input('propertie')) {
                $updatePropertie->status = 0;
                $updatePropertie->save();
            }

            $contract->email = $request->input('email');
            $contract->propertie = $request->input('propertie');
            $contract->profile_type = $request->input('profile_type');
            $contract->document = $request->input('document');
            $contract->full_name = $request->input('full_name');
            $contract->save();

            $propertie = Properties::find($request->input('propertie'));
            $propertie->status = 1;
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
     * @param  \App\Models\Contracts  $contracts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contracts $contracts, $id)
    {
        try {
            $contract = Contracts::find($id);

            $propertie = Properties::find($contract->propertie);
            $propertie->status = 0;
            $propertie->save();

            $contract->delete();

            return response()->json([
                'message' => 'Deletado com sucesso!'
            ], 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
