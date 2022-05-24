<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component titulo="Buscar animais">
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component 
                                    titulo = "ID" 
                                    id = "input-id" 
                                    id-help="idHelp" 
                                    texto-ajuda="Informe o ID do animal (parametro opcional)"
                                >
                                <input type="number" class="form-control" id="input-id" aria-describedby="idHelp" v-model="busca.id">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component 
                                    titulo = "Nome" 
                                    id = "input-nome" 
                                    id-help="nomeHelp" 
                                    texto-ajuda="Informe o nome do animal (parametro opcional)"
                                >
                                <input type="text" class="form-control" id="input-nome" aria-describedby="nomeHelp" v-model="busca.nome">
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-end" @click="pesquisar()">Pesquisar</button>
                    </template>
                </card-component>
                
                <card-component titulo="Animais cadastrados">
                    <template v-slot:conteudo>
                        <table-component 
                            :dados="animais.data"
                            :visualizar =" { visivel : true, dataToggle : 'modal', dataTarget : '#modalVisualizar'}"
                            :atualizar = true
                            :excluir =" {visivel : true, dataToggle : 'modal', dataTarget : '#modalExcluir'}"
                            :titulos="{
                                id: { titulo : 'ID', tipo:'texto'},
                                nome: {titulo : 'Nome', tipo:'texto'},
                                raca:{titulo: 'Raça', tipo:'texto'},
                                dados:{titulo: null, tipo: null}
                            }">
                            </table-component>
                    </template>
                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                        <li v-for="l, key in animais.links" :key="key" :class ="l.active ? 'page-item active' : 'page-item'" @click.prevent="paginacao(l)">
                                            <a class="page-link" href="" v-html="l.label"></a>
                                        </li>
                                </paginate-component>
                            </div>
                            <div class="col-2">
                                <button type="submit" data-bs-toggle="modal" data-bs-target="#modalAnimal" class="btn btn-primary btn-sm float-end">Cadastrar animal</button>
                            </div>
                        </div>
                    </template>
                </card-component>
            </div>
        </div>
        <!-- Modal de exibição do animal -->
        <modal-component titulo="Visualizar cadastro do animal" id="modalVisualizar">
            <template v-slot:conteudo>
                <div class="row">
                    <div class="col text-center">
                        <button class="btn btn-default"> 
                            <img v-if="$store.state.item.foto" :src="'storage/'+ $store.state.item.foto" class="img-thumbnail" width = "130" alt="foto do animal">
                        </button>
                    </div>
                </div>
                <hr/>
                <fieldset disabled>
                    <input-container-component 
                        titulo = "ID" 
                        id = "input-id" 
                        id-help="idHelp"
                    >
                    <input type="number" class="form-control" id="input-id" aria-describedby="idHelp" :value="$store.state.item.id">
                    </input-container-component>
                    <input-container-component 
                        titulo = "Nome" 
                        id = "input-nome-visualizar" 
                        id-help="nomeVisualizarHelp"
                    >
                    <input type="text" class="form-control" id="input-nome-visualizar" aria-describedby="nomeVisualizarHelp" :value="$store.state.item.nome">
                    </input-container-component>
                    <input-container-component 
                        titulo = "Nome do tutor" 
                        id = "input-nome-tutor-visualizar" 
                        id-help="nomeTutorVisualizarHelp"
                    >
                    <input type="text" v-if="$store.state.item.tutor" class="form-control" id="input-nome-tutor-visualizar" aria-describedby="nomeTutorVisualizarHelp" :value="$store.state.item.tutor.nome">
                    </input-container-component>
                    <input-container-component 
                        titulo = "Espécie" 
                        id = "input-especie-visualizar" 
                        id-help="especieVisualizarHelp"
                    >
                    <input type="text" v-if="$store.state.item.tutor" class="form-control" id="input-especie-visualizar" aria-describedby="especieVisualizarHelp" :value="especies_obj[$store.state.item.especie_id].especie">
                    </input-container-component>
                </fieldset>
            </template>
            <template :v-slot=alertas></template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!-- Modal remover -->
        <modal-component titulo="Excluir Animal" id="modalExcluir">
            <template v-slot:conteudo>
                <div class="row">
                    <div class="col text-center">
                        <button class="btn btn-default"> 
                            <img v-if="$store.state.item.foto" :src="'storage/'+ $store.state.item.foto" class="img-thumbnail" width = "130" alt="foto do animal">
                        </button>
                    </div>
                </div>
                <hr/>
                <fieldset disabled>
                    <input-container-component 
                        titulo = "ID" 
                        id = "input-id" 
                        id-help="idHelp"
                    >
                    <input type="number" class="form-control" id="input-id" aria-describedby="idHelp" :value="$store.state.item.id">
                    </input-container-component>
                    <input-container-component 
                        titulo = "Nome" 
                        id = "input-nome-visualizar" 
                        id-help="nomeVisualizarHelp"
                    >
                    <input type="text" class="form-control" id="input-nome-visualizar" aria-describedby="nomeVisualizarHelp" :value="$store.state.item.nome">
                    </input-container-component>
                </fieldset>
            </template>
            <template :v-slot=alertas></template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!-- Modal de cadastro de animal -->
        <modal-component titulo="Cadastrar animal" id="modalAnimal">
            <template v-slot:conteudo>
                <div class="row mb-2">
                    <input-container-component 
                        titulo = "Nome" 
                        id = "cadastro-nome" 
                        id-help="cadastroNomeHelp" 
                        texto-ajuda="Nome do animal"
                    >
                    <input type="text" class="form-control" id="cadastro-nome" aria-describedby="cadastroNomeHelp" v-model="nome">
                    </input-container-component>
                </div>
                <div class="row mb-2">
                    <input-container-component 
                        titulo = "foto" 
                        id = "cadastro-foto" 
                        id-help="cadastrofotoHelp" 
                        texto-ajuda="foto do animal"
                    >
                    <input type="file" class="form-control" id="cadastro-foto" aria-describedby="cadastrofotoHelp" @change="carregar_imagem($event)">
                    </input-container-component>
                </div>
                <div class="row mb-2">
                    <input-container-component 
                        titulo = "Espécie" 
                        id = "cadastro-especie" 
                        id-help="cadastroEspecieHelp" 
                        texto-ajuda="Selecione a espécie do animal"
                    >
                    <select  class="form-control" id="cadastro-especie-id" aria-describedby="cadastroEspecieHelp" v-model="especie_id" v-html="especies">

                    </select>
                    </input-container-component>
                </div>
                <div class="row mb-2">
                    <input-container-component 
                        titulo = "Raça" 
                        id = "cadastro-raca" 
                        id-help="cadastroRacaHelp" 
                        texto-ajuda="Cadastrar raça do animal"
                    >
                    <input type="text" class="form-control" id="cadastro-raca" aria-describedby="cadastroRacaHelp" v-model="raca">
                    </input-container-component>
                </div>
                <div class="row mb-2">
                    <input-container-component 
                        titulo = "Tutor" 
                        id = "cadastro-tutor" 
                        id-help="cadastroTutorHelp" 
                        texto-ajuda="Selecione o tutor"
                    >
                    <select  class="form-control" id="cadastro-tutor-id" aria-describedby="cadastroTutorHelp" v-model="tutor_id" v-html="tutores">

                    </select>
                    </input-container-component>
                </div>
                <div class = "row">
                    <template :v-slot=alertas>
                        <alert-component classe="danger" :detalhes="detalheTransacao" titulo="Erro ao tentar cadastrar animal" v-if="statusTransacao == 'erro'">
                        </alert-component>
                        <alert-component classe="success" :detalhes="detalheTransacao" titulo="Animal cadastrado com sucesso" v-if="statusTransacao == 'inserido'">
                        </alert-component>
                    </template>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Cadastrar</button>
            </template>
        </modal-component>      
    </div>
