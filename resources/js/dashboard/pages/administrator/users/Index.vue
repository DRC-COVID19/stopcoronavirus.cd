<template>
    <b-container fluid>
    <b-row>
        <Header :title="title" :iconClass="iconClass"/>
    </b-row>
        
        <b-row>
            <b-col cols="12" md="8">
                <ListUser :users="users"/>
            </b-col>
            <b-col cols="12" md="4">
                <Create /> 
            </b-col>
        </b-row>
    </b-container>
    <!-- <div class="main">
        
        <div class="list-user">
            
            <Create class="col-md-6" /> 
        </div>
    </div> -->
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

<style scoped>
    .main {
        background-color: rgb(235, 245, 255);
    }
    .fa-plus {
        color: white;
        font-size: 14px;
    }
</style>
