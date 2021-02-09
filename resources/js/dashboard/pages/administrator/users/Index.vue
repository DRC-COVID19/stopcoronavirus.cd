<template>
    <div class="main">
        <Header :title="title" :iconClass="iconClass"/>
        <div class="list-user">
            <List />
        </div>
    </div>
</template>

<script>
    import Header from './components/Header';
    import List from './components/List';
    export default {
        components: {
            Header,
            List
        },
        data () {
            return {
                title: "Dashboard",
                iconClass: "fa fa-home"
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
</style>
