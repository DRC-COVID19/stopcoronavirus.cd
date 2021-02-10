<template>
    <div class="main">
        <Header :title="title" :iconClass="iconClass"/>
        <div class="list-user">
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
                    { id: 2, username: 'Dickerson', name: 'Macdonald', role: 'Admin' },
                    { id: 21, username: 'Larsen', name: 'Shaw', role: 'User' },
                    { id: 39, username: 'Geneva', name: 'Wilson', role: 'User' },
                    { id: 38, username: 'Jami', name: 'Carney', role: 'Admin' },
                    { id: 89, username: 'Geneva', name: 'Wilson', role: 'Admin' },
                    { id: 38, username: 'Jami', name: 'Carney', role: 'Admin' },
                    { id: 38, username: 'Jami', name: 'Carney', role: 'Admin' },
                    { id: 33, username: 'Jami', name: 'Carney', role: 'Admin' },
                    { id: 57, username: 'Jami', name: 'Carney', role: 'Admin' },
                    { id: 78, username: 'Jami', name: 'Carney', role: 'Admin' },
                    { id: 89, username: 'Geneva', name: 'Wilson', role: 'Admin' },
                    { id: 38, username: 'Jami', name: 'Carney', role: 'Admin' },
                    { id: 38, username: 'Jami', name: 'Carney', role: 'Admin' },
                    { id: 33, username: 'Jami', name: 'Carney', role: 'Admin' },
                    { id: 57, username: 'Jami', name: 'Carney', role: 'Admin' },
                    { id: 78, username: 'Jami', name: 'Carney', role: 'Admin' },
                    { id: 38, username: 'Jami', name: 'Carney', role: 'Admin' },
                    { id: 38, username: 'Jami', name: 'Carney', role: 'Admin' }
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
        padding: 30px 3%;
    }
    .fa-plus {
        color: white;
        font-size: 14px;
    }
</style>
