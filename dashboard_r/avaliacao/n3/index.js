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




