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
                    { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
                    { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
                    { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
                    { age: 38, first_name: 'Jami', last_name: 'Carney' },
                    { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
                    { age: 38, first_name: 'Jami', last_name: 'Carney' },
                    { age: 38, first_name: 'Jami', last_name: 'Carney' },
                    { age: 38, first_name: 'Jami', last_name: 'Carney' },
                    { age: 38, first_name: 'Jami', last_name: 'Carney' },
                    { age: 38, first_name: 'Jami', last_name: 'Carney' }
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
