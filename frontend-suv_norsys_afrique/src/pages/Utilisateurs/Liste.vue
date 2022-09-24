<template>
  <div class="row">
    <div class="col-12">
      <card title="Liste des utilisateurs">
        <p-button type="info" class="addbutton"
                  outline
                  @click.native.prevent="ajouterUtilisateur">
          Ajouter un utilisateur
        </p-button>
        <div class="table table-responsive">
          <table id="datatable">
            <thead>
            <tr>
              <th>#</th>
              <th>Nom</th>
              <th>Prenom</th>
              <th>Email</th>
              <th>DateNaissance</th>
              <th>Ville</th>
              <th>Pays</th>
              <th>CodePostale</th>
              <th>Adresse</th>
              <th>NumeroTelephone</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="utilisateur in utilisateurs" v-bind:key="utilisateur.id">
              <td>{{ utilisateur.id }}</td>
              <td>{{ utilisateur.nom }}</td>
              <td>{{ utilisateur.prenom }}</td>
              <td>{{ utilisateur.email }}</td>
              <td>{{ new Date(utilisateur.dateNaissance).toLocaleDateString('fr', options) }}</td>
              <td>{{ utilisateur.ville }}</td>
              <td>{{ utilisateur.pays }}</td>
              <td>{{ utilisateur.codePostal }}</td>
              <td>{{ utilisateur.adresse }}</td>
              <td>{{ utilisateur.telephone }}</td>
              <td>
                <button v-b-modal="'modifier'+utilisateur.id" class="btn btn-info btn-sm">
                  <i class="fa fa-edit"></i>
                </button>
                <b-modal :id="'modifier'+utilisateur.id" title="Confirmation">
                  <b>
                    Voulez-vous vraiment modifier cette utilisateur ?
                  </b>
                  <template #modal-footer="{ ok, cancel }">
                    <p-button
                      round
                      type="info"
                      @click.native.prevent="modifier(utilisateur.id)">
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

                <button v-b-modal="'supprimer'+utilisateur.id" class="btn btn-danger btn-sm">
                  <i class="fa fa-trash"></i>
                </button>
                <b-modal :id="'supprimer' + utilisateur.id" title="Confirmation">
                  <b>
                    Voulez-vous vraiment supprimer cette utilisateur ?
                  </b>
                  <template #modal-footer="{ ok, cancel }">
                    <p-button round type="info" @click.native.prevent="supprimer(utilisateur.id)">
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
      utilisateurs: [],
      show: false,

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
    listUtilisateurs() {
      axios.get("/utilisateurs").then(response => {
        this.utilisateurs = response.data;
        this.datatable();
      });
    },
    ajouterUtilisateur() {
      this.$router.push({path: '/utilisateurs/ajouter'});
    },
    modifier(id) {
      this.$router.push("/utilisateurs/modifier/" + id);
    },
    supprimer(id) {
      axios.delete("utilisateurs/delete/" + id).then(
        response => {
          this.$notify({
            title: 'Utilisateurs supprimée',
            text: 'Utilisateurs supprimée avec succès',
            type: 'danger',
            template: NotificationTemplate,
            icon: 'fa fa-trash',
            horizontalAlign: 'center',
          });
            this.$router.go(0)
        }
      ).catch(error => {
        error.toString();
      });
    }
  },
  mounted() {
    this.listUtilisateurs()
  }
};
</script>
<style>


</style>
