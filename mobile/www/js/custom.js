// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyCbD2ZWPs1Vd7itx_S_DlZbHNMM_C5eg2g",
    authDomain: "prova1-pdm.firebaseapp.com",
    databaseURL: "https://prova1-pdm.firebaseio.com",
    projectId: "prova1-pdm",
    storageBucket: "prova1-pdm.appspot.com",
    messagingSenderId: "25622153019",
    appId: "1:25622153019:web:9de2a116eff569e6f0991e"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

var listaDB = firebase.database().ref('lista')


var list = []

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