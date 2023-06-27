<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class ACLController extends Controller
{

  public function index()
  {
      // Verifica se o usuário autenticado é um administrador ou moderador
      if (Auth::user()->level === 'administrator' || Auth::user()->level === 'moderator') {
          $users = User::all();
      } else {
          $users = [];
      }

      return response()->json([
          'users' => $users
      ], 200);
  }

  public function create()
  {
      // Verifica se o usuário autenticado é um administrador
      if (Auth::user()->level === 'administrator') {
        return response()->json([
            'message' => 'Record created...'
        ], 200);
      } else {
        return response()->json([
            'message' => 'Not allowed...'
        ], 200);
      }
  }

  public function store(Request $request)
  {
      // Verifica se o usuário autenticado é um administrador
      if (Auth::user()->level === 'administrator') {
          // Cria um novo registro com base nos dados enviados
          User::create($request->all());

          return response()->json([
              'message' => 'Store ok...'
          ], 200);
      } else {
        return response()->json([
            'message' => 'Not allowed...'
        ], 200);
      }
  }

  public function edit($id)
  {
      // Verifica se o usuário autenticado é um administrador ou um nível de perfil financeiro que pode editar registros
      if (Auth::user()->level === 'administrator' || Auth::user()->level === 'financial_edit') {
        $user = User::find($id);

        return response()->json([
            'user' => $user
        ], 200);
      } else {
        return response()->json([
            'message' => 'Not allowed...'
        ], 200);
      }
  }

  public function update(Request $request, $id)
  {
      // Verifica se o usuário autenticado é um administrador ou um nível de perfil financeiro que pode editar registros
      if (Auth::user()->level === 'administrator' || Auth::user()->level === 'financial_edit') {

        try {

        } catch (\Exception $e) {

        }

          // Atualiza o registro com base nos dados enviados
          if( $user = User::find($id) ){
            $user->update($request->all());
          } else {
            return response()->json([
                'message' => 'Record not found...'
            ], 200);
          };

          return response()->json([
              'message' => 'Record updated...'
          ], 200);
      } else {
        return response()->json([
            'message' => 'Not allowed...'
        ], 200);
      }
  }

  public function destroy($id)
  {
      // Verifica se o usuário autenticado é um administrador ou um nível de perfil Finance que pode excluir registros
      if (Auth::user()->level === 'administrator' || Auth::user()->level === 'financial_delete') {

        if( $user = User::find($id) ){
          $user->delete();
        } else {
          return response()->json([
              'message' => 'Record not found...'
          ], 200);
        };

          return response()->json([
              'message' => 'Record deleted...'
          ], 200);
      } else {
        return response()->json([
            'message' => 'Not allowed...'
        ], 200);
      }
  }

}
