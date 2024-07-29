<form class="formulario_instalacao_iptv" method="post">
    <div>
        <input value="1" type="checkbox" name="execucao" id="execucao">
        <label for="execucao" id="label_execucao">A ordem de serviço estava com o Status em "Execução"? </label>
    </div>

    <div>
        <input class="checkbox" value="1" type="checkbox" name="potencia" id="potencia">
        <label for="potencia" id="label_potencia">Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.</label>
    </div>
    <div>
        <input class="checkbox" value="1" type="checkbox" name="potenciaBoa" id="potenciaBoa">
        <label for="potenciaBoa" id="label_potenciaBoa">A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?</label>
    </div>
    <div>
        <input class="checkbox" value="1" type="checkbox" name="organizadoCaixa" id="organizadoCaixa">
        <label for="organizadoCaixa" id="label_organizadoCaixa">Foi organizado os cabos na CTO/Caixa?</label>
    </div>
    <div>
        <input class="checkbox" value="1" type="checkbox" name="organizadoParede" id="organizadoParede">
        <label for="organizadoParede" id="label_organizadoParede">Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?</label>
    </div>
    <div>
        <input class="checkbox" value="1" type="checkbox" name="velocidade" id="velocidade">
        <label for="velocidade" id="label_velocidade">Foi Feito o teste de velocidade?</label>
    </div>
    <div>
        <input class="checkbox" value="1" type="checkbox" name="acessoRemoto" id="acessoRemoto">
        <label for="acessoRemoto" id="label_acessoRemoto">Foi ativado o Ping e liberado o acesso remoto?</label>
    </div>
    <div>
        <input class="checkbox" value="1" type="checkbox" name="nomeRede" id="nomeRede">
        <label for="nomeRede" id="label_nomeRede">Foi inserido o nome (Ticonnect), na rede wifi?</label>
    </div>
    <div>
        <label for="obs" id="label_obs">OBS:</label>
        <input type="text" name="obs" id="obs">
    </div>
    <button type="button" onclick="generateAndCopyText()">Gerar e Copiar Texto</button>
</form>

<script>
function generateAndCopyText() {
    const fields = [
        { id: 'execucao', label: 'A ordem de serviço estava com o Status em "Execução"?' },
        { id: 'potencia', label: 'Foi aferida a potência do Sinal, na casa do cliente e na CTO? Frequência 1490nm.' },
        { id: 'potenciaBoa', label: 'A potência do sinal óptico ficou na margem de sinal permitido = ou < que -25db?' },
        { id: 'organizadoCaixa', label: 'Foi organizado os cabos na CTO/Caixa?' },
        { id: 'organizadoParede', label: 'Os Equipamentos e cabos ficaram organizados na parede, de acordo com o Padrão Ti Connect?' },
        { id: 'velocidade', label: 'Foi Feito o teste de velocidade?' },
        { id: 'acessoRemoto', label: 'Foi ativado o Ping e liberado o acesso remoto?' },
        { id: 'nomeRede', label: 'Foi inserido o nome (Ticonnect), na rede wifi?' },
    ];
    
    let resultText = '';

    fields.forEach(field => {
        const checkbox = document.getElementById(field.id);
        resultText += `${field.label}\nSim (${checkbox.checked ? 'X' : ' '}) Não (${checkbox.checked ? ' ' : 'X'})\n\n`;
    });

    const obs = document.getElementById('obs').value;
    resultText += `OBS: ${obs}\n`;

    navigator.clipboard.writeText(resultText).then(() => {
        alert('Texto copiado para a área de transferência!');
    }).catch(err => {
        console.error('Erro ao copiar o texto: ', err);
    });
}
</script>
