<template>
  <div class="home-container">
    <header class="header">
      <h1>Bienvenue sur l'application Alhambra</h1>
    </header>

    <ul class="menu">
      <li>
        <router-link to="/utilisateur" class="menu-link">Gestion des Utilisateurs</router-link>
      </li>
      <li>
        <router-link to="/commissions" class="menu-link">Gestion des Commissions</router-link>
      </li>
      <li>
        <router-link to="/posts" class="menu-link">Gestion des Posts</router-link>
      </li>
      <li>
        <router-link to="/privilèges" class="menu-link">Gestion des Privilèges</router-link>
      </li>
      <li>
        <router-link to="/chat" class="menu-link">Accès au chat</router-link>
      </li>
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
/* Style général de la page */
.home-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
  background-color: #eae6df; /* couleur inspirée de WhatsApp */
  height: 100vh;
  font-family: Arial, sans-serif;
  color: #333;
}

/* Style pour le header */
.header {
  background-color: #075e54; /* couleur verte de WhatsApp */
  width: 100%;
  padding: 20px;
  text-align: center;
  color: white;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  margin-bottom: 20px;
}

.header h1 {
  font-size: 1.5em;
  margin: 0;
}

/* Style pour le menu */
.menu {
  list-style-type: none;
  padding: 0;
  margin: 0;
  width: 100%;
  max-width: 400px;
}

.menu li {
  margin-bottom: 15px;
}

/* Style pour les liens du menu */
.menu-link {
  display: block;
  text-decoration: none;
  color: #333;
  background-color: #ffffff;
  padding: 15px;
  text-align: center;
  border-radius: 8px;
  font-size: 1.1em;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: background-color 0.3s, color 0.3s;
}

.menu-link:hover {
  background-color: #dcf8c6; /* couleur verte claire inspirée de WhatsApp */
  color: #075e54;
}
</style>
