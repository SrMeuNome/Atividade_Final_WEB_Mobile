// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyDuLYIHPh9drkC0Rxhb53maCKT--qKSKUs",
    authDomain: "atividadefinal-ac78d.firebaseapp.com",
    databaseURL: "https://atividadefinal-ac78d-default-rtdb.firebaseio.com",
    projectId: "atividadefinal-ac78d",
    storageBucket: "atividadefinal-ac78d.appspot.com",
    messagingSenderId: "124885668186",
    appId: "1:124885668186:web:a8a0565b9a69c6717ae363"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

var database = firebase.database()

var listaAlunos = database.ref('aluno')
var listaMaterias = database.ref('materia')
var listaNotas = database.ref('nota')

var nome
var notas = []

const makeLogin = () => {
    var id = ''
    var nome = ''
    let matricula = $('#matricula').val()
    listaAlunos.on('value', function (itens) {
        let id
        itens.forEach(function (item, index) {
            if (item.val().matricula === matricula) {
                id = item.key
                nome = item.val().nome
                $('#c1').toggle(false)
                $('#c2').toggle(true)
                $('#user').html(nome)
                return
            }
        })
        if (nome === '') {
            msgAlert("Você não está cadastrado no sistema!")
        }
        else {
            carregarDados(id)
        }
    })
}

const carregarDados = (id) => {
    listaNotas.on('value', function (itens) {
        itens.forEach(function (item, index) {
            if (item.val().aluno === id) {
                notas.push({ aluno: item.val().aluno, turma: item.val().turma, nota: item.val().nota })
            }
        })
        listaMaterias.on('value', function (itens) {
            itens.forEach(function (item) {
                alert("Estou aqui")
                let index = notas.findIndex(element => element.turma === item.key)
                if (typeof (index) !== undefined) {
                    notas[index].turma = item.val().nome
                    alert(item.val().nome)
                }
            })
            showNotas()
        })
    })
}

const showNotas = () => {
    var listHTML = []
    notas.forEach(function (value, index) {
        listHTML.push(`<li id="${index}" class="collection-item">
        <div class="list-container">
            <b>Matéria:</b> ${value.turma}<br>
            <b>Nota:</b> ${value.nota}
        </div>
    </li >`)
    })
    $('#list-nota').html(listHTML);
}

const msgAlert = (text) => {
    $('#error-text').html(text)
    $('#error').fadeIn('2.5s')
}

const addList = () => {
    if ($('#nome').val() === '' && $('#telefone').val() === '') {
        $('#error-text').html(`Você deve preencher todos os campos antes!`)
        $('#error').fadeIn('2.5s')
    }
    else if ($('#nome').val() === '') {
        $('#error-text').html(`Você deve preencher o campo "Nome" antes!`)
        $('#error').fadeIn('2.5s')
    }
    else if ($('#telefone').val() === '') {
        $('#error-text').html(`Você deve preencher o campo "Telefone" antes!`)
        $('#error').fadeIn('2.5s')
    }
    else if ($('#telefone').cleanVal().length < 10) {
        $('#error-text').html(`Preencha o campo "Telefone" corretamente!`)
        $('#error').fadeIn('2.5s')
    }
    else {
        listaDB.push({ nome: $('#nome').val(), telefone: $('#telefone').val() }, (a) => {
            if (a) {
                msgAlert("Ocorreu um erro ao adicionar um novo item, verifique sua conexão!")
            }
        })
        $('#nome').val('')
        $('#telefone').val('')
        $('label[for="nome"]').attr('class', $('label[for="nome"]').attr('class').replace(/\bactive\b/g, ''))
        $('label[for="telefone"]').attr('class', $('label[for="nome"]').attr('class').replace(/\bactive\b/g, ''))
        carregarLista()
    }
}