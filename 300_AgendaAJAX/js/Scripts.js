window.onload = inicializaciones;
var tablaCategorias;
var tablaPersonas;
// TODO ¿Útil para mantener un control de eliminaciones, etc.?     var categorias;



function inicializaciones() {
    tablaCategorias = document.getElementById("tablaCategorias");
    document.getElementById('submitCrearCategoria').addEventListener('click', clickCrearCategoria);
    cargarTodasLasCategorias();
}

//categorias
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
    tr.setAttribute("id", "categoria"+categoria.id);
    
    var td = document.createElement("td");
    var td2 = document.createElement("td");
    var tdModificar= document.createElement("td");
    
    var a = document.createElement("a");
    var a2 = document.createElement("a");
    var botonModificar = document.createElement("button");

    a.setAttribute("href","CategoriaFicha.php?id=" + categoria.id);
    a2.setAttribute("onclick","eliminarCategoria(" + categoria.id + ")");
    botonModificar.setAttribute("onclick", "modificarCategoria(" + categoria.id + ")");
    td.setAttribute("id", "id"+categoria.id);

    var textoContenido = document.createTextNode(categoria.nombre);
    var textoContenido2 = document.createTextNode("X");
    var textoModificar= document.createTextNode("Modificar");

    a.appendChild(textoContenido);
    a2.appendChild(textoContenido2);
    botonModificar.appendChild(textoModificar);

    td.appendChild(a);
    td2.appendChild(a2);
    tdModificar.appendChild(botonModificar);

    tr.appendChild(td);
    tr.appendChild(td2);
    tr.appendChild(tdModificar);

    tablaCategorias.appendChild(tr);
}

function eliminarCategoria(id) {
    var request= new XMLHttpRequest();
    request.open("GET", "categoriaEliminar.php?id="+id);
    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var linea=document.getElementById("categoria"+id);
            linea.remove();
        }
    };
    request.send()
}

function modificarCategoria(id) {
    var td= document.getElementById("id"+id);

    if(td.textContent != "") {
        var input= document.createElement("input");
        input.setAttribute("type", "text");
        input.setAttribute("id", "nuevoNombre"+id);
        input.setAttribute("name", "nuevoNombre"+id);
        td.removeChild(td.firstChild);
        td.appendChild(input); 
    }else if(document.getElementById("nuevoNombre"+id).value != "") {
        var request= new XMLHttpRequest();
        request.open("GET", "categoriaGuardar.php?id="+id+"&nombre="+document.getElementById("nuevoNombre"+id).value);
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                alert("Modificacion correcta");
            }
        };
        request.send()
    }
}

// TODO Actualizar lo local si actualizan el servidor. Poner timestamp de modificación en la tabla y pedir categoriaObtenerModificadasDesde(timestamp)

//personas
function cargarTodasLasPersonas() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var personas = JSON.parse(this.responseText);

            for (var i=0; i<personas.length; i++) {
                insertarPersona(personas[i]);
            }
        }
    };

    request.open("GET", "PersonaObtenerTodas.php");
    request.send();
}

var nombrePersona;
var apellidosPersona;
var telefonoPersona;
var estrellaPersona;
var categoriaIdPersona;
function clickCrearPersona() {
    nombrePersona= document.getElementById("nombrePersona").value;
    document.getElementById("nombrePersona").value= "";
    apellidosPersona= document.getElementById("apellidosPersona").value;
    document.getElementById("apellidosPersona").value= "";
    telefonoPersona= document.getElementById("telefonoPersona").value;
    document.getElementById("telefonoPersona").value= "";
    estrellaPersona= document.getElementById("estrellaPersona").value;
    document.getElementById("estrellaPersona").value= "";
    categoriaIdPersona= document.getElementById("categoriaIdPersona").value;
    document.getElementById("categoriaIdPersona").value= "";

    var request = new XMLHttpRequest();
    var URL= "PersonaCrear.php?nombre="+nombrePersona+"&apellidos="+apellidosPersona+"&telefono="+telefonoPersona+"&estrella="+estrellaPersona+"&categoriaId="+categoriaIdPersona;
    if(nombre != "") {
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var personas = JSON.parse(this.responseText);
                insertarPersona(personas);
            }
        };

        request.open("GET", URL);
        request.send();
    }
}

