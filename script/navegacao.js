var ButtonAdd = document.getElementById('buttonAdd')
var buttonCancelar = document.getElementById('buttonCancelar')

ButtonAdd.addEventListener('click' , () => {
    var PageSection = document.querySelector(".list-colaboradores")
    var PageBd = document.querySelector(".add-banco-de-dados")
    if(PageSection.classList.contains('hidden')){
        PageSection.classList.remove('hidden')
    }else{
        PageSection.classList.add('hidden')
        ButtonAdd.style.display = 'none'
        PageBd.style.display = 'flex'
    }
})

buttonCancelar.addEventListener('click', () =>{
    var PageSection = document.querySelector(".list-colaboradores")
    var PageBd = document.querySelector(".add-banco-de-dados")

    if(PageSection.classList.contains('hidden')){
        PageSection.classList.remove('hidden')
        ButtonAdd.style.display = 'flex'
        PageBd.style.display = 'none'
    }else{
        PageSection.classList.add('hidden')
        ButtonAdd.style.display = 'none'
    }
})
