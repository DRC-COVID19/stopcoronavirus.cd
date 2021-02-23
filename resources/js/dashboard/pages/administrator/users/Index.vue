<template>
    <b-container  fluid>
        <b-row class="flex-md-row-reverse">
            <b-col cols="12" md="4" class="mt-5">
                <b-alert
                    variant="success"
                    :show="showSuccess"
                    dismissible
                    fade
                    @dismiss-count-down="timeOut"
                    class="mx-3"
                >
                    Utilisateur cree avec success
                </b-alert>
                <Create @onUpdate="updateUser" @onCreate='createUser' @onCancelUpdate="cancelUpdate" :userAdded="userAdded" :userUpdated="userUpdated" :formToPopulate="formToPopulate" /> 
            </b-col>
            <b-col cols="12" md="8">
                <Header :title="title" :iconClass="iconClass"/>
                <b-alert
                    variant="success"
                    :show="isUserDeleted"
                    dismissible
                    fade
                    @dismiss-count-down="timeOut"
                    class="mx-3"
                >
                    Utilisateur supprime avec success
                </b-alert>
                <ListUser :class="{hidden_list:updating}" :users="users" @onDeleteUser="deleteUser" @onUpdateUser='populateForm' />
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import Header from '../components/Header';
    import ListUser from './components/ListUsers';
    import Create from './components/Create';
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
                userUpdated: false,
                userAdded: false,
                showSuccess: false,
                isUserDeleted: false,
                timeOut: 3,
                formToPopulate: {},
                updating: false
            }
        },
        mounted () {
            this.getUserList()
        },
        methods: {
            deleteUser (currentUserId) {
                axios.delete('/api/admin_users/'+currentUserId, {
                    params: {}
                })
                .then(() => {
                    this.getUserList()
                    this.isUserDeleted = true
                })
                .catch(() => {
                    console.log('failed')
                })
            },
            populateForm (currentUser) {
                this.updating = true
                this.formToPopulate = currentUser
            },
            cancelUpdate () {
                this.updating = false
            },
            updateUser (currentUser) {
                this.isLoading = true;
                this.userUpdated = false;
                axios.put('/api/admin_user/form.', {
                    username: currentUser.username,
                    name: currentUser.name,
                    email: currentUser.email,
                    roles_id: currentUser.roles
                })
                .then(() => {
                    this.userUpdated = true;
                    this.isLoading = false;
                    this.showSuccess = true;
                    this.getUserList(1);
                })
                .catch()
            },
            createUser(form) {
                this.userAdded = false
                this.isLoading = true
                axios.post('/api/admin_users', {
                    username: form.username,
                    name: form.name,
                    password: form.password,
                    password_confirmation: form.confirmPassword,
                    email: form.email,
                    roles_id: form.roles
                })
                .then(() => {
                    this.userAdded = true;
                    this.isLoading = false;
                    this.showSuccess = true;
                    this.getUserList(1);
                })
                .catch((response) => {
                    console.log('response',response);
                })
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
    .hidden_list {
        opacity: 0.6
    }
</style>
