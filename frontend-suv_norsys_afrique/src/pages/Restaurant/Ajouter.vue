<template>
  <card class="card" title="Ajouter une restaurant">
    <div>
      <form @submit.prevent="ajouterRestaurant">
            <div class="row">
                <div class="col-md-6">
                    <fg-input type="text"
                      label="Nom de restaurant"
                      placeholder="Nom de restaurant"
                      v-model="restaurant.nom">
                    </fg-input>
                </div>
                <div class="col-md-6">
                    <fg-input type="text"
                            label="Adresse de restaurant"
                            placeholder="Adresse de restaurant"
                            v-model="restaurant.adresse">
                    </fg-input>
                </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-3">
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
      </form>
    </div>
  </card>
</template>

<script>
import axios from "axios";
import NotificationTemplate from "../Notifications/NotificationTemplate";

export default {
  data() {
    return {
      restaurant: {
        nom: "",
        adresse: "",
      }
    };
  },
  methods: {
    ajouterRestaurant() {
        const restaurant_data = {
          nom: this.restaurant.nom,
          adresse: this.restaurant.adresse,
        };
      axios.post('restaurant/ajouter', restaurant_data).then(
        this.$notify({
          title: 'restaurant ajoutée',
          text: 'restaurant ajoutée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        }),
        this.$router.push('/restaurant')
      ).catch(
        err => {
          err.toString()
          this.$notify({
            title: 'Erreur',
            text: 'Erreur lors de l\'ajout de restaurant',
            type: 'error',
            template: NotificationTemplate,
            icon: 'fa fa-times'
        });
    });
    },
  }
}
</script>

<style scoped>
.center_buttons{
  display: grid;
  grid-auto-flow: column;
  grid-gap: 10px;
}
</style>
