<template>
    <div>
        <h1>Liste des Utilisateurs</h1>
        <UtilisateursListe/>
    </div>

</template>

<script>
import UtilisateursListe from '../../components/UtilisateursListe.vue';

export default {
    name: 'UtilisateurShow',
    components: {
        UtilisateursListe,
    },
};
</script>