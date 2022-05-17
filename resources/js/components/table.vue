<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th v-for="t, key in titulos" :key="key">{{t.titulo}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dados_filtrados" :key="chave">
                    <td v-for="value, keyValue in obj" :key="keyValue">
                        <span class="" v-if="titulos[keyValue].tipo == 'texto'">{{value}}</span>
                        <span class="" v-if="titulos[keyValue].tipo == 'imagem'">
                            <img :src="'/storage/'+valor" width="50" height="50"/>
                        </span>
                        <span class="" v-if="titulos[keyValue].tipo == 'data'">...{{value}}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props:['dados', 'titulos'],
        computed:{
            dados_filtrados(){
                let campos = Object.keys(this.titulos)
                let dados_filtrados = []
                this.dados.map((item, chave) => {
                    let tutores_filtrados = {}

                    campos.forEach(campo => {
                        tutores_filtrados[campo] = item[campo]
                    })
                    dados_filtrados.push(tutores_filtrados)
                })
                return dados_filtrados;
            }
        }
    }
</script>
