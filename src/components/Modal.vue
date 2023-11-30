<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-form @submit.prevent="handleSubmit">
        <v-card>
          <v-card-title>
            <span class="headline">Login</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <!-- <v-flex xs12>
                  <v-text-field label="Legal first name*" required></v-text-field>
                </v-flex> -->
                <v-flex xs12>
                  <v-text-field
                    type="password"
                    label="Password"
                    hint="Inserisci la password per continuare"
                    v-model="password"
                  ></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" depressed @click="handleSubmit">Login</v-btn>
            <v-btn depressed @click="dialog = false">Chiudi</v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>
  </v-layout>
</template>

<script>
import EventBus from "@/eventBus.js";
import axios from "axios";
import { endpoint } from "@/plugins/endpoint";

export default {
  data() {
    return {
      dialog: false,
      password: "",
    };
  },
  methods: {
    handleSubmit() {
      const formData = new FormData();
      formData.append("checkPassword", true);
      formData.append("password", this.password);

      if (this.password.length > 0) {
        axios
          .post(`${endpoint}/api.php`, formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
          .then((response) => {
            console.log("response", response);
            if (response.data.status === "OK") {
              this.dialog = false;
              this.$router.push({
                path: "/formlist",
              });
            } else {
              EventBus.$emit("snackbar", {
                color: "error",
                state: true,
                text: "Password Errata!",
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
          });
      }
    },
  },
  mounted() {
    EventBus.$on("modal", (payload) => {
      this.dialog = payload;
    });
  },
};
</script>
