<template>
  <card class="card" title="Ajouter Utilisateur">
    <div>
      <form @submit.prevent="ajouterUtilisateur">
        <div class="row">
          <div class="col-md-3">
            <fg-input type="text"
                      label="Nom"
                      placeholder="Donnez le nom d'Utilisateur"
                      v-model="utilisateur.nom">
            </fg-input>
          </div>
          <div class="col-md-3">
            <fg-input type="text"
                      label="Prenom"
                      placeholder="Donnez le prenom d'Utilisateur"
                      v-model="utilisateur.prenom">
            </fg-input>
          </div>
          <div class="col-md-6">
            <fg-input type="email"
                      label="Email"
                      placeholder="Donnez l'email d'Utilisateur"
                      v-model="utilisateur.email">
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8">
            <fg-input type="password"
                      label="Mot de passe"
                      placeholder="Donnez le password d'Utilisateur"
                      v-model="utilisateur.password">
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <fg-input type="date"
                      label="Date Naissance"
                      placeholder="Donnez la Date Naissance d'Utilisateur"
                      v-model="utilisateur.dateNaissance">
            </fg-input>
          </div>


        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="select-text"><div> Pays <span></span></div><div> Ville <span></span></div></div>
            <vueCountriesCities
              @country="utilisateur.pays = $event"
              @city="utilisateur.ville = $event"
            />
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <fg-input type="number"
                      label="Code Postal"
                      placeholder="Donnez codePostal d'Utilisateur"
                      v-model="utilisateur.codePostal">
            </fg-input>
          </div>
          <div class="col-md-6">
            <fg-input type="twxt"
                      label="Adresse "
                      placeholder="Donnez la adresse d'Utilisateur"
                      v-model="utilisateur.adresse">
            </fg-input>
          </div>
          <div class="col-md-6">
            <fg-input type="number"
                      label="Telephone"
                      placeholder="Donnez telephone d'Utilisateur"
                      v-model="utilisateur.telephone">

            </fg-input>
          </div>
        </div>
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
        <div class="clearfix"></div>
      </form>
    </div>
  </card>
</template>
<script>
import axios from "axios";
import vueCountriesCities from "vue-countries-cities";
import NotificationTemplate from "@/pages/Notifications/NotificationTemplate";

export default {
  data() {
    return {
      utilisateur: {
        nom: "",
        prenom: "",
        email: "",
        password: "",
        dateNaissance: "",
        ville: "",
        pays: "",
        codePostal: "",
        adresse: "",
        telephone: ""
      }
    }
  },
  components: {vueCountriesCities},
  mounted() {
  },
  methods: {
    ajouterUtilisateur() {
      axios.post("/utilisateur/ajouter", this.utilisateur)
        .then((response) => {
          this.$notify({
            title: 'Utilisateur ajoutée',
            text: 'Utilisateur ajoutée avec succès',
            type: 'success',
            template: NotificationTemplate,
            icon: 'fa fa-check',
            horizontalAlign: 'center',
          })
          this.$router.push('/utilisateurs')
        })
    },
  }
}
</script>
<style>
.select-text {
  display: flex;
  justify-content: space-around;
  color: #9A9A9A;
  margin-bottom: -50px;
}
.select-box{
  background-color: #fffcf5!important;
}

.center_buttons{
  display: grid;
  grid-auto-flow: column;
  grid-gap: 10px;

}
</style>

