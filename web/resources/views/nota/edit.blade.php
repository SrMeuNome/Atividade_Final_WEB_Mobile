@extends('template.app-home')

@section('main')
    <div class="container custom-container">
        <div class="bg-light float-field-box">
            <fieldset>
                <legend class="title">Editar Posição {{$posicao->nome}}</legend>
                <div class="cadastro">
                    <div class="container">
                        <form class="row" method="POST" action="/posicao">
                            <div class="form-group col-6">
                                <label for="posicao" class="form-text">Nome:</label>
                                <input value="{{$posicao->nome}}" readonly id="nome" name="nome" class="form-control" type="text">
                                <input value="{{$posicao->id}}" id="id" name="id" type="hidden">
                            </div>
                            <div class="form-group col-6">
                                <label for="posicao" class="form-text">Descrição:</label>
                                <input value="{{$posicao->descricao}}" id="descricao" name="descricao" class="form-control" type="text">
                            </div>
                            @csrf
                            <div class="form-inline col-12 btn-custom-group">
                                <button type="submit" class="btn btn-outline-success icon"><i class="material-icons">add_circle_outline</i></button>
                                <button type="reset" class="btn btn-outline-warning icon"><i class="material-icons">clear</i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </fieldset>
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