<template>
  <v-container fluid>
    <v-layout wrap>
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

export default {
  components: {
    UpdatedForm,
    Header,
    Comments
  },
  props: ["header", "updatedForm"],
  created() {
    if (!this.header || !this.updatedForm) {
      this.$router.push("/");
    }
  }
};
</script>
