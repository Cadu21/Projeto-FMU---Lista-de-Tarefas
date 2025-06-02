document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("todo-form");
  const tarefaInput = document.getElementById("tarefa");
  const comPrazo = document.getElementById("comPrazo");
  const prazoInputs = document.querySelector(".prazo-inputs");
  const dataInicio = document.getElementById("dataInicio");
  const dataFim = document.getElementById("dataFim");
  const lista = document.getElementById("lista-tarefas");

  comPrazo.addEventListener("change", () => {
    prazoInputs.style.display = comPrazo.checked ? "flex" : "none";
  });

  // Carregar tarefas do banco
  fetch("../controllers/TarefaController.php")
    .then((res) => res.json())
    .then((dados) => {
      if (dados.status === "sucesso") {
        dados.tarefas.forEach(renderizarTarefa);
      }
    });

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const texto = tarefaInput.value.trim();
    if (!texto) return;

    if (comPrazo.checked && dataInicio.value && dataFim.value) {
      const ini = new Date(dataInicio.value);
      const fim = new Date(dataFim.value);

      if (fim < ini) {
        alert("A data de fim não pode ser anterior à data de início.");
        return;
      }
    }

    const formData = new FormData();
    formData.append("acao", "adicionar");
    formData.append("nome_tarefa", texto);
    formData.append("possui_prazo", comPrazo.checked ? 1 : 0);
    formData.append("data_inicio", comPrazo.checked ? dataInicio.value : "");
    formData.append("data_fim", comPrazo.checked ? dataFim.value : "");

    try {
      const resposta = await fetch("../controllers/TarefaController.php", {
        method: "POST",
        body: formData,
      });

      const resultado = await resposta.json();
      alert(resultado.mensagem);

      if (resultado.status === "sucesso" && resultado.tarefa) {
        renderizarTarefa(resultado.tarefa);
        form.reset();
        prazoInputs.style.display = "none";
      }
    } catch (error) {
      alert("Erro ao cadastrar a tarefa.");
      console.error(error);
    }
  });

  function renderizarTarefa(tarefa) {
    const li = document.createElement("li");
    const span = document.createElement("span");

    let texto = tarefa.nome_tarefa;
    if (tarefa.possui_prazo && tarefa.data_inicio && tarefa.data_fim) {
      texto += ` — prazo: de ${formatarData(tarefa.data_inicio)} até ${formatarData(tarefa.data_fim)}`;
    }
    span.textContent = texto;
    li.appendChild(span);

    if (tarefa.tarefa_concluida) {
      li.style.backgroundColor = "#bbf7d0";
    }

    const btnDelete = criarBotao("Excluir tarefa", "delete", async () => {
      if (!confirm("Deseja realmente excluir esta tarefa?")) return;
      await fetch("../controllers/TarefaController.php", {
        method: "POST",
        body: new URLSearchParams({
          acao: "excluir",
          id_tarefa: tarefa.id_tarefa,
        }),
      });
      li.remove();
    });
    li.appendChild(btnDelete);

    const btnEditar = criarBotao("Mudar data", "update", async () => {
      const novaIni = prompt("Nova data de início (YYYY-MM-DD):", tarefa.data_inicio || "");
      const novaFim = prompt("Nova data de fim (YYYY-MM-DD):", tarefa.data_fim || "");

      if (!novaIni || !novaFim) return;

      const ini = new Date(novaIni);
      const fim = new Date(novaFim);

      if (fim < ini) {
        alert("A data de fim não pode ser anterior à data de início.");
        return;
      }

      await fetch("../controllers/TarefaController.php", {
        method: "POST",
        body: new URLSearchParams({
          acao: "editar",
          id_tarefa: tarefa.id_tarefa,
          data_inicio: novaIni,
          data_fim: novaFim,
        }),
      });

      span.textContent = `${tarefa.nome_tarefa} — prazo: de ${formatarData(novaIni)} até ${formatarData(novaFim)}`;
    });
    li.appendChild(btnEditar);

    const btnConcluir = criarBotao("Concluir tarefa", "complete", async () => {
      await fetch("../controllers/TarefaController.php", {
        method: "POST",
        body: new URLSearchParams({
          acao: "concluir",
          id_tarefa: tarefa.id_tarefa,
        }),
      });
      li.style.backgroundColor = "#bbf7d0";
      btnConcluir.disabled = true;
    });
    li.appendChild(btnConcluir);

    lista.appendChild(li);
  }

  function criarBotao(texto, classe, fn) {
    const btn = document.createElement("button");
    btn.textContent = texto;
    btn.classList.add("btn", classe);
    btn.addEventListener("click", fn);
    return btn;
  }

  function formatarData(str) {
    const [y, m, d] = str.split("-");
    return `${d.padStart(2, "0")}/${m.padStart(2, "0")}/${y}`;
  }
});

document.getElementById("sairBtn").addEventListener("click", () => {
  window.location.href = "../controllers/login.php";
});

document.getElementById("uploadFoto").addEventListener("change", function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById("fotoPerfil").src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});
