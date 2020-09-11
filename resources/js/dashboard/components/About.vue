<template>
  <div class="apropos">
    <b-card no-body class="default-card">
      <b-tabs pills card vertical>

        <b-tab title="Mobilité" active>
            <b-row>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/mobility-gen-in.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Graphe global des mobilités entrantes par province</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/mobility-gen-out.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Graphe global des mobilités sortantes par province</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
            </b-row>
            <b-row>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/mobility-in-line.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Graphe de l'evolution du pourcentage de mobilité en entrée dans une zone donnée</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/mobility-out-line.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Graphe de l'evolution du pourcentage de mobilité en sortie dans une zone donnée</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
            </b-row>
            <b-row>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/mobility-in-bar.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Graphe de la liste des zones de provenance pour une mobilité en entrée d'une zone donnée</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/mobility-out-bar.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Graphe de la liste des zones de destination pour une mobilité en sortie d'une zone donnée</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
            </b-row>
            <b-row>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/mobility-forte-decroissance.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Graphe du top 5 des zones de santé avec la plus forte décroissance de mobilité</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/mobility-faible-decroissance.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Graphe du top 5 des zones de santé avec la plus faible décroissance de mobilité</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
            </b-row>
            <b-row>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/mobility-top-zone-affectee.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Impact sur la mobilité pour les 5 zones de santé les plus affectées</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/mobility-gen-zone.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Graphe de l'evolution du pourcentage de mobilité en generale d'une province donnée</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
            </b-row>
            <b-row>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/mobility-in-zones-province.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Détails des mobilités en entrée d'une province</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/mobility-out-zones-province.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Détails des mobilités en sortie d'une province</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
            </b-row>
            <b-row>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/mobility-tendance.JPG" class="img-capture" alt
                      @click="showModal" style="height:90px" />
                  </div>
                  <h5>Graphe de l'evolution de la tendance d'une zone</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
            </b-row>
        </b-tab>

        <b-tab title="Indicateurs">
          <b-row>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/indicateur-point.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Mobilité vs Epidémiologie 1</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/indicateur-line.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Mobilité vs Epidémiologie 2</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
            </b-row>
        </b-tab>

        <b-tab title="Infrastructures">
          <b-row>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/infrastructure-lits.JPG" class="img-capture" alt
                      @click="showModal"/>
                  </div>
                  <h5>Graphe d'evolution de l'occupation des lits de réanimation</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/infrastructure-respirateurs.JPG" class="img-capture" alt
                      @click="showModal" />
                  </div>
                  <h5>Graphe d'evolution de l'occupation des respirateurs</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
              <b-col cols="12" md="6">
                <b-card class="default-card">
                  <div class="img-capture-wrapper">
                    <img src="/img/screen-capture/infrastructure-taux.JPG" class="img-capture" alt
                      @click="showModal"/>
                  </div>
                  <h5>Graphe d'evolution globale du taux d'occupation</h5>
                  <p>
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquam, iure consectetur
                    doloremque alias dolore perspiciatis illum quam doloribus porro quo itaque tempore
                    sunt fugit asperiores eius quaerat necessitatibus fugiat. Commodi.
                  </p>
                </b-card>
              </b-col>
            </b-row>
        </b-tab>
      </b-tabs>
    </b-card>

     <b-modal id="modal-img" centered hide-footer>
      <div class="text-center wrapper-img-modal">
        <img :src="modalSourceImg" class="img-capture" alt />
      </div>
    </b-modal>
  </div>
</template>

<script>
export default {
  data(){
    return {
      modalSourceImg : null
    }
  },
  methods: {
    showModal(e){
      console.log(e)
      this.modalSourceImg = e.target.src
      this.$bvModal.show('modal-img')
    }
  },
}
</script>

<style lang="scss">
  @import "@~/sass/_variables";
  html{
    background-color: $dash-background ;
  }
  .apropos{
    height : 100vh ;
    .nav-pills .nav-link{
      text-decoration: none ;
      color : $dash-text-100 ;
      &.active{
        background-color: $dash-blue;
        color : white ;
      }
    }
    .tab-content{
      background-color: #eef2ff;
       > .tab-pane {
        padding-top: 0.75rem;
      }
      .row{
        justify-content: left;
        >div{
          margin-bottom: 30px;
          display: flex;
        }
      }
      .img-capture-wrapper{
        overflow: hidden;
        float: right ;
        margin-left: 20px;
        margin-bottom: 10px;
        .img-capture{
          width : 150px ;
          cursor: zoom-in;
          transition: 0.3s ease-in-out;
          transform-origin: center;
          &:hover{
            opacity: 0.6;
            transform: scale(1.1);
          }
        }
      }
    }
  }
  .wrapper-img-modal{
    width: max-content;
    margin: auto;
    img{
      max-width: 900px;
    }
  }
  .modal-dialog {
    max-width: 1000px !important;
    width: max-content;
    min-width: 500px;
  }
  .modal-header .close:focus{
    outline: none;
  }
</style>
