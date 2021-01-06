@extends('template.app')

@section('nome_tela', 'Nota')

@section('cadastro')
    <div class="container">
        <form class="row" method="GET" action="/nota/{{$turma->id}}">
            <div class="form-group col-12">
                <label for="turma" class="form-text">Turmas:</label>
                <select onchange="changeAlunos(this)" id="turma" name="turma" class="form-control">
                    <option value=""></option> 
                    @foreach ($turmas as $turmaAuxi)
                        @if($turmaAuxi->id == $turma->id)
                            <option value="{{$turmaAuxi->id}}" selected>{{$turmaAuxi->nome}}</option>
                        @else
                            <option value="{{$turmaAuxi->id}}">{{$turmaAuxi->nome}}</option>
                        @endif 
                    @endforeach
                </select>
            </div>
            @csrf
        </form>
    </div>
@endsection

@section('listagem')
    <div class="custom-table">
        <table class="table table-hover table-light col-6">
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alunosNotas as $aluno)
                    <tr>
                        <td>{{$aluno->nome}}</td>
                        <td>
                            <form method="POST" action="/nota"> 
                                @csrf
                                <input onkeydown="changeNota(event, obj)"
                                value="{{$aluno->nota}}" name="nota"
                                class="form-control" type="number" min="0" max="10">
                                <input type="hidden" name="aluno" value="{{$aluno->id}}">
                                <input type="hidden" name="turma-id" value="{{$turma->id}}">
                                <input type="hidden" name="nota-id" value="{{$aluno->idnota}}">
                            </form>
                        </td>
                    </tr>
                @endforeach 
            </tbody>
        </table>
    </div>
@endsection

@section('tab-active')
<script>
    $(document).ready(function() {
        $('#nota-link').tab('show');
    })
</script>
@endsection

