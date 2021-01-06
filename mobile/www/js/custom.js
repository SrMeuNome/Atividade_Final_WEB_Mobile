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

var listaDB = firebase.database().ref('aluno')


var list = []

const makeLogin = () => {
    let matricula = $('#matricula').val()
    listaDB.on('value', function (itens) {
        itens.forEach(function (item, index) {
            if (item.val().matricula == matricula) {
                window.location.replace('../notas.html')
                return true
            }
        })
        msgAlert("Você não está cadastrado no sistema!")
        return false
    })
}

const carregarLista = () => {
    list = []
    value = {}
    listaDB.on('value', function (itens) {
        itens.forEach(function (item, index) {
            value = { id: item.key, nome: item.val().nome, telefone: item.val().telefone }
            list.push(value)
        })
        refleshList()
    })
}

const refleshList = () => {
    var listHTML = []
    var checked = ''
    list.forEach(function (value, index) {
        listHTML.push(`<li id="${index}" class="collection-item">
        <div class="list-container">
            <b>Nome:</b> ${value.nome}<br>
            <a onclick="deleteList(${index})" class=" secondary-content">
                <i class="material-icons blue-text">clear</i>
            </a><br>
            <b>Telefone:</b> ${value.telefone}
        </div>
    </li >`)
    })
    $('#list-level').html(listHTML);
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

const deleteList = (id) => {
    listaDB.child(list[id].id).remove((a) => {
        if (a) {
            msgAlert("Ocorreu um erro ao deletar um item, verifique sua conexão!")
        }
    })
    carregarLista()
}

//A regexp /\D/g em conjunto com o replace, está anulando todo caractere não numerico
//\D representa todo caractere não numerico

var maskFunc = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 0.0000-0000' : '(00) 0000-00009';
},
    maskFuncOptions = {
        onKeyPress: function (val, e, field, options) {
            field.mask(maskFunc.apply({}, arguments), options);
        }
    };

$('#telefone').mask(maskFunc, maskFuncOptions)