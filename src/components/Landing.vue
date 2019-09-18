<template>
  <v-container fluid>
     <v-layout text-xs-center>
      <v-flex xs12>
        <v-card>
          <v-card-text>
            <v-layout text-xs-center justify-center>
              <v-flex xs3>
                <v-text-field
                prepend-icon="vpn_key"
                label="Inserisci Codice"
                ></v-text-field>
                <v-btn>Nuova segnalazione</v-btn>
              </v-flex>
            </v-layout>
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
