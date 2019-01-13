<template>
  <v-app>
    <v-toolbar app dark color="#3581b5">
      <v-toolbar-side-icon></v-toolbar-side-icon>
      <v-toolbar-title class="headline text-uppercase">
        <span>Città di Bitetto</span>
        <!-- <span class="font-weight-light">MATERIAL DESIGN</span> -->
      </v-toolbar-title>
    </v-toolbar>

    <v-content>
      <Form/>
    </v-content>
  </v-app>
</template>

<script>
import Form from "./components/Form";

export default {
  name: "App",
  components: {
    Form
  },
  data() {
    return {
      //
    };
  }
};
</script>
