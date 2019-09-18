<template>
  <v-app>
    <v-toolbar app dark color="#3581b5">
      <!-- <v-toolbar-side-icon></v-toolbar-side-icon> -->
      <v-toolbar-title class="headline text-uppercase">
        <span>Città di Bitetto</span>
        
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn
        class="hidden-sm-and-up"
        color="warning"
        dark
        small
        absolute
        bottom
        right
        fab
        @click="handleDialogToggle"
      >
        <v-icon>vpn_key</v-icon>
      </v-btn>
      <v-toolbar-items class="hidden-sm-and-down">
        <v-btn flat v-show="!btnToggle" @click="handleToggle">Hai già effettuato una segnalazione?</v-btn>
        <v-text-field
          v-show="btnToggle"
          :loading="loading"
          prepend-icon="vpn_key"
          color="white"
          :clearable="true"
          label="Inserisci il tuo Codice"
          v-model="searchSecretCode"
        ></v-text-field>
        <v-btn v-show="btnToggle" @click="handleSearchForm" icon>
          <v-icon>send</v-icon>
        </v-btn>
      </v-toolbar-items>
      
                
    </v-toolbar>
        <!-- <router-link to="/">Home</router-link> |
        <router-link to="/about">About</router-link> -->
      <!-- </div> -->
      <v-content>
        <router-view/>
      </v-content>
    <!-- </div> -->
  </v-app>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
