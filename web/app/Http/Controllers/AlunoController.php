<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\FirebaseController;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Nota;

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
        $alunoAuxi = new Aluno();
        $alunos = $firebase->getAll("aluno");
        $nota = new Nota();
        $notas = $firebase->getAll("nota");
        $turma = new Turma();
        $turmas = $firebase->getAll("turma");
        return view("aluno.index", [
            "aluno" => $aluno,
            "alunos" => $alunos,
            "alunoAux" => $alunoAuxi,
            "nota" => $nota,
            "notas" => $notas,
            "turma" => $turma,
            "turmas" => $turmas
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

        $alunoRef = $firebase->insert('/aluno', $aluno);

        if ($request->post('id') == '') {
            $alunoKey = $alunoRef->getKey();
        } else {
            $alunoKey = $request->post('id');
        }

        if ($request->post('id') == '') {
            $alunoAuxi = new Aluno();
            $alunoAuxi->limparTurmas($alunoKey);
            $nota = new Nota();
            foreach ($request->post('turma') as $turma) {
                $nota->aluno = $alunoKey;
                $nota->turma = $turma;
                $nota->nota = 0;
                $firebase->insert('/nota', $nota);
            }
        } else {
            $alunoAuxi = new Aluno();
            $nota = new Nota();
            $notas = $alunoAuxi->listaNotas($alunoKey);
            $alunoAuxi->limparTurmas($alunoKey);
            foreach ($request->post('turma') as $turma) {
                $nota->aluno = $alunoKey;
                $nota->turma = $turma;
                $nota->nota = 0;
                foreach ($notas as $notaAuxi) {
                    if ($nota->aluno == $notaAuxi->aluno && $nota->turma == $notaAuxi->turma) {
                        $nota->nota = $notaAuxi->nota;
                    }
                }
                $firebase->insert('/nota', $nota);
            }
        }

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
        $alunoAuxi = new Aluno();
        $alunos = $firebase->getAll("aluno");
        $nota = new Nota();
        $notas = $firebase->getAll("nota");
        $turma = new Turma();
        $turmas = $firebase->getAll("turma");
        return view("aluno.index", [
            "aluno" => $aluno,
            "alunos" => $alunos,
            "alunoAux" => $alunoAuxi,
            "nota" => $nota,
            "notas" => $notas,
            "turma" => $turma,
            "turmas" => $turmas
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
