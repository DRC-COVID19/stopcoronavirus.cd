<template>
  <b-link :to="route" class="card-link">
    <b-card class="card__recent-form">
      <div class="text-card-title">
        {{ form.title }}
      </div><br />
      <b-badge v-if="form.visible_all_hospitals === true" class="mt-2">
        Visible pour tout le monde
      </b-badge>
    </b-card>
  </b-link>
</template>

<script>
export default {
  props: {
    form: {
      type: Object,
      default: () => {},
    },
    route: {
      type: Object,
      default: () => {},
    },
  },
};
</script>
<style lang="scss">
@import "@~/sass/_variables";
.card__Scroll {
  display: flex;
   overflow-x: scroll !important;
    white-space: nowrap;
    flex-direction: row !important;
    flex-wrap: nowrap;
    &::-webkit-scrollbar {
      width: 0;
      background: transparent;
    }
  @media (max-width:1210px) {
    & {
      z-index: 5;
      height: 100%;
      width: 100%;
      border-right: 0;
    }
  }
}
.card__recent-form {
  width: 190px;
  word-wrap: wrap;
  height: 8rem;
  cursor: pointer;
  background: #ffffff;
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  display: flex;
  flex-direction: row;
  align-content: center;
  align-items: center;
  background: #3767fa;
  color: #ffffff;
  font-weight: 700;
  font-size: 14px;
  transition: all 0.3s ease-in;
  text-align: center;
  border: 0 !important;
  transform: scale(1);
  margin-top: 10px;
  .text-card-title{
    white-space: normal;
    margin-top: 15px;
  }
  &:hover {
    transform: scale(1.1);
    background-color: #ffffff;
    color: #3767fa;
  }
  @media screen and($small) {
    .card__recent-form {
      font-size: 15px;
    }
  }
  @media screen and($medium) {
    & {
      .card__recent-form {
        font-size: 15.5px;
      }
    }
  }

  @media screen and($large) {
    .card__recent-form {
      font-size: 16px;
    }
  }
  @media screen and($x-large) {
  }
}
</style>
