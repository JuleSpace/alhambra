<template>
    <div>
        <h1>Liste des Utilisateurs</h1>
        <UtilisateurListe/>
    </div>

    <router-link to="/create">Créer un nouvel utilisateur</router-link>
</template>

<script>
import UtilisateurListe from '@/components/UtilisateurListe.vue';

</script>