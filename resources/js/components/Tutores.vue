<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component titulo="Buscar tutores">
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component 
                                    titulo = "ID" 
                                    id = "input-id" 
                                    id-help="idHelp" 
                                    texto-ajuda="Informe o ID do tutor (parametro opcional)"
                                >
                                <input type="number" class="form-control" id="input-id" aria-describedby="idHelp" v-model="busca.id">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component 
                                    titulo = "Nome" 
                                    id = "input-nome" 
                                    id-help="nomeHelp" 
                                    texto-ajuda="Informe o nome do tutor (parametro opcional)"
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
                
                <card-component titulo="Tutores cadastrados">
                    <template v-slot:conteudo>
                        <table-component :dados="tutores.data" 
                            :visualizar =" { visivel : true, dataToggle : 'modal', dataTarget : '#modalVisualizar'}"
                            :atualizar = true
                            :excluir = true
                            :titulos="{
                                id: { titulo : 'ID', tipo:'texto'},
                                nome: {titulo : 'Nome', tipo:'texto'},
                                logradouro: {titulo : 'Endereço', tipo:'texto'},
                                CPF :{titulo:'CPF', tipo:'texto'},
                                created_at:{titulo: 'Data de criação', tipo:'data'},
                                dados:{titulo: null, tipo: null}
                            }">
                            </table-component>
                    </template>
                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                        <li v-for="l, key in tutores.links" :key="key" :class ="l.active ? 'page-item active' : 'page-item'" @click.prevent="paginacao(l)">
                                            <a class="page-link" href="" v-html="l.label"></a>
                                        </li>
                                </paginate-component>
                            </div>
                            <div class="col-2">
                                <button type="submit" data-bs-toggle="modal" data-bs-target="#modalTutor" class="btn btn-primary btn-sm float-end">Novo tutor</button>
                            </div>
                        </div>
                    </template>
                </card-component>
            </div>
        </div>
        <modal-component titulo="Visualizar cadastro do tutor" id="modalVisualizar">
            <template v-slot:conteudo>
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
                    <div class="row">
                        <div class="col">
                            <input-container-component 
                                titulo = "Sexo" 
                                id = "input-sexo-visualizar" 
                                id-help="sexoVisualizarHelp"
                            >
                            <input type="text" class="form-control" id="input-sexo-visualizar" aria-describedby="sexoVisualizarHelp" :value="$store.state.item.sexo == 'M' ? 'Masculino' : 'Feminino'">
                            </input-container-component>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input-container-component 
                                titulo = "CPF" 
                                id = "input-cpf-visualizar" 
                                id-help="cpfVisualizarHelp"
                            >
                            <input type="text" class="form-control" id="input-cpf-visualizar" aria-describedby="cpfVisualizarHelp" :value="$store.state.item.CPF">
                            </input-container-component>
                        </div>
                        <div class="col">
                            <input-container-component 
                                titulo = "RG" 
                                id = "input-rg-visualizar" 
                                id-help="rgVisualizarHelp"
                            >
                            <input type="text" class="form-control" id="input-rg-visualizar" aria-describedby="rgVisualizarHelp" :value="$store.state.item.RG">
                            </input-container-component>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input-container-component 
                                titulo = "Estado" 
                                id = "input-uf-visualizar" 
                                id-help="ufVisualizarHelp"
                            >
                            <input type="text" class="form-control" id="input-uf-visualizar" aria-describedby="ufVisualizarHelp" :value="$store.state.item.UF">
                            </input-container-component>
                        </div>
                        <div class="col">
                            <input-container-component 
                                titulo = "Cidade" 
                                id = "input-cidade-visualizar" 
                                id-help="cidadeVisualizarHelp"
                            >
                            <input type="text" class="form-control" id="input-cidade-visualizar" aria-describedby="cidadeVisualizarHelp" :value="$store.state.item.cidade">
                            </input-container-component>
                        </div>
                        <div class="col">
                            <input-container-component 
                                titulo = "Bairro" 
                                id = "input-bairro-visualizar" 
                                id-help="bairroVisualizarHelp"
                            >
                            <input type="text" class="form-control" id="input-bairro-visualizar" aria-describedby="bairroVisualizarHelp" :value="$store.state.item.bairro">
                            </input-container-component>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input-container-component 
                                titulo = "Logradouro" 
                                id = "input-logradouro-visualizar" 
                                id-help="logradouroVisualizarHelp"
                            >
                            <input type="text" class="form-control" id="input-logradouro-visualizar" aria-describedby="logradouroVisualizarHelp" :value="$store.state.item.logradouro">
                            </input-container-component>
                        </div>
                    </div>
                    <div class="row" v-if="$store.state.item.animais">
                        <label for="" class="">Animais:</label>
                        <ul class="list-group">
                            <li v-for="l, key in $store.state.item.animais" :key ="key" class="list-group-item">{{l.nome}}</li>
                        </ul>
                    </div>
                </fieldset>
            </template>
            <template :v-slot=alertas></template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <modal-component titulo="Cadastrar tutor" id="modalTutor">
            <template v-slot:conteudo>
                <div class="row mb-2">
                    <input-container-component 
                        titulo = "Nome" 
                        id = "cadastro-nome" 
                        id-help="cadastroNomeHelp" 
                        texto-ajuda="Nome do tutor"
                    >
                    <input type="text" class="form-control" id="cadastro-nome" aria-describedby="cadastroNomeHelp" v-model="nome">
                    </input-container-component>
                </div>
                <div class="row mb-2">
                    <input-container-component 
                        titulo = "Sexo" 
                        id = "cadastro-sexo" 
                        id-help="cadastroSexoHelp" 
                        texto-ajuda="Sexo do tutor"
                    >
                    <select class="form-control" id="cadastro-sexo" aria-describedby="cadastroNomeHelp" v-model="sexo">
                        <optgroup>
                            <option value = "M">Masculino</option>
                            <option value = "F">Feminino</option>
                        </optgroup>
                    </select>
                    </input-container-component>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <input-container-component 
                            titulo = "CPF" 
                            id = "cadastro-cpf" 
                            id-help="cadastroCPFHelp" 
                            texto-ajuda="CPF do tutor"
                        >
                        <input type="text" class="form-control" id="cadastro-cpf" aria-describedby="cadastroCPFHelp" v-model="cpf">
                        </input-container-component>
                    </div>
                    <div class="col">
                        <input-container-component 
                            titulo = "RG" 
                            id = "cadastro-rg" 
                            id-help="cadastroCPFHelp" 
                            texto-ajuda="RG do tutor"
                        >
                        <input type="text" class="form-control" id="cadastro-rg" aria-describedby="cadastroRGHelp" v-model="rg">
                        </input-container-component>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <input-container-component 
                            titulo = "Estado" 
                            id = "cadastro-estado" 
                            id-help="cadastroEstadoHelp" 
                            texto-ajuda="Selecione o Estado do tutor"
                        >
                        <select class="form-control" id="cadastro-estado" aria-describedby="cadastroEstadoHelp" v-model="estado">
                            <option>SP</option>
                            <option>RJ</option>
                            <option>MG</option>
                        </select>
                        </input-container-component>
                    </div>
                    <div class="col">
                        <input-container-component 
                            titulo = "Cidade" 
                            id = "cadastro-cidade" 
                            id-help="cadastroCidadeHelp" 
                            texto-ajuda="Selecione a cidade do tutor"
                        >
                        <select class="form-control" id="cadastro-cidade" aria-describedby="cadastroCidadeHelp" v-model="cidade">
                            <option>Tatuí</option>
                            <option>Cerquilho</option>
                            <option>Boituva</option>
                        </select>
                        </input-container-component>
                    </div>
                </div>
                <div class="row mb-2">
                    <input-container-component 
                            titulo = "Bairro" 
                            id = "cadastro-bairro" 
                            id-help="cadastroBairroHelp" 
                            texto-ajuda="Bairro do tutor"
                        >
                        <input type="text" class="form-control" id="cadastro-bairro" aria-describedby="cadastroBairroHelp" v-model="bairro">
                        </input-container-component>
                </div>
                <div class = "row mb-2">
                    <input-container-component 
                        titulo = "Logradouro" 
                        id = "cadastro-logradouro" 
                        id-help="cadastroLogradouroHelp" 
                        texto-ajuda="Endereço do tutor"
                    >
                    <input type="text" class="form-control" id="cadastro-logradouro" aria-describedby="cadastroLogradouroHelp" v-model="logradouro">
                    </input-container-component>
                </div>
                <div class = "row mb-2">
                    <input-container-component 
                        titulo = "CEP" 
                        id = "cadastro-cep" 
                        id-help="cadastroCEPHelp" 
                        texto-ajuda="CEP do tutor"
                    >
                    <input type="text" class="form-control" id="cadastro-cep" aria-describedby="cadastroCEPHelp" v-model="cep">
                    </input-container-component>
                </div>
                <div class = "row">
                    <template :v-slot=alertas>
                        <alert-component classe="danger" :detalhes="detalheTransacao" titulo="Erro ao tentar cadastrar tutor" v-if="statusTransacao == 'erro'">
                        </alert-component>
                        <alert-component classe="success" :detalhes="detalheTransacao" titulo="Tutor cadastrado com sucesso" v-if="statusTransacao == 'inserido'">
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
                url : 'http://127.0.0.1:8000/api/v1/tutor',
                url_paginacao : '',
                url_filtro : '',
                nome : '',
                sexo : '',
                cpf : '',
                rg : '',
                estado : '',
                cidade : '',
                bairro : '',
                logradouro : '',
                cep : '',
                statusTransacao : '',
                detalheTransacao : {},
                tutores: { data: []},
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
            pesquisar(){
                let filtros = ''
                for (let chave in this.busca){
                    if(this.busca[chave]){
                        if(filtros != '')
                            $filtros += ';';
                        filtros+= chave + ":like:" + this.busca[chave]
                    }
                }
                if(filtros){
                    this.url_paginacao = "page=1" 
                    this.url_filtro = "&filtro="+filtros
                }
                else
                    this.url_filtro = ''
                console.log(this.url_filtro)
                this.carregar_lista()
            },
            paginacao(l){
                if(l.url){
                    l.url = l.url.split('?')[1];
                    console.log(l.url);
                    this.url_paginacao = l.url
                    this.carregar_lista()
                }
            },
            carregar_lista(){
                let url = this.url + "?" + this.url_paginacao + this.url_filtro
                
                axios.get(url).then(
                    response => {
                        this.tutores = response.data
                    }).
                    catch(errors => {

                    })
            },
            salvar(){
                let formData = new FormData()
                formData.append('nome', this.nome)
                formData.append('sexo', this.sexo)
                formData.append('CPF', this.cpf)
                formData.append('RG', this.rg)
                formData.append('UF', this.estado)
                formData.append('cidade', this.cidade)
                formData.append('bairro', this.bairro)
                formData.append('logradouro', this.logradouro)
                formData.append('CEP', this.cep)

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
                        console.log(errors.response.data.errors);
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
        }, 
        
    }
</script>
