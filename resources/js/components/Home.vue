import router from '../router';
<template>

                <div id="miDiagrama" style="height: 500px; width: 100%; background-color: #FDDDCA;"></div>

</template>

import router from '../router';
<script>
const idMap = {};
    export default {
        name : 'Home',
        data() {
            return {
                pizarraId: null // Inicializa con el valor de la pizarra actual
            }

        },
        created() {

            // El componente se ha creado, y ahora puedes utilizar pizarraId.
            // Puedes usarlo para crear elementos gráficos asociados a esta pizarra.
        },
        methods: {

        }
    }
</script>
