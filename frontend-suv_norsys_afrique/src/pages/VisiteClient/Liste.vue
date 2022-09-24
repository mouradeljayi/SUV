<template>
  <div class="row">
    <div class="col-12">
      <card title="Liste Table planning d'événement">
        <p-button type="info" class="addbutton"
                  outline
                  @click.native.prevent="ajouterVisiteClient">
          Ajouter Visite Client
        </p-button>
        <div class="table table-responsive">
          <table id="datatable">
            <thead>
            <tr>
              <th>#</th>
              <th>Jour</th>
              <th>Programme De Jour</th>
              <th>Heure</th>
              <th>Nombre De Pax</th>
              <th>Transport</th>
              <th>Hotel</th>
              <th>Restaurant</th>
              <th>Evenement</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="visiteclient in visitClients" v-bind:key="visiteclient.id">
              <td>{{ visiteclient.id }}</td>
              <td>{{ new Date(visiteclient.Jour).toLocaleDateString('fr', options) }}</td>
              <td>{{ visiteclient.programmeDeJour }}</td>
              <td>{{ new Date(visiteclient.heure).toLocaleTimeString() }}</td>
              <td>{{ visiteclient.nombreDePax }}</td>
              <td>{{ visiteclient.transport.nom }}</td>
              <td>{{ visiteclient.hotel.nom }}</td>
              <td>{{ visiteclient.restaurant.nom }}</td>
              <td>{{ visiteclient.evenement.nom}}</td>
              <td>
                <button v-b-modal="'modifier'+visiteclient.id" class="btn btn-info btn-sm">
                  <i class="fa fa-edit"></i>
                </button>
                <b-modal :id="'modifier'+visiteclient.id" title="Confirmation">
                  <b>
                    Voulez-vous vraiment modifier cette visite client ?
                  </b>
                  <template #modal-footer="{ ok, cancel }">
                    <p-button
                      round
                      type="info"
                      @click.native.prevent="modifier(visiteclient.id)">
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
                <button v-b-modal="'supprimer'+visiteclient.id" class="btn btn-danger btn-sm">
                  <i class="fa fa-trash"></i>
                </button>
                <b-modal :id="'supprimer' + visiteclient.id" title="Confirmation">
                  <b>
                    Voulez-vous vraiment supprimer cette visiteclient ?
                  </b>
                  <template #modal-footer="{ ok, cancel }">
                    <p-button round type="info" @click.native.prevent="supprimer(visiteclient.id)">
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
    listVisiteClient() {
      axios.get("visiteclient/liste").then(response => {
        this.visitClients = response.data
        this.datatable()
        console.log(response.data)
      })
    },
    ajouterVisiteClient() {
      this.$router.push({path: '/visiteclient/ajouter'});
    },
    modifier(id) {
      this.$router.push("/visiteclient/modifier/" + id);
    },
    supprimer(id) {
      axios.delete("visiteclient/supprimer/" + id, id).then(response => {
        console.log(response.data)
        this.$notify({
          title: 'visite client supprimée',
          text: 'visite client supprimée avec succès',
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
    this.listVisiteClient()
  }
}
</script>

<style scoped>

</style>
