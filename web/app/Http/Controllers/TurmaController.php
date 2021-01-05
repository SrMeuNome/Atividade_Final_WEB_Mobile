<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\FirebaseController;
use App\Models\Turma;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $firebase = new FirebaseController();
        $turma = new Turma();
        $turmas = $firebase->getAll("turma");
        return view("turma.index", [
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
                'turma' => 'required',
                'curso' => 'required'
            ],
            [
                'turma.required' => 'A turma é obrigatório',
                'curso.required' => 'O curso é obrigatório'
            ]
        );

        if ($request->post('id') == '') {
            $turma = new Turma();
        } else {
            $turma = $firebase->getById($request->post('id'), "turma");
        }
        $turma->nome = $request->post('turma');
        $turma->curso = $request->post('curso');
        $firebase->insert('/turma', $turma);
        $request->session()->flash('salvar', 'Turma salva com sucesso!');
        return redirect('/turma');
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
        $turma = $firebase->getById($id, "turma");
        $turmas = $firebase->getAll("turma");
        return view("turma.index", [
            "turma" => $turma,
            "turmas" => $turmas,
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
        $firebase->delete($id, "turma");
        $request->session()->flash('excluir', "Turma excluida com sucesso!");
        return redirect('/turma');
    }
}
