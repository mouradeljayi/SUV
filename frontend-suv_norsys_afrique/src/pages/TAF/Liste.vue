<template>
  <div class="row">
    <div class="col-12">
      <card title="Table des Activités Finales">
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
            <tr v-for="taf in tafs" v-bind:key="taf.id">
              <th>{{ taf.pac.activite.evenement.nom }}</th>
              <td>{{ taf.pac.activite.nom }}</td>
              <td>{{ new Date(taf.pac.activite.date).toLocaleDateString('fr', options) }}</td>
              <td>{{ taf.pac.activite.cotisation }}</td>
              <td>{{ taf.pac.activite.cotisationParSalarie }}</td>
              <td>{{ taf.pac.activite.description }}</td>
              <td>
                <div v-for="result in finalresults" v-bind:key="result.id">
                  <div v-if="taf.pac.activite.id === result.pac.activite.id && result.vote === true">
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
import $ from "jquery";
import axios from "axios";

export default {
  data() {
    return {
      tafs: [],
      finalresults: [],
      finalactivites: [],
    }
  },
  mounted() {
    this.getTAF()
    this.getFinalResult()
  },
  methods: {

    getFinalResult() {
      axios.get('/finalresults').then((response) => {
        this.finalresults = response.data
      })
    },
    getTAF() {
      axios.get('/taf/liste').then((response) => {
        this.tafs = response.data
        this.datatable()
      })
    },
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
  }
}
</script>

<style scoped>

</style>
