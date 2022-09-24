<template>
    <div class="row">
        <div class="col-12">
            <card title="Les résultats du questionnairee">
                <p-button type="info" class="addbutton"
                  outline
                  @click.native.prevent="ajouterPAC">
                    Générer table PAC
                </p-button>
                <div class="table table-responsive">
                    <table id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Utilisateur</th>
                                <th>Activite</th>
                                <th>Vote</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="result in resultats" v-bind:key="result.id">
                                <td>{{ result.id }}</td>
                                <td>{{ result.utilisateur.email }}</td>
                                <td>{{ result.activite.nom }}</td>
                                <td>{{ result.vote }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </card>
        </div>
    </div>
</template>
<script>
import "jquery/dist/jquery.min.js";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import $ from "jquery";
import axios from "axios";
import NotificationTemplate from "@/pages/Notifications/NotificationTemplate";

export default{
    data(){
        let act = [];
        let actresults = [];
        return {
            resultats: [],
            act,
            actresults,
            pacs: [],
            results: [],

        }
    },
    methods: {
        datatable() {
            this.$nextTick(() => {
                $.fn.dataTable.ext.classes.sPageButton = "btn bcustom btn-sm btn-outline-info";
                $.fn.dataTable.ext.classes.sPageButtonActive = "btn bcustom btn-sm btn-info active";
                $("#datatable").DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "filter": true,
                    "autoWidth": true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                    },
                })
            });
        },

        listResult(){
            axios.get("/result").then(response => {
                this.resultats = response.data;
                this.datatable();
            });
        },

        listeResultat(){
            axios.get("pac").then(response => {
            this.results = response.data
        })
        },

        listPAC() {
        axios.get("/pac/liste").then(response => {
            this.pacs = response.data
        })
        },

        ajouterPAC() {
            for(let i=0; i<this.results.length; i++){
            this.act.push(this.results[i])
            const resultat = {
                  activite: this.act[i].activite,
            };
            axios.post('/pac/ajouter', resultat)
            }
            
                this.$notify({
                title: 'PAC ajoutée',
                text: 'PAC ajoutée avec succès',
                type: 'success',
                template: NotificationTemplate,
                icon: 'fa fa-check',
                horizontalAlign: 'center',
            }),
            this.$router.push("/pac/liste")
        },
    },
    mounted() {
        this.listResult();
        this.listPAC(),
        this.listeResultat()
    },
}
</script>
<style>
.dataTables_wrapper {
  overflow: auto;
  table-layout: fixed;
}

.dataTables_filter {
  margin-bottom: 1em;
}
.addbutton {
  float: right;
  margin-bottom: 2em;
  margin-top: 1.5em;
}

.bcustom {
  margin: 0.5em 0.5em;
}

.dataTables_wrapper .dataTables_filter input{
  background-color: #fffcf5;
  border: 1px solid #e6e6e6;
  border-radius: 4px;
  color: #66615b;
  font-size: 14px;
  transition: background-color 0.3s ease 0s;
  padding: 7px 18px;
  height: 40px;
  -webkit-box-shadow: none;
  box-shadow: none;
}
.dataTables_wrapper .dataTables_length select{
  background-color: #fffcf5;
  border: 1px solid #e6e6e6;
  border-radius: 4px;
  color: #66615b;
  font-size: 14px;
  transition: background-color 0.3s ease 0s;
  padding: 7px 18px;
  height: 40px;
  -webkit-box-shadow: none;
  box-shadow: none;
}
</style>
