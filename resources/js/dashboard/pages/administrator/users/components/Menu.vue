<template>
  <div class="col-2 side-menu">
    <div class="parent" v-for="item in items" :key="item.key" @mouseover="hover = item.key" @mouseleave="hover = -1">
      <div class="elmt" :class="{active : activeItem == item.key || hover == item.key}">
        {{item.label}}
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
          {key: 1, label: "Dashboard"},
          {key: 2, label: "Carte"},
          {key: 3, label: "Graphique"},
          {key: 4, label: "Administrateurs"},
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
    font-size: 20px;
    padding: 5px;
    margin: 10px 0;
  }
  .active {
    border-radius: 10px;
    background-color: rgb(220, 220, 220);
    color: blue;
    font-weight: bold;
  }
  .parent {
    padding: 0 20px;
  }
</style>