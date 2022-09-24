<template>
  <div class="row">
    <div class="col-12">
      <card title="Liste des Restaurants">
        <p-button type="info" class="addbutton"
                  outline
                  @click.native.prevent="ajouter">
          Ajouter un restaurant
        </p-button>
        <div class="table table-responsive">
          <table id="datatable">
            <thead>
              <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="restaurant in restaurants" v-bind:key="restaurant">
                <td>{{ restaurant.id }}</td>
                <td>{{ restaurant.nom }}</td>
                <td>{{ restaurant.adresse }}</td>
                <td>
                  <button v-b-modal="'modifier'+restaurant.id" class="btn btn-info btn-sm">
                    <i class="fa fa-edit"></i>
                  </button>
                  <b-modal :id="'modifier'+restaurant.id" title="Confirmation">
                    <b>
                      Voulez-vous vraiment modifier cette restaurant ?
                    </b>
                    <template #modal-footer="{ ok, cancel }">
                      <p-button
                        round
                        type="info"
                        @click.native.prevent="modifier(restaurant.id)">
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
                  <button v-b-modal="'supprimer'+restaurant.id" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i>
                  </button>
                  <b-modal v-if="modalShow" :id="'supprimer' + restaurant.id" title="Confirmation">
                    <b>
                      Voulez-vous vraiment supprimer cette restaurant ?
                    </b>
                    <template #modal-footer="{ ok, cancel }">
                      <p-button round type="info" @click.native.prevent="supprimer(restaurant.id)">
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
      restaurants: [],
      modalShow: true,
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
     listRestaurants() {
       axios.get("/restaurant").then(response => {
        this.restaurants = response.data;
        this.datatable();
      });
    },
    ajouter() {
      this.$router.push("/restaurant/ajouter");
    },
    modifier(id) {
      this.$router.push("/restaurant/modifier/" + id);
    },
    supprimer(id) {
      axios.delete("/restaurant/supprimer/" + id).then(response => {
          this.$notify({
            title: 'Restaurant supprimée',
            text: "Restaurant archivée avec succès",
            type: 'danger',
            template: NotificationTemplate,
            icon: 'fa fa-trash',
            horizontalAlign: 'center',
          });
          this.$router.go(0);
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
    this.listRestaurants();
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
