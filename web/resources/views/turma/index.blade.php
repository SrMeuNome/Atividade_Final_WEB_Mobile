@extends('template.app')

@section('nome_tela', 'Turma')

@section('cadastro')
    <div class="container">
        <form class="row" method="POST" action="/turma">
            <div class="form-group col-6">
                <label for="turma" class="form-text">Turma:</label>
                <input value="{{$turma->nome}}" id="turma" name="turma" class="form-control" type="text">
            </div>
            <div class="form-group col-6">
                <label for="curso" class="form-text">Curso:</label>
                <input value="{{$turma->curso}}" id="curso" name="curso" class="form-control" type="text">
            </div>
            <input type="hidden" id="id" name="id" value="{{$turma->id}}">
            @csrf
            <div class="form-inline col-12 btn-custom-group">
                <button type="submit" class="btn btn-outline-success icon"><i class="material-icons">add_circle_outline</i></button>
                <button type="reset" class="btn btn-outline-warning icon"><i class="material-icons">clear</i></button>
            </div>
        </form>
    </div>
@endsection

@section('listagem')
    <div class="custom-table">
        <table class="table table-hover table-light col-12">
            <thead>
                <tr>
                    <th>Turma</th>
                    <th>Curso</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach ($turmas as $turma)
                    <tr> 
                        <td>{{$turma->nome}}</td>
                        <td>{{$turma->curso}}</td>
                        <td>
                            <div class="btn-custom-group">
                                <form method="GET" action="/turma/{{$turma->id}}/edit">
                                        @csrf
                                        <button class="btn btn-outline-primary icon btn-circle" type="submit"><i class="material-icons">edit</i></button>
                                </form>
                            </div>
                        </td>
                        
                        <td>
                            <div class="btn-custom-group">
                                <form method="POST" action="/turma/{{$turma->id}}">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete" />
                                    <button onclick="return confirm('Você deseja realmente deletar essa turma?')" class="btn btn-outline-danger icon btn-circle" type="submit"><i class="material-icons">delete</i></button>
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
        $('#turma-link').tab('show');
    })
</script>
@endsection

