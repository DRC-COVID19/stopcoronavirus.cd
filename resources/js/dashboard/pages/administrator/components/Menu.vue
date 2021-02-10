<template>
  <div class="col-sm-2  side-menu">
    <div class="header-menu">
      <div class="d-flex justify-content-center my-3">
        <img alt="Avatar" class="avatar" src="../../../../../../public/img/admin/avatar_placeholder.png" />
      </div>
      <h5 class="h6 text-center">Administrateur</h5>
    </div>
    <div class="parent" v-for="item in items" :key="item.key" @mouseover="hover = item.key" @mouseleave="hover = -1">
      <div class="elmt" :class="{active : activeItem == item.key || hover == item.key}">
        <b-link class="elmt nav-link" :to="{name:item.path}">{{item.label}}</b-link> 
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        activeItem: 1,
        hover: -1,
        items: [
          {key: 1, label: "Utilisateurs", path: 'administrator.users'},
          {key: 2, label: "Situation Epidemiologique", path: 'administrator.users.create'}
        ]
      }
    }
  }
</script>

<style>
  .side-menu {
    height: 100vh;
  }
  .avatar {
    height: 80px;
    width: 80px;
    border-radius: 40px;
  }
  .btn-close {
    border-radius: 10px;
    width: 20%;
  }
  .elmt {
    text-decoration: none;
    padding: 5px;
    margin: 10px 0;
  }
  .active {
    border-radius: 10px;
    background-color: rgb(220, 220, 220);
    font-weight: bold;
  }
  .parent {
    padding: 0 20px;
  }
  .header-menu {
    margin: 25px auto;
  }
</style>