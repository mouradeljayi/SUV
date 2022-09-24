<template>
  <div class="row">
    <div class="col-12">
      <card title="PAC">
        <p-button type="success" class="addbutton ml-2"
                  outline
                  @click.native.prevent="generer">
          Générer le questionnaire de confirmation
        </p-button>
        <p-button type="success" class="addbutton ml-2"
                  outline
                  @click.native.prevent="resultat">
          Résultat deuxième questionnaire
        </p-button>
        <div class="table table-responsive">
          <table id="datatable">
            <thead>
            <tr>
              <th>Événement</th>
              <th>Activite</th>
              <th>Date</th>
              <th>Cotisation</th>
              <th>Cotisation collaborateur</th>
              <th>Commentaire</th>
              <th>Participants</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="pac in pacs" v-bind:key="pac.id">
              <td>{{ pac.activite.evenement.nom }}</td>
              <td>{{ pac.activite.nom }}</td>
              <td>{{ new Date(pac.activite.date).toLocaleDateString('fr', options) }}</td>
              <td>{{ pac.activite.cotisation }}</td>
              <td>{{ pac.activite.cotisationParSalarie }}</td>
              <td>{{ pac.activite.description }}</td>
              <td>
                  <div v-for="result in pacresults" v-bind:key="result.id">
                        <div v-if="pac.activite.id === result.activite.id && result.vote === true">
                            <li>{{result.utilisateur.nom}} {{result.utilisateur.prenom}}</li>
                        </div>
                  </div>
              </td>

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

export default {
  data() {
      let act = [];
      let actresults = [];
      let pcresult = []
    return {
      act,
      pcresult,
      actresults,
      pacs: [],
      activites: [],
      results: [],
      pacresults: [],
      doubles: []
    }
  },
  methods: {
    datatable() {
      this.$nextTick(() => {
        $("#datatable").DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "filter": true,
          "autoWidth": false,
          "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
          },
          buttons: [
            "copy", "csv", "excel", "pdf", "print"
          ]
        })
      });
    },

    listVoteResults(){
        axios.get("result").then(response => {
        this.pacresults = response.data
      })
    },

    listeResult(){
        axios.get("pac").then(response => {
        this.results = response.data
      })
    },

    listPAC() {
      axios.get("/pac/liste").then(response => {
        this.pacs = response.data
        this.datatable()
      })
    },

    generer(){
      this.$router.push("/titreQuestionnaire");
    },
    resultat(){
      this.$router.push("/finalresult");
    },
  },
  mounted() {
    this.listPAC(),
    this.listeResult(),
    this.listVoteResults()
  }
}
</script>

<style>

</style>