</template>

<script>
    export default {
        data(){
            return{
                url : 'http://127.0.0.1:8000/api/v1/animal',
                url_paginacao : '',
                url_filtro : '',
                url_especies : 'http://127.0.0.1:8000/api/v1/especie',
                url_tutores : 'http://127.0.0.1:8000/api/v1/get_tutores',
                nome : '',
                foto : [],
                especie_id : '',
                tutor_id : '',
                especies_obj: {},
                especies: '',
                tutores: '',
                raca : '',
                tutor_id : '',
                statusTransacao : '',
                detalheTransacao : {},
                animais: { data: []},
                busca:{id:'', nome:''}
            }  
        },
        computed:{
            token(){
                let token = document.cookie.split(';').find(indice =>{
                    return indice.includes('token=')
                })
                token = token.split('=')[1]
                return "Bearer " + token;
            }
        },
        methods:{
            carregar_imagem(e){
                this.foto = e.target.files;
            },
            carregar_especies(){
                axios.get(this.url_especies).then(
                    response => {
                        response.data.map((value, key) => {
                            this.especies_obj[value.id] = value
                            this.especies += "<option value = " + value.id + ">" + value.especie + "</option>"
                        })
                    }).
                    catch(errors => {

                    })
            },
            carregar_tutores(){
                axios.get(this.url_tutores).then(
                    response => {
                        response.data.map((value, key) => {
                            this.tutores += "<option value = " + value.id + ">" + value.nome + "</option>"
                        })
                    }).
                    catch(errors =>  {
                        console.log(errors);
                
                    })
            },
            pesquisar(){
                let filtros = ''
                for (let chave in this.busca){
                    if(this.busca[chave]){
                        if(filtros != '')
                            filtros += ';';
                        filtros+= chave + ":like:" + this.busca[chave]
                    }
                }
                if(filtros){
                    this.url_paginacao = "page=1" 
                    this.url_filtro = "&filtro="+filtros
                }
                else
                    this.url_filtro = ''
                this.carregar_lista()
            },
            paginacao(l){
                if(l.url){
                    l.url = l.url.split('?')[1];
                    this.url_paginacao = l.url
                    this.carregar_lista()
                }
            },
            carregar_lista(){
                let url = this.url + "?" + this.url_paginacao + this.url_filtro
                
                axios.get(url).then(
                    response => {
                        this.animais = response.data
                    }).
                    catch(errors => {

                    })
            },
            salvar(){
                let formData = new FormData()
                formData.append('nome', this.nome)
                formData.append('foto', this.foto[0])
                formData.append('especie_id', this.especie_id)
                formData.append('tutor_id', this.tutor_id)
                formData.append('raca', this.raca)

                let config = {
                    headers: {
                        'Content-Type' : 'multipart/form-data',
                        'Accept' : 'Application/json',
                        'Authorization' : "Bearer " + this.token
                    }
                }
                axios.post(this.url, formData, config)
                    .then(response => {
                        this.statusTransacao = 'inserido'
                        this.detalheTransacao = {
                            mensagem: 'Cadastro de ID: ' + response.data.id + ' registrado com sucesso'
                        }
                    })
                    .catch(errors => {
                        this.statusTransacao = 'erro'
                        this.detalheTransacao = {
                            mensagem: '',
                            errors: errors.response.data.errors
                        }
                    })
            }
        },
        mounted(){
            this.carregar_lista()
            this.carregar_especies()
            this.carregar_tutores()
        }, 
        
    }
</script>
