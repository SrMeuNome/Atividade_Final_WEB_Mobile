<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kreait\Firebase;

use Kreait\Firebase\Factory;

use Kreait\Firebase\ServiceAccount;

use Kreait\Firebase\Database;
use stdClass;

use App\Models\Turma;

class FirebaseController extends Controller
{
    private $database;

    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromValue(__DIR__ . '/firebase_credentials.json');

        $firebase = (new Factory)

            ->withServiceAccount($serviceAccount)

            ->withDatabaseUri('https://atividadefinal-ac78d-default-rtdb.firebaseio.com');

        $this->database = $firebase->createDatabase(); //->getDatabase();
    }

    /**
     * Insert data.
     */
    public function insert (string $caminho, object $valor)
    {
        if($valor->id == '')
        {
            $this->database
            ->getReference($caminho)
            ->push($valor);
        }
        else
        {
            $valorAux = new stdClass();
            foreach($valor as $key => $aux)
            {
                if($key <> 'id')
                {
                    $valorAux->$key = $aux;
                }
            }
            $updates = [
                $caminho . "/" . $valor->id => $valorAux,
            ];
    
            $this->database->getReference()->update($updates);
        }
    }

    public function insertTest()
    {
        //insertAluno
        /*$testeInfo = new \stdClass;
        $testeInfo->nome = "Aluno2";
        $testeInfo->codigo = "Codi3";

        $testes = $this->getAll("turma");
        foreach($testes as $teste)
        {
            $this->insert("turma/" . $teste->id . "/aluno", $testeInfo);
        }*/

        //insertNotas
        /*$testeInfo = new \stdClass;
        $testeInfo->descricao = "Prova 01";
        $testeInfo->valor = 50;

        $testes = $this->getAll("turma");
        foreach($testes as $teste)
        {
            $testesAlunos = $this->getAll("turma/" . $teste->id . "/aluno", $testeInfo);

            foreach($testesAlunos as $testeAluno)
            {
                $this->insert("turma/" . $teste->id . "/aluno/" . $testeAluno->id . "/nota", $testeInfo);
            }
        }*/

        $testeInfo = new Turma();
        $testeInfo->nome = "Teste Turma 2";
        $testeInfo->curso = "Teste Curso 2";

        $this::insert("turma", $testeInfo);
    }

    /**
     * Retrieve data.
     */

    public function getAll(string $caminho)
    {
        $data = $this->database->getReference($caminho)->getValue();
        $objetos = [];
        if($data)
        {
            foreach ($data as $_key => $values) {
                $aux = new stdClass();
                $aux->id = $_key;
                foreach ($values as $key => $value) {
                    $aux->$key = $value;
                }
                array_push($objetos, $aux);
            }
        }
        return $objetos;
    }

    public function getById(string $id, string $caminho)
    {
        $objetos = $this->getAll($caminho);
        $objeto = array_filter($objetos, function ($objetoAux) use($id) {
            if($objetoAux->id == $id)
            {
                return $objetoAux;
            }
        });
        return array_values($objeto)[0];
    }

    public function getData()
    {
        $data = $this->getAll("turma");
        $turmas = [];
        //echo ($data["-MQD1w6gwwMLRAJdISR-"] + "\n\n\n");
        foreach ($data as $_key => $values) {
            $aux = new stdClass();
            $aux->id = $_key;
            foreach ($values as $key => $value) {
                $aux->$key = $value;
            }
            array_push($turmas, $aux);
        }

        //echo($this->getById("-MQDBzHgaXhoL6HpB3tk")->nome);

        return response()->json($turmas);
    }

    /**
     * Delete data.
     */
    public function delete(string $id, string $caminho)
    {
        $delete = $this->database->getReference( $caminho . "/" . $id)->remove();
    }

    /**
     * Delete all data.
     */
    public function deleteAll(string $caminho)
    {
        $this->database->getReference('blog/posts')->remove();
    }
}
