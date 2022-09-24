<template>
  <card class="card" title="Ajouter un Hôtel">
    <div>
      <form @submit.prevent="ajouterHotel">
        <div class="row">
          <div class="col-md-6">
            <fg-input type="text"
                      label="Nom d'Hôtel"
                      placeholder="Saisissez le nom de l'hôtel"
                      v-model="hotel.nom">
            </fg-input>
          </div>
          <div class="col-md-6">
            <fg-input type="text"
                      label="Adresse d'Hôtel"
                      placeholder="Saisissez l'adresse de l'hôtel"
                      v-model="hotel.adresse">
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="center_buttons">
              <p-button type="success"
                        native-type="submit">
                Ajouter
              </p-button>
              <p-button type="danger"
                        native-type="reset">
                Réinitialiser
              </p-button>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </form>
    </div>
  </card>
</template>

<script>
import axios from "axios";
import NotificationTemplate from "@/pages/Notifications/NotificationTemplate";

export default {
  data() {
    return {
      hotel: {
        nom: "",
        adresse: ""
      }
    }
  },
  methods: {
    ajouterHotel() {
      const data = {
        nom: this.hotel.nom,
        adresse: this.hotel.adresse
      }
      axios.post('hotel/ajouter', data).then(response => {
        this.$notify({
          title: 'Hôtel ajouté avec succès',
          text: 'Hôtel ajouté avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        }),
        this.$router.push("/hotels")
      })
    }
  }
}
</script>

<style scoped>

</style>
