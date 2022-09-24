<template>
  <div class="row">
    <div class="col-12">
      <card title="Liste Transport">
        <p-button type="info" class="addbutton"
                  outline
                  @click.native.prevent="ajouterTransport">
          Ajouter Transport
        </p-button>
        <div class="table table-responsive">
          <table id="datatable">
            <thead>
            <tr>
              <th>#</th>
              <th>Nom</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="transport in transports" v-bind:key="transport.id">
              <td>{{ transport.id }}</td>
              <td>{{ transport.nom }}</td>
              <td>
                <button v-b-modal="'modifier'+transport.id" class="btn btn-info btn-sm">
                  <i class="fa fa-edit"></i>
                </button>
                <b-modal :id="'modifier'+transport.id" title="Confirmation">
                  <b>
                    Voulez-vous vraiment modifier cette transport ?
                  </b>
                  <template #modal-footer="{ ok, cancel }">
                    <p-button
                      round
                      type="info"
                      @click.native.prevent="modifier(transport.id)">
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
                <button v-b-modal="'supprimer'+transport.id" class="btn btn-danger btn-sm">
                  <i class="fa fa-trash"></i>
                </button>
                <b-modal v-if="modalShow" :id="'supprimer' + transport.id" title="Confirmation">
                  <b>
                    Voulez-vous vraiment supprimer cette transport ?
                  </b>
                  <template #modal-footer="{ ok, cancel }">
                    <p-button round type="info" @click.native.prevent="supprimer(transport.id)">
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
      transports: [],
      modalShow: true,
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
    listTransport() {
      axios.get("transport/liste").then(response => {
        this.transports = response.data
        this.datatable()
      })
    },
    ajouterTransport() {
      this.$router.push({path: '/transport/ajouter'});
    },
    modifier(id) {
      this.$router.push("/transport/modifier/" + id);
    },
    supprimer(id) {
      axios.delete("transport/supprimer/" + id, id).then(response => {
        this.$notify({
          title: 'transport supprimée',
          text: 'transport supprimée avec succès',
          type: 'danger',
          template: NotificationTemplate,
          icon: 'fa fa-trash',
          horizontalAlign: 'center',
        }),
        this.$router.go(0)
      }).catch(error => {
        error.toString();
        this.$notify({
          title: "cette ligne ne peut pas être supprimée",
          text: ' cette ligne ne peut pas être supprimée ',
          type: 'danger',
          template: NotificationTemplate,
          icon: 'fa fa-trash',
          horizontalAlign: 'center',          
        })
        this.modalShow = false
      });
    },
  },
  mounted() {
    this.listTransport()
  }

}
</script>

<style>

</style>
