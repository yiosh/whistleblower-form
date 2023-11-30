<template>
  <v-container>
    <v-layout text-xs-center justify-center>
      <v-flex xs12 md6>
        <v-card class="mb-4">
          <v-toolbar dark color="primary">
            <v-toolbar-title
              >Hai già effettuato una segnalazione?</v-toolbar-title
            >
          </v-toolbar>
          <v-card-text class="d-flex justify-center">
            <div class="d-flex flex-column justify-center">
              <v-text-field
                prepend-icon="vpn_key"
                label="Inserisci Codice"
                v-model="searchSecretCode"
              ></v-text-field>
              <v-btn :loading="loading" @click="handleSearchForm">Invia</v-btn>
            </div>
          </v-card-text>
        </v-card>
        <v-card>
          <v-card-text>
            <v-layout text-xs-center justify-center wrap>
              <v-flex xs12>
                <p>
                  Il segnalante deve rivestire il ruolo di dipendente pubblico o
                  equiparato
                </p>
              </v-flex>
              <v-flex xs12 class="d-flex justify-center">
                <v-btn to="form">Nuova segnalazione</v-btn>
              </v-flex>
            </v-layout>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import EventBus from "@/eventBus.js";
import { endpoint } from "@/plugins/endpoint";
import axios from "axios";

export default {
  data() {
    return {
      searchSecretCode: "",
      loading: false,
    };
  },
  methods: {
    handleSearchForm() {
      if (this.searchSecretCode.length) {
        this.loading = true;
        let formData = new FormData();
        formData.append("fetchForm", true);
        formData.append("secretCode", this.searchSecretCode);

        let vm = this;

        axios
          .post(`${endpoint}/api.php`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            console.log("response", response);
            if (response.data !== null) {
              vm.$router.push({ path: `/form/${this.searchSecretCode}` });
            } else {
              EventBus.$emit("snackbar", {
                color: "error",
                state: true,
                text: "Modulo non trovato!",
              });
            }
          })
          .catch((error) => {
            EventBus.$emit("snackbar", {
              color: "error",
              state: true,
              text: "Errore di rete!",
            });
            console.log(error);
          })
          .finally(() => {
            this.loading = false;
          });
      }
    },
  },
};
</script>

<style></style>
