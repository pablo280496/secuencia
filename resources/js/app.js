import './bootstrap';
import { createApp } from 'vue';

import 'jointjs/css/layout.css';

import Home from './components/Home.vue';
import channel from "bootstrap/js/src/dom/event-handler";
import socket from "socket.io-client";
createApp(Home).mount('#app');


// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });
//Los eventos PUSHER
import * as joint from 'jointjs';
import {compileString} from "sass";
// Define un grafo para la pizarra
const graph = new joint.dia.Graph();
// Obtén el área de dibujo (miDiagrama)
const canvas = new joint.dia.Paper({
    el: document.getElementById('miDiagrama'),
    width: '100%',
    height: 500,
    model: graph,
    gridSize: 10,
    drawGrid: true,
    interactive: true
});

// Agregar evento clic para el botón "Agregar Actor"
document.getElementById('btnAddActor').addEventListener('click', function() {
    const url = window.location.href;
// Divide la URL en partes utilizando "/" como separador
    const partesURL = url.split('/');
// El ID de la pizarra se encuentra en la última parte de la URL
    const pizarraId = partesURL[partesURL.length - 1];
    console.log('ID de la pizarra:', pizarraId);

    const nombreElemento = prompt('Ingresa un nombre para el elemento Actor:');
    // Define las propiedades de un elemento Actor
    if (nombreElemento) {
        // Define las propiedades de un elemento Actor
        const actor = new joint.shapes.standard.Rectangle();
        actor.position(100, 30);
        actor.resize(100, 40);
        actor.attr({
            body: {
                fill: 'lightblue',
                rx: 10,
                ry: 10,
                stroke: 'black'
            },
            label: {
                text: nombreElemento, // Establece el nombre ingresado por el usuario
                fill: 'black'
            }
        });
        // Crear una línea vertical para representar la vida del actor
        const vidaLinea = new joint.shapes.standard.Path();
        vidaLinea.position(150, 400); // La posición inicial de la línea vertical
        vidaLinea.attr({
            path: { d: 'M 0 0 L 0 500' }, // Línea vertical de 100 unidades (ajusta según sea necesario)
            stroke: 'black'
        });
        // Agrega el elemento al área de dibujo
        graph.addCell([actor, vidaLinea]);
        const enlace = new joint.dia.Link({
            source: { id: actor.id },
            target: { id: vidaLinea.id }
        });
        graph.addCell(enlace);

        actor.on('change:position', function(element, newPosition) {
            // Verifica que el elemento no se mueva en el eje Y (siempre en 30)
             if (newPosition.y !== 30) {
                newPosition.y = 30;
             }
             // Aplica la nueva posición solo en el eje X
            element.set('position', { x: newPosition.x, y: 30 });
             // Mueve la línea vertical junto con el actor
            vidaLinea.position(newPosition.x + 50, 400);
            // Actualiza el enlace
        });
        // Habilita el arrastre solo en el eje X
        actor.set('draggable', 'x');
        // Envía los datos al servidor a través de WebSockets
        ///socket.emit('AgregarElementoPizarra', eventData);

        axios.post('/elementos-pizarra', {
            pizarra_id: pizarraId, // Asegúrate de que pizarraId sea el ID de la pizarra actual.
            tipo: 'Actor',
            nombre: nombreElemento,
            posicion_x: actor.position().x,
            posicion_y: actor.position().y,
            cid:actor.cid,
            contenido: 'Elemento agregado', // Añade contenido si es necesario.
        })
            .then(function (response) {
                // El elemento se ha creado con éxito. Puedes actualizar el lienzo gráfico aquí.
                console.log(response.data.message);
            })
            .catch(function (error) {
                console.error('Error al crear el elemento:', error);
            });
    }
});

         // Agregar evento clic para el botón "Agregar Entidad"
