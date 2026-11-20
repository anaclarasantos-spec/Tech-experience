document.addEventListener('DOMContentLoaded', () => {
    const textarea = document.getElementById('mensagem');
    const contador = document.getElementById('contador-caracteres');
    const form = document.getElementById('form-inscricao');
    const maxChars = 200;

    
    if (textarea && contador) {
        textarea.addEventListener('input', () => {
            const restantes = maxChars - textarea.value.length;
            contador.textContent = `Restam ${restantes} caracteres`;
        });
    }

   
    if (form) {
        form.addEventListener('submit', (event) => {
            const checkboxes = document.querySelectorAll('input[name="oficinas[]"]:checked');
            const erroOficinas = document.getElementById('erro-oficinas');

            if (checkboxes.length === 0) {
                event.preventDefault(); 
                if (erroOficinas) erroOficinas.style.display = 'block';
            } else {
                if (erroOficinas) erroOficinas.style.display = 'none';
            }
        });
    }
});