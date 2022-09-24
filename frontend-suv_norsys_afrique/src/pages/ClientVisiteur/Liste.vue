<template>
  <div class="row">
    <div class="col-12">
      <card title="Liste Client Visiteur">
        <p-button type="info" class="addbutton"
                  outline
                  @click.native.prevent="ajouterClientVisiteur">
          Ajouter Client Visiteur
        </p-button>

        <div class="table table-responsive">
          <table id="datatable">
            <thead>
            <tr>
              <th>#</th>
              <th>Nom</th>
              <th>Prenom</th>
              <th>Evenement</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="clientvisiteur in visitClients" v-bind:key="clientvisiteur.id">
              <td>{{ clientvisiteur.id }}</td>
              <td>{{ clientvisiteur.nom }}</td>
              <td>{{ clientvisiteur.prenom }}</td>
              <td>{{ clientvisiteur.Evenement.nom}}</td>
              <td>
                <button v-b-modal="'modifier'+clientvisiteur.id" class="btn btn-info btn-sm">
                  <i class="fa fa-edit"></i>
                </button>
                <b-modal :id="'modifier'+clientvisiteur.id" title="Confirmation">
                  <b>
                    Voulez-vous vraiment modifier ce client visiteur ?
                  </b>
                  <template #modal-footer="{ ok, cancel }">
                    <p-button
                      round
                      type="info"
                      @click.native.prevent="modifier(clientvisiteur.id)">
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
                <button v-b-modal="'supprimer'+clientvisiteur.id" class="btn btn-danger btn-sm">
                  <i class="fa fa-trash"></i>
                </button>
                <b-modal :id="'supprimer' + clientvisiteur.id" title="Confirmation">
                  <b>
                    Voulez-vous vraiment supprimer ce client visiteur ?
                  </b>
                  <template #modal-footer="{ ok, cancel }">
                    <p-button round type="info" @click.native.prevent="supprimer(clientvisiteur.id)">
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
      visitClients: []
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
    listClientVisiteur() {
      axios.get("/clientvisiteur/liste").then(response => {
        this.visitClients = response.data
        this.datatable()
      })

    },
    ajouterClientVisiteur() {
      this.$router.push({path: '/clientvisiteur/ajouter'});
    },
    modifier(id) {
      this.$router.push("/clientvisiteur/modifier/" + id);
    },
    supprimer(id) {
      axios.delete("clientvisiteur/supprimer/" + id, id).then(response => {
        this.$notify({
          title: 'client visiteur supprimée',
          text: 'client visiteur supprimée avec succès',
          type: 'danger',
          template: NotificationTemplate,
          icon: 'fa fa-trash',
          horizontalAlign: 'center',
        }),
          this.$router.go(0)
      }).catch(error => {
        error.toString();
      });
    },
  },
  mounted() {
    this.listClientVisiteur()
  }
}
</script>

<style scoped>

</style>
