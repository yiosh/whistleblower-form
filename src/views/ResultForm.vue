<template>
  <v-container fluid>
    <v-layout v-if="loading" justify-center>
      <v-progress-circular
        :size="70"
        :width="7"
        color="#3581b5"
        indeterminate
      ></v-progress-circular>
    </v-layout>
    <v-layout v-if="!loading" wrap :key="updatedForm.id">
      <v-flex md8>
        <UpdatedForm :updatedForm="updatedForm" />
      </v-flex>
      <v-flex md4>
        <Header :header="header" />
        <Comments :formId="updatedForm.id" />
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import UpdatedForm from "@/components/UpdatedForm";
import Header from "@/components/Header";
import Comments from "@/components/Comments";
import EventBus from "@/eventBus.js";
import axios from "axios";
import { endpoint } from "@/plugins/endpoint";

export default {
  components: {
    UpdatedForm,
    Header,
    Comments
  },
  data() {
    return {
      loading: true,
      updatedForm: {},
      header: {}
    };
  },
  methods: {
    handleSearchForm(secretCode) {
      console.log("secret", secretCode);
      // return;

      let formData = new FormData();
      formData.append("fetchForm", true);
      formData.append("secretCode", secretCode);

      let vm = this;

      axios
        .post(`${endpoint}/api.php`, formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          if (response.data != false) {
            console.log("Fetch form response: ", response);
            let fileList = response.data.files == [] ? "" : response.data.files;
            vm.updatedForm = Object.assign(
              {},
              {
                nome: response.data.form.nome,
                autoreFatto: response.data.form.autore_fatto,
                cognome: response.data.form.cognome,
                azioniValore: decodeURI(response.data.form.azioni_valore).split(
                  ","
                ),
                dataA: response.data.form.data_a,
                dataDa: response.data.form.data_da,
                descrizioneFatto: response.data.form.descrizione_fatto,
                email: response.data.form.email,
                id: response.data.form.id,
                altriEventualiSoggetti: response.data.form.eventuali_soggetti.split(
                  ","
                ),
                luogoFatto: response.data.form.luogo_fatto.split(", "),
                qualificaProfessionale:
                  response.data.form.qualifica_professionale,
                secretCode: response.data.form.secret_code,
                sedeServizio: response.data.form.sede_servizio,
                telefono: response.data.form.telefono,
                fileList
              }
            );

            vm.header = Object.assign(
              {},
              {
                createdAt: response.data.form.created_at,
                updatedAt: response.data.form.updated_at,
                expiresAt: response.data.form.expires_at
              }
            );
          } else {
            console.log("Something went wrong");
            // this.handleSnackbar("error", true, "Nessun modulo trovato!");
          }
          this.loading = false;
        })
        .catch(error => {
          EventBus.$emit("snackbar", {
            color: "error",
            state: true,
            text: "Errore di rete!"
          });
          console.log(error);
        });
    }
  },
  mounted() {
    this.handleSearchForm(this.$route.params.secret);
  }
  // created() {
  //   if (!this.header || !this.updatedForm) {
  //     this.$router.push("/");
  //   }
  // }
};
</script>
