<template>
    <div :class="estilo" role="alert">
        {{titulo}}
        <hr/>
        <ul class="" v-if="detalhe.data.errors">
            <li v-for="e, key in detalhe.data.errors" :key="key">
                {{ e[0] }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: ['classe', 'titulo', 'detalhe'],
        computed:{
            estilo(){
                return 'alert alert-' + this.classe
            }
        }

    }
</script>
