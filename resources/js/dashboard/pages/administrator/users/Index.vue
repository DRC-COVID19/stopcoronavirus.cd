<template>
    <div class="main">
        <Header :title="title" :iconClass="iconClass"/>
        <div class="list-user">
            <ListUser class="col-md-6" :users="users"/>
            <Create class="col-md-6" />
        </div>
    </div>
</template>

<script>
    import Header from '../components/Header';
    import ListUser from './components/ListUsers';
    import Create from './components/ListUsers';
    export default {
        components: {
            Header,
            Create,
            ListUser
        },
        data () {
            return {
                title: "Utilisateurs",
                iconClass: "fa fa-home",
                isLoading: false,
                users: [],
                userDisplay: [
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
        },
        mounted () {
            this.getUserList()
        },
        methods: {
            getUserList (page = 1) {
                this.isLoading = true
                axios.get('/api/admin_users', {
                    params: {page}
                })
                    .then(({data}) => {
                        this.users = data.data
                        this.isLoading = false
                    })
                    .catch(e => console.log(e))
            },
            switchPage (page) {
                this.getUserList(page)
            }
        }
    }
</script>

<style>
    .main {
        background-color: rgb(235, 245, 255);
        height: 100vh;
    }
    .list-user {
        padding: 30px 3%;
    }
    .fa-plus {
        color: white;
        font-size: 14px;
    }
</style>
