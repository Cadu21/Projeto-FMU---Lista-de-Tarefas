function instalar() {
  const output = document.getElementById('output');
  const btn = document.getElementById('btn-instalar');

  btn.disabled = true;
  btn.textContent = "Instalando...";
  output.textContent = "";

  fetch('../controllers/install.php')
    .then(res => res.json())
    .then(data => {
      output.textContent = data.mensagem;

      if (data.status === "ok") {
        setTimeout(() => {
          window.location.href = "login.html";
        }, 2000);
      } else {
        btn.disabled = false;
        btn.textContent = "Instalar Agora";
      }
    })
    .catch(err => {
      output.textContent = '❌ Erro ao executar o instalador:\n' + err;
      btn.disabled = false;
      btn.textContent = "Instalar Agora";
    });
}
