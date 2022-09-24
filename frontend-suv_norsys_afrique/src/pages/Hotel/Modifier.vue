<template>
  <card class="card" title="Modifier un Hôtel">
    <div>
      <form @submit.prevent="modifierHotel(hotel.id)">
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
                Modifier
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
      hotel: "",
    }
  },
  mounted() {
    this.getHotel(this.$route.params.id)
  },
  methods: {
    getHotel(id) {
      axios.get('hotel/afficher/' + id).then((response) => {
        this.hotel = response.data
      })
    },
    modifierHotel() {
      const updatedHotel = {
        nom: this.hotel.nom,
        adresse: this.hotel.adresse
      };
      axios.put("/hotel/modifier/" + this.hotel.id, updatedHotel).then(response => {
        console.log(response.data)
        this.$notify({
          title: 'hôtel modifié avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        });
        this.$router.push("/hotels");
      })
    },
  }
}
</script>

<style scoped>

</style>
