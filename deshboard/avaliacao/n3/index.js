document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('#abrirDetalhes');
    const boxes = document.querySelectorAll('.box-detalhes');

    buttons.forEach((button, index) => {
        button.addEventListener('click', function() {
            const selectedBox = boxes[index];

            // Oculta todas as caixas
            boxes.forEach(box => {
                if (box !== selectedBox) {
                    box.classList.remove('active');
                }
            });

            // Alterna a classe 'active' na caixa clicada
            selectedBox.classList.toggle('active');
        });
    });
});

// soma checkbox

function calcularSoma(index) {
    // Selecionar o formulário específico
    const form = document.querySelector(`#form-${index}`);
    const checkboxes = form.querySelectorAll('input[type="checkbox"]');
    let soma = 0;

    // Iterar sobre todos os checkboxes e somar os valores dos marcados
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            soma += parseInt(checkbox.value);
        }
    });

    // Exibir a soma ou fazer outra coisa com ela
    alert(`A soma dos valores dos checkboxes marcados no formulário ${index} é: ${soma}`);
}