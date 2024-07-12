<template>
  <div>
    <h1>Bienvenue sur l'application de gestion de l'association Alhambra</h1>

    <ul>
      <li><router-link to="/utilisateur">Gestion des Utilisateurs</router-link></li>
      <li><router-link to="/commissions">Gestion des Commissions</router-link></li>
      <li><router-link to="/posts">Gestion des Posts</router-link></li>
      <li><router-link to="/privilèges">Gestion des Privilèges</router-link></li>
      <li><router-link to="/chat">Accès au chat</router-link></li>
    </ul>
  </div>
</template>

<script>
/* eslint-disable vue/multi-word-component-names */
export default {
  name: 'Home',
  metaInfo: {
    title: 'Accueil'
  }
}
/* eslint-enable vue/multi-word-component-names */
</script>

<style scoped>
/* Ajoutez vos styles ici */
</style>
