<template>
  <div class="row">
    <div class="col-12">
      <card title="Les résultats du questionnaire de confirmation">
        <p-button type="success" class="addbutton ml-2"
                  outline
                  @click.native.prevent="genererTAF">
          Générer table d'activités finales
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
            <tr v-for="result in resultatsFinal" v-bind:key="result.id">
              <td>{{ result.id }}</td>
              <td>{{ result.utilisateur.nom }} {{ result.utilisateur.prenom}}</td>
              <td>{{ result.pac.activite.nom }}</td>
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
import $ from "jquery";
import axios from "axios";

export default {
  data(){
    let act = [];
    let res = [];
    return {
      act,
      res,
      resultatsFinal: [],
      groupresults: [],
    }
  },
  methods: {
    listResult(){
      axios.get("/finalresults").then(response => {
        this.resultatsFinal = response.data;
        this.datatable();
      });
    },
    getGroupeActivites() {
      axios.get('/taf').then((response) => {
        this.groupresults = response.data
      })
    },
    genererTAF() {
      for(let i=0; i<this.groupresults.length; i++){
        this.act.push(this.groupresults[i])
        const resultat = {
          pac: this.act[i].pac,
        };
        axios.post('/taf/ajouter', resultat)
        this.$router.push("/TAF")
      }
    },
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
  },
  mounted() {
    this.listResult();
    this.getGroupeActivites();
  },
}
</script>

<style scoped>

</style>
