<template>
    <div class="row">
        <div class="col-12">
            <card title="liste des status">
                <p-button type="info" class="addbutton"
                    outline
                    @click.native.prevent="ajouter">
                    Ajouter une status
                </p-button>
                <div class="table table-responsive">
                    <table id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="typestatu in typestatus" v-bind:key="typestatu.id">
                            <td>{{ typestatu.id }}</td>
                            <td>{{ typestatu.nom }}</td>
                            <td>
                                <button v-b-modal="'modifier'+typestatu.id" class="btn btn-info btn-sm">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <b-modal :id="'modifier'+typestatu.id" title="Confirmation">
                                    <b>
                                    Voulez-vous vraiment modifier cette status ?
                                    </b>
                                    <template #modal-footer="{ ok, cancel }">
                                    <p-button
                                        round
                                        type="info"
                                        @click.native.prevent="modifier(typestatu.id)">
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
                                <button v-b-modal="'supprimer'+typestatu.id" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <b-modal :id="'supprimer' + typestatu.id" title="Confirmation">
                                    <b>
                                    Voulez-vous vraiment supprimer cette status ?
                                    </b>
                                    <template #modal-footer="{ ok, cancel }">
                                    <p-button
                                        round
                                        type="info"
                                        @click.native.prevent="supprimer(typestatu.id)">
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

export default{
    data(){
        return {
            typestatus: [],
        }
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
        listTypeStatus(){
            axios.get("/type/status").then(response => {
                this.typestatus = response.data;
                this.datatable();
            });
        },
        ajouter() {
            this.$router.push("/status/ajouter");
        },
        modifier(id) {
            this.$router.push("/status/modifier/" + id);
        },
        getStatus(id) {
            axios.get("/type/status/" + id, id).then(response => {
                this.status = response.data;
            });
        },
        supprimer(id) {
            axios.put("/type/status/archiver/" + id).then(response => {
                if(response.data.Message === "Archivée avec succès") {
                    this.$notify({
                        title: 'Status supprimée',
                        text: "Status archivée avec succès",
                        type: 'danger',
                        template: NotificationTemplate,
                        icon: 'fa fa-trash',
                        horizontalAlign: 'center',
                    });
                    this.$router.go(0);
                    }
                })
            .catch(error => {
                this.$notify({
                title: error.toString(),
                type: 'danger',
                template: NotificationTemplate,
                icon: 'fa fa-times',
                horizontalAlign: 'center',
                });
            });
        },
    },
    mounted() {
        this.listTypeStatus();
    },
}
</script>
<style>

</style>