document.getElementById('btnAddEntidad').addEventListener('click', function() {
    const url = window.location.href;
// Divide la URL en partes utilizando "/" como separador
    const partesURL = url.split('/');
// El ID de la pizarra se encuentra en la última parte de la URL
    const pizarraId = partesURL[partesURL.length - 1];
    console.log('ID de la pizarra:', pizarraId);
    const nombreElemento = prompt('Ingresa un nombre para el elemento Entidad:');
    // Define las propiedades de un elemento Actor
    if (nombreElemento) {
        // Define las propiedades de un elemento Actor
        const entidad = new joint.shapes.standard.Rectangle();
        entidad.position(100, 30);
        entidad.resize(100, 40);
        entidad.attr({
            body: {
                fill: 'lightyellow',
                rx: 10,
                ry: 10,
                stroke: 'black'
            },
            label: {
                text: nombreElemento, // Establece el nombre ingresado por el usuario
                fill: 'black'
            }
        });
        // Crear una línea vertical para representar la vida del actor
        const vidaLinea1 = new joint.shapes.standard.Path();
        vidaLinea1.position(150, 400); // La posición inicial de la línea vertical
        vidaLinea1.attr({
            path: { d: 'M 0 0 L 0 500' }, // Línea vertical de 100 unidades (ajusta según sea necesario)
            stroke: 'black'
        });
        // Agrega el elemento al área de dibujo
        graph.addCell([entidad, vidaLinea1]);
        const enlace1 = new joint.dia.Link({
            source: { id: entidad.id },
            target: { id: vidaLinea1.id }
        });
        graph.addCell(enlace1);
        entidad.on('change:position', function(element, newPosition) {
            // Verifica que el elemento no se mueva en el eje Y (siempre en 30)
            if (newPosition.y !== 30) {
                newPosition.y = 30;
            }
            // Aplica la nueva posición solo en el eje X
            element.set('position', { x: newPosition.x, y: 30 });
            // Mueve la línea vertical junto con el actor
            vidaLinea1.position(newPosition.x + 50, 400);

        });
        // Habilita el arrastre solo en el eje X
        entidad.set('draggable', 'x');

        axios.post('/elementos-pizarra', {
            pizarra_id: pizarraId, // Asegúrate de que pizarraId sea el ID de la pizarra actual.
            tipo: 'entidad',
            nombre: nombreElemento,
            posicion_x: entidad.position().x,
            posicion_y: entidad.position().y,
            cid:entidad.cid,
            contenido: 'Elemento agregado', // Añade contenido si es necesario.
        })
            .then(function (response) {
                // El elemento se ha creado con éxito. Puedes actualizar el lienzo gráfico aquí.
                console.log(response.data.message);
            })
            .catch(function (error) {
                console.error('Error al crear el elemento:', error);
            });

    }
});

         // Agregar evento clic para el botón "Agregar Entidad"
