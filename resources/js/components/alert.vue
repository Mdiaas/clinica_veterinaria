<template>
    <div :class="estilo" role="alert">
        {{titulo}}
        <p>{{detalhes.mensagem}}</p>
        <hr/>
        <ul v-if="detalhes.errors">
            <li v-for="e, key in detalhes.errors" :key ="key">{{e[0]}}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['classe', 'titulo', 'detalhes'],
        computed:{
            estilo(){
                return 'alert alert-' + this.classe
            }
        }

    }
</script>
