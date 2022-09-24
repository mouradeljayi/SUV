<template>
  <div class="row">
    <div class="col-12">
      <card title="Liste des Activites">
        <p-button type="success" class="addbutton ml-2"
                  outline
                  @click.native.prevent="resultat">
          Résultat de vote
        </p-button>
        <p-button type="success" class="addbutton ml-2"
                  outline
                  @click.native.prevent="generer">
          Générer un questionnaire
        </p-button>
        <p-button type="info" class="addbutton"
                  outline
                  @click.native.prevent="ajouter">
          Ajouter une activité
        </p-button>
        <div class="table table-responsive">
          <table id="datatable">
            <thead>
              <tr>
                <th>#</th>
                <th>responsable Etude</th>
                <th>Evenement</th>
                <th>Nom</th>
                <th>Date</th>
                <th>Montant</th>
                <th>Detail Montant</th>
                <th>Cotisation</th>
                <th>Cotisation Entreprise</th>
                <th>Cotisation/Salarie</th>
                <th>Description</th>
                <th>Prix Globale/Salarie</th>
                <th>participant</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="activite in activites" v-bind:key="activite.id">
                <td>{{ activite.id }}</td>
                <td>{{ activite.responsableEtude.nom }} {{ activite.responsableEtude.prenom }}</td>
                <td>{{ activite.evenement.nom }}</td>
                <td>{{ activite.nom }}</td>
                <td>{{ new Date(activite.date).toLocaleDateString('fr', options) }}</td>
                <td>{{ activite.montant }}</td>
                <td>{{ activite.detailMontant }}</td>
                <td>{{ activite.cotisation }}</td>
                <td>{{ activite.cotisationEntreprise }}</td>
                <td>{{ activite.cotisationParSalarie }}</td>
                <td>{{ activite.description }}</td>
                <td>{{ activite.prixGlobalParSalarie }}</td>
                <td>{{ activite.participant }}</td>

                <td>
                  <button v-b-modal="'modifier'+activite.id" class="btn btn-info btn-sm">
                    <i class="fa fa-edit"></i>
                  </button>
                  <b-modal :id="'modifier'+activite.id" title="Confirmation">
                    <b>
                      Voulez-vous vraiment modifier cette activité ?
                    </b>
                    <template #modal-footer="{ ok, cancel }">
                      <p-button
                        round
                        type="info"
                        @click.native.prevent="modifier(activite.id)">
                        Oui
                      </p-button>
                      <p-button
                        round
                        type="danger"
                        @click.native.prevent="cancel()">
                        Annuler
                      </p-button>
                    </template>
                  </b-modal>
                  |
                  <button v-b-modal="'supprimer'+activite.id" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i>
                  </button>
                  <b-modal :id="'supprimer' + activite.id" title="Confirmation">
                    <b>
                      Voulez-vous vraiment supprimer cette activité ?
                    </b>
                    <template #modal-footer="{ ok, cancel }">
                      <p-button round type="info" @click.native.prevent="supprimer(activite.id)">
                        Oui
                      </p-button>
                      <p-button round type="danger" @click.native.prevent="cancel()">
                        Annuler
                      </p-button>
                    </template>
                  </b-modal>
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
    return {
      activites: [],
      show: false,
    };
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
     listActivities() {
       axios.get("/activites").then(response => {
        this.activites = response.data;
        this.datatable();
      });
    },
    resultat(){
      this.$router.push("/result");
    },
    ajouter() {
      this.$router.push("/activites/ajouter");
    },
    modifier(id) {
      this.$router.push("/activites/modifier/" + id);
    },
    supprimer(id) {
      axios.put("/activites/archiver/" + id).then(response => {
        if(response.data.message === "Activité archivée avec succès") {
          this.$notify({
            title: 'Activité supprimée',
            text: "Activité archivée avec succès",
            type: 'danger',
            template: NotificationTemplate,
            icon: 'fa fa-trash',
            horizontalAlign: 'center',
          });
          this.$router.go(0);
        }
      }).catch(error => {
        error.toString();
      });
    },
    generer(){
      this.$router.push("/questionnaire/titre");
    }
  },
  mounted() {
    this.listActivities();
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