document.getElementById('btnAddControl').addEventListener('click', function() {
    const url = window.location.href;
// Divide la URL en partes utilizando "/" como separador
    const partesURL = url.split('/');
// El ID de la pizarra se encuentra en la última parte de la URL
    const pizarraId = partesURL[partesURL.length - 1];
    console.log('ID de la pizarra:', pizarraId);
    const nombreElemento = prompt('Ingresa un nombre para el elemento control:');
    // Define las propiedades de un elemento control
    if (nombreElemento) {
        // Define las propiedades de un elemento Actor
        const control = new joint.shapes.standard.Rectangle();
        control.position(100, 30);
        control.resize(100, 40);
        control.attr({
            body: {
                fill: 'lightgreen',
                rx: 10,
                ry: 10,
                stroke: 'black'
            },
            label: {
                text: nombreElemento , // Establece el nombre ingresado por el usuario
                fill: 'black',
            }
        });
        // Crear una línea vertical para representar la vida del actor
        const vidaLinea2 = new joint.shapes.standard.Path();
        vidaLinea2.position(150, 400); // La posición inicial de la línea vertical
        vidaLinea2.attr({
            path: { d: 'M 0 0 L 0 500' }, // Línea vertical de 100 unidades (ajusta según sea necesario)
            stroke: 'black'
        });
        // Agrega el elemento al área de dibujo
        graph.addCell([control, vidaLinea2]);

        const enlace2 = new joint.dia.Link({
            source: { id: control.id },
            target: { id: vidaLinea2.id }
        });
        graph.addCell(enlace2);
        control.on('change:position', function(element, newPosition) {
            // Verifica que el elemento no se mueva en el eje Y (siempre en 30)
            if (newPosition.y !== 30) {
                newPosition.y = 30;
            }
            // Aplica la nueva posición solo en el eje X
            element.set('position', { x: newPosition.x, y: 30 });
            // Mueve la línea vertical junto con el actor
            vidaLinea2.position(newPosition.x + 50, 400);
        });
        // Habilita el arrastre solo en el eje X
        control.set('draggable', 'x');

        axios.post('/elementos-pizarra', {
            pizarra_id: pizarraId, // Asegúrate de que pizarraId sea el ID de la pizarra actual.
            tipo: 'control',
            nombre: nombreElemento,
            posicion_x: control.position().x,
            posicion_y: control.position().y,
            cid:control.cid,
            contenido: 'control agregado', // Añade contenido si es necesario.
        })
            .then(function (response) {
                // El elemento se ha creado con éxito. Puedes actualizar el lienzo gráfico aquí.
                console.log(response.data.message);
            })
            .catch(function (error) {
                console.error('Error al crear el elemento:', error);
            });
        // Agrega un botón para eliminar el elemento control
        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Eliminar';
        deleteButton.style.position = 'absolute';
        deleteButton.style.top = '0';
        deleteButton.style.right = '0';
        control.get('label').appendChild(deleteButton);

        // Agrega un evento click al botón para eliminar el elemento control
        deleteButton.addEventListener('click', function() {
            control.remove();
        });
    }
});


document.getElementById('btnDelActor').addEventListener('click', function() {
    const tipoAEliminar = 'Actor'; // Reemplaza con el tipo que deseas eliminar

    axios.delete(`/eliminar-elementos-por-tipo/${tipoAEliminar}`)
        .then(function(response) {
            if (response.data.success) {
                // Operación de eliminación exitosa en la base de datos.
                // Puedes realizar otras acciones o actualizaciones en el lienzo aquí.
                console.log(response.data.message);
                // Recargar la página para ver los cambios
                location.reload(); // Esto recargará la página actual
            } else {
                console.error('Error al eliminar elementos en la base de datos.');
            }
        })
        .catch(function(error) {
            console.error('Error en la solicitud de eliminación:', error);
        });
});

document.getElementById('btnDelEntidad').addEventListener('click', function() {
    const tipoAEliminar = 'entidad'; // Reemplaza con el tipo que deseas eliminar

    axios.delete(`/eliminar-elementos-por-tipo/${tipoAEliminar}`)
        .then(function(response) {
            if (response.data.success) {
                // Operación de eliminación exitosa en la base de datos.
                // Puedes realizar otras acciones o actualizaciones en el lienzo aquí.
                console.log(response.data.message);
                // Recargar la página para ver los cambios
                location.reload(); // Esto recargará la página actual
            } else {
                console.error('Error al eliminar elementos en la base de datos.');
            }
        })
        .catch(function(error) {
            console.error('Error en la solicitud de eliminación:', error);
        });
});

document.getElementById('btnDelControl').addEventListener('click', function() {
    const tipoAEliminar = 'control'; // Reemplaza con el tipo que deseas eliminar

    axios.delete(`/eliminar-elementos-por-tipo/${tipoAEliminar}`)
        .then(function(response) {
            if (response.data.success) {
                // Operación de eliminación exitosa en la base de datos.
                // Puedes realizar otras acciones o actualizaciones en el lienzo aquí.
                console.log(response.data.message);
                // Recargar la página para ver los cambios
                location.reload(); // Esto recargará la página actual
            } else {
                console.error('Error al eliminar elementos en la base de datos.');
            }
        })
        .catch(function(error) {
            console.error('Error en la solicitud de eliminación:', error);
        });
});

