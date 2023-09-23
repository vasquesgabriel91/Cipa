var btn = document.querySelector("#btn");
var btn1 = document.querySelector("#btn1");
var cadastrar = document.querySelector("#cadastrar");
var re = document.querySelector("#re");
var nome = document.querySelector("#nome");
var setor = document.querySelector("#setor");



btn.addEventListener('click', ()=>{
    re.value= '';
    nome.value= '';
});
btn1.addEventListener('click', ()=>{
    re.value= '';
    nome.value= '';
});



var consulta = document.querySelector("#consulta").disabled = true;

document.querySelector("#matricula").addEventListener("input", function(event){

    var matricula = document.querySelector("#matricula").value;

    if (matricula !== null && matricula !== '' ){ 
        document.querySelector("#consulta").disabled = false;

      } else {
        document.querySelector("#consulta").disabled = true;

      }

});

var btn_acesso = document.getElementById("#btn_acesso").disabled = true;

document.querySelector("#matricula").addEventListener("input", function(event){

    var matricula = document.querySelector("#matricula").value;

    if (matricula !== null && matricula !== '' && nome !== '' && re !== ''){ 
        document.querySelector("#btn_acesso").disabled = false;

      } else {
        document.querySelector("#btn_acesso").disabled = true;

      }

});
