<?php

namespace App\Models;

use App\Http\Controllers\FirebaseController;
use App\Models\Nota;

class Turma
{
    public $id;
    public $nome;
    public $curso;

    public function listaAlunos($idTurma)
    {
        $firebase = new FirebaseController();
        $alunos = $firebase->getAll("nota");
        $alunosList = [];

        foreach ($alunos as $aluno) {
            if ($aluno->turma == $idTurma) {
                array_push($alunosList, $aluno->turma);
            }
        }
        return $alunosList;
    }

    public function countTurmas($idAluno)
    {
        return sizeof($this->listaAlunos($idAluno));
    }

    public function listaNotas($idTurma)
    {
        $firebase = new FirebaseController();
        $notas = $firebase->getAll("nota");
        $notasList = [];

        foreach ($notas as $nota) {
            if ($nota->turma == $idTurma) {
                array_push($notasList, $nota->id);
            }
        }
        return $notasList;
    }

    public function contemAluno($idTurma, $idAluno)
    {
        $alunos = $this->listaAlunos($idTurma);
        $contem = false;

        if (gettype($alunos) == "array") {
            if (in_array($idAluno, $alunos)) {
                $contem = true;
            }
        }
        return $contem;
    }

    public function limparAlunos($idTurma)
    {
        $firebase = new FirebaseController();
        $notasLista = $this->listaNotas($idTurma);

        if (gettype($notasLista) == "array") {
            foreach ($notasLista as $nota) {
                $firebase->delete($nota, "nota");
            }
        }
    }
}
