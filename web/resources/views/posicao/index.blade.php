@extends('template.app-home')

@section('main')
    <div class="custom-container">
        <div class="custom-table col-12">
            <table class="table table-hover table-light">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posicoes as $posicao)
                        <tr>
                            <td>{{$posicao->nome}}</td>
                            <td>{{$posicao->descricao}}</td>
                            <td>
                                <div class="btn-custom-group">
                                    <form method="GET" action="/posicao/{{$posicao->id}}/edit">
                                            @csrf
                                            <button class="btn btn-outline-primary icon btn-circle" type="submit"><i class="material-icons">edit</i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('tab-active')
<script>
    $(document).ready(function() {
        $('#posicoes-link').tab('show');
    })
</script>
@endsection