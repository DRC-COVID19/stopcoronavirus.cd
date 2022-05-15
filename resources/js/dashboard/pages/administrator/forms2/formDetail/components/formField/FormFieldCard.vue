<template>
  <div class="container-icon">
      <div class="ml-2">
          <img src="/img/icon/create_response.svg" class="img-create" height="32px" width="32px" alt  />
      </div>
      <div class="img-response-action ml-2">
          <img src="/img/icon/delete_response.svg" class="img-delete" height="32px" width="32px" alt  />
      </div>
      <div class="img-response-action ml-2">
          <img src="/img/icon/pencil_response.svg" 
           class="img-pencil"
           height="32px"
           width="32px"
            alt
            v-b-modal.createResponse
             />
           <FormFieldCreate/>
      </div>
  </div>
</template>

<script>
export default {

}
</script>
<style lang="scss" scoped>
  .container-icon{
    background-color: white;
    padding: 3px;
    padding-right: 10px;
    padding-bottom: 54px;
    margin-right: 0px;
    .img-response-action{
      margin-top: 20px;
    }
    .img-create{
      cursor: pointer;
    }
    .img-delete{
      cursor: pointer;
    }
    .img-pencil{
      cursor: pointer;
    }
  }
 @media screen and (max-width: 767px) {
   .container-icon{
     padding-bottom: 145px;
   }
 }
</style>
