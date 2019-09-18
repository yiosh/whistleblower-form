<template>
  <v-container fluid>
     <v-layout text-xs-center>
      <v-flex xs12>
        <h1>Grazie!</h1>
        <h2>La tua segnalazione è stata inviata con successo</h2>
        <v-card>
          <v-card-text>
            <p>Memorizza il tuo codice per la segnalazione:</p>
            <h4>{{ code }}</h4>
          </v-card-text>

        </v-card>
      </v-flex>
    </v-layout>        
  </v-container>
</template>

<script>
export default {
  props: ["code"]
};
</script>

<style>
</style>
