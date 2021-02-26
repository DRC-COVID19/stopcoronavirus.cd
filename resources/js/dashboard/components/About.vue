<template>
  <div class="apropos">
    <b-card no-body class="default-card">
      <b-tabs pills card vertical>
        <!-- <b-tab title="Mobilité" active>
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
        </b-tab> -->

        <b-tab title="Change log">
          <b-row>
            <b-card class="default-card">
              <!-- <b-col cols="12" md="12">

                <Timeline
                  :timeline-items="changeLogs.data"
                  :message-when-no-items="messageWhenNoItems"
                  dateLocale="fr-fr"
                  class="timeline"
                />

            </b-col> -->
              <b-col
                cols="12"
                class="mb-0"
                v-for="(item, index) in changeLogsData"
                :key="index"
                :class="{
                  'timeline-selected': activeItem(item),
                }"
              >
                <vue-timeline-update
                  :date="new Date(item.from)"
                  :dateString="moment(item.from).format('DD.MM.yyyy')"
                  :title="item.title"
                  dateLocale="fr"
                  :description="item.description"
                  icon="code"
                  color="black"
                />
              </b-col>
            </b-card>
          </b-row>
          <b-row>
            <b-col class="d-flex justify-content-end">
              <b-pagination
                v-model="changeLogsMeta.current_page"
                :total-rows="changeLogsMeta.total"
                :per-page="changeLogsMeta.per_page"
                @change="switchPage"
              ></b-pagination>
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
import Timeline from "timeline-vuejs";
import { mapActions, mapMutations, mapState } from "vuex";

export default {
  components: {
    Timeline,
  },
  data() {
    return {
      modalSourceImg: null,
      messageWhenNoItems: "There are not items",
      currentPage: 1,
      rows: 10,
      perPage: 1,
      timelineItems: [
        {
          from: new Date(2018, 7),
          title: "Name",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius earum architecto dolor, vitae magnam voluptate accusantium assumenda numquam error mollitia, officia facere consequuntur reprehenderit cum voluptates, ea tempore beatae unde.",
          showDayAndMonth: true,
        },

        {
          from: new Date(2016, 1),
          title: "Name",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius earum architecto dolor, vitae magnam voluptate accusantium assumenda numquam error mollitia, officia facere consequuntur reprehenderit cum voluptates, ea tempore beatae unde.",
          showDayAndMonth: true,
        },
        {
          from: new Date(2016, 6),
          title: "Name",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius earum architecto dolor, vitae magnam voluptate accusantium assumenda numquam error mollitia, officia facere consequuntur reprehenderit cum voluptates, ea tempore beatae unde.",
          showDayAndMonth: true,
        },
        {
          from: new Date(2012, 1),
          title: "Name",
          description:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius earum architecto dolor, vitae magnam voluptate accusantium assumenda numquam error mollitia, officia facere consequuntur reprehenderit cum voluptates, ea tempore beatae unde.",
          showDayAndMonth: true,
        },
      ],
    };
  },
  mounted() {
    this.getListChangedLogs().then(() => {
      this.setChangeLogsRead();
    });
  },
  computed: {
    ...mapState({
      changeLogs: (state) => state.changeLog.listChangeLogs,
      selectedChangeLog: (state) => state.changeLog.selectedChangeLog,
    }),
    changeLogsData() {
      return this.changeLogs.data;
    },
    changeLogsMeta() {

      return this.changeLogs.meta
        ? this.changeLogs.meta
        : {
            current_page: 1,
            from: 1,
            last_page: 1,
            path: "#",
            per_page: 1,
            to: 1,
            total: 1,
          };
    },
  },
  methods: {
    ...mapMutations(["setSelectedChangeLog"]),
    ...mapActions([
      "getListChangedLogs",
      "setChangeLogsRead",
      "getListChangedLogs",
    ]),
    activeItem(item) {
      if (this.selectedChangeLog && this.selectedChangeLog.id == item.id) {
        setTimeout(() => {
          this.setSelectedChangeLog(null);
        }, 3000);
        return true;
      }
      return false;
    },
    showModal(e) {
      console.log(e);
      this.modalSourceImg = e.target.src;
      this.$bvModal.show("modal-img");
    },
    switchPage(page) {
      this.getListChangedLogs({ page }).then(() => {
        window.scrollTo(0, 0);
      });
    },
  },
};
</script>

<style lang="scss" scoped >
@import "@~/sass/_variables";
.timeline-selected {
  background: $waiting_background;
}
</style>
