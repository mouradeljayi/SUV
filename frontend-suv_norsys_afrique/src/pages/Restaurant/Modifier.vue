<template>
  <card class="card" title="Modifier une restaurant">
    <div>
      <form @submit.prevent="modifierRestaurant(restaurant.id)">
        <div class="row">
          <div class="col-md-6">
            <fg-input type="text"
                      label="Nom de restaurant"
                      placeholder="Nom de restaurant"
                      v-bind:value="restaurant.nom"
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
                Modifier
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
      restaurant: "",
    };
  },
  methods: {
    getRestuarnts(id) {
      axios.get("restaurant/" + id, id).then(response => {
        this.restaurant = response.data;
      });
    },
    modifierRestaurant() {
      const updatedRestaurant = {
        nom: this.restaurant.nom,
        adresse: this.restaurant.adresse,
      };
      axios.put("restaurant/modifier/" + this.restaurant.id, updatedRestaurant).then(response => {
        this.$notify({
          title: 'Restaurant modifiée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',

        });
        this.$router.push("/restaurant");
      }).catch(error => {
        this.$notify({
          title: error.toString(),
          type: 'danger',
          template: NotificationTemplate,
          icon: 'fa fa-times',
          horizontalAlign: 'center',
        });
      });
    }
  },
  mounted() {
    this.getRestuarnts(this.$route.params.id);
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
