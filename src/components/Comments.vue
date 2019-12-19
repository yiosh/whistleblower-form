<template>
  <v-container>
    <v-layout text-xs-center wrap>
      <v-flex xs12>
        <v-toolbar>
          <v-toolbar-title>Commenti</v-toolbar-title>
        </v-toolbar>
        <v-card>
          <v-card-text>
            <v-textarea
              v-model="comment"
              outline
              name="input-7-4"
              solo
              counter
            ></v-textarea>
            <v-btn
              color="success"
              :loading="buttonLoading"
              @click="handleSendComment"
            >
              Invia
            </v-btn>
          </v-card-text>

          <v-list three-line>
            <template v-for="(item, index) in items">
              <v-divider v-if="index < items.length" :key="index"></v-divider>

              <v-list-tile :key="item.title">
                <v-list-tile-content>
                  <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                  <v-list-tile-sub-title>
                    {{ item.subtitle }}
                  </v-list-tile-sub-title>
                </v-list-tile-content>
              </v-list-tile>
            </template>
          </v-list>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import EventBus from "@/eventBus.js";
import axios from "axios";
import { endpoint } from "@/plugins/endpoint";

export default {
  props: ["formId"],
  data() {
    return {
      buttonLoading: false,
      comment: "",
      formData: new FormData(),
      items: [],
      snackbar: {
        color: "success",
        state: false,
        y: "top",
        x: null,
        mode: "",
        timeout: 6000,
        text: "Il commento è stato inviato con successo."
      }
    };
  },
  methods: {
    handleFetchComments() {
      this.formData.append("fetchComments", true);
      this.formData.append("formId", this.formId);

      axios
        .post(`${endpoint}/api.php`, this.formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          console.log("fetch", response);
          // const comments = response.data;
          response.data.forEach(comment => {
            let newComment = {
              id: comment.id,
              title: comment.text,
              subtitle: comment.createdAt
            };
            this.items.push(newComment);
          });
        })
        .catch(error => {
          console.log(error);
          this.snackbar.text = "Errore di rete";
          this.snackbar.color = "error";
          this.snackbar.state = true;
        });
    },
    handleSendComment() {
      this.buttonLoading = true;
      this.formData.append("insertComment", true);
      this.formData.append("formId", this.formId);
      this.formData.append("text", this.comment);

      axios
        .post(`${endpoint}/api.php`, this.formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          this.buttonLoading = false;
          console.log("insertComment response", response.data);
          let newComment = {
            id: response.data.recordId,
            title: this.comment,
            subtitle: new Date().toLocaleString().replace(/\//g, "-")
          };
          this.items.push(newComment);

          EventBus.$emit("snackbar", {
            color: "success",
            state: true,
            text: "Il commento è stato inviato con successo."
          });
          this.snackbar.state = true;
          this.comment = "";
        })
        .catch(error => {
          console.log(error);
          EventBus.$emit("snackbar", {
            color: "error",
            state: true,
            text: "Errore di rete!"
          });
        });
    }
  },
  created() {
    this.handleFetchComments();
  }
};
</script>

<style></style>