// Supongamos que 'elementos' es un array de elementos recuperados de la base de datos.
const formas = [];
elementos.forEach(function(elemento) {

    // Crear elementos gráficos basados en los datos recuperados.
    if (elemento.tipo === 'Actor') {
        const actor = new joint.shapes.standard.Rectangle();
        actor.position(elemento.posicion_x, elemento.posicion_y);
        actor.resize(100, 40);
        actor.attr({
            body: {
                fill: 'lightblue',
                rx: 10,
                ry: 10,
                stroke: 'black'
            },
            label: {
                text: elemento.nombre,
                fill: 'black'
            }
        });
        // Crear otras partes de tu elemento aquí según su tipo.
        // ...
        // Agregar el elemento al área de dibujo.
        graph.addCell(actor);
        const vidaLinea = new joint.shapes.standard.Path();
        vidaLinea.position(elemento.posicion_x + 50, 400); // La posición inicial de la línea vertical
        vidaLinea.attr({
            path: { d: 'M 0 0 L 0 500' }, // Línea vertical de 100 unidades (ajusta según sea necesario)
            stroke: 'black'
        });
        // Agrega el elemento al área de dibujo
        graph.addCell([actor, vidaLinea]);
        const enlace = new joint.dia.Link({
            source: { id: actor.id },
            target: { id: vidaLinea.id }
        });
        graph.addCell(enlace);
        actor.on('change:position', function(element, newPosition) {
            // Verifica que el elemento no se mueva en el eje Y (siempre en 30)
            if (newPosition.y !== 30) {
                newPosition.y = 30;
            }
            // Aplica la nueva posición solo en el eje X
            element.set('position', { x: newPosition.x, y: 30 });
            // Mueve la línea vertical junto con el actor
            vidaLinea.position(newPosition.x + 50, 400);
            // Actualiza el enlace
        });
        // Habilita el arrastre solo en el eje X
        actor.set('draggable', 'x');
        // Agregar cualquier otra parte de tu elemento al área de dibujo.
    }
    else if (elemento.tipo === 'entidad') {
        const entidad = new joint.shapes.standard.Rectangle();
        entidad.position(elemento.posicion_x, elemento.posicion_y);
        entidad.resize(100, 40);
        entidad.attr({
            body: {
                fill: 'lightyellow',
                rx: 10,
                ry: 10,
                stroke: 'black'
            },
            label: {
                text: elemento.nombre,
                fill: 'black'
            }

        });
        // Crear otras partes de tu elemento aquí según su tipo.
        // ...
        // Agregar el elemento al área de dibujo.
        graph.addCell(entidad);
        const vidaLinea1 = new joint.shapes.standard.Path();
        vidaLinea1.position(elemento.posicion_x + 50, 400); // La posición inicial de la línea vertical
        vidaLinea1.attr({
            path: { d: 'M 0 0 L 0 500' }, // Línea vertical de 100 unidades (ajusta según sea necesario)
            stroke: 'black'
        });
        // Agrega el elemento al área de dibujo
        graph.addCell([entidad, vidaLinea1]);
        const enlace1 = new joint.dia.Link({
            source: { id: entidad.id },
            target: { id: vidaLinea1.id }
        });
        graph.addCell(enlace1);
        entidad.on('change:position', function(element, newPosition) {
            // Verifica que el elemento no se mueva en el eje Y (siempre en 30)
            if (newPosition.y !== 30) {
                newPosition.y = 30;
            }
            // Aplica la nueva posición solo en el eje X
            element.set('position', { x: newPosition.x, y: 30 });
            // Mueve la línea vertical junto con el actor
            vidaLinea1.position(newPosition.x + 50, 400);

        });
        // Habilita el arrastre solo en el eje X
        entidad.set('draggable', 'x');

    }
    else if (elemento.tipo === 'control') {
        const control = new joint.shapes.standard.Rectangle();
        control.position(elemento.posicion_x, elemento.posicion_y);
        control.resize(100, 40);
        control.attr({
            body: {
                fill: 'lightgreen',
                rx: 10,
                ry: 10,
                stroke: 'black'
            },
            label: {
                text: elemento.nombre,
                fill: 'black'
            }
        });
        // Crear otras partes de tu elemento aquí según su tipo.
        // ...
        // Agregar el elemento al área de dibujo.
        graph.addCell(control);
        const vidaLinea2 = new joint.shapes.standard.Path();
        vidaLinea2.position(elemento.posicion_x + 50, 400); // La posición inicial de la línea vertical
        vidaLinea2.attr({
            path: { d: 'M 0 0 L 0 500' }, // Línea vertical de 100 unidades (ajusta según sea necesario)
            stroke: 'black'
        });
        // Agrega el elemento al área de dibujo
        graph.addCell([control, vidaLinea2]);

        const enlace2 = new joint.dia.Link({
            source: { id: control.id },
            target: { id: vidaLinea2.id }
        });
        graph.addCell(enlace2);
        control.on('change:position', function(element, newPosition) {
            // Verifica que el elemento no se mueva en el eje Y (siempre en 30)
            if (newPosition.y !== 30) {
                newPosition.y = 30;
            }
            // Aplica la nueva posición solo en el eje X
            element.set('position', { x: newPosition.x, y: 30 });
            // Mueve la línea vertical junto con el actor
            vidaLinea2.position(newPosition.x + 50, 400);
        });
        // Habilita el arrastre solo en el eje X
        control.set('draggable', 'x');

    }
    else if (elemento.tipo === 'Path de Inicio') {
        const line1 = new joint.shapes.standard.Path({
            position: {x: elemento.posicion_x, y: elemento.posicion_y},
            size: {width: 6, height: 10}, // Ancho y altura de la línea
            attrs: {
                path: {
                    d: 'M 0 1 L 200 1', // Representa una línea horizontal
                    stroke: 'black', // Color de la línea
                    'stroke-width': 2 // Ancho de la línea
                }
            }
        });

        formas.push(line1);
        graph.addCell(line1);
        line1.set('draggable', true);


    }else if (elemento.tipo === 'Path de Fin') {
        const line2 = new joint.shapes.standard.Path({
            position: {x: elemento.posicion_x, y: elemento.posicion_y},
            size: {width: 6, height: 10}, // Ancho y altura de la línea
            attrs: {
                path: {
                    d: 'M 0 1 L 200 1', // Representa una línea horizontal
                    stroke: 'black', // Color de la línea
                    'stroke-width': 2 // Ancho de la línea
                }
            }
        });
        line2.set('draggable', true);
        graph.addCell(line2);


        console.log(formas)
        const enlace = new joint.shapes.standard.Link({
            source: { id: formas[formas.length-1].id },  // Primer elemento (inicio)
            target: { id: line2.id }   // Segundo elemento (fin)
        });
        enlace.labels([
                {
                    attrs: {
                        text: {
                            text: elemento.nombre
                        }
                    }
                }
            ]);
        graph.addCell(enlace);
    }
    // Agrega el enlace al área de dibujo (graph)
    // Puedes agregar más casos según los diferentes tipos de elementos que tengas.
});


