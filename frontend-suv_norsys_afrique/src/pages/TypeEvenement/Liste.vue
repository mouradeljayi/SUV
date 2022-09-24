<template>
  <div class="row">
    <div class="col-12">
      <card title="Liste Type Evenements">
        <p-button type="info" class="addbutton"
                  outline
                  @click.native.prevent="ajouterTypeEvenement">
          Ajouter Type Evenement
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
            <tr v-for="typeevenement in typeEvenements" v-bind:key="typeevenement.id">
              <td>{{ typeevenement.id }}</td>
              <td>{{ typeevenement.nom }}</td>
              <td>
                <button v-b-modal="'modifier'+typeevenement.id" class="btn btn-info btn-sm">
                  <i class="fa fa-edit"></i>
                </button>
                <b-modal :id="'modifier'+typeevenement.id" title="Confirmation">
                  <b>
                    Voulez-vous vraiment modifier cette typeevenement ?
                  </b>
                  <template #modal-footer="{ ok, cancel }">
                    <p-button
                      round
                      type="info"
                      @click.native.prevent="modifier(typeevenement.id)">
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
                <button v-b-modal="'supprimer'+typeevenement.id" class="btn btn-danger btn-sm">
                  <i class="fa fa-trash"></i>
                </button>
                <b-modal :id="'supprimer' + typeevenement.id" title="Confirmation">
                  <b>
                    Voulez-vous vraiment supprimer cette typeevenement ?
                  </b>
                  <template #modal-footer="{ ok, cancel }">
                    <p-button round type="info" @click.native.prevent="supprimer(typeevenement.id)">
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
      typeEvenements: []
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
    listTypeEvenement() {
      axios.get("typeevenement/liste").then(response => {
        this.typeEvenements = response.data
        this.datatable()
      })
    },
    ajouterTypeEvenement() {
      this.$router.push({path: '/typeevenement/ajouter'});
    },
    modifier(id) {
      this.$router.push("/typeevenement/modifier/" + id);
    },
    supprimer(id) {
      axios.delete("typeevenement/supprimer/" + id, id).then(response => {
        console.log(response.data)
        this.$notify({
          title: 'type evenement supprimée',
          text: 'type evenement supprimée avec succès',
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
    this.listTypeEvenement()
  }
}
</script>

<style scoped>

</style>
