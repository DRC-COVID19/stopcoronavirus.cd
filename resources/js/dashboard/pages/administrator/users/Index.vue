<template>
    <b-container  fluid>
            
        <b-row>
            <b-col cols="12" md="8">
                <b-row class="d-flex justify-content-start">
                    <Header :title="title" :iconClass="iconClass"/>
                </b-row>
                <ListUser :users="users"/>
            </b-col>
            <b-col cols="12" md="4" class="mt-5">
                <Create @onCreate='createUser' :userAdded="userAdded" /> 
            </b-col>
        </b-row>
        <Waiting v-if="isLoading" />
    </b-container>
</template>

<script>
    import Header from '../components/Header';
    import ListUser from './components/ListUsers';
    import Create from './components/Create';
    import Waiting from "../../../components/Waiting";
    export default {
        components: {
            Header,
            Create,
            Waiting,
            ListUser
        },
        data () {
            return {
                title: "Utilisateurs",
                iconClass: "fa fa-home",
                isLoading: false,
                users: [],
                userAdded: false
            }
        },
        mounted () {
            this.getUserList()
        },
        methods: {
            createUser(form) {
                console.log('processing')
                this.isLoading = true
                axios.post('/api/admin_user', {
                    username: form.username,
                    name: form.name,
                    password: form.password,
                    password_confirmation: from.confirmPassword,
                    email: form.email,
                    role_id: form.selected
                })
                    .then(({data}) => {
                        console.log('success')
                        this.userAdded = true
                        this.isLoading = false
                    })
                    .catch((e) => console.log(e))
            },
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

<style lang='scss' scoped>
    @import "@~/sass/_variables";
    .fa-plus {
        color: white;
        font-size: 14px;
    }
</style>