function insertarPersona(persona) {

    var tr = document.createElement("tr");
    tr.setAttribute("id", "persona"+persona.id);
    
    var td = document.createElement("td");
    var tdApellidos= document.createElement("td");
    var tdTelefono= document.createElement("td");
    var tdEstrella= document.createElement("td");
    var tdCategoriaId= document.createElement("td");
    var tdEliminar = document.createElement("td");
    var tdModificar= document.createElement("td");
    
    var a = document.createElement("a");
    var aApellidos = document.createElement("a");
    var aTelefono = document.createElement("a");
    // var aEstrella = document.createElement("a");
    var aCategoriaId = document.createElement("a");
    var aEliminar = document.createElement("a");
    var botonModificar = document.createElement("button");

    a.setAttribute("href","PersonaFicha.php?id=" + persona.id);
    aApellidos.setAttribute("href","PersonaFicha.php?id=" + persona.id);
    aTelefono.setAttribute("href","PersonaFicha.php?id=" + persona.id);
    // aEstrella.setAttribute("href","PersonaFicha.php?id=" + persona.id);
    aCategoriaId.setAttribute("href","PersonaFicha.php?id=" + persona.id);
    aEliminar.setAttribute("onclick","eliminarPersona(" + persona.id + ")");
    botonModificar.setAttribute("onclick", "modificarPersona(" + persona.id + ")");
    td.setAttribute("id", "id"+persona.id);

    var textoContenido = document.createTextNode(persona.nombre);
    var textoApellidos = document.createTextNode(persona.apellidos);
    var textoTelefono = document.createTextNode(persona.telefono);
    // var textoEstrella = document.createTextNode(persona.estrella);
    var textoCategoriaId = document.createTextNode(persona.categoriaId);
    var textoContenido2 = document.createTextNode("X");
    var textoModificar= document.createTextNode("Modificar");

    a.appendChild(textoContenido);
    aApellidos.appendChild(textoApellidos);
    aTelefono.appendChild(textoTelefono);
    // aEstrella.appendChild(textoEstrella);
    aCategoriaId.appendChild(textoCategoriaId);
    aEliminar.appendChild(textoContenido2);
    botonModificar.appendChild(textoModificar);

    td.appendChild(a);
    tdApellidos.appendChild(aApellidos);
    tdTelefono.appendChild(aTelefono);
    // tdEstrella.appendChild(aEstrella);
    tdCategoriaId.appendChild(aCategoriaId);
    tdEliminar.appendChild(aEliminar);
    tdModificar.appendChild(botonModificar);

    tr.appendChild(td);
    tr.appendChild(tdApellidos);
    tr.appendChild(tdTelefono);
    tr.appendChild(tdEstrella);
    tr.appendChild(tdCategoriaId);
    tr.appendChild(tdEliminar);
    tr.appendChild(tdModificar);

    tablaPersonas.appendChild(tr);
}

function eliminarPersona(id) {
    var request= new XMLHttpRequest();
    request.open("GET", "personaEliminar.php?id="+id);
    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var linea=document.getElementById("persona"+id);
            linea.remove();
        }
    };
    request.send()
}

function modificarPersona(id) {
    var td= document.getElementById("idPersona"+id);

    if(td.textContent != "") {
        var input= document.createElement("input");
        input.setAttribute("type", "text");
        input.setAttribute("idPersona", "nuevoNombrePersona"+id);
        input.setAttribute("namePersona", "nuevoNombrePersona"+id);
        td.removeChild(td.firstChild);
        td.appendChild(input); 
    }else if(document.getElementById("nuevoNombrePersona"+id).value != "") {
        var request= new XMLHttpRequest();
        request.open("GET", "personaGuardar.php?id="+id+"&nombre="+document.getElementById("nuevoNombrePersona"+id).value+"&apellidos");
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                alert("Modificacion correcta");
            }
        };
        request.send()
    }
}