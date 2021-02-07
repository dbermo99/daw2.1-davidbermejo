window.onload = inicializaciones;
var tablaCategorias;
// TODO ¿Útil para mantener un control de eliminaciones, etc.?     var categorias;



function inicializaciones() {
    tablaCategorias = document.getElementById("tablaCategorias");
    document.getElementById('submitCrearCategoria').addEventListener('click', clickCrearCategoria)

    cargarTodasLasCategorias();
}

function cargarTodasLasCategorias() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var categorias = JSON.parse(this.responseText);

            for (var i=0; i<categorias.length; i++) {
                insertarCategoria(categorias[i]);
            }
        }
    };

    request.open("GET", "CategoriaObtenerTodas.php");
    request.send();
}

var nombre;
function clickCrearCategoria() {
    // Recoger datos del form.
    // Limpiar los datos en el form: .clear()
    // Crear un XMLHttpRequest. Enviar en la URL los datos de la categoria: CategoriaCrear.php?nombre=blablabla
    // Recoger la respuesta del request. Vendrá un objeto categoría.
    // Llamar con ese objeto a insertarCategoria(categoria);
    nombre= document.getElementById("nombre").value;
    document.getElementById("nombre").value= "";

    var request = new XMLHttpRequest();
    var URL= "CategoriaCrear.php?nombre="+nombre;
    if(nombre != "") {
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var categorias = JSON.parse(this.responseText);
                insertarCategoria(categorias);
            }
        };

        request.open("GET", URL);
        request.send();
    }
}

function insertarCategoria(categoria) {
    // TODO Que la categoría se inserte en el lugar que le corresponda según un orden alfabético.
    // Usar esto: https://www.w3schools.com/jsref/met_node_insertbefore.asp

    var tr = document.createElement("tr");
    var td = document.createElement("td");
    var td2 = document.createElement("td");
    var a = document.createElement("a");
    var a2 = document.createElement("a");

    a.setAttribute("href","CategoriaFicha.php?id=" + categoria.id);
    a2.setAttribute("href","CategoriaEliminar.php?id=" + categoria.id);
    var textoContenido = document.createTextNode(categoria.nombre);
    var textoContenido2 = document.createTextNode("Eliminar");

    a.appendChild(textoContenido);
    a2.appendChild(textoContenido2);
    td.appendChild(a);
    td2.appendChild(a2);
    tr.appendChild(td);
    tr.appendChild(td2);
    tablaCategorias.appendChild(tr);
}

function eliminarCategoria(id) {
    var tr = document.createElement("tr");
    var td = document.createElement("td");
    var a = document.createElement("a");
    a.setAttribute("href","CategoriaEliminar.php?id=" + id);
    var textoContenido = document.createTextNode("Eliminada");

    a.appendChild(textoContenido);
    td.appendChild(a);
    tr.appendChild(td);
    tablaCategorias.appendChild(tr);
}

function modificarCategoria(categoria) {
    // TODO Pendiente de hacer.
    nombre= document.getElementById("nombre").value;
    
}

// TODO Actualizar lo local si actualizan el servidor. Poner timestamp de modificación en la tabla y pedir categoriaObtenerModificadasDesde(timestamp)