<!DOCTYPE html>
<html>

<head>
    <meta charset="utf8">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('css/icons.css')}}">
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.js')}}"></script>
    <script src="{{asset('js/bootstrap-select.js')}}"></script>
    <title>@yield('nome_tela')</title>
</head>

<body>
    <nav class="nav nav-pills nav-fill bg-success ">
        <div class="nav-item"><a id="home-link" class="nav-link text-light" href="/">Home</a></div>
        <div class="nav-item"><a id="turma-link" class="nav-link text-light" href="/turma">Turmas</a></div>
        <div class="nav-item"><a id="aluno-link" class="nav-link text-light" href="/aluno">Alunos</a></div>
        <div class="nav-item"><a id="nota-link" class="nav-link text-light" href="/nota">Notas</a></div>
    </nav>

    @if (Session::has('salvar'))
        <div class="alert alert-success">
            {{Session::get('salvar')}}
        </div>
    @endif
    
    @if (Session::has('excluir'))
        <div class="alert alert-danger">
            {{Session::get('excluir')}}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{$e}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @yield('main')
    
    @yield('tab-active')
</body>

</html>