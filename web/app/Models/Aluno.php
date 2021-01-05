<?php

namespace App\Models;

use App\Http\Controllers\FirebaseController;

class Aluno
{
    public $id;
    public $nome;
    public $email;
    public $matricula;

    public function listaTurmas($idAluno)
    {
        $firebase = new FirebaseController();
        $turmas = $firebase->getAll("nota");
        $turmasList = [];

        foreach ($turmas as $turma) {
            if ($turma->aluno == $idAluno) {
                array_push($turmasList, $turma->turma);
            }
        }
        return $turmasList;
    }

    public function listaNotas($idAluno)
    {
        $firebase = new FirebaseController();
        $notas = $firebase->getAll("nota");
        $notasList = [];

        foreach ($notas as $nota) {
            if ($nota->aluno == $idAluno) {
                array_push($notasList, $nota->id);
            }
        }
        return $notasList;
    }

    public function countTurmas($idAluno)
    {
        return sizeof($this->listaTurmas($idAluno));
    }

    public function contemTurma($idAluno, $idTurma)
    {
        $turmas = $this->listaTurmas($idAluno);
        $contem = false;

        if (gettype($turmas) == "array") {
            if (in_array($idTurma, $turmas)) {
                $contem = true;
            }
        }
        return $contem;
    }

    public function limparTurmas($idAluno)
    {
        $firebase = new FirebaseController();
        $notasLista = $this->listaNotas($idAluno);

        if (gettype($notasLista) == "array") {
            foreach ($notasLista as $nota) {
                $firebase->delete($nota, "nota");
            }
        }
    }
}
