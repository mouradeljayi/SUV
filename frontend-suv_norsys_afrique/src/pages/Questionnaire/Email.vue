<template>

    <div class="mt-5">
        <h1 class="mb-5">Boutton pour envoyer questionnaire</h1>
        <button class="btn btn-secondary" @click="submit">
            Envoyer
        </button>  
    </div>

</template>
<script>
import "jquery/dist/jquery.min.js";
import $ from "jquery";

import axios from "axios";
import NotificationTemplate from "@/pages/Notifications/NotificationTemplate";

export default {
  data() {
    return {
    };
  },
  methods:{
    submit() {
      if (axios.get("http://localhost:98/email").then(response => {
        this.email = response.data;
      })){
          alert(' Your email well sent');
      }
      else{
        alert(' You have problem to send email');
      }
    },
  },
};
</script>
<style>


</style>