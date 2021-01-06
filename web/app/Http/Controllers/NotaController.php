<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\FirebaseController;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Nota;

class NotaController extends Controller
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
        $alunosNotas = (object) [];
        $turma = new Turma();
        $turmas = $firebase->getAll("turma");
        return view("nota.index", [
            "aluno" => $aluno,
            "alunosNotas" => $alunosNotas,
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
                'nota' => 'required',
            ],
            [
                'nota.required' => 'A nota é obrigatório',
            ]
        );

        if ($request->post('nota-id') == '') {
            $nota = new nota();
        } else {
            $nota = $firebase->getById($request->post('nota-id'), "nota");
        }
        $nota->aluno = $request->post('aluno');
        $nota->materia = $request->post('turma-id');
        $nota->nota = $request->post('nota');

        $firebase->insert('/nota', $nota);

        $request->session()->flash('salvar', 'Nota salva com sucesso!');
        return redirect('/nota/' . $request->post("turma-id"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $firebase = new FirebaseController();

        $aluno = new Aluno();
        $alunosNotas = [];

        $turma = $firebase->getById($id, "turma");
        $turmaAuxi = new Turma();
        $turmas = $firebase->getAll("turma");

        $nota = new Nota();
        $notas = [];
        $notasAuxi = $turmaAuxi->listaNotas($id);

        foreach ($notasAuxi as $nota) {
            array_push($notas, $firebase->getById($nota, "nota"));
        }

        foreach ($notas as $nota) {
            $index = array_push($alunosNotas, $firebase->getById($nota->aluno, "aluno"));
            $alunosNotas[$index - 1]->nota = $nota->nota;
            $alunosNotas[$index - 1]->idnota = $nota->id;
        }

        return view("nota.index", [
            "aluno" => $aluno,
            "alunosNotas" => $alunosNotas,
            "turma" => $turma,
            "turmas" => $turmas
        ]);
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
        $aluno = new Aluno();
        $alunosNotas = (object) [];
        $turma = new Turma();
        $turmas = $firebase->getAll("turma");
        return view("nota.index", [
            "aluno" => $aluno,
            "alunosNotas" => $alunosNotas,
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
