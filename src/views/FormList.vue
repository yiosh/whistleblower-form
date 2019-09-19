<template>
  <v-container class="mt-3">
    <v-layout v-if="loading" justify-center>
      <v-progress-circular
        :size="70"
        :width="7"
        color="#3581b5"
        indeterminate
      ></v-progress-circular>
    </v-layout>
     <v-layout v-if="!loading" text-xs-center justify-center>
      <v-flex xs12 md6>
        <v-text-field
          prepend-icon="search"
          label="Ricerca"
          v-model="search"
          class="py-3 px-1"
        ></v-text-field>
        
        <v-card v-for="item in filterItems" :key="item.id" class="mb-3">
           <v-toolbar dark color="#3581b5">
              <v-toolbar-title>Modulo ID#{{ item.id }}</v-toolbar-title>
            </v-toolbar>
          
          <v-card-actions>
            <small>{{ item.created_at }}</small>
            <v-layout justify-end>
            <v-btn @click="handleRedirect(item.secret_code)" flat>Vedi Modulo</v-btn>
            </v-layout>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>        
  </v-container>
</template>

<script>
import EventBus from "@/eventBus.js";
import axios from "axios";

export default {
  data() {
    return {
      loading: true,
      search: "",
      items: [],
      endpoint:
        location.hostname === "localhost"
          ? "http://www.comune.bitetto.ba.it/whistleblower2/"
          : ""
    };
  },
  computed: {
    filterItems() {
      if (this.search.length) {
        let items = [];
        this.items.filter(item => {
          if (item.id.toLowerCase().includes(this.search.toLowerCase())) {
            items.push(item);
          }
        });
        return items;
      }
      return this.items;
    }
  },
  methods: {
    handleRedirect(secret) {
      this.$router.push({ path: `/form/${secret}` });
    },
    async handleCheckSession() {
      let formData = new FormData();
      formData.append("checkSession", true);

      try {
        const response = await axios.post(this.endpoint + "api.php", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        });
        console.log("response-check-session", response);
        if (response.data.status === "OK") {
          this.handleFetchForms();
        } else {
          this.$router.push({ path: `/` });
        }
      } catch (error) {
        EventBus.$emit("snackbar", {
          color: "error",
          state: true,
          text: "Errore di rete!"
        });
        console.log(error);
      }
    },
    handleFetchForms() {
      let formData = new FormData();
      formData.append("fetchAllForms", true);

      axios
        .post(this.endpoint + "api.php", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          this.items = response.data;
          console.log("response-all-forms", response);
          this.loading = false;
        })
        .catch(error => {
          this.loading = false;
          EventBus.$emit("snackbar", {
            color: "error",
            state: true,
            text: "Errore di rete!"
          });
          console.log(error);
        });
    }
  },
  created() {
    this.handleCheckSession();
    // if (=== "OK") {
    //   this.handleFetchForms();
    // } else {

    // }

    // if (this.$route.params.loggedIn) {
    // } else {
    //
    // }
  }
};
</script>

<style>
</style>
