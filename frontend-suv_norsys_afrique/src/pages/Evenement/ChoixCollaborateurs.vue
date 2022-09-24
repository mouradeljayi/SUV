<template>
  <div class="text-center">
    <label>Choisissez des collaborteurs </label>
    <div class="row">
      <div class="col-md-10">
        <multiselect v-model="value"
                     :options="users"
                     label="prenom"
                     track-by="prenom"
                     :multiple="true"
                     placeholder="choisissez collaborateurs"
                     deselect-label="Entrez pour supprimer"
                     select-label="Entrez pour sélectionner"
        >
        </multiselect>
      </div>
      <div class="col-md-2">
        <div class="text-center">
          <p-button type="success"
                    round
                    @click.native.prevent="sendEmail"
          >
            Envoyer
          </p-button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
import Vue from "vue";
import axios from "axios";

import Notification from "@/pages/Notifications/NotificationTemplate";


Vue.component('multiselect', Multiselect)

export default {
  components: {
    Multiselect
  },
  data() {
    return {
      showdata: false,
      users: [],
      value: [],
      valeur: []
    }
  },
  mounted() {
    this.getUsers()
  },
  methods: {
    getUsers() {
      axios
        .get('utilisateurs')
        .then((response) => {
          this.users = response.data
        })
      console.log(this.users)
    },
    sendEmail() {
      try {
        for(let i=0; i < this.value.length; i++){
          this.valeur[i] = this.value[i].email;
          console.log(this.valeur[i])
        }
        console.log(this.valeur)
        axios.get('/sendemail', {
          params: {
            to: this.valeur,
          }
        })
        this.$notify({
          title: 'Demande envoyé avec succès',
          text: 'Demande envoyé avec succès',
          type: 'success',
          template: Notification,
          icon: 'fa fa-check',
          horizontalAlign: 'right',
        })
      } catch(error) {
        error.toString()
        this.$notify({
          title: 'Erreur lors de l\'envoi du message! ',
          text: 'Erreur lors de l\'envoi du message!',
          type: 'error',
          template: Notification,
          icon: 'fa fa-times'
        })
      }
      this.$router.push("/event")
    },
  }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css">

</style>
