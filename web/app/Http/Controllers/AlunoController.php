<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\FirebaseController;
use App\Models\Aluno;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $firebase = new FirebaseController();
        $aluno = new Aluno();
        $alunos = $firebase->getAll("aluno");
        return view("aluno.index", [
            "aluno" => $aluno,
            "alunos" => $alunos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $firebase = new FirebaseController();
        $validacao = $request->validate(
            [
                'nome' => 'required',
                'email' => 'required',
                'matricula' => 'required'
            ],
            [
                'nome.required' => 'O nome é obrigatório',
                'email.required' => 'O curso é obrigatório',
                'matricula.required' => 'A matrícula é obrigatória'
            ]
        );

        if ($request->post('id') == '') {
            $aluno = new Aluno();
        } else {
            $aluno = $firebase->getById($request->post('id'), "aluno");
        }
        $aluno->nome = $request->post('nome');
        $aluno->email = $request->post('email');
        $aluno->matricula = $request->post('matricula');
        $firebase->insert('/aluno', $aluno);
        $request->session()->flash('salvar', 'Aluno salvo com sucesso!');
        return redirect('/aluno');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $firebase = new FirebaseController();
        $aluno = $firebase->getById($id, "aluno");
        $alunos = $firebase->getAll("aluno");
        return view("aluno.index", [
            "aluno" => $aluno,
            "alunos" => $alunos,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $firebase = new FirebaseController();
        $firebase->delete($id, "aluno");
        $request->session()->flash('excluir', "Aluno excluido com sucesso!");
        return redirect('/aluno');
    }
}
