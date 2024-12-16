document.querySelector('.menu-btn').addEventListener('click', function () {
    const dropdown = document.querySelector('.dropdown');
    dropdown.classList.toggle('show');
});

const searchInput = document.getElementById("searchInput").value;

function buscarArticulos() {
    const termino = document.getElementById("searchInput").value.toLowerCase();
    const articulos = document.querySelectorAll(".article-card");

    articulos.forEach(articulo => {
        const titulo = articulo.querySelector("h2").innerText.toLowerCase();
        const descripcion = articulo.querySelector("p").innerText.toLowerCase();

        // Verifica si el término está en el título o en la descripción
        if (titulo.includes(termino) || descripcion.includes(termino)) {
            articulo.style.display = "block"; // Muestra el artículo si coincide
        } else {
            articulo.style.display = "none"; // Oculta el artículo si no coincide
        }
    });
}

searchInput.addEventListener("input", buscarArticulos);