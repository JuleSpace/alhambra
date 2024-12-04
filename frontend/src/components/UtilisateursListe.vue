<template>
    <div>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="utilisateur in utilisateurs" :key="utilisateur.id">
            <td>{{ utilisateur.id }}</td>
            <td>{{ utilisateur.nom }}</td>
            <td>{{ utilisateur.prenom }}</td>
            <td>{{ utilisateur.email }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    name: 'UtilisateurListe',
    data() {
      return {
        utilisateurs: [],
      };
    },
    mounted() {
      this.fetchUtilisateurs();
    },
    methods: {
      async fetchUtilisateurs() {
        try {
          const response = await fetch('http://127.0.0.1:8000/api/utilisateurs');
          this.utilisateurs = await response.json();
        } catch (error) {
          console.error('Erreur lors du chargement des utilisateurs:', error);
        }
      },
    },
  };
  </script>
  
  <style scoped>

  table {
    width: 100%;
    border-collapse: collapse;
  }
  th, td {
    border: 1px solid #ddd;
    padding: 8px;
  }
  </style>
  