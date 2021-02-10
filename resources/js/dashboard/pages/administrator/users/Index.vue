<template>
    <div class="main">
        <Header :title="title" :iconClass="iconClass"/>
        <div class="list-user">
            <div class="d-flex justify-content-end">
                <b-button class="mb-4" variant="success" pill><i class="fa fa-plus"></i> Ajouter</b-button>
            </div>
            <ListUser :users="users"/>
        </div>
    </div>
</template>

<script>
    import Header from '../components/Header';
    import ListUser from './components/ListUsers';
    export default {
        components: {
            Header,
            ListUser
        },
        data () {
            return {
                title: "Utilisateurs",
                iconClass: "fa fa-home",
                users: [
                    { id: 2, username: 'Dickerson', name: 'Macdonald', role: 'Admin', action: '' },
                    { id: 21, username: 'Larsen', name: 'Shaw', role: 'User', action: '' },
                    { id: 39, username: 'Geneva', name: 'Wilson', role: 'User', action: '' },
                    { id: 38, username: 'Jami', name: 'Carney', role: 'Admin', action: '' },
                    { id: 89, username: 'Geneva', name: 'Wilson', role: 'Admin', action: '' },
                    { id: 38, username: 'Jami', name: 'Carney', role: 'Admin', action: '' },
                    { id: 38, username: 'Jami', name: 'Carney', role: 'Admin', action: '' },
                    { id: 33, username: 'Jami', name: 'Carney', role: 'Admin', action: '' },
                    { id: 57, username: 'Jami', name: 'Carney', role: 'Admin', action: '' },
                    { id: 78, username: 'Jami', name: 'Carney', role: 'Admin', action: '' }
                ]
            }
        }
    }
</script>

<style>
    .main {
        background-color: rgb(235, 245, 255);
    }
    .list-user {
        padding: 50px 10%;
    }
    .fa-plus {
        color: white;
        font-size: 14px;
    }
</style>
