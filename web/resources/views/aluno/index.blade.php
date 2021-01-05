@extends('template.app')

@section('nome_tela', 'Aluno')

@section('cadastro')
    <div class="container">
        <form class="row" method="POST" action="/aluno">
            <div class="form-group col-6">
                <label for="nome" class="form-text">Nome do aluno:</label>
                <input value="{{$aluno->nome}}" id="nome" name="nome" class="form-control" type="text">
            </div>
            <div class="form-group col-6">
                <label for="email" class="form-text">E-mail:</label>
                <input value="{{$aluno->email}}" id="email" name="email" class="form-control" type="email">
            </div>
            <div class="form-group col-6">
                <label for="matricula" class="form-text">Matrícula:</label>
                <input value="{{$aluno->matricula}}" id="matricula" name="matricula" class="form-control" type="text">
            </div>
            <div class="form-group col-6">
                <label for="turma" class="form-text">Turmas:</label>
                <select id="turma" name="turma[]" class="form-control" required multiple>
                    @foreach ($turmas as $turma)
                        @if ($alunoAux->contemTurma($aluno->id, $turma->id))
                            <option value="{{$turma->id}}" selected >{{$turma->nome}}</option>
                        @else
                            <option value="{{$turma->id}}">{{$turma->nome}}</option>
                        @endif 
                    @endforeach
                </select>
            </div>
            <input type="hidden" id="id" name="id" value="{{$aluno->id}}">
            @csrf
            <div class="form-inline col-12 btn-custom-group">
                <button type="submit" class="btn btn-outline-success icon"><i class="material-icons">add_circle_outline</i></button>
                <button type="reset" class="btn btn-outline-warning icon"><i class="material-icons">clear</i></button>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $("#turma").selectpicker("refresh")
        });
    </script>
@endsection

@section('listagem')
    <div class="custom-table">
        <table class="table table-hover table-light col-12">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Matrícula</th>
                    <th>Turmas</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach ($alunos as $aluno)
                    <tr> 
                        <td>{{$aluno->nome}}</td>
                        <td>{{$aluno->email}}</td>
                        <td>{{$aluno->matricula}}</td>
                        <td>
                            @if($alunoAux->countTurmas($aluno->id) > 0)
                                @foreach ($turmas as $turma)
                                    <ul>
                                        @if ($alunoAux->contemTurma($aluno->id, $turma->id))
                                            <li>{{$turma->nome}}</li>
                                        @endif
                                    </ul>
                                @endforeach
                            @else
                                Não está cadastrado em turmas.
                            @endif 
                        </td>
                        <td>
                            <div class="btn-custom-group">
                                <form method="GET" action="/aluno/{{$aluno->id}}/edit">
                                    @csrf
                                    <button class="btn btn-outline-primary icon btn-circle" type="submit"><i class="material-icons">edit</i></button>
                                </form>
                            </div>
                        </td>
                        <td>
                            <div class="btn-custom-group">
                                <form method="POST" action="/aluno/{{$aluno->id}}">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete" />
                                    <button onclick="return confirm('Você deseja realmente deletar esse aluno?')" class="btn btn-outline-danger icon btn-circle" type="submit"><i class="material-icons">delete</i></button>
                                </form>
                            </div>
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
        $('#aluno-link').tab('show');
    })
</script>
@endsection

