<template>
  <div class="background">
    <div class="center">
      <div class="content">
        <h3 style="text-align: center">SUV Norsys Afrique</h3>
        <hr/>
        <form @submit.prevent="login">
          <div class="form-group">
            <fg-input type="email"
                      label="Adresse email"
                      placeholder="Email"
                      v-model="user.email"
            >
            </fg-input>
          </div>
          <div class="form-group">
            <fg-input type="password"
                      label="Mot de passe"
                      placeholder="Mot de passe"
                      v-model="user.password"
            >
            </fg-input>
          </div>
          <hr />
          <p-button type="info"
                    round
                    id="btn-center"
                    native-type="submit"
                    >
            Se connecter
          </p-button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import { extend } from "vee-validate";
import { required, email, min } from "vee-validate/dist/rules";
import axios from "axios";


extend("email", email);
extend("required", required);
extend("min", min);

export default {
  beforeCreate() {
    if (localStorage.getItem("token") == null) {
      this.$router.push("/login");
    }else{
      this.$router.push("/");
    }
  },
  data() {
    return {
      user:{
        email: "",
        password: ""
      }
    };
  },
  methods: {
    login() {
      axios.post("auth/login", this.user).then((response) => {
        localStorage.setItem("token", response.data.token);
        this.$router.push("/dashboard");
      })
        .catch ((error) => {
          console.log(error);
        });
      }
    }
}
</script>
<style scoped>
.background {
  background: #e2e2e2;
  width: 100%;
  position: absolute;
  top: 0;
  bottom: 0;
}

.center {
  width: 400px;
  height: 400px;
  background-color: #fff;
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  margin: auto;
  max-width: 100%;
  max-height: 100%;
  overflow: auto;
  padding: 1em 2em;
  border-bottom: 2px solid #ccc;
  display: table;
}

#btn-center{
  display: block;
  margin-left: auto;
  margin-right: auto;
}
div.content {
  display: table-cell;
  vertical-align: middle;
}

</style>
