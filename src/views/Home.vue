<template>
  <v-container fluid>
    <v-layout wrap>
      <v-flex xs12>
        <Form />
        <!-- <ThankYouPage :code="code" v-if="formSubmit === true"/> -->
      </v-flex>
      
    </v-layout>
  </v-container>
</template>

<script>
import Form from "@/components/Form";
// @ is an alias to /src

export default {
  name: "home",
  components: {
    Form
  }
};
</script>
