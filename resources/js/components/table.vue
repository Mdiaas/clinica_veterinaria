<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th v-for="t, key in titulos" :key="key">{{t.titulo}}</th><th v-if="visualizar || atualizar || excluir"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dados_filtrados" :key="chave">
                    <td v-for="value, keyValue in obj" :key="keyValue">
                        <span class="" v-if="titulos[keyValue].tipo == 'texto'">{{value}}</span>
                        <span class="" v-if="titulos[keyValue].tipo == 'imagem'">
                            <img :src="'/storage/'+value" width="50" height="30"/>
                        </span>
                        <span class="" v-if="titulos[keyValue].tipo == 'data'">...{{value}}</span>
                    </td>
                    <td v-if="visualizar.visivel || atualizar || excluir" style = "width:30%">
                        <button v-if="visualizar.visivel" class="btn btn-outline-primary btn-sm" :data-bs-toggle="visualizar.dataToggle" :data-bs-target="visualizar.dataTarget" @click="setStore(obj)">
                            Visualizar
                        </button>
                        <button v-if="atualizar" class="btn btn-outline-primary btn-sm">Atualizar</button>
                        <button v-if="excluir" class="btn btn-outline-danger btn-sm">Excluir</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props:['dados', 'titulos', 'atualizar', 'visualizar', 'excluir'],
        computed:{
            dados_filtrados(){
                let campos = Object.keys(this.titulos)
                let dados_filtrados = []
                this.dados.map((item, chave) => {
                    let itens_filtrados = {}
                    itens_filtrados['dados'] = item
                    campos.forEach(campo => {
                        if(campo != 'dados')
                            itens_filtrados[campo] = item[campo]
                    })
                    dados_filtrados.push(itens_filtrados)
                })
                return dados_filtrados;
            }
        },
        methods:{
            setStore(obj){
                this.$store.state.item = obj['dados']
            }
        }
    }
</script>