// Ahora, tienes los elementos gráficos en tu área de dibujo (graph).

graph.on('change:position', function(element) {
    // Obtén la nueva posición del elemento
    const url = window.location.href;
// Divide la URL en partes utilizando "/" como separador
    const partesURL = url.split('/');
// El ID de la pizarra se encuentra en la última parte de la URL
    const pizarraId = partesURL[partesURL.length - 1];

    console.log('ID de la pizarra:', pizarraId);
    console.log(element.cid);
    console.log(element);

    const newPosition = element.get('position');

    // Crea un objeto con los datos necesarios
    const eventData = {
        elementId: element.cid,
        newPosition: newPosition,
    };

    // Envía los datos al servidor a través de WebSockets usando Pusher
    channel.trigger('App\\Events\\MoverElementoEvent', eventData);

    // También puedes realizar una solicitud Axios al servidor para guardar la posición en la base de datos.
    // Reemplaza con la URL correcta y los datos que necesites enviar.
    axios.post('/actualizar-posicion/' + pizarraId, {
        nuevaPosicionX: newPosition.x,
        nuevaPosicionY: newPosition.y,
        elementoCid: element.cid,
    })

        .then(function (response) {
            // Maneja la respuesta del servidor, si es necesario.
            console.log(response.data);
        })
        .catch(function (error) {
            console.error('Error al actualizar la posición:', error);
        });
});


