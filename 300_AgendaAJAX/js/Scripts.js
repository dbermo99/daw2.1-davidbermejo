window.onload = inicializaciones;
var tablaCategorias;
var tablaPersonas;
// TODO ¿Útil para mantener un control de eliminaciones, etc.?     var categorias;



function inicializaciones() {
    tablaCategorias = document.getElementById("tablaCategorias");
    document.getElementById('submitCrearCategoria').addEventListener('click', clickCrearCategoria);
    cargarTodasLasCategorias();

    tablaPersonas = document.getElementById("tablaPersonas");
    document.getElementById('submitCrearPersona').addEventListener('click', clickCrearPersona);
    cargarTodasLasPersonas();
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
    botonModificar.setAttribute("onclick", "modificarCategoria(" + categoria + ")");
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

function modificarCategoria(categoria) {
    var td= document.getElementById("id"+categoria.id);

    if(td.textContent != "") {
        var input= document.createElement("input");
        input.setAttribute("type", "text");
        input.setAttribute("id", "nuevoNombre"+categoria.id);
        input.setAttribute("name", "nuevoNombre"+categoria.id);
        input.setAttribute("value", categoria.nombre)
        td.removeChild(td.firstChild);
        td.appendChild(input); 
    }else if(document.getElementById("nuevoNombre"+categoria.id).value != "") {
        var request= new XMLHttpRequest();
        request.open("GET", "categoriaGuardar.php?id="+categoria.id+"&nombre="+document.getElementById("nuevoNombre"+categoria.id).value);
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var nuevoNombreCategoria = document.createTextNode(document.getElementById("nuevoNombre"+categoria.id).value);
                td.removeChild(td.firstChild);
                var a = document.createElement("a");
                a.setAttribute("href","CategoriaFicha.php?id=" + categoria.id);
                a.appendChild(nuevoNombreCategoria);
                td.appendChild(a);
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

    var trPersona = document.createElement("tr");
    trPersona.setAttribute("id", "persona"+persona.id);
    
    var tdNombrePersona = document.createElement("td");
    var tdApellidos= document.createElement("td");
    var tdTelefono= document.createElement("td");
    var tdEstrella= document.createElement("td");
    var tdCategoriaId= document.createElement("td");
    var tdEliminar = document.createElement("td");
    var tdModificar= document.createElement("td");
    
    var aNombre = document.createElement("a");
    var aApellidos = document.createElement("a");
    var aTelefono = document.createElement("a");
    var aEstrella = document.createElement("a");
    var aCategoriaId = document.createElement("a");
    var aEliminar = document.createElement("a");
    var botonModificar = document.createElement("button");

    aNombre.setAttribute("href","PersonaFicha.php?id=" + persona.id);
    aApellidos.setAttribute("href","PersonaFicha.php?id=" + persona.id);
    aTelefono.setAttribute("href","PersonaFicha.php?id=" + persona.id);
    aEstrella.setAttribute("href","PersonaFicha.php?id=" + persona.id);
    aCategoriaId.setAttribute("href","PersonaFicha.php?id=" + persona.id);
    aEliminar.setAttribute("onclick","eliminarPersona(" + persona.id + ")");
    botonModificar.setAttribute("onclick", "modificarPersona(" + persona.id + ")");
    
    tdNombrePersona.setAttribute("id", "idNombre"+persona.id);
    tdApellidos.setAttribute("id", "idApellidos"+persona.id);
    tdTelefono.setAttribute("id", "idTelefono"+persona.id);
    tdEstrella.setAttribute("id", "idEstrella"+persona.id);
    tdCategoriaId.setAttribute("id", "idCategoriaId"+persona.id);

    var textoContenido = document.createTextNode(persona.nombre);
    var textoApellidos = document.createTextNode(persona.apellidos);
    var textoTelefono = document.createTextNode(persona.telefono);
    var textoEstrella = document.createTextNode(persona.estrella);
    var textoCategoriaId = document.createTextNode(persona.categoriaId);
    var textoContenido2 = document.createTextNode("X");
    var textoModificar= document.createTextNode("Modificar");

    aNombre.appendChild(textoContenido);
    aApellidos.appendChild(textoApellidos);
    aTelefono.appendChild(textoTelefono);
    aEstrella.appendChild(textoEstrella);
    aCategoriaId.appendChild(textoCategoriaId);
    aEliminar.appendChild(textoContenido2);
    botonModificar.appendChild(textoModificar);

    tdNombrePersona.appendChild(aNombre);
    tdApellidos.appendChild(aApellidos);
    tdTelefono.appendChild(aTelefono);
    tdEstrella.appendChild(aEstrella);
    tdCategoriaId.appendChild(aCategoriaId);
    tdEliminar.appendChild(aEliminar);
    tdModificar.appendChild(botonModificar);

    trPersona.appendChild(tdNombrePersona);
    trPersona.appendChild(tdApellidos);
    trPersona.appendChild(tdTelefono);
    trPersona.appendChild(tdEstrella);
    trPersona.appendChild(tdCategoriaId);
    trPersona.appendChild(tdEliminar);
    trPersona.appendChild(tdModificar);

    tablaPersonas.appendChild(trPersona);
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
    var tdNombre= document.getElementById("idNombre"+id);
    var tdApellidos= document.getElementById("idApellidos"+id);
    var tdTelefono= document.getElementById("idTelefono"+id);
    var tdEstrella= document.getElementById("idEstrella"+id);
    var tdCategoriaId= document.getElementById("idCategoriaId"+id);

    if(tdNombre.textContent != "" && tdApellidos.textContent != "" && tdTelefono.textContent != "" && tdEstrella.textContent != "" && tdCategoriaId.textContent != "" ) {
        var input= document.createElement("input");
        input.setAttribute("type", "text");
        input.setAttribute("id", "nuevoNombrePersona"+id);
        input.setAttribute("name", "nuevoNombrePersona"+id);
        tdNombre.removeChild(tdNombre.firstChild);
        tdNombre.appendChild(input);

        var inputApellidos= document.createElement("input");
        inputApellidos.setAttribute("type", "text");
        inputApellidos.setAttribute("id", "nuevoApellidosPersona"+id);
        inputApellidos.setAttribute("name", "nuevoApellidosPersona"+id);
        tdApellidos.removeChild(tdApellidos.firstChild);
        tdApellidos.appendChild(inputApellidos);

        var inputTelefono= document.createElement("input");
        inputTelefono.setAttribute("type", "text");
        inputTelefono.setAttribute("id", "nuevoTelefonoPersona"+id);
        inputTelefono.setAttribute("name", "nuevoTelefonoPersona"+id);
        tdTelefono.removeChild(tdTelefono.firstChild);
        tdTelefono.appendChild(inputTelefono);

        var inputEstrella= document.createElement("input");
        inputEstrella.setAttribute("type", "text");
        inputEstrella.setAttribute("id", "nuevoEstrellaPersona"+id);
        inputEstrella.setAttribute("name", "nuevoEstrellaPersona"+id);
        tdEstrella.removeChild(tdEstrella.firstChild);
        tdEstrella.appendChild(inputEstrella);

        var inputCategoriaId= document.createElement("input");
        inputCategoriaId.setAttribute("type", "text");
        inputCategoriaId.setAttribute("id", "nuevoCategoriaIdPersona"+id);
        inputCategoriaId.setAttribute("name", "nuevoCategoriaIdPersona"+id);
        tdCategoriaId.removeChild(tdCategoriaId.firstChild);
        tdCategoriaId.appendChild(inputCategoriaId);
    }else if(document.getElementById("nuevoNombrePersona"+id).value != "" && document.getElementById("nuevoApellidosPersona"+id).value != "" && document.getElementById("nuevoTelefonoPersona"+id).value != "" && document.getElementById("nuevoEstrellaPersona"+id).value != "" && document.getElementById("nuevoCategoriaIdPersona"+id).value != "") {
        var nombre= document.getElementById("nuevoNombrePersona"+id).value;
        var apellidos= document.getElementById("nuevoApellidosPersona"+id).value;
        var telefono= document.getElementById("nuevoTelefonoPersona"+id).value;
        var estrella= document.getElementById("nuevoEstrellaPersona"+id).value;
        var categoriaId= document.getElementById("nuevoCategoriaIdPersona"+id).value;

        var request= new XMLHttpRequest();
        var url= "personaGuardar.php?id="+id+"&nombre="+nombre+"&apellidos="+apellidos+"&telefono="+telefono+"&estrela="+estrella+"&categoriaId="+categoriaId;
        request.open("GET", url);
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                
                tdNombre.removeChild(td.firstChild);
                var aNombre = document.createElement("a");
                aNombre.setAttribute("href","PersonaFicha.php?id=" + id);
                aNombre.appendChild(nombre);
                tdNombre.appendChild(aNombre);

                tdApellidos.removeChild(tdApellidos.firstChild);
                var aApellidos = document.createElement("a");
                aApellidos.setAttribute("href","PersonaFicha.php?id=" + id);
                aApellidos.appendChild(apellidos);
                tdApellidos.appendChild(aApellidos);

                tdTelefono.removeChild(tdTelefono.firstChild);
                var aTelefono = document.createElement("a");
                aTelefono.setAttribute("href","PersonaFicha.php?id=" + id);
                aTelefono.appendChild(telefono);
                tdTelefono.appendChild(aTelefono);

                tdEstrella.removeChild(tdEstrella.firstChild);
                var aTelefono = document.createElement("a");
                aEstrella.setAttribute("href","PersonaFicha.php?id=" + id);
                aEstrella.appendChild(estrella);
                tdEstrella.appendChild(aEstrella);

                tdCategoriaId.removeChild(tdCategoriaId.firstChild);
                var aCategoriaId = document.createElement("a");
                aCategoriaId.setAttribute("href","PersonaFicha.php?id=" + id);
                aCategoriaId.appendChild(categoriaId);
                tdCategoriaId.appendChild(aCategoriaId);
                
            }
        };
        request.send()
        
    }else {
        alert("Rellena todos los campos");
    }
}
