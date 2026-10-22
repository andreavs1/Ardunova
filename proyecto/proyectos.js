async function cargarProyectos() {
  const contenedor = document.getElementById("lista-proyectos");

  if (!contenedor) {
    console.error("No se encontró el contenedor de proyectos.");
    return;
  }

  try {
    const respuesta = await fetch("./proyectos.json");

    if (!respuesta.ok) {
      throw new Error("No se pudo cargar proyectos.json");
    }

    const proyectos = await respuesta.json();

    contenedor.innerHTML = proyectos.map(proyecto => `
      <div class="col-12 col-sm-6 col-lg-4 proyecto"
           data-nivel="${proyecto.nivel.toLowerCase()}">

        <div class="card h-100 shadow-sm">
          <img
            src="${proyecto.imagen}"
            class="card-img-top"
            alt="${proyecto.titulo}"
          >

          <div class="card-body d-flex flex-column">
            <span class="tag-nivel">${proyecto.nivel}</span>

            <h2 class="h5 mt-2">${proyecto.titulo}</h2>

            <p>${proyecto.descripcion}</p>

            <a
              href="${proyecto.enlace}"
              class="btn btn-gradient mt-auto"
            >
              Ver proyectos
            </a>
          </div>
        </div>

      </div>
    `).join("");

  } catch (error) {
    console.error("Error al cargar los proyectos:", error);
    contenedor.textContent =
      "No se pudieron cargar los proyectos. Revisá los archivos.";
  }
}

document.addEventListener("DOMContentLoaded", () => {
  cargarProyectos();

  const filtro = document.getElementById("filtro-nivel");

  if (filtro) {
    filtro.addEventListener("change", () => {
      const tarjetas = document.querySelectorAll(
        "#lista-proyectos .proyecto"
      );

      tarjetas.forEach(tarjeta => {
        tarjeta.hidden =
          filtro.value !== "todos" &&
          tarjeta.dataset.nivel !== filtro.value;
      });
    });
  }
});
