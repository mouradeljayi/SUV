<template>
  <card class="card" title="Modifier Utilisateur">
    <div>
      <form @submit.prevent="modifierUtilisateur(utilisateur.id)">
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
            <fg-input type="text"
                      label="Date Naissance"
                      placeholder="Donnez la dateNaissance d'Utilisateur"
                      v-model="utilisateur.dateNaissance">
            </fg-input>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <fg-input type="text"
                      label="Pays"
                      placeholder="Donnez la pays d'Utilisateur"
                      v-model="utilisateur.pays">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="text"
                      label="Ville"
                      placeholder="Donnez la ville d'Utilisateur"
                      v-model="utilisateur.ville">
            </fg-input>
          </div>
          <div class="col-md-4">
            <fg-input type="text"
                      label="Code Postal"
                      placeholder="Donnez codePostal d'Utilisateur"
                      v-model="utilisateur.codePostal">
            </fg-input>
          </div>
        </div>
        <div class="row">

          <div class="col-md-6">
            <fg-input type="twxt"
                      label="Adresse"
                      placeholder="Donnez la adresse d'Utilisateur"
                      v-model="utilisateur.adresse">
            </fg-input>
          </div>
          <div class="col-md-6">
            <fg-input type="text"
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
      utilisateur: "",
    };
  },
  methods: {
    getUtilisateurs(id) {
      axios.get("/utilisateurs/" + id, id).then(response => {
        this.utilisateur = response.data;
      });
    },
    modifierUtilisateur(id) {
      const updatedUtilisateur = {
        nom: this.utilisateur.nom,
        prenom: this.utilisateur.prenom,
        email: this.utilisateur.email,
        dateNaissance: this.utilisateur.dateNaissance,
        ville: this.utilisateur.ville,
        pays: this.utilisateur.pays,
        codePostal: this.utilisateur.codePostal,
        adresse: this.utilisateur.adresse,
        telephone: this.utilisateur.telephone,
      };

      axios.put("/utilisateurs/edit/" + this.utilisateur.id, updatedUtilisateur).then(response => {
        this.$notify({
          title: 'utilisateur modifiée avec succès',
          type: 'success',
          template: NotificationTemplate,
          icon: 'fa fa-check',
          horizontalAlign: 'center',
        });
        this.$router.push("/utilisateurs");
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
    this.getUtilisateurs(this.$route.params.id);
  }
}
</script>
<style scoped>

</style>