//---------------------
document.getElementById('btnGuardarMensaje').addEventListener('click', function () {
    const url = window.location.href;
// Divide la URL en partes utilizando "/" como separador
    const partesURL = url.split('/');
// El ID de la pizarra se encuentra en la última parte de la URL
    const pizarraId = partesURL[partesURL.length - 1];
    console.log('ID de la pizarra:', pizarraId);
    const nombreEnlace = prompt('Ingresa un nombre para el enlace:');
    // Crear la primera línea
    const line1 = new joint.shapes.standard.Path({
        position: { x: 100, y: 100 },
        size: { width: 6, height: 10 }, // Ancho y altura de la línea
        attrs: {
            path: {
                d: 'M 0 1 L 200 1', // Representa una línea horizontal
                stroke: 'black', // Color de la línea
                'stroke-width': 2 // Ancho de la línea
            }
        }
    });
    // Crear la segunda línea
    const line2 = new joint.shapes.standard.Path({
        position: { x: 300, y: 100 },
        size: { width: 6, height: 10 },
        attrs: {
            path: {
                d: 'M 0 1 L 200 1',
                stroke: 'black',
                'stroke-width': 2
            }
        }
    });
    line1.set('draggable', true);
    line2.set('draggable', true);
    // Agregar las líneas al área de dibujo (graph)
    graph.addCell([line1, line2]);

    if (nombreEnlace) {
        const link = new joint.shapes.standard.Link({
            source: { id: line1.id },
            target: { id: line2.id },

            // Configuración adicional del enlace, como flechas, estilo, etc.
       });
        link.labels( [{  attrs: {
                text: {
                    text: nombreEnlace
                }
            }}]);
        graph.addCell(link);
       }

    axios.post('/elementos-pizarra', {
        pizarra_id: pizarraId, // Asegúrate de que pizarraId sea el ID de la pizarra actual.
        tipo: 'Path de Inicio',
        nombre: nombreEnlace,
        posicion_x: line1.position().x,
        posicion_y: line1.position().y,
        cid:line1.cid,
        contenido: 'Elemento agregado', // Añade contenido si es necesario.
    })
        .then(function (response) {
            // El elemento se ha creado con éxito. Puedes actualizar el lienzo gráfico aquí.
            console.log(response.data.message);
        })
        .catch(function (error) {
            console.error('Error al crear el elemento:', error);
        });
    axios.post('/elementos-pizarra', {
        pizarra_id: pizarraId, // Asegúrate de que pizarraId sea el ID de la pizarra actual.
        tipo: 'Path de Fin',
        nombre: nombreEnlace,
        posicion_x: line2.position().x,
        posicion_y: line2.position().y,
        cid:line2.cid,
        contenido: 'Elemento agregado', // Añade contenido si es necesario.
    })
        .then(function (response) {
            // El elemento se ha creado con éxito. Puedes actualizar el lienzo gráfico aquí.
            console.log(response.data.message);
        })
        .catch(function (error) {
            console.error('Error al crear el elemento:', error);
        });

});
document.getElementById('btnDelActor').addEventListener('click', function() {
    const tipoAEliminar = 'Actor'; // Reemplaza con el tipo que deseas eliminar

    axios.delete(`/eliminar-elementos-por-tipo/${tipoAEliminar}`)
        .then(function(response) {
            if (response.data.success) {
                // Operación de eliminación exitosa en la base de datos.
                // Puedes realizar otras acciones o actualizaciones en el lienzo aquí.
                console.log(response.data.message);
                // Recargar la página para ver los cambios
                location.reload(); // Esto recargará la página actual
            } else {
                console.error('Error al eliminar elementos en la base de datos.');
            }
        })
        .catch(function(error) {
            console.error('Error en la solicitud de eliminación:', error);
        });
});
